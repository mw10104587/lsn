<?php
namespace App\Controller;

use App\Controller\AppController;

class EnterExitLogsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $results = $this->EnterExitLogs->find('all');
        $this->set(compact('results'));
    }
}