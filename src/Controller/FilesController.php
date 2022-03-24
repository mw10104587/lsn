<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;

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
        
        $arr_file_types = [
            'text/csv', 
            'application/vnd.ms-excel' /* allow ms-excel csv file as well */
        ];

        if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
            $this->log('file_type:'. $_FILES['file']['type'], 'debug');
            $this->Flash->error(__( env('DEBUG') ? 'Please choose a csv file' : 'csvファイルを選択してください'));
            return;
        }

        // open csv file
        $row = 1;
        $data = [];
        if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
            while (($line = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // The first row is the header. We skip it.
                if($row === 1) {
                    $row++;
                    continue;
                }

                $column_count = count($line);
                $row++;

                switch($type) {
                    case 'parents':
                        if($column_count < 6) {
                            throw new Exception('too little columns for parents table');
                        }

                        $parent = [];
                        for($c = 0; $c < $column_count; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $parent['id'] = $line[$c];
                                    break;
                                case 1:
                                    $parent['parents_name'] = $line[$c];
                                    break;
                                case 2:
                                    $parent['phone'] = $line[$c];
                                    break;
                                case 3:
                                    $parent['address1'] = $line[$c];
                                    break;
                                case 4:
                                    $parent['address2'] = $line[$c];
                                    break;
                                case 5:
                                    $parent['address3'] = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $parent;
                        break;
                    case 'parents_email':
                        if($column_count < 2) {
                            throw new Exception('too little columns for parent email table');
                        }

                        $parent_email = [];
                        for($c = 0; $c < $column_count; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $parent_email['parent_id'] = $line[$c];
                                    break;
                                case 1:
                                    $parent_email['email'] = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $parent_email;
                        break;
                    case 'student':
                        if($column_count < 8) {
                            throw new Exception('too little columns for student table');
                        }

                        $student = [];
                        for($c = 0; $c < $column_count; $c++) {
                            // remove \ufeff
                            if($c == 0) {
                                $line[$c] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $line[$c]);
                            }
                            switch($c) {
                                case 0:
                                    $student['parent_id'] = $line[$c];
                                    break;
                                case 1:
                                    $student['id'] = $line[$c];
                                    break;
                                case 2:
                                    $student['student_name'] = $line[$c];
                                    break;
                                case 3:
                                    $student['student_furigana'] = $line[$c];
                                    break;
                                case 4:
                                    $student['school_year'] = $line[$c];
                                    break;
                                case 5:
                                    $student['classroom'] = $line[$c];
                                    break;
                                case 6:
                                    $student['class'] = $line[$c];
                                    break;
                                case 7:
                                    $student['subject'] = $line[$c];
                                    break;
                            }
                        }
                        $data[] = $student;
                        break;
                }
            }

            if($type == 'parents') {
                $parent = $this->Parents->newEntities($data);
                if($this->Parents->saveMany($parent)) {
                    $this->Flash->success(__(env('DEBUG') ? 'File uploaded successfully' : 'ファイルが正常にアップロードされました'));
                } else {
                    $this->Flash->error(__(env('DEBUG') ? 'File uploaded failed': 'アップロードされたファイルが失敗しました'));
                }
            }
            else if($type == 'parents_email') {
                // filter duplicate email
                $email_set = array();
                $filtered_data = [];
                for($i = 0; $i < count($data); $i++) {
                    $size_before_setting = count($email_set);
                    // $this->log('size before: '.$size_before_setting, 'error');
                    $email_set[$data[$i]['email']] = true;
                    $size_after_setting = count($email_set);
                    // $this->log('size after: '.$size_after_setting, 'error');
                    if($size_after_setting == $size_before_setting + 1) {
                        $filtered_data[] = $data[$i];
                    }
                }

                $email = $this->Emails->newEntities($filtered_data);
                if($this->Emails->saveMany($email)) {
                    $this->Flash->success(__(env('DEBUG') ? 'File uploaded successfully' : 'ファイルが正常にアップロードされました'));
                } else {
                    $this->Flash->error(__(env('DEBUG') ? 'File uploaded failed': 'アップロードされたファイルが失敗しました'));
                }
            }
            else {
                $student = $this->Students->newEntities($data);
                if($this->Students->saveMany($student)) {
                    $this->Flash->success(__(env('DEBUG') ? 'File uploaded successfully' : 'ファイルが正常にアップロードされました'));
                } else {
                    $this->Flash->error(__(env('DEBUG') ? 'File uploaded failed': 'アップロードされたファイルが失敗しました'));
                }
            }
            fclose($handle);
        }
    }
}
