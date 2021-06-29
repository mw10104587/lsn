<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class LineBotUser extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}