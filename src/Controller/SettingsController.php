<?php
namespace App\Controller;

use App\Controller\AppController;

class SettingsController extends AppController
{
    public function index()
    {
        // Grab all the calendar id and concat into a string
        // so that we can render as the default text content for textarea
        $all_calendars = $this->Settings->find('all');
        $results = $all_calendars->all();
        $settings = $results->toArray();

        $unique_calendar_ids = array();
        foreach($settings as $setting) {
            $calendar_id = trim($setting['calendar_id']);
            if($calendar_id == '') {
                continue;
            }
            $unique_calendar_ids = $unique_calendar_ids + array($calendar_id => true /* placeholder */);
        }

        $calendar_ids_string = '';
        foreach($unique_calendar_ids as $calendar_id => $_) {
            $calendar_ids_string = $calendar_ids_string . $calendar_id . PHP_EOL;
        }
        $this->set('calendar_ids_string', $calendar_ids_string);

        // Handle form submission
        if($this->request->is('post')) {
            $raw_data = $this->request->getData();
            $calendar_id_string = $raw_data['calendar_id'];
            $calendar_id_arr = explode(PHP_EOL, $calendar_id_string);

            $cleanup_func = function ($calendar_raw_id) {
                return trim($calendar_raw_id);
            };

            $filter_func = function ($calendar_raw_id) {
                return $calendar_raw_id == '' ? false : true;
            };

            $calendar_id_cleaned = array_map($cleanup_func, $calendar_id_arr);
            $input_calendar_ids = array_values(array_filter($calendar_id_cleaned, $filter_func));

            // Check if update is required
            $new_calender_ids = array();
            foreach($calendar_id_arr as $calendar_id) {
                $trimmed_calendar_id = trim($calendar_id);
                if($trimmed_calendar_id == '') {
                    continue;
                }
                // $this->log('check for existing: '. $trimmed_calendar_id, 'debug');
                if(!array_key_exists($trimmed_calendar_id, $unique_calendar_ids)) {
                    $new_calender_ids = $new_calender_ids + array($trimmed_calendar_id => true /* placeholder */);
                }
            }

            if(count($new_calender_ids) == 0) {
                $this->Flash->error(__('No updates to setting.'));
                return;
            }

            // If update is required
            // Delete everything
            $this->Settings->deleteAll(['memo' => '']);

            // Save the new settings
            $func = function ($val1, $val2) {
                $new_data = $val1;
                $new_data['calendar_id'] = $val2;

                // These two are just placeholders so that we don't have to modify the
                // schema of the database.
                $new_data['user'] = '-';
                $new_data['password'] = '-';
                return $new_data;
            };
            $raw_data_arr = array_fill(0, count($input_calendar_ids), $raw_data);
            $data_arr = array_map($func, $raw_data_arr, $input_calendar_ids);
            $setting = $this->Settings->newEntities($data_arr);

            if ($this->Settings->saveMany($setting)) {
                $this->Flash->success(__('Your setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your setting.'));
        }

    }

}
