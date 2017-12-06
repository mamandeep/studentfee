<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FeesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fees');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Students', [
            'bindingKey' => ['semester_id'],
            'foreignKey' => ['semester_id']
        ]);
        
        $this->addBehavior('Timestamp');
    }
}