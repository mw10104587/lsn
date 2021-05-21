<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ParentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasMany('Students');
    }
}