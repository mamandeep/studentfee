<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use \DateTime;
use \DateTimeZone;
use \SimpleXMLElement;

class StudentsController extends AppController {
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
    public function feesubmission() {
        $students = TableRegistry::get('Students');
        $student = $this->Students->find('all', ['conditions' => ['Students.registration_no_cupb' => $this->Auth->user('username')]])
                                ->contain(['Fees', 'Categories', 'Semesters'])
                                ->toArray();
        if(count($student) != 1) {
            $this->Flash->error(__('Please contact Support.'));
            return $this->redirect(['action' => 'feesubmission']);
        }
        $flag = $this->isFormFillingOpen();
        $closingDate = new DateTime('2017-10-30 23:59:59', new DateTimeZone('Asia/Calcutta'));
        $late_fee_apply = $this->checklatefee($closingDate);
        $session = $this->request->session();
        if ($this->request->is(['patch', 'post', 'put']) && $flag === true) {
            //debug($this->request->getData()); return null;
            $student_id = intval($student[0]['id']);
            $token = $session->read('feetoken');
            $fee_type = "";  
            if($token === $this->request->data()['tokenid']) {
                $fee_type = (!empty($this->request->getData()['fee_type']) ? $this->request->getData()['fee_type'] : NULL);
                if(empty($fee_type) || is_null($fee_type) || $fee_type === "select") {
                    $this->Flash->error(__('No fee type selected. Please select fee type.'));
                    return $this->redirect(['action' => 'feesubmission']);
                }
                if(!is_null($fee_type)) $session->write('fee_type', $fee_type);
            }
            
            $receivedFeeTable = TableRegistry::get('Receivedfees');
            $receivedFees = $receivedFeeTable->find('all', ['conditions' => ['Receivedfees.student_id' => $student_id,
                                                                             'Receivedfees.fee_type' => $fee_type,
                                                                             'Receivedfees.semester_id' => $student[0]['semester_id']]])
                                ->toArray();
            if(!empty($receivedFees[0]) && $receivedFees[0]['response_code'] === 0) {
                // transaction complete , redirect to print receipts link.
                $this->Flash->success(__('Your fee submission has been completed successfully.'));
            }
            else if(!empty($receivedFees[0]) && is_null($receivedFees[0]['response_code']) && $receivedFees[0]['remarks'] != $this->request->getData()['remarks']) {
                    $receivedFees_new = $receivedFees[0];
                    $receivedFees_new = $receivedFeeTable->patchEntity($receivedFees_new, ['student_id' => $student[0]['id'],
                                                                                           'fee_type' => $fee_type,
                                                                                           'remarks' => $this->request->getData()['remarks'],
                                                                                           'semester_id' => $student[0]['semester_id'],
                                                                                           'cupb_reg_no' => $student[0]['registration_no_cupb']]);
                    if ($receivedFeeTable->save($receivedFees_new)) {
                        $this->Flash->success(__('Your fee submission has been initiated. Please submit the fee online.'));
                        return ($fee_type == "ACADEMIC") ? $this->redirect(['controller' => 'payments', 'action' => 'pay']) : $this->redirect(['controller' => 'payments', 'action' => 'payhostel']);
                    }
                    else {
                        $this->Flash->error(__('Unable to save your fee submission.'));
                    }
            }
            else if(!empty($receivedFees[0]) && is_null($receivedFees[0]['response_code'])) {
                //debug("here"); return null;
                $open_datetime = new DateTime("2017-01-01 08:59:59", new DateTimeZone('Asia/Calcutta'));
                $latefee_datetime = new DateTime("2017-10-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
                $fee_received = $this->getFeeSubmissionStatus($fee_type, $student, $open_datetime, $latefee_datetime);
                if($fee_received['Status'] == "yes" && $fee_received['registration_no'] === $student[0]['registration_no_cupb']) {
                    // fetch the entry, update the entry into the database and redirect to print receipt page (for this receipt)
                    $receivedFees_new = $receivedFees[0];
                    $receivedFees_new = $receivedFeeTable->patchEntity($receivedFees_new, ['account_id' => ($fee_type === "ACADEMIC") ? 24828 : (($fee_type === "HOSTEL") ? 24829 : NULL),
                                                                                   'response_code' => 0,
                                                                                   'payment_id' => intval($fee_received['payment_id']),
                                                                                   'payment_transaction_id' => intval($fee_received['payment_transaction_id']),
                                                                                   'payment_amount' => intval($fee_received['payment_amount']),
                                                                                   'payment_date_created' => date("Y-m-d H:i:s", strtotime($fee_received['payment_date_created']))]);
                    //$receivedFees->user_id = $this->Auth->user('id');
                    if ($receivedFeeTable->save($receivedFees_new)) {
                        $this->Flash->success(__('Your fee has been received and saved successfully.'));
                        // redirect to print receipt page
                        // return $this->redirect(['controller' => 'preferences', 'action' => 'add']);
                    }
                    else {
                        $this->Flash->error(__('Unable to save your fee submission. Please contact support.'));
                        return $this->redirect(['action' => 'feesubmission']);
                    }
                }
                else {
                    // redirect to payment page
                    return ($fee_type == "ACADEMIC") ? $this->redirect(['controller' => 'payments', 'action' => 'pay']) : $this->redirect(['controller' => 'payments', 'action' => 'payhostel']);
                }
            }
            else if(!empty($receivedFees[0]) && !is_null($receivedFees[0]['response_code'])) {
                $this->Flash->error(__('An error has occured in Fee Submission. Please contact Support.'));
                return $this->redirect(['action' => 'feesubmission']);
            }
            else if(empty($receivedFees[0])) {
                // make an entry into the database and redirect to payment page
                $receivedFee_create = $receivedFeeTable->newEntity(['student_id' => $student[0]['id'],
                                                                    'fee_type' => $fee_type,
                                                                    'remarks' => $this->request->getData()['remarks'],
                                                                    'semester_id' => $student[0]['semester_id'],
                                                                    'cupb_reg_no' => $student[0]['registration_no_cupb']]);
                $receivedFee_create->user_id = $this->Auth->user('id');
                if ($receivedFeeTable->save($receivedFee_create)) {
                    $this->Flash->success(__('Your fee submission has been initiated. Please submit the fee online.'));
                    return ($fee_type == "ACADEMIC") ? $this->redirect(['controller' => 'payments', 'action' => 'pay']) : $this->redirect(['controller' => 'payments', 'action' => 'payhostel']);
                }
                else {
                    $this->Flash->error(__('Unable to initiate your fee submission. Please contact support.'));
                    return $this->redirect(['action' => 'feesubmission']);
                }
            }
            else {
                $this->Flash->error(__('Error occured. Please contat Support.'));
                return $this->redirect(['action' => 'feesubmission']);
            }
        }
        else if($this->request->is(['patch', 'post', 'put']) && $flag === false) {
            $this->Flash->error(__('Fee submission is closed at this time.'));
        }
        $token = uniqid();
        
        $session->write('feetoken', $token);
        //debug($student); return null;
        //$feesTable = TableRegistry::get('Fees');
        //$fee = $feesTable->find('all', ['conditions' => ['Fees.semester_id' => $student[0]['semester_id']]])->toArray();
        
        $this->set('student', $student[0]);
        //debug($late_fee_apply);
        $this->set('latefee', $late_fee_apply);
        $session->write('late_fee_applicable', $late_fee_apply);
        $no_of_days = $this->getNoOfDays($closingDate);
        $this->set('no_of_days', $no_of_days);
        foreach($student[0]['fees'] as $fee) {
            //debug($this->checklatefee($closingDate));
            if($this->checklatefee($closingDate)) {
                //debug($fee['category_id'] == $student[0]['category_id']); debug($fee['fee_type']);
                if((empty($fee['category_id']) && $fee['fee_type'] == "ACADEMIC" ) || ($fee['category_id'] == $student[0]['category_id'] && $fee['fee_type'] == "ACADEMIC")) {
                    $session->write('late_fee_amount_ACADEMIC', $no_of_days * $fee['late_fee_per_day']);
                }
                if($fee['category_id'] == $student[0]['category_id'] && $fee['fee_type'] == "HOSTEL") {
                    $session->write('late_fee_amount_HOSTEL', $no_of_days * $fee['late_fee_per_day']);
                }
            }
        }
        
        $this->set('token', $token);
        //$this->set('fee', $fee);
    }
    
    private function getFeeSubmissionStatus($fee_type, $student, $openingDate, $latefeeSubmissionDate) {
        $ch = curl_init();
        $fields = "";
        if($fee_type == "ACADEMIC") {//RefNo=16maplsc02
            $fields = "Action=statusByRef&AccountID=24828&SecretKey=2401afdd1045e96b4804a3fe58b8edab&RefNo=" . $student[0]['registration_no_cupb'];
        }
        else if($fee_type == "HOSTEL") {
            $fields = "Action=statusByRef&AccountID=24829&SecretKey=f88b6a6e05f21233eb59ef28d654cfd7&RefNo=" . $student[0]['registration_no_cupb'];
        }
        //debug($fields);
        curl_setopt($ch, CURLOPT_URL,"https://api.secure.ebs.in/api/1_0");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // receive server response ...
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
        $info = curl_getinfo($ch);
        //debug($server_output); debug($info); debug(curl_error($ch)); debug(curl_errno($ch));
        curl_close ($ch);

        $fee_details = [];
        // further processing ....
        if (!empty($info) && $info['http_code'] === 200) {
            // check if the fee has been submitted after opening date dateTime="2017-07-14 11:00:19"
            //$xml = simplexml_load_string($server_output);debug($xml->attributes());
            $xml = new SimpleXMLElement($server_output); //debug($xml->attributes());
            $paymentVerified = true;
            $errorCodeValue = (!empty($xml->xpath('/output/@errorCode')[0]) ? (string) $xml->xpath('/output/@errorCode')[0] : "0"); //debug($values);
            if($errorCodeValue === "3") {
                $paymentVerified = false;
            }
            else {
                $statusValue = (string) $xml->xpath('/output/@status')[0];
                $transactionTypeValue = (string) $xml->xpath('/output/@transactionType')[0];
                $isFlaggedValue = (string) $xml->xpath('/output/@isFlagged')[0];
                $dateTimeValue = (string) $xml->xpath('/output/@dateTime')[0];
                if($statusValue != "Processed") { $paymentVerified = false; }
                if($transactionTypeValue != "Authorized") { $paymentVerified = false; }
                if($isFlaggedValue != "NO") { $paymentVerified = false; }
                $feedatetime = new DateTime($dateTimeValue, new DateTimeZone('Asia/Calcutta'));
                if(!($feedatetime >= $openingDate && $feedatetime <= $latefeeSubmissionDate)) {
                    $paymentVerified = false;
                }
            }
            //debug($fee_details); debug($paymentVerified);
            if($paymentVerified === true) {
                foreach($xml->attributes() as $key => $value) {
                    if($key === "status") { $fee_details['Status'] = "yes"; }
                    if($key === "transactionId") { $fee_details['payment_transaction_id'] = $value; }
                    if($key === "paymentId") { $fee_details['payment_id'] = $value; }
                    if($key === "amount") { $fee_details['payment_amount'] = $value; }
                    if($key === "dateTime") { $fee_details['payment_date_created'] = $value; }
                    if($key === "referenceNo") { $fee_details['registration_no'] = $value; }
                }
            }
            else {
                $fee_details['Status'] = "no";
            }
        } else {
            $this->Flash->error(__('Fee submission status could not be checked. Kindly contact Support'));
            $fee_details['Status'] = "no";
        }
        //debug($fee_details);
        return $fee_details;
    }
    
    private function checklatefee($closingDate) {
        $date_today = new DateTime('now');
        return $date_today > $closingDate;
    }
    
    private function getNoOfDays($closingDate) {
        $date_today = new DateTime('now');
        //debug($date_today);
        $diff = $date_today->diff($closingDate);

        $hours = $diff->h;
        $days = $diff->days;

        return ($hours > 0) ? ($days+1) : $days;
    }
    
    public function printreceipt() {
        $students = TableRegistry::get('Students');
        $student = $this->Students->find('all', ['conditions' => ['Students.registration_no_cupb' => $this->Auth->user('username')]])
                                ->contain(['Fees', 'Categories', 'Semesters'])
                                ->toArray();
        if(count($student) != 1) {
            $this->Flash->error(__('Please contact Support.'));
            return $this->redirect(['action' => 'feesubmission']);
        }
        $flag = $this->isStatusCheckingOpen();
        $receivedFeeTable = TableRegistry::get('Receivedfees');
        $receivedFees = $receivedFeeTable->find('all', ['conditions' => ['Receivedfees.student_id' => $student[0]['id'],
                                                                         'Receivedfees.semester_id' => $student[0]['semester_id']]])
                            ->toArray();
        $status = []; $count = 0;
        $flag = $this->isPrintingReceiptOpen();
        $semestersTable = TableRegistry::get('Semesters');
        $semesters = $semestersTable->find('all');
	$semester = $semestersTable->newEntity();
        $semester_id = 0;
        if ($this->request->is(['patch', 'post', 'put']) && $flag === true) {
            $semester_id = (!empty($this->request->data()['sid']) && is_numeric($this->request->data()['sid'])) ? intval($this->request->data()['sid']) : 0;
            if($semester_id === 0) {
                $this->Flash->error(__('The semester id selected is not a valid semester.'));
                return $this->redirect(['action' => 'printreceipt']);
            }
	    $semesterObj = $semestersTable->find('all')
                                         ->where(['Semesters.id' => $semester_id])->toArray();
            foreach($receivedFees as $fee) {
                if($semester_id == $fee['semester_id']) {
                    $status[$count]['batch'] = $student[0]['batch'];
                    $status[$count]['registration_no'] = $student[0]['registration_no_cupb'];
                    $status[$count]['semester_id'] = $student[0]['semester']['name'];
                    $status[$count]['name'] = $student[0]['name'];
                    $status[$count]['fee_type'] = $fee['fee_type'];
                    //debug($fee);
                    if(!empty($fee) && $fee['response_code'] === 0) {
                        $status[$count]['fee_status'] = 1;
                        $status[$count]['amount_paid'] = intval($fee['payment_amount']);
                        $status[$count]['latefee_applicable'] = $fee['latefee_applicable'];
                        $status[$count]['latefee_amount'] = $fee['latefee_amount'];
                        $status[$count]['payment_date_created'] = $fee['payment_date_created'];
                        $status[$count]['payment_id'] = $fee['payment_date_created'];
                        $this->set('fee', $status[$count]);
                    }
                    else {
                        //$this->Flash->error(__('An error has occured in one of your Fee Submissions. Please contact Support.'));
                        $status[$count]['fee_status'] = 0; // kindly check fee status
                        //return $this->redirect(['action' => 'checkstatus']);
                    }
                    $count++;
                }
            }
            $this->set('selected_sem_id', $semester_id);
        }
        else if($this->request->is(['patch', 'post', 'put']) && $flag === false) {
            $this->Flash->error(__('Printing of Recepit is closed at this time.'));
        }
        $sem_options = [];
        foreach($semesters as $sem) {
            $sem_options[$sem['id']] = $sem['name'];
        }
        $this->set('semesters', $sem_options);
        $this->set('semester', $semester);
    }
    
    public function checkstatus() {
        $students = TableRegistry::get('Students');
        $student = $this->Students->find('all', ['conditions' => ['Students.registration_no_cupb' => $this->Auth->user('username')]])
                                ->contain(['Fees', 'Categories', 'Semesters'])
                                ->toArray();
        if(count($student) != 1) {
            $this->Flash->error(__('Please contact Support.'));
            return $this->redirect(['action' => 'feesubmission']);
        }
        $flag = $this->isStatusCheckingOpen();
        $receivedFeeTable = TableRegistry::get('Receivedfees');
        $receivedFees = $receivedFeeTable->find('all', ['conditions' => ['Receivedfees.student_id' => $student[0]['id'],
                                                                         'Receivedfees.semester_id' => $student[0]['semester_id']]])
                            ->toArray();
        $status = []; $count = 0;
        foreach($receivedFees as $fee) {
            $status[$count]['batch'] = $student[0]['batch'];
            $status[$count]['registration_no'] = $student[0]['registration_no_cupb'];
            $status[$count]['semester_id'] = $student[0]['semester']['name'];
            $status[$count]['name'] = $student[0]['name'];
            $status[$count]['fee_type'] = $fee['fee_type'];
            if(!empty($fee) && $fee['response_code'] === 0) {
                $status[$count]['fee_status'] = 1;
                $status[$count]['amount_paid'] = intval($fee['payment_amount']);
                $status[$count]['latefee_applicable'] = $fee['latefee_applicable'];
                $status[$count]['latefee_amount'] = $fee['latefee_amount'];
                $status[$count]['payment_date_created'] = $fee['payment_date_created'];
                $status[$count]['payment_id'] = $fee['payment_date_created'];
            }
            else if(!empty($fee) && is_null($fee['response_code'])) {
                //debug("here"); return null;
                $open_datetime = new DateTime("2017-01-01 08:59:59", new DateTimeZone('Asia/Calcutta'));
                $latefee_datetime = new DateTime("2017-10-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
                $fee_received = $this->getFeeSubmissionStatus($fee_type, $student, $open_datetime, $latefee_datetime);
                if($fee_received['Status'] == "yes" && $fee_received['registration_no'] === $student[0]['registration_no_cupb']) {
                    // fetch the entry, update the entry into the database and redirect to print receipt page (for this receipt)
                    $receivedFees_new = $receivedFees[0];
                    $receivedFees_new = $receivedFeeTable->patchEntity($receivedFees_new, ['account_id' => ($fee['fee_type'] === "ACADEMIC") ? 24828 : (($fee['fee_type'] === "HOSTEL") ? 24829 : NULL),
                                                                                   'response_code' => 0,
                                                                                   'payment_id' => intval($fee_received['payment_id']),
                                                                                   'payment_transaction_id' => intval($fee_received['payment_transaction_id']),
                                                                                   'payment_amount' => intval($fee_received['payment_amount']),
                                                                                   'payment_date_created' => date("Y-m-d H:i:s", strtotime($fee_received['payment_date_created']))]);
                    //$receivedFees->user_id = $this->Auth->user('id');
                    if ($receivedFeeTable->save($receivedFees_new)) {
                        //$this->Flash->success(__('Your fee has been received and saved successfully.'));
                        $status[$count]['fee_status'] = 1;
                        $status[$count]['paid_amount'] = intval($fee['payment_amount']);
                        $status[$count]['latefee_applicable'] = $fee['latefee_applicable'];
                        $status[$count]['latefee_amount'] = $fee['latefee_amount'];
                        $status[$count]['payment_date_created'] = $fee['payment_date_created'];
                        $status[$count]['payment_id'] = $fee['payment_date_created'];
                        // redirect to print receipt page
                        // return $this->redirect(['controller' => 'preferences', 'action' => 'add']);
                    }
                    else {
                        //$this->Flash->error(__('Unable to save your fee submission details. Please contact suppport.'));
                        $status[$count]['fee_status'] = 0;
                    }
                }
            }
            else if(!empty($fee) && !is_null($fee['response_code'])) {
                //$this->Flash->error(__('An error has occured in one of your Fee Submissions. Please contact Support.'));
                $status[$count]['fee_status'] = 2;
                //return $this->redirect(['action' => 'checkstatus']);
            }
            $count++;
        }
        $this->set('status', $status);
    }
    
    public function xls($id, $output_type = 'D', $file = 'my_spreadsheet.xlsx') {
        $conn = ConnectionManager::get('default');
        $query_string = 'SELECT s1.name, s1.registration_no_cupb, s1.batch, s1.semester_id, s1.programme_name, s1.degree_convo_fee, s1.alumni_association_life,
                        s1.security_deposit_refundable, s1.admission_fee, s1.identity_card, s1.medical_fee, s1.literary_cultural_fee,
                        s1.students_union_fund, s1.tuition_fee, s1.laboratory_fee, s1.library_e_lib_fee, s1.computer_internet_fee,
                        s1.examination_fee, s1.marksheet_fee, s1.sports_fee, s1.students_welfare_fund,
                        SUM(case when r1.fee_type = \'ACADEMIC\' then r1.payment_amount else 0 end) as ACADEMIC_FEE,
                        SUM(case when r1.fee_type = \'ACADEMIC\' then r1.payment_id else 0 end) as ACADEMIC_FEE_ID,
                        SUM(case when r1.fee_type = \'ACADEMIC\' then r1.payment_date_created end) as ACADEMIC_FEE_DATE,
                        SUM(case when r1.fee_type = \'ACADEMIC\' then r1.latefee_applicable end) as ACADEMIC_FEE_LATE_FEE_APPLICABLE,
                        SUM(case when r1.fee_type = \'ACADEMIC\' then r1.latefee_amount end) as ACADEMIC_FEE_LATE_FEE_AMOUNT,
                        SUM(case when r1.fee_type = \'HOSTEL\' then r1.payment_amount else 0 end) as HOSTEL_FEE,
                        SUM(case when r1.fee_type = \'HOSTEL\' then r1.payment_amount else 0 end) as HOSTEL_FEE_ID,
                        SUM(case when r1.fee_type = \'HOSTEL\' then r1.payment_date_created end) as HOSTEL_FEE_DATE,
                        SUM(case when r1.fee_type = \'HOSTEL\' then r1.latefee_applicable end) as HOSTEL_FEE_LATE_FEE_APPLICABLE,
                        SUM(case when r1.fee_type = \'HOSTEL\' then r1.latefee_amount end) as HOSTEL_FEE_LATE_FEE_AMOUNT
                        from receivedfees r1
                        left join students s1
                        on r1.student_id = s1.id
                        group by s1.id';
        $stmt = $conn->execute($query_string);
        $seatsSummary = $stmt->fetchAll('assoc');
        $count = 0;
        
        foreach($seatsSummary as $studentFee) {
            $seatsSummary[$count++] = array_merge($studentFee, ['ACADEMIC_FEE_DATE_DISPLAY' => $this->convertDate($studentFee['ACADEMIC_FEE_DATE']),
                                                                'HOSTEL_FEE_DATE_DISPLAY' => $this->convertDate($studentFee['HOSTEL_FEE_DATE'])]);
        }
        //$this->set('summary', $seatsSummary);
        //$user = $this->Users->get($id);
        $user = $seatsSummary;
        $this->set(compact('seatsSummary', 'output_type', 'file'));
        $this->viewBuilder()->layout('xls\default');
        $this->viewBuilder()->template('xls\spreadsheet_user');
        $this->RequestHandler->respondAs('xlsx');
        $this->render();
    }
    
    private function convertDate($dateTimeValue) {
        return  substr($dateTimeValue, 6, 2) . "/" . substr($dateTimeValue, 4, 2) . "/" . substr($dateTimeValue, 0, 4) . " " . 
                substr($dateTimeValue, 8, 2) . ":" . substr($dateTimeValue, 10, 2) . ":" . substr($dateTimeValue, 12, 2);
    }
    
    public function isAuthorized($user = null) {
        //return parent::isAuthorized($user);
        if(parent::isAuthorized($user)) {
            return true;
        }
        
        // All users with role as 'exam' can add seats seatalloted
        if (isset($user['role']) && $user['role'] === 'student' && ($this->request->getParam('action') === 'feesubmission' 
                                                                 || $this->request->getParam('action') === 'printreceipt'
                                                                 || $this->request->getParam('action') === 'checkstatus')) {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
            $candidateId = (int) $this->request->getParam('pass.0');
            if ($this->Candidates->isOwnedBy($candidateId, $user['id'])) {
                return true;
            }
        }
        
    }   
}