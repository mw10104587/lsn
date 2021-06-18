<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Email extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}