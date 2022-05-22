<?php
namespace App\Controller;

use App\Controller\AppController;
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;

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
        $this->loadModel('LineBotUsers');
        $this->loadModel('Parents');
        $this->loadModel('EnterExitLogs');
        $this->request->allowMethod(['post']);

        if(!$this->request->is(['post', 'put'])) {
            return $this->response->withStringBody('Not supported Restful Method.');
        }

        // Grab Request Body Data.
        $classroom_name = $this->request->getParsedBody()['classroom_name'];
        $class_event_id = $this->request->getParsedBody()['class_event_id'];
        $new_status = $this->request->getParsedBody()['new_status'];

        $return_json = [];

        // Update Student Status
        // $student = $this->Students->findById($student_id)->contain(['Parents'])->firstOrFail();
        // This should never fail since when we render the button, we check if the student
        // is present in the database, if not, we create an instance for them.
        $student = $this->Students->findById($student_id)->firstOrFail();
        if ($new_status == 'LEFT' /* $student->status == 'stay' */) {
            $student->status = 'leave';
            $return_json['status'] = 'leave';
            $return_json['studentName'] = $student->student_name;
        } else if($new_status == 'READY_TO_EXIT') {
            $student->status = 'stay';
            $return_json['status'] = 'stay';
            $return_json['studentName'] = $student->student_name;
        } else {
            $this->log('We are assuming no students would stop the button status on
            READY_TO_ENTER, but we have this incident happened', 'warning');

            // Setting the Student status to empty helps us render student status 
            // correctly on enter exit view
            $student->status = ''; 
            $return_json['status'] = 'stay';
            $return_json['studentName'] = $student->student_name;
            // return $this->response->withStringBody('No Status Update.');
        }

        if($this->Students->save($student)) {
            $return_json['student_status_update'] = 'success';
        } else {
            $return_json['student_status_update'] = 'failed';
        }

        $parent_id = $student->parent_id;
        $parent = $this->Parents->findById($parent_id)->first();
        $parent_phone = $parent == null ? 'NO_PARENT_PHONE': $parent->phone;

        // Log to enter_exit_logs no matter there's parent attached
        $enter_exit_log = $this->EnterExitLogs->newEntity();
        $enter_exit_log->student_id = $student->id;
        $enter_exit_log->student_name = $student->student_name;
        $enter_exit_log->parent_id = $parent_id;
        $enter_exit_log->class_event_id = $class_event_id;
        $enter_exit_log->phone = $parent_phone;
        $enter_exit_log->enter_or_exit = $student->status;
        if($this->EnterExitLogs->save($enter_exit_log)) {
            $return_json['enter_exit_log_status'] = 'success';
        } else {
            $return_json['enter_exit_log_status'] = 'failed';
        }

        // Send notification to parent if we found their id
        // if not, we log this as an error
        if($parent_id == 0) {
            $this->log('parent_id is null for student with id: '.$student_id, 'error');
            $return_json['line_notify'] = 'failed. No Parent Info';
        } else {
            $line_bot_user = $this->LineBotUsers->findByParentId($parent_id)->first();
            if((!$line_bot_user) || !$line_bot_user->email_verified) {
                $return_json['line_notify'] = 'failed';

                if($line_bot_user == null) {
                    $this->log("Line Account is not connected for student with id: ".
                            $student_id.", and parent_id: ".$parent_id, 'error');
                } else {
                    $this->log("Email is not verified for student with id: ".
                            $student_id.", and parent_id: ".$parent_id, 'error');
                }

            } else {
                $line_bot_id = $line_bot_user->line_bot_id; //The Line Account ID of the Parent
                // Send Push Message to parent.
                $httpClient = new LINEBot\HTTPClient\CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
                $bot = new LINEBot($httpClient, [env('LINE_CHANNEL_SECRET') => env('LINE_CHANNEL_SECRET')]);
                $text_message = $this->getFormattedLineMessage(
                    $parent->parents_name,
                    $student->student_name,
                    $classroom_name,
                    $return_json['status']
                );
                $text_message_builder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_message);
                $response = $bot->pushMessage($line_bot_id, $text_message_builder);
            }
        }

        return $this->response->withType('application/json')
                    ->withStringBody(json_encode($return_json));
    }

    private function getFormattedLineMessage($parent_name, $student_name, $classroom_name, $stay_or_leave) {
        $arrived_or_leave_string = $stay_or_leave == 'stay' ? "がコーディング教室に到着しました。" : "コーディングクラスを離れました。";

        return "【登校のお知らせ】\n".
                $parent_name."様\n".
                $student_name.'様が'.$classroom_name."".$arrived_or_leave_string;
    }


}
