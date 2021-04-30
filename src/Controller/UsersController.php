<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
    }

    public function index()
    {
        $users = $this->Paginator->paginate($this->Users->find());
        $this->set(compact('users'));
    }

    public function view($user_name)
    {
        $user = $this->Users->findByUserName($user_name)->firstOrFail();
        $this->set(compact('user'));
    }
}