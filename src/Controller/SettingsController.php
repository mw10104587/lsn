<?php
namespace App\Controller;

use App\Controller\AppController;

class SettingsController extends AppController
{
    public function index()
    {
        if($this->request->is('post')) {
            $raw_data = $this->request->getData();
            $calander_url_string = $raw_data['calander_url'];
            
            $calander_url_arr = explode(PHP_EOL, $calander_url_string);
            $data_arr = array();
            foreach($calander_url_arr as $calander_url) {
                $tmp = $raw_data;
                $tmp['calander_url'] = $calander_url;
                array_push($data_arr, $tmp);
            }

            $setting = $this->Settings->newEntities($data_arr);
            
            $setting = $this->Settings->patchEntities($setting, $data_arr);
            if ($this->Settings->saveMany($setting)) {
                $this->Flash->success(__('Your setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your setting.'));
        }
        
    }
}