<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $classrooms = $this->getClassrooms();
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
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(\Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $token_path = 'token.json';
        if (file_exists($token_path)) {
            $access_token = json_decode(file_get_contents($token_path), true);
            $client->setAccessToken($access_token);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $auth_url = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $auth_url);
                print 'Enter verification code: ';
                $auth_code = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $access_token = $client->fetchAccessTokenWithAuthCode($auth_code);
                $client->setAccessToken($access_token);

                // Check to see if there was an error.
                if (array_key_exists('error', $access_token)) {
                    throw new Exception(join(', ', $access_token));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($token_path))) {
                mkdir(dirname($token_path), 0700, true);
            }
            file_put_contents($token_path, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    private function getEvent($calendar_id, $opt_params)
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);

        $results = $service->events->listEvents($calendar_id, $opt_params);
        // $events = $results->getItems();

        return $results;        
    }

    private function getClassrooms()
    {
        $this->loadModel('Settings');
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);

        $classrooms = array();
        $calendar_list = $this->Settings->find();
        
        foreach($calendar_list as $calendar) {
            $classrooms[$calendar->calendar_id] = $calendar->memo;
        }

        return $classrooms;
    }
}