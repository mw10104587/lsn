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

    // Some days, there are multiple classes and that the same student
    // might be in both classes. Adding this intermediate step so that
    // the teacher actually get to pick the right class before showing
    // the enter exit operation page.
    public function pickClass($calendar_id, $classroom_name) {

        date_default_timezone_set("Asia/Tokyo");

        // $this->log(date("Y-m-d\TH:i:s\Z", strtotime('today 19:00')), 'error');
        // $this->log(date("Y-m-d\TH:i:s\Z", strtotime("today 8:00")),'error');

        $opt_params = array(
            'singleEvents' => true, /* so we can fetch recurring events */
            'timeMax' => date("Y-m-d\TH:i:s\Z", strtotime('today 19:00')),
            'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime("yesterday 23:59")),
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
                if($start_date !== date("Y-m-d")) {
                    continue;
                }

                $class_name = $event->getSummary();
                $class_object = array(
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

    public function enterExitOperation($calendar_id, $event_title)
    {
        $class_name = $event_title;
        // start time range looks something like: '16:30～17:30'
        $start_time_range = explode(" ", $event_title)[1];
        $start_time = explode('～', $start_time_range)[0];

        $opt_params = array(
            'singleEvents' => true, /* so we can fetch recurring events */
            // Assuming classes won't start before last day midnight
            // and won't start after 7pm.
            'timeMax' => date("Y-m-d\TH:i:s\Z", strtotime('today 19:00')),
            'timeMin' => date("Y-m-d\TH:i:s\Z", strtotime("yesterday 23:59")),
            'timeZone' => 'Asia/Tokyo'
        );

        // get events by calendar ID and optional parameters
        $events = $this->getEvent($calendar_id, $opt_params);
        $expected_datetime = date("Y-m-d\TH:i:s\Z", strtotime("today ".$start_time));
        $expected_datetime_tz_idx = strrpos($expected_datetime, 'Z');
        $expected_datetime_without_tz = substr($expected_datetime, 0, $expected_datetime_tz_idx);

        // Find the ones that are NOT whole day events
        // PS. in Haga's case, they are also recurring events
        $students = array();
        foreach ($events as $event) {
            // we only handle the one with NON-empty starting dateTime
            // since this means that this is NOT all-day event
            if (!empty($event->start->dateTime)) {

                $event_tz_pos = strrpos($event->start->dateTime, '+');
                $event_datetime_without_tz = substr($event->start->dateTime, 0, $event_tz_pos);

                // If the datetime doesn't align, we skip
                if ($expected_datetime_without_tz !== $event_datetime_without_tz) {
                    continue;
                }

                $student_name_raw = $event->getSummary();
                $parsed_student_name = self::parseStudentNameFromEventTitle($student_name_raw);
                array_push($students, $parsed_student_name);
            }
        }

        $this->set(compact('class_name'));
        $this->set(compact('students'));
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

    private function parseStudentNameFromEventTitle($event_title) {
        $name_fractions = explode(' ', trim($event_title));
        return $name_fractions[0].$name_fractions[1];
    }

}
