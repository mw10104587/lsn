<?php
namespace App\Controller;

use App\Controller\AppController;

class ApisController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function enterExit($student_id)
    {
        $this->render(false);
        $this->loadModel('Students');

        $this->request->allowMethod(['post']);
        $student = $this->Students->findById($student_id)->contain(['Parents'])->firstOrFail();
        $return_json = [];
        if ($this->request->is(['post', 'put'])) {
            if ($student->status == 'stay') {
                $student->status = 'leave';
                $return_json['status'] = 'leave';
                $return_json['studentName'] = $student->student_name;
            } else {
                $student->status = 'stay';
                $return_json['status'] = 'stay';
                $return_json['studentName'] = $student->student_name;
            }

            if ($this->Students->save($student)) {
                echo json_encode($return_json);
            } else {
                echo "Failure";
            }
        }
    }


    public function lineNotify($student_id)
    {
        $this->autoRender = false;
        $this->render(false);

        $this->log($this->request->getData('class_event_id'), 'error');
        $class_event_id = $this->request->getData('class_event_id');
        $this->log($class_event_id, 'error');

        $this->loadModel('Students');
        $this->loadModel('Parents');
        $this->loadModel('EnterExitLogs');
        $this->loadModel('LineBotUsers');
        $student_data = $this->Students->findById($student_id)->contain(['Parents'])->firstOrFail();
        $parent_id = $student_data->parent_id;
        // insert to enter_exit_logs
        $enter_exit_log = $this->EnterExitLogs->newEntity();
        $enter_exit_log->student_id = $student_data->id;
        $enter_exit_log->student_name = $student_data->student_name;
        $enter_exit_log->parent_id = $parent_id;

        // Add calendar event id
        $enter_exit_log->class_event_id = $class_event_id;

        // I think we should be able to remove this field.
        $enter_exit_log->phone = '0800-090-000'; // TEMP
        $enter_exit_log->enter_or_exit = $student_data->status;

        if($this->EnterExitLogs->save($enter_exit_log)) {
            // $this->
            // echo 'Successfully insert the log.';
        } else {
            // echo 'Something got wrong.';
        }

        $query = $this->LineBotUsers->findByParentId($parent_id);

        if(!$query->isEmpty()) {
            $line_bot_user = $this->LineBotUsers->findByParentId($parent_id)->firstOrFail();
            $line_bot_id = $line_bot_user->line_bot_id;

            // call line api
            $url = 'https://lsn-line-chatbot.herokuapp.com/notify';
            $data = array(
                'line_bot_id' => $line_bot_id,
                'student' => $student_data->student_name,
                'status' => $student_data->status
            );

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            file_get_contents($url, false, $context);
            $parent = $this->Parents->findById($parent_id)->firstOrFail();
            $parent_phone = $parent->phone;
        }
        else {
            // echo 'no existing line bot id';
            $this->log('no existin line bot id', 'debug');
        }


    }


}
