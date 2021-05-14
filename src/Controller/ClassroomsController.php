<?php
namespace App\Controller;

use Cake\I18n\Time;

use App\Controller\AppController;

class ClassroomsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadModel('Student');
    }

    public function index()
    {
        $classrooms = $this->Paginator->paginate($this->Classrooms->find());
        $this->set(compact('classrooms'));
    }

    public function enterExitOperation($classroom)
    {
        $this->set(compact('classroom'));

        $now = Time::now()->i18nFormat('yyyy-mm-dd HH:mm:ss', 'Asia/Shanghai');
        $this->set(compact('now'));
        
        $this->loadModel('Students');
        $students = $this->Paginator->paginate($this->Students->findByClassroom($classroom));
        $this->set(compact('students'));
    }
}