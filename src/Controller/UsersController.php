<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

    public $paginate = array(
        'limit' => 10,
        'conditions' => array('status' => '1'),
        'order' => array('Users.username' => 'asc' ) 
    );
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'login']);
        $this->Auth->config('authenticate', [
            'Basic' => ['userModel' => 'Users'],
            'Form' => ['userModel' => 'Users']
        ]);
    }

    public function index()
    {
        //$this->set('users', $this->Users->find('all'));
        //$query = $this->Users->find('all')->where(['author_id' => 1]);
        //$this->set('users', $this->paginate($query));
        $this->set('users', $this->paginate());
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                //$this->Auth->setUser($user->toArray());
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'login'
                ]);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
	
    public function login()
    {        
	if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            //debug($user);
            if ($user) {
                $this->Auth->setUser($user);
                return $this->checkAndRedirect($user);
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
	else if($this->request->is('post') && $flag === false) {
		$this->Flash->error(__('Login is closed at this time.'));
	}
        $user = $this->Users->newEntity();
        $this->set('users', $user);
    }
	
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    private function checkAndRedirect(User $user) {
        if (isset($user['role']) && $user['role'] === 'student') {
            return $this->redirect([
                        'controller' => 'students',
                        'action' => 'feesubmission'
                    ]);
        }
        else if(isset($user['role']) && $user['role'] === 'admin') {
            return $this->redirect([
                        'controller' => 'reports',
                        'action' => 'dashboard'
                    ]);
        }
        return $this->redirect($this->Auth->redirectUrl());
                    
    }
    
    public function activate($id = null) {
        $user = "";
        if(intval(trim($id)) > 0)
            $user = $this->Users->get($id);
        else
            return false;
        $user = $this->Users->patchEntity($user, ['status' => 0]);
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                //$this->Auth->setUser($user->toArray());
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect([
                    'controller' => 'articles',
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
    
    public function deactivate($id = null) {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                //$this->Auth->setUser($user->toArray());
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect([
                    'controller' => 'articles',
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
    
    public function prelogin() {
        
    }

    public function isAuthorized($user = null) {
        // All users with role as 'exam' can add seats
        if ($this->request->getParam('action') === 'login' || $this->request->getParam('action') === 'logout'
                || $this->request->getParam('action') === 'prelogin') {
            return true;
        }

        return parent::isAuthorized($user);
    }
    
}
