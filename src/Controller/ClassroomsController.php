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
        $this->loadModel('EnterExitLogs');
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

        date_default_timezone_set("Asia/Tokyo");
        $opt_params = array(
            'singleEvents' => true, /* so we can fetch recurring events */
            // +09:00 makes sure we're using the JST timezone to filter out events 
            'timeMax' => date("Y-m-d\TH:i:s\+09:00", strtotime('today 19:00')),
            // 'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime("yesterday 23:59")),
            'timeMin' => date("Y-m-d\TH:i:s\+09:00", strtotime("today 00:00")),
            'timeZone' => 'Asia/Tokyo'
        );

        // get events by calendar ID and optional parameters
        $events = $this->getEvent($calendar_id, $opt_params);

        // Find the ones that are whole day events
        // whole day events are clear representation of number of classes
        // that day.
        // PS. in Haga's case, they are also recurring events.
        $classes = array();
        foreach ($events as $event) {
            $start_time = $event->start->dateTime;

            // we only handle the one with empty starting dateTime
            // since this means that this is all-day event
            if (empty($start_time)) {
                $start_date = $event->start->date;

                // filter out start_date that's different from today
                // There is an issue right now even if we provide
                // timeMax and timeMin correctly, we still get events
                // not in today.
                // if($start_date !== date("Y-m-d")) {
                //     continue;
                // }

                $class_name = $event->getSummary();
                $class_object = array(
                    // this event id should be logged into student enter
                    // exit operation, so we can know whether they're
                    // pre-enter, pre-exit or disabled.
                    'event_id' => $event->id,
                    'class_name' => $class_name
                );
                array_push($classes, $class_object);
            }
        }

        $this->set(compact('classroom_name'));
        $this->set(compact('classes'));
        $this->set(compact('calendar_id'));


    }

    /*
    event id, is the id of the ALL DAY event, that represents a class.
    NOT a student, NOT a calendar.
    */
    public function enterExitOperation($calendar_id, $event_title, $classroom_name, $event_id)
    {

        $this->loadModel('Settings');

        $setting = $this->Settings->findByCalendarId($calendar_id)->firstOrFail();
        $memo = $setting->memo;

        $class_name = $event_title;
        // start time range looks something like: '16:30～17:30'
        $start_time_range = explode(" ", $event_title)[1];

        // Try to find either "～" or "-" in the string
        $time_split_symbol = str_contains($start_time_range, '～') ? '～' : '-';
        $start_time = explode($time_split_symbol, $start_time_range)[0];

        $opt_params = array(
            'singleEvents' => true, /* so we can fetch recurring events */
            // Assuming classes won't start before last day midnight
            // and won't start after 7pm.
            'timeMax' => date("Y-m-d\TH:i:s\+09:00", strtotime('today 19:00')),
            'timeMin' => date("Y-m-d\TH:i:s\+09:00", strtotime("today 00:00")),
            'timeZone' => 'Asia/Tokyo'
        );

        // get events by calendar ID and optional parameters
        $events = $this->getEvent($calendar_id, $opt_params);
        $expected_datetime = date("Y-m-d\TH:i:s\+09:00", strtotime("today ".$start_time));
        
        // Find the ones that are NOT whole day events
        // PS. in Haga's case, they are also recurring events
        $students = array();

        // An Array that stores the tri state of the button
        // 1. To be checked in
        // 2. Checked in already, to be checked out
        // 3. Checked out, disabled.
        $student_states = array();

        // student names in the calendar event id is different
        // so we have to show the full name, but use the parsed name
        // for database query.
        $student_raw_names = array();

        foreach ($events as $event) {
            // we only handle the one with NON-empty starting dateTime
            // since this means that this is NOT all-day event
            if (!empty($event->start->dateTime)) {

                $this->log('event start datetime'. $event->start->dateTime, 'debug');
                // If the datetime doesn't align, we skip
                if ($expected_datetime !== $event->start->dateTime) {
                    continue;
                }

                $student_name_raw = $event->getSummary();
                $parsed_student_name = self::parseStudentNameFromEventTitle($student_name_raw);

                // Find student instance based on student name
                $query = $this->Students->findByStudentName($parsed_student_name);
                // if student's data isn't in database, insert it
                if ($query->isEmpty()){
                    $student = $this->Students->newEntity();
                    $student->student_name = $parsed_student_name;
                    $student->created = date("Y-m-d H:i:s");
                    $student->modified = date("Y-m-d H:i:s");
                    $this->Students->save($student);
                }
                $student = $this->Students->findByStudentName($parsed_student_name)->firstOrFail();
                array_push($students, $student);
                array_push($student_raw_names, $student_name_raw);

                // check whether the student is logged and push the state
                // $student_state_count = $this->EnterExitLogs->findByStudentName($parsed_student_name)->findByClassEventId($event_id)->count();
                $student_state_count = $this->EnterExitLogs->findByClassEventIdAndStudentName($event_id, $parsed_student_name)->count();
                // $this->log('student state count: '.$student_state_count, 'error');
                switch ($student_state_count) {
                    case 1:
                        array_push($student_states, 'READY_TO_EXIT');
                        // $this->log('ready to exit', 'error');
                        break;
                    case 2:
                        array_push($student_states, 'LEFT');
                        // $this->log('left', 'error');
                        break;
                    case 0:
                    default:
                        array_push($student_states, 'READY_TO_ENTER');
                        // $this->log('ready to enter', 'error');
                        break;
                }
            }
        }

        $this->set(compact('class_name'));
        $this->set(compact('students'));
        $this->set(compact('classroom_name'));
        $this->set(compact('student_raw_names'));
        $this->set(compact('student_states'));
        $this->set(compact('event_id'));
        $this->set(compact('memo'));
    }


    private function getClient()
    {
        $scopes = array('https://www.googleapis.com/auth/calendar.readonly');
        $client = new Google_Client();
        $client->setScopes($scopes);
        $client->setAuthConfig('../lsn-project-314612-a4b12fcefd67.json');

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

    private function parseStudentNameFromEventTitle($event_title) {
        $name_fractions = explode(' ', trim($event_title));
        $space_cleaned = $name_fractions[0].$name_fractions[1];

        // There will be names like 水谷哈哈(みろく)
        // notice that there's no space between the left parenthesis and
        // the last character of the student name
        // so we want to find the left parenthesis and remove
        // whatever is behund it.
        $left_par_idx = strrpos($space_cleaned, '(');
        if($left_par_idx === false) {
            return $space_cleaned;
        }
        return substr($space_cleaned, 0, $left_par_idx);
    }
}
