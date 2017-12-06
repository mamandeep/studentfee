<?php

namespace App\Model\Table;

use Cake\Validation\Validator;
use Cake\ORM\Table;

class RegistrationsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setPrimaryKey('id');
        
        
        $this->addBehavior('Timestamp');
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('username')
            ->notEmpty('username', 'Please fill this field')
            ->add('username', [
                'correct' => [
                    'rule' => function ($value, $context){
                        $pattern = '/^admin|16[a-zA-Z]{6}[0-9]{2}$/';
                        //debug($value); debug(preg_match($pattern, $value));
                        if(preg_match($pattern, $value)) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    },
                    'message' => 'The username is not a valid CUPB Registration Number.'
                ]
            ])
            ->requirePresence('email')
            ->notEmpty('email', 'Please fill this field')
            ->add('email', [
                'correct' => [
                    'rule' => function ($value, $context) {
                        return (!filter_var($value, FILTER_VALIDATE_EMAIL) === false) ? true : false;
                    },
                    'message' => 'The email Id. should be valid. e.g. abc@xyz.com'
                ]
            ])
            ->requirePresence('mobile')
            ->notEmpty('mobile', 'Please fill this field')
            ->add('mobile', [
                'correct' => [
                    'rule' => function ($value, $context){
                        $pattern = '/^[789]\d{9}$/';
                        //debug($value); debug(preg_match($pattern, $value));
                        if(preg_match($pattern, $value)) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    },
                    'message' => 'The mobile no. should be 10 digit.'
                ]
            ])
            ->requirePresence('password')
            ->notEmpty('password', 'Please fill this field')
            ->add('password', [
                'length' => [
                    'rule' => function ($value, $context){
                        return (strlen($value) >= 8);
                    },
                    'message' => 'The length of password must be atleast 8 digits.'
                ],
                'number' => [
                    'rule' => function ($value, $context){
                        $pattern = '/[0-9]+/';
                        if(preg_match($pattern, $value)) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    },
                    'message' => 'The password must contain atleast 1 number.'
                ],
                'alphabet' => [
                    'rule' => function ($value, $context){
                        $pattern = '/[a-zA-Z]+/';
                        if(preg_match($pattern, $value)) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    },
                    'message' => 'The password must contain atleast 1 alphabet.'
                ],
                'match' => [
                    'rule' => function ($value, $context){
                        $password_confirm = $context['data']['password_confirm'];
                        return ($value === $password_confirm);
                    },
                    'message' => 'The password and confirm password do not match.'
                ]
            ]);
        return $validator;
    }
}
