<?php
namespace App\Model\Table;

use Cake\Validation\Validator;
use Cake\ORM\Table;
use Cake\Network\Session;
use DateTime;

class SemestersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('semesters');
        $this->setPrimaryKey('id');
        
        $this->hasOne('Students');
        /*$this->hasOne('Seats');
        $this->belongsTo('Categories');
        $this->hasMany('Preferences');
        $this->hasOne('States');*/
        
        $this->addBehavior('Timestamp');
    }
    
}