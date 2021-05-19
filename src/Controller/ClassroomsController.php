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
        $this->loadModel('Students');
    }

    public function index()
    {
        $classrooms = $this->Paginator->paginate($this->Classrooms->find());
        $this->set(compact('classrooms'));
    }

    public function enterExitOperation($classroom)
    {
        $this->set(compact('classroom'));
        
        $students = $this->Paginator->paginate($this->Students->findByClassroom($classroom));
        $this->set(compact('students'));
    }

    public function enterExit($student_id)
    {
        $this->request->allowMethod(['post']);

        $student = $this->Students->findById($student_id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            if ($student->status == 'stay') {
                $student->status = 'leave';
                $text = $student->student_name . ' status: leave';
            } else {
                $student->status = 'stay';
                $text = $student->student_name . ' status: stay';
            }
            
            if ($this->Students->save($student)) {
                $this->Flash->success(__($text));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Got something wrong :('));
        }
    }
}