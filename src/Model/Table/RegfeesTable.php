<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ReceivedfeesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('receivedfees');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Students', [
            'bindingKey' => ['student_id'],
            'foreignKey' => ['student_id']
        ]);
        
        $this->addBehavior('Timestamp');
    }
}