<?php
namespace App\Controller;

use Cake\I18n\Time;

use App\Controller\AppController;

class StudentsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $results = $this->Students->find('all')
        // This is limiting to showing only students with parent data, not sure if we want this.
            ->where(['Students.parent_id <>' => 0])
            ->contain(['Parents']);

        $this->log($results, 'error');
        $this->set(compact('results'));
    }

    public function information($student_id)
    {
        $this->render(false);
        $student = $this->Students->findById($student_id)->contain(['Parents'])->firstOrFail();
        echo $student;
    }
}
