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

    // public function findAuth(\Cake\ORM\Query $query, array $options)
    // {
    //     $query
    //         ->select(['id', 'user_id', 'password']);

    //     return $query;
    // }
}