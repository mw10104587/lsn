<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Classroom extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}