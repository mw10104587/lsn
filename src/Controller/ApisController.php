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

        // Grab Request Body Data.
        $classroom_name = $this->request->getParsedBody()['classroom_name'];
        $class_event_id = $this->request->getParsedBody()['class_event_id'];

        $student = $this->Students->findById($student_id)->contain(['Parents'])->firstOrFail();
        $parent_id = $student->parent_id;
        $parent = $this->Parents->findById($parent_id)->firstOrFail();
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

                // Send notification to parent if we found their id
                // if not, we log the incident.
                if($parent_id == 0) {
                    $this->log('parent_id is null for student with id: '.$student_id, 'error');
                } else {
                    $line_bot_user = $this->LineBotUsers->findByParentId($parent_id)->firstOrFail();
                    $line_bot_id = $line_bot_user->line_bot_id; //The Line Account ID of the Parent

                    // Send Push Message to parent.
                    $httpClient = new LINEBot\HTTPClient\CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
                    $bot = new LINEBot($httpClient, [env('LINE_CHANNEL_SECRET') => env('LINE_CHANNEL_SECRET')]);
                    $text_message = $this->getFormattedLineMessage($parent->parents_name, $student->student_name, $classroom_name);
                    $text_message_builder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_message);
                    $response = $bot->pushMessage($line_bot_id, $text_message_builder);
                }
            }

            // Log to enter_exit_logs
            $enter_exit_log = $this->EnterExitLogs->newEntity();
            $enter_exit_log->student_id = $student->id;
            $enter_exit_log->student_name = $student->student_name;
            $enter_exit_log->parent_id = $parent_id;
            $enter_exit_log->class_event_id = $class_event_id;
            $parent_phone = $parent->phone != null && $parent->phone != "" ? $parent->phone: "NO_PHONE";
            $enter_exit_log->phone = $parent_phone;
            $enter_exit_log->enter_or_exit = $student->status;
            $this->EnterExitLogs->save($enter_exit_log);

            if ($this->Students->save($student)) {
                $this->log($return_json, 'error');
                echo json_encode($return_json);
            } else {
                echo "Failure";
            }
        }
    }

    private function getFormattedLineMessage($parent_name, $student_name, $classroom_name) {
        return "【登校のお知らせ】\n".
                $parent_name."様\n".
                $student_name.'様が'.$classroom_name."クラスに登校しました。がコーディング教室に到着しました。";
    }


}
