<?php
namespace App\Controller;

use App\Controller\AppController;

class EnterExitLogsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Parents');
    }

    public function index()
    {
        $results = $this->EnterExitLogs->find('all');
        $this->set(compact('results'));
    }
    
    public function information($parent_id)
    {
        $this->render(false); 
        $parent = $this->Parents->findById($parent_id)->firstOrFail();
        echo $parent;
    }
}