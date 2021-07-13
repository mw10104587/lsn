<?php
namespace App\Controller;

use App\Controller\AppController;

class FilesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Parents');
        $this->loadModel('Emails');
        $this->loadModel('Students');
    }

    public function parents()
    {
        
    }

    public function parentsEmail()
    {

    }

    public function student()
    {

    }

    public function ajax($type)
    {
        // set this route only for receiving ajax call 
        // and would not be rendered
        $this->render(false);

        $arr_file_types = ['text/csv'];
        
        if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
            $this->Flash->error(__('Please choose a csv file'));
            return;
        }

        // open csv file
        $row = 1;
        $data = [];
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            while (($line = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($line);
                $row++;
                $element = [];
                switch($type) {
                    case 'parents':
                        for($c = 0; $c < $num; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $parent->id = $line[$c];
                                    break;
                                case 1:
                                    $parent->parents_name = $line[$c];
                                    break;
                                case 2:
                                    $parent->phone = $line[$c];
                                    break;
                                case 3:
                                    $parent->address1 = $line[$c];
                                    break;
                                case 4:
                                    $parent->address2 = $line[$c];
                                    break;
                                case 5:
                                    $parent->address3 = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $element;
                        break;
                    case 'parents_email':
                        for($c = 0; $c < $num; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $element['parent_id'] = $line[$c];
                                    break;
                                case 1:
                                    $element['email'] = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $element;
                        break;
                    case 'student':
                        for($c = 0; $c < $num; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $student->parent_id = $line[$c];
                                    break;
                                case 1:
                                    $student->id = $line[$c];
                                    break;
                                case 2:
                                    $student->student_name = $line[$c];
                                    break;
                                case 3:
                                    $student->furigana = $line[$c];
                                    break;
                                case 4:
                                    $student->school_year= $line[$c];
                                    break;
                                case 5:
                                    $student->classroom = $line[$c];
                                    break;
                                case 6:
                                    $student->class = $line[$c];
                                    break;
                                case 7:
                                    $student->subject = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $element;
                        break;
                }
            }

            if($type == 'parent') {
                $parent = $this->Parents->newEntities($data);
                if($this->Parents->saveMany($parent)) {
                    $this->Flash->success(__('File uploaded successfully'));
                } else {
                    $this->Flash->error(__('File uploaded failed'));
                }
            } 
            else if($type == 'parents_email') {
                $email = $this->Emails->newEntities($data);
                if($this->Emails->saveMany($email)) {
                    $this->Flash->success(__('File uploaded successfully'));
                } else {
                    $this->Flash->error(__('File uploaded failed'));
                }
            }
            else {
                $student = $this->Students->newEntities($data);
                if($this->Students->saveMany($student)) {
                    $this->Flash->success(__('File uploaded successfully'));
                } else {
                    $this->Flash->error(__('File uploaded failed'));
                } 
            }
            fclose($handle);
        }
    }
}