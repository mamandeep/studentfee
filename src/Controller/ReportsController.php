<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class ReportsController extends AppController {

    //private $uploadPath = 'uploads/reports/';
    
    public function initialize() {
        parent::initialize();

        $this->loadComponent('Flash'); // Include the FlashComponent
        require_once(ROOT . DS. 'Vendor' . DS . 'phpexcel' . DS . 'PHPExcel.php');
        
        // Load Files model
        $this->loadModel('Files');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    public function index() {
        $this->set('AuthId', $this->Auth->user('id'));
    }

    public function view($id) {
        $candidate = $this->Candidates->get($id);
        $this->set(compact('candidate'));
        $this->set('AuthId', $this->Auth->user('id'));
    }

    public function sendemail() {
        $email = new Email('default');
        $email->setSender('app@example.com', 'MyApp emailer');
        Email::setConfigTransport('ernet', [
            'host' => 'ssl://mail.eis.ernet.in',
            'port' => 465,
            'username' => 'sa@cup.ac.in',
            'password' => 'ASMann@123#',
            'className' => 'Smtp'
        ]);
        $email->setFrom(['sa@cup.ac.in' => 'My Site'])
                ->setTo('mann.cse@gmail.com')
                ->setSubject('About Link Confirmation')
                ->send('My message');
    }

    public function dashboard() {
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
        /*$query_string = 'select s1.programme_id as p_id, p1.name as p_name, count(*) as Total_seats, SUM(CASE  WHEN category_id = 1 and candidate_id is not NULL THEN 1 ELSE 0 END) as Open_filled,
                        SUM(CASE  WHEN category_id = 3 and candidate_id is not NULL THEN 1 ELSE 0 END) as SC_filled,
                        SUM(CASE  WHEN category_id = 4 and candidate_id is not NULL THEN 1 ELSE 0 END) as ST_filled,
                        SUM(CASE  WHEN category_id = 5 and candidate_id is not NULL THEN 1 ELSE 0 END) as OBC_filled,
                        SUM(CASE  WHEN category_id = 1 and candidate_id is NULL THEN 1 ELSE 0 END) as Open_vacant,
                        SUM(CASE  WHEN category_id = 3 and candidate_id is NULL THEN 1 ELSE 0 END) as SC_vacant,
                        SUM(CASE  WHEN category_id = 4 and candidate_id is NULL THEN 1 ELSE 0 END) as ST_vacant,
                        SUM(CASE  WHEN category_id = 5 and candidate_id is NULL THEN 1 ELSE 0 END) as OBC_vacant
                        from seats s1
                        inner join programmes p1
                        on s1.programme_id = p1.id
                        group by s1.programme_id';*/
        $stmt = $conn->execute($query_string);
        $seatsSummary = $stmt->fetchAll('assoc');
        /*$totalSeats = '';
        $seatsFilled = '';
        $seatsVacant = '';
        foreach($seatsSummary as $programme) {
            $totalSeats  += $programme['Total_seats'];
            $seatsFilled += ($programme['Open_filled'] + $programme['SC_filled'] + $programme['ST_filled'] + $programme['OBC_filled'] );
            $seatsVacant += ($programme['Open_vacant'] + $programme['SC_vacant'] + $programme['ST_vacant'] + $programme['OBC_vacant'] );
        }
        $this->set('totalseats', $totalSeats);
        $this->set('seatsfilled', $seatsFilled);
        $this->set('seatsvacant', $seatsVacant);*/
        $count = 0;
        //debug($seatsSummary);
        foreach($seatsSummary as $studentFee) {
            $seatsSummary[$count++] = array_merge($studentFee, ['ACADEMIC_FEE_DATE_DISPLAY' => $this->convertDate($studentFee['ACADEMIC_FEE_DATE']),
                                                                'HOSTEL_FEE_DATE_DISPLAY' => $this->convertDate($studentFee['HOSTEL_FEE_DATE'])]);
        }
        //debug($seatsSummary);
        $this->set('summary', $seatsSummary);
    }
    
    private function convertDate($dateTimeValue) {
        return  substr($dateTimeValue, 6, 2) . "/" . substr($dateTimeValue, 4, 2) . "/" . substr($dateTimeValue, 0, 4) . " " . 
                substr($dateTimeValue, 8, 2) . ":" . substr($dateTimeValue, 10, 2) . ":" . substr($dateTimeValue, 12, 2);
    }
    
    public function export() {
        
    }
    
    public function import() {
        $uploadData = '';
        if ($this->request->is('post')) {
            if(!empty($this->request->data['file']['name'])) {
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'uploads/reports/';
                $uploadFile = $uploadPath . $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)) {
                    $uploadData = $this->Reports->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    //debug($uploadFile); return null;
                    if ($this->Reports->save($uploadData)) {
                        $this->Flash->success(__('File has been uploaded successfully.'));
                        $objPHPExcel = PHPExcel_IOFactory::load($uploadFile);
 
                        $dataArr = array();

                        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                            $worksheetTitle     = $worksheet->getTitle();
                            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

                            for ($row = 1; $row <= $highestRow; ++ $row) {
                                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                                    //1:1,1:15,1:35,1:45,2:1 (S.No.),2:2 (Reg. No.)
                                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                                    debug($row . $col . $val);
                                    if($col == 1 && empty($cell)) {
                                        break;
                                    }
                                    $val = $cell->getValue();
                                    $dataArr[$row][$col] = $val;
                                }
                            }
                        }
                        unset($dataArr[1]);
                        /*foreach($dataArr as $val) {
                            $query = $db->query("INSERT INTO employees SET fname = '" . $db->escape($val['1']) . "', lname = '" . $db->escape($val['2']) . "', email = '" . $db->escape($val['3']) . "', phone = '" . $db->escape($val['4']) . "', company = '" . $db->escape($val['5']) . "'");
                            $this->Flash->success(__('File has been imported successfully.'));
                        }*/
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'));
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'));
                }
            }else{
                $this->Flash->error(__('Please choose a file to upload.'));
            }

        }
        $this->set('uploadData', $uploadData);

        $files = $this->Reports->find('all', ['order' => ['Reports.created' => 'DESC']]);
        $filesRowNum = $files->count();
        $this->set('files',$files);
        $this->set('filesRowNum',$filesRowNum);
    }
    
    public function add() {
        $candidate = $this->Candidates->find('all', ['conditions' => ['Candidates.user_id' => $this->Auth->user('id')]])->toArray();
        //debug($candidate); //return false;
        if(count($candidate) > 1) {
            $this->Flash->error(__('More than 1 application forms have been received. Please contact support.'));
            return $this->redirect(['action' => 'add']);
        }
        $candidate = (count($candidate) === 1) ? $candidate[0] : $this->Candidates->newEntity();
        $flag = $this->isFormFillingOpen();
        if ($this->request->is(['patch', 'post', 'put']) && $flag === true) {
            $candidate = $this->Candidates->patchEntity($candidate, $this->request->getData());
            $candidate->user_id = $this->Auth->user('id');
            if ($this->Candidates->save($candidate)) {
                $this->Flash->success(__('Your application form has been saved.'));
                return $this->redirect(['controller' => 'preferences', 'action' => 'add']);
            }
            $this->Flash->error(__('Unable to save your application form.'));
        }
        else if($this->request->is(['patch', 'post', 'put']) && $flag === false) {
            $this->Flash->error(__('Filling of application form is closed at this time.'));
        }
        $this->set('candidate', $candidate);
        //$categories = $this->Candidates->Categories->find('all')
                                                             // ->where(['Categories.id !=' => 1]);
        //$states = $this->Candidates->States->find('all');
        $statesOptions = [];
        $catOptions = [];
        /*foreach ($states as $state) {
            $statesOptions[$state['id']] = $state['state_name'];
        }
        foreach ($categories as $category) {
            //debug($category);
            $catOptions[$category['id']] = $category['type'];
        }*/
        $this->set('states', $statesOptions);
        $this->set('categories', $catOptions);
    }
    
    public function isAuthorized($user = null) {
        return parent::isAuthorized($user);
        if(parent::isAuthorized($user)) {
            return true;
        }
        // All users with role as 'exam' can add seats seatalloted
        if (isset($user['role']) && $user['role'] === 'student' && ($this->request->getParam('action') === 'add' 
                || $this->request->getParam('action') === 'index' || $this->request->getParam('action') === 'seatalloted')) {
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
