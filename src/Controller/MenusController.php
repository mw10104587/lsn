<?php
namespace App\Controller;

use App\Controller\AppController;

class MenusController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        if(!$this->Auth->user()) {
            $this->redirect($this->referer());
        }
        $identity = $this->Auth->user('identity');
        $this->set(compact('identity'));
    }
}