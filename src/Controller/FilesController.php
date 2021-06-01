<?php
namespace App\Controller;

use App\Controller\AppController;

class FilesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
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
        
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777);
        }
        
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $type . '_'. $_FILES['file']['name']);

        $this->Flash->success(__('File uploaded successfully'));
    }
}