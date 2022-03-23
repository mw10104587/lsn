<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('username')
            ->notEmptyString('username')
            ->requirePresence('password')
            ->notEmptyString('password');

        return $validator;
    }
}