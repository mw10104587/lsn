<?php
namespace App\Controller;

use App\Controller\AppController;

class SettingsController extends AppController
{
    public function index()
    {
        if($this->request->is('post')) {
            $raw_data = $this->request->getData();
            $calendar_id_string = $raw_data['calendar_id'];
            
            $calendar_id_arr = explode(PHP_EOL, $calendar_id_string);
            
            $func = function ($val1, $val2) {
                $new_data = $val1;
                $new_data['calendar_id'] = $val2;
                return $new_data;
            };
            $raw_data_arr = array_fill(0, count($calendar_id_arr), $raw_data);
            $data_arr = array_map($func, $raw_data_arr, $calendar_id_arr);

            $setting = $this->Settings->newEntities($data_arr);
            
            if ($this->Settings->saveMany($setting)) {
                $this->Flash->success(__('Your setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your setting.'));
        }
        
    }
}