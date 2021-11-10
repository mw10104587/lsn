<?php
namespace App\Controller;

use App\Controller\AppController;
use Google_Client;
use Google_Service_Calendar;

class ClassroomsController extends AppController
{
    private $todaysEvents;

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

    // Some days, there are multiple classes and that the same student
    // might be in both classes. Adding this intermediate step so that
    // the teacher actually get to pick the right class before showing
    // the enter exit operation page.
    public function pickClass($calendar_id, $classroom_name) {

        // Fetch all the events
        date_default_timezone_set("Asia/Tokyo");

        $this->log(date("Y-m-d\TH:i:s\Z", strtotime('today 19:00')), 'error');
        $this->log(date("Y-m-d\TH:i:s\Z", strtotime("today 8:00")),'error');

        $opt_params = array(
            'singleEvents' => true, /* so we can fetch recurring events */
            'timeMax' => date("Y-m-d\TH:i:s\Z", strtotime('today 19:00')),
            'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime("yesterday 23:59")),
            'timeZone' => 'Asia/Tokyo'
        );

        // get events by calendar ID and optional parameters
        $this->events = $this->getEvent($calendar_id, $opt_params);

        // Find the ones that are whole day events
        // whole day events are clear representation of number of classes
        // that day.
        // PS. in Haga's case, they are also recurring events.
        $classes = array();
        foreach ($this->events as $event) {
            $start_time = $event->start->dateTime;

            // we only handle the one with empty starting dateTime
            // since this means that this is all-day event
            if (empty($start_time)) {
                $start_date = $event->start->date;

                // filter out start_date that's different from today
                // There is an issue right now even if we provide
                // timeMax and timeMin correctly, we still get events
                // not in today.
                if($start_date !== date("Y-m-d")) {
                    continue;
                }

                $class_name = $event->getSummary();
                array_push($classes, $class_name);
            }
        }

        // $this->log($classes, 'error');
        $this->set(compact('classroom_name'));
        $this->set(compact('classes'));


    }

    public function enterExitOperation($calendar_id, $classroom_name)
    {
        date_default_timezone_set("Asia/Tokyo");

        $opt_params = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMax' => date("Y-m-d\TH:i:s\Z", strtotime('tomorrow')),
            'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime('today')),
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
