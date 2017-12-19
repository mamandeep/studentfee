<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Cache\Cache;
use \DateTime;
use \DateTimeZone;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    var $OTPValidity = "30";
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        Cache::disable();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'username', 'password' => 'password'],
                    'passwordHasher' => array(
                        'className' => 'Default'
                    )
                ]
            ],
            'storage' => 'Session',
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'reports',
                'action' => 'dashboard'
            ],
            /*'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'*/
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login',
                'home'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'candidates',
                'action' => 'add',
                'prefix' => false
            ],
            'authError' => 'You must be authorized to view this page.',
            'loginError' => 'Invalid Username or Password entered, please try again.'
        ]);
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        $this->loadComponent('Auth');
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        //if ($this->Auth->user()) {
            $this->viewBuilder()->theme('AdminLTE');
            $this->set('theme', Configure::read('Theme'));
        //}
            //debug($this->Auth->user());
        $this->set('user', $this->Auth->user());
    }
	
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['prelogin', 'logout']);
    }

    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'report') {
            return true;
        }

        // Default deny
        return false;
    }
    
    protected function is_connected() {
        $connected = @fsockopen("www.smsjust.com", 80);
        $is_conn = false;
        
        if($connected) {
            $is_conn = true;
            fclose($connected);
        }
        else {
            $is_conn = false;
        }
        
        return $is_conn;
    }
    
    protected function getOTPTimeGap($reg_user){
        $generted_time = new DateTime($reg_user['otp_timestamp'], new DateTimeZone("Asia/Calcutta"));
        $now = new DateTime();
        
        $diff = $now->diff($generted_time);
        
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);
        $minutes = $diff->i;
        $minutes = $minutes + ($hours * 60);
        
        return $minutes;
        
    }
    
    protected function smsSend($mobile_no, $message) {
        //$username = urlencode("u1810"); 
        $username = urlencode("cuplib"); 
        $password = urlencode("cuplib@123");
        //$msg_token = urlencode("fP9oW6"); 
        //$sender_id = urlencode("BBSBEC"); // optional (compulsory in transactional sms) 
        $sender_id = urlencode("CUPEXM");
        $message = urlencode($message); 
        $mobile = urlencode($mobile_no); 

        //$api = "http://manage.sarvsms.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

        $api = "http://www.smsjust.com/sms/user/urlsms.php?username=".$username."&pass=".$password."&senderid=".$sender_id."&dest_mobileno=".$mobile."&message=".$message."&response=Y";
        $response = file_get_contents($api);

        return $response; 
    }
    
    protected function ozekiOTP($length = 8, $chars = 'BCDFGHJKMPQRTVWXY2346789')
    {
        $chars_length = (strlen($chars) - 1);
        $string = $chars{rand(0, $chars_length)};
        for ($i = 1; $i < $length; $i = strlen($string))
        {
            $r = $chars{rand(0, $chars_length)};
            if ($r != $string{$i - 1}) $string .=  $r;
        }
        return $string;
    }
    
    protected function isFormFillingOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-09-01 08:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-12-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isStatusCheckingOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-09-01 08:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-10-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isPrintingReceiptOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-09-01 08:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-11-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isPreferenceFillingOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-06-09 11:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-07-30 08:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isViewSeatOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-06-18 11:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-06-19 14:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isLockingSeatOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-06-16 05:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-06-19 14:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
    
    protected function isSubmitFeeOpen() {
        $current_datetime = new DateTime();
        $current_datetime->setTimezone(new DateTimeZone('Asia/Calcutta'));
        $open_datetime = new DateTime("2017-06-19 08:59:59", new DateTimeZone('Asia/Calcutta'));
        $close_datetime = new DateTime("2017-07-21 15:59:59", new DateTimeZone('Asia/Calcutta'));
        if ($current_datetime >= $open_datetime && $current_datetime <= $close_datetime) {
            return true;
        }
        else {
            return false;
        }
    }
}
