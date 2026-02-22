<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\HistoryModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;

class notifyc extends BaseController
{
    protected $model, $userid, $user;

    public function __construct()
    {
        $this->userid = session()->userid;
        $this->model = new UserModel();
        $this->user = $this->model->getUser($this->userid);
        $this->time = new \CodeIgniter\I18n\Time;
    }
    
    


    public function tata()
    {
        $historyModel = new HistoryModel();
        $data = [
            'title' => 'Notification',
            'user' => $this->user,
            'time' => $this->time,
            'history' => $historyModel->getAll(),
        ];
         return view('User/notify',$data);
    }




}

   