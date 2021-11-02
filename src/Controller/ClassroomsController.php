<?php
namespace App\Controller;

use App\Controller\AppController;
use Google_Client;
use Google_Service_Calendar;

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
        $classrooms = $this->getCalendarIDsAndNamesTuple();
        $this->set(compact('classrooms'));
    }

    public function enterExitOperation($calendar_id, $classroom_name)
    {
        date_default_timezone_set("Asia/Tokyo");
        // $start = date('Y-m-d\TH:i:s\Z', strtotime('now'));
        // $end = date('Y-m-d\TH:i:s\Z', strtotime('+30 minutes'));

        $opt_params = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            // 'timeMax' => date("Y-m-d\TH:i:s\Z", strtotime('tomorrow')),
            // 'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime('today')),
        );

        // get events by calendar ID and optional parameters
        $events = $this->getEvent($calendar_id, $opt_params);
        $students = array();

        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (!empty($start)) {
                $student_name = $event->getSummary();

                $query = $this->Students->findByStudentName($student_name);
                // if student's data isn't in database, insert it
                if ($query->isEmpty()){
                    $student = $this->Students->newEntity();
                    $student->student_name = $student_name;
                    $student->created = date("Y-m-d H:i:s");
                    $student->modified = date("Y-m-d H:i:s");
                    $this->Students->save($student);
                }
                $student = $this->Students->findByStudentName($student_name)->firstOrFail();
                array_push($students, $student);
            }
        }

        $this->set(compact('classroom_name'));
        $this->set(compact('students'));
        $this->set(compact('events'));
    }

    private function getClient()
    {
        $scopes = array('https://www.googleapis.com/auth/calendar.readonly');
        $client = new Google_Client();
        $client->setScopes($scopes);
        $client->setAuthConfig('lsn-project-314612-a4b12fcefd67.json');

        return $client;
    }

    private function getEvent($calendar_id, $opt_params)
    {
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);
        $results = $service->events->listEvents($calendar_id, $opt_params);

        return $results;
    }

    private function getCalendarIDsAndNamesTuple() /* [calendar_id, calendar_name] */
    {
        $this->loadModel('Settings');
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($this->getClient());

        $classrooms = array();
        $calendar_list = $this->Settings->find();

        foreach($calendar_list as $calendar) {
            $classrooms[$calendar->calendar_id] = $calendar->calendar_id;
        }

        // TODO: Check whether API supports fetching multiple at the same time.
        $get_calendar_name = function($calendar_id) use($service) {
            $calendar = $service->calendars->get($calendar_id);
            return [$calendar_id, $calendar->getSummary()];
        };

        return array_map($get_calendar_name, array_keys($classrooms));
    }
}
