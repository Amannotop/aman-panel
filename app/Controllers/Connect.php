<?php

namespace App\Controllers;

use App\Models\KeysModel;

class Connect extends BaseController
{
    protected $model, $game, $uKey, $sDev, $xct;

    public function __construct()
    {
        $this->model = new KeysModel();
        $this->maintenance = false;
        $this->staticWords = "Vm8Lk7Uj2JmsjCPVPVjrLa7zgfx3uz9E";
    }

    public function index()
    {
        if ($this->request->getPost()) {
            return $this->index_post();
        } else {
            header("Location: https://botxd.online/"); /* Redirect browser */
  exit();
        }
    }

    public function index_post()
    {
        $isMT = 0;
        $game = $this->request->getPost('game');
        $uKey = $this->request->getPost('key');
        $sDev = $this->request->getPost('udid');

        $form_rules = [
            'game' => 'required|alpha_dash',
            'key' => 'required|alpha_numeric|min_length[16]|max_length[16]'
        ];

        if (!$this->validate($form_rules)) {
            $data = [
                'status' => "false",
                'reason' => "Key Mistyped !",
            ];
            return $this->response->setJSON($data);
        }

        if ($isMT) {
            $data = [
                'status' => "false",
                'reason' => 'SERVER UNDER MAINTENANCE '
            ];
        } else {
            if (!$game or !$uKey or !$sDev) {
                $data = [
                    'status' => "false",
                    'reason' => 'INVALID PARAMETER'
                ];
            } else {
                $time = new \CodeIgniter\I18n\Time;
                $model = $this->model;
                $findKey = $model
                    ->getKeysGame(['user_key' => $uKey]);

                if ($findKey) {
                    if ($findKey->status != 1) {
                        $data = [
                            'status' => "false",
                            'reason' => 'USER BLOCKED'
                        ];
                    } else {
                        $id_keys = $findKey->id_keys;
                        $duration = $findKey->duration;
                        $expired = $findKey->expired_date;
                        $max_dev = $findKey->max_devices;
                        $devices = $findKey->devices;
                        $type = $findKey->game;
    
                        function checkDevicesAdd($serial, $devices, $max_dev)
                        {
                            $lsDevice = explode(",", $devices);
                            $cDevices = isset($devices) ? count($lsDevice) : 0;
                            $serialOn = in_array($serial, $lsDevice);
    
                            if ($serialOn) {
                                return true;
                            } else {
                                if ($cDevices < $max_dev) {
                                    array_push($lsDevice, $serial);
                                    $setDevice = reduce_multiples(implode(",", $lsDevice), ",", true);
                                    return ['devices' => $setDevice];
                                } else {
                                    // ! false - devices max
                                    return false;
                                }
                            }
                        }
    
                        if (!$expired) {
                            $setExpired = $time::now()->addDays($duration);
                            $model->update($id_keys, ['expired_date' => $setExpired]);
                            $xct = true;
                        } else {
                            if ($time::now()->isBefore($expired)) {
                                $xct = true;
                            } else {
                                $data = [
                                    'status' => "false",
                                    'reason' => 'EXPIRED KEY'
                                ];
                            }
                        }
    
                        if ($xct) {
                            $devicesAdd = checkDevicesAdd($sDev, $devices, $max_dev);
                            if ($devicesAdd) {
                                if (is_array($devicesAdd)) {
                                    $model->update($id_keys, $devicesAdd);
                                }
                                // ? game-user_key-serial-word di line 15
                                $real = "$game-$uKey-$sDev-$this->staticWords";
                                $data = [
                                    'status' => "true",
                                    'reason' => 'yuiorecjkkszmbhcjkldm',
                                        'seller' => 'CHEATBOT',
                                        'uuid' => $sDev,
                                        'endtime' => $expired ];
                            } else {
                                $data = [
                                    'status' => "false",
                                    'reason' => 'DEVICE LIMIT EXCEEDED!'
                                ];
                            }
                        }
                    }
                } else {
                    $data = [
                        'status' => "false",
                        'reason' => 'USER NOT REGISTERED!'
                    ];
                }
            }
        }
        return $this->response->setJSON($data);
    }
}
