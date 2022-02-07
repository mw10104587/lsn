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
            $unique_calendar_ids = $unique_calendar_ids + array($calendar_id => $setting['memo'] /* placeholder */);
        }

        // $this->log('$unique_calendar_ids', 'error');
        // $this->log($unique_calendar_ids, 'error');

        // Create the two strings to show in the input
        $calendar_ids_string = '';
        $memos_string = '';
        foreach($unique_calendar_ids as $calendar_id => $memo) {
            $calendar_ids_string = $calendar_ids_string . $calendar_id . PHP_EOL;
            $memos_string = $memos_string . $memo . PHP_EOL;
        }
        $this->set('calendar_ids_string', $calendar_ids_string);
        $this->set('memos_string', $memos_string);

        // Handle form submission
        if($this->request->is('post')) {
            $raw_data = $this->request->getData();
            $calendar_id_string = $raw_data['calendar_id'];
            $memo_string = $raw_data['memo'];

            $calendar_id_arr = explode(PHP_EOL, $calendar_id_string);
            $memo_string_arr = explode(PHP_EOL, $memo_string);

            // $this->log('memo string array', 'error');
            // $this->log($memo_string_arr, 'error');

            $cleanup_func = function ($calendar_raw_id) {
                return trim($calendar_raw_id);
            };
            $filter_func = function ($calendar_raw_id) {
                return $calendar_raw_id == '' ? false : true;
            };

            $calendar_id_cleaned = array_map($cleanup_func, $calendar_id_arr);
            $input_calendar_ids = array_values(array_filter($calendar_id_cleaned, $filter_func));
            $calendar_tuples = [];

            // Create an Array of {memo: string, calendar_id: string}.
            // use the length of calendar_id as the main, if there's extra memo,
            // we neglect it.
            for ($i = 0; $i < count($input_calendar_ids); $i++) {
                $data = [];
                $data['calendar_id'] = $input_calendar_ids[$i];
                $data['memo'] = $i < count($memo_string_arr) ? $memo_string_arr[$i] : '空のメモ';
                $calendar_tuples[] = $data;
            }

            // Check if update is required
            $new_calender_ids = array();
            foreach($calendar_id_arr as $idx => $calendar_id) {
                $trimmed_calendar_id = trim($calendar_id);
                if($trimmed_calendar_id == '') {
                    continue;
                }
                // $this->log('check for existing: '. $trimmed_calendar_id, 'debug');
                // If there's new calendar id or
                // If the memo is different.
                if(
                    !array_key_exists($trimmed_calendar_id, $unique_calendar_ids) ||
                    $unique_calendar_ids[$trimmed_calendar_id] != $memo_string_arr[$idx]
                ) {
                    $new_calender_ids = $new_calender_ids + array($trimmed_calendar_id => $memo_string_arr[$idx]);
                }
            }

            if(count($new_calender_ids) == 0) {
                $this->Flash->error(__('No updates to setting.'));
                return;
            }

            // If update is required
            // Delete everything
            $this->Settings->deleteAll(['password' => '-']);

            // Save the new settings
            $func = function ($val1, $val2, $val3) {
                $new_data = $val1;
                $new_data['calendar_id'] = $val2;
                $this->log('$val3: '.$val3, 'error');
                $new_data['memo'] = $val3 == '' || $val3 == null || !isset($val3) ? "空のメモ" : $val3;

                // These two are just placeholders so that we don't have to modify the
                // schema of the database.
                $new_data['user'] = '-';
                $new_data['password'] = '-';

                return $new_data;
            };

            $raw_data_arr = array_fill(0, count($input_calendar_ids), $raw_data);
            $data_arr = array_map(
                $func,
                $raw_data_arr,
                $input_calendar_ids,
                array_slice($memo_string_arr, 0, count($input_calendar_ids))
            );

            $setting = $this->Settings->newEntities($data_arr);

            if ($this->Settings->saveMany($setting)) {
                $this->Flash->success(__('Your setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your setting.'));
        }

    }

}
