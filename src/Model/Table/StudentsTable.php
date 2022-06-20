<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class StudentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Parents');
        $this->addBehavior('Timestamp');
    }
}