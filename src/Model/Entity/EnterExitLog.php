<?php
use Cake\ORM\Entity;

class EnterExitLog extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}