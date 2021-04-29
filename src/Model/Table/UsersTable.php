<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class UsersTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}