<?php
namespace App\Model\Table;

use Cake\Validation\Validator;
use Cake\ORM\Table;
use Cake\Network\Session;
use DateTime;

class StudentsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('students');
        $this->setPrimaryKey('id');
        
        
        /*$this->hasOne('Seats');
        $this->belongsTo('Categories');
        $this->hasMany('Preferences');*/
        
        $this->belongsTo('Categories');
        $this->belongsTo('Semesters');
        
        $this->hasMany('Fees', [
            'bindingKey' => ['semester_id'],
            'foreignKey' => ['semester_id']
        ]);
        
        $this->addBehavior('Timestamp');
    }
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('name')
            ->notEmpty('name', 'Please fill this field')
            ->requirePresence('f_name')
            ->notEmpty('f_name', 'Please fill this field')
            ->requirePresence('dob')
            ->notEmpty('dob', 'Please fill this field')
            ->add('dob', [
                'validFormat' => [
                    'rule' => array('custom', '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/'),
                    'message' => 'Please enter a valid date (DD/MM/YYYY).',
                ],
                'checkallpresent' => [
                    'rule' => function ($value, $context) {
                        //debug($value); debug($context); debug($sessionData);
                        $pattern = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/';
                        $valid = preg_match($pattern, $value);
                        if($valid === false || $valid === 0) {
                            return true;
                        }
                        $age = 0;
                        $from = new DateTime(date("Y-m-d", strtotime($value)));
                        $to   = new DateTime('today');
                        $age = $to->diff($from)->y;
                        //debug($value); debug($age); return false;
                        if($age >= 18) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    },
                    'message' => 'The minimum age requirement is not met.'
                ]
            ])
            ->requirePresence('cucet_roll_no')
            ->notEmpty('cucet_roll_no', 'Please fill this field')
            ->add('cucet_roll_no', [
                'validFormat' => [
                    'rule' => array('custom', '/^[0-9]{8}$/i'),
                    'message' => 'Please enter a valid Roll No. (8 digits)',
                ]
            ])
            ->requirePresence('category_id')
            ->notEmpty('category_id', 'Please fill this field')
            ->add('category_id', [
                'minValue' => [
                    'rule' => ['comparison', '>=', 2],
                    'message' => 'Category selected is not valid.',
                ],
                'maxValue' => [
                    'rule' => ['comparison', '<=', 5],
                    'message' => 'Category selected is not valid.',
                ]
            ])
            ->requirePresence('pwd')
            ->notEmpty('pwd', 'Please fill this field')
            ->add('pwd', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select appropriate value.',
                ]
            ])
            ->requirePresence('hostel_acco')
            ->notEmpty('hostel_acco', 'Please fill this field')
            ->add('hostel_acco', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select Yes/No value.',
                ]
            ])
            ->requirePresence('ward_of_def')
            ->notEmpty('ward_of_def', 'Please fill this field')
            ->add('ward_of_def', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select appropriate value.',
                ]
            ])
            ->requirePresence('kashmiri_mig')
            ->notEmpty('kashmiri_mig', 'Please fill this field')
            ->add('kashmiri_mig', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select appropriate value.',
                ]
            ])
            ->requirePresence('state_id')
            ->notEmpty('state_id', 'Please fill this field')
            ->add('state_id', [
                'minValue' => [
                    'rule' => ['comparison', '>=', 1],
                    'message' => 'State selected is not valid.',
                ],
                'maxValue' => [
                    'rule' => ['comparison', '<=', 36],
                    'message' => 'State selected is not valid.',
                ]
            ])
            ->allowEmpty('aadhar_no')
             ->add('aadhar_no', [
                'validFormat' => [
                    'rule' => array('custom', '/^[0-9]{4} [0-9]{4} [0-9]{4}$/i'),
                    'message' => 'Please enter a valid Aadhar No. (12 digits in format:xxxx xxxx xxxx)',
                ]
            ])
            ->requirePresence('qualif_result_declared')
            ->notEmpty('qualif_result_declared', 'Please fill this field')
            ->add('qualif_result_declared', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select appropriate value.',
                ],
                'checkallpresent' => [
                    'rule' => function ($value, $context) {
                        //debug($value); debug($context); debug($sessionData);
                        if(strcmp($value, "yes") === 0 && (intval($context['data']['qualif_marks_obtained']) === 0 || intval($context['data']['qualif_total_marks']) === 0)) {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'Please fill the fields of Marks Obtained and Total Marks appropriately.'
                ]
            ])
            ->requirePresence('qualif_degree')
            ->notEmpty('qualif_degree', 'Please fill this field')
            ->add('qualif_degree', [
                'validFormat' => [
                    'rule' => array('custom', '/^B.A.|B.Com.|B.Pharm.|B.Sc.|B.Tech.\/B.E.|BBA|LL.B.|Other$/'),
                    'message' => 'Please select valid Qualifying Degree.',
                ]
            ])
            ->requirePresence('valid_gate_gpat')
            ->notEmpty('valid_gate_gpat', 'Please fill this field')
            ->add('valid_gate_gpat', [
                'validFormat' => [
                    'rule' => array('custom', '/^yes|no$/i'),
                    'message' => 'Please select appropriate value.',
                ],
                'checkallpresent' => [
                    'rule' => function ($value, $context) {
                        //debug($value); debug($context); debug($sessionData);
                        $match = true;
                        if(strcmp($value, "yes") === 0) {
                            $match = (strcmp($context['data']['ggp_exam'], "GATE") === 0 || strcmp($context['data']['ggp_exam'], "GPAT") === 0) ? true : false;
                            if($match === false) {
                                return $match;
                            }
                            $pattern = '/^[0-9]{4}$/';
                            $match = (preg_match($pattern, $context['data']['ggp_year_passing'])) ? true : false;
                            if($match === false) {
                                return $match;
                            }
                            $pattern = '/[0-9]+/';
                            $match = (preg_match($pattern, $context['data']['ggp_marksobtained_rank'])) ? true : false;
                        }
                        return $match;
                    },
                    'message' => 'Please fill below fields (e.g. Examination/Roll Number/Year of Passing/Marks Obtained.)'
                ]
            ]);
            
        return $validator;
    }
    
    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);
    }
}
