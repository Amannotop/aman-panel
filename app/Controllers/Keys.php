<?php

namespace App\Controllers;

use App\Models\HistoryModel;
use App\Models\KeysModel;
use App\Models\UserModel;
use Config\Services;

class Keys extends BaseController
{
    protected $userModel, $model, $user;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->user = $this->userModel->getUser();
        $this->model = new KeysModel();
        $this->time = new \CodeIgniter\I18n\Time;

        /* ------- Game ------- */
        $this->game_list = [
            'PREMIUM' => 'PREMIUM',
            'FREE' => 'FREE'
        ];

        $this->duration = [
            1 => '1 Days &mdash; 300 Rs/Device',
            3 => '3 Days &mdash; 500 Rs/Device',
            7 => '7 Days &mdash; 700 Rs/Device',
            14 => '14 Days &mdash; 1000 Rs/Device',
            30 => '30 Days &mdash; 1500 Rs/Device',
            60 => '60 Days &mdash; 2500 Rs/Device',
        ];

        $this->price = [
            1 => 300,
            3 => 500,
            7 => 700,
            14 => 1000,
            30 => 1500,
            60 => 2500,
        ];
    }

    public function index()
    {
        $model = $this->model;
        $user = $this->user;

        if ($user->level != 1) {
            $keys = $model->where('registrator', $user->username)
                ->findAll();
        } else {
            $keys = $model->findAll();
        }

        $data = [
            'title' => 'Keys',
            'user' => $user,
            'keylist' => $keys,
            'time' => $this->time,
        ];
        return view('Keys/list', $data);
    }

    public function api_get_keys()
    {
        // ? API for DataTable Keys
        $model = $this->model;
        return $model->API_getKeys();
    }

    public function api_key_reset()
    {
        sleep(1);
        $model = $this->model;
        $keys = $this->request->getGet('userkey');
        $reset = $this->request->getGet('reset');
        $db_key = $model->getKeys($keys);

        $rules = [];
        if ($db_key) {
            $total = $db_key->devices ? explode(',', $db_key->devices) : [];
            $rules = ['devices_total' => count($total), 'devices_max' => (int) $db_key->max_devices];
            $user = $this->user;
            if ($db_key->devices and $reset) {
                if ($user->level == 1 or $db_key->registrator == $user->username) {
                    $model->set('devices', NULL)
                        ->where('user_key', $keys)
                        ->update();
                    $rules = ['reset' => true, 'devices_total' => 0, 'devices_max' => $db_key->max_devices];
                }
            } else {
            }
        }

        $data = [
            'registered' => $db_key ? true : false,
            'keys' => $keys,
        ];

        $real_response = array_merge($data, $rules);
        return $this->response->setJSON($real_response);
    }

    public function edit_key($key = false)
    {
        if ($this->request->getPost()) return $this->edit_key_action();
        $msgDanger = "The user key no longer exists.";
        if ($key) {
            $dKey = $this->model->getKeys($key, 'id_keys');
            $user = $this->user;
            if ($dKey) {
                if ($user->level == 1 or $dKey->registrator == $user->username) {
                    $validation = Services::validation();
                    $data = [
                        'title' => 'Key',
                        'user' => $user,
                        'key' => $dKey,
                        'game_list' => $this->game_list,
                        'time' => $this->time,
                        'key_info' => getDevice($dKey->devices),
                        'messages' => setMessage('Please carefuly edit information'),
                        'validation' => $validation,
                    ];
                    return view('Keys/key_edit', $data);
                } else {
                    $msgDanger = "Restricted to this user key.";
                }
            }
        }
        return redirect()->to('keys')->with('msgDanger', $msgDanger);
    }

    private function edit_key_action()
    {
        $keys = $this->request->getPost('id_keys');
        $user = $this->user;
        $dKey = $this->model->getKeys($keys, 'id_keys');
        $game = implode(",", array_keys($this->game_list));

        if (!$dKey) {
            $msgDanger = "The user key no longer exists~";
        } else {
            if ($user->level == 1 or $dKey->registrator == $user->username) {
                $form_reseller = [
                    'status' => [
                        'label' => 'status',
                        'rules' => 'required|integer|in_list[0,1]',
                        'erros' => [
                            'integer' => 'Invalid {field}.',
                            'in_list' => 'Choose between list.'
                        ]
                    ]
                ];
                $form_admin = [
                    'id_keys' => [
                        'label' => 'keys',
                        'rules' => 'required|is_not_unique[keys_code.id_keys]|numeric',
                        'errors' => [
                            'is_not_unique' => 'Invalid keys.'
                        ],
                    ],
                    'game' => [
                        'label' => 'Games',
                        'rules' => "required|alpha_numeric_space|in_list[$game]",
                        'errors' => [
                            'alpha_numeric_space' => 'Invalid characters.'
                        ],
                    ],
                    'user_key' => [
                        'label' => 'User keys',
                        'rules' => "required|is_unique[keys_code.user_key,user_key,$dKey->user_key]|alpha_numeric",
                        'errors' => [
                            'is_unique' => '{field} has been taken.'
                        ],
                    ],
                    'duration' => [
                        'label' => 'duration',
                        'rules' => 'required|numeric|greater_than_equal_to[1]',
                        'errors' => [
                            'greater_than_equal_to' => 'Minimum {field} is invalid.',
                            'numeric' => 'Invalid day {field}.'
                        ]
                    ],
                    'max_devices' => [
                        'label' => 'devices',
                        'rules' => 'required|numeric|greater_than_equal_to[1]',
                        'errors' => [
                            'greater_than_equal_to' => 'Minimum {field} is invalid.',
                            'numeric' => 'Invalid max of {field}.'
                        ]
                    ],
                    'registrator' => [
                        'label' => 'registrator',
                        'rules' => 'permit_empty|alpha_numeric_space|min_length[4]'
                    ],
                    'expired_date' => [
                        'label' => 'expired',
                        'rules' => 'permit_empty|valid_date[Y-m-d H:i:s]',
                        'errors' => [
                            'valid_date' => 'Invalid {field} date.',
                        ]
                    ],
                    'devices' => [
                        'label' => 'device list',
                        'rules' => 'permit_empty'
                    ]
                ];

                if ($user->level == 1) {
                    // Admin full rules.
                    $form_rules = array_merge($form_reseller, $form_admin);
                    $devices = $this->request->getPost('devices');
                    $max_devices = $this->request->getPost('max_devices');

                    $data_saves = [
                        'game' => $this->request->getPost('game'),
                        'user_key' => $this->request->getPost('user_key'),
                        'duration' => $this->request->getPost('duration'),
                        'max_devices' => $max_devices,
                        'status' => $this->request->getPost('status'),
                        'registrator' => $this->request->getPost('registrator'),
                        'expired_date' => $this->request->getPost('expired_date') ?: NULL,
                        'devices' => setDevice($devices, $max_devices),
                    ];
                } else {
                    // Reseller just status rules, you can set manually later.
                    $form_rules = $form_reseller;
                    $data_saves = ['status' => $this->request->getPost('status')];
                }

                if (!$this->validate($form_rules)) {
                    return redirect()->back()->withInput()->with('msgDanger', 'Failed! Please check the error');
                } else {
                    // * Data Updates
                    $this->model->update($dKey->id_keys, $data_saves);
                    return redirect()->back()->with('msgSuccess', 'User key successfuly updated!');
                }
            } else {
                $msgDanger = "@CheatBot_Owner Restricted to this user key~";
            }
        }
        return redirect()->to('keys')->with('msgDanger', $msgDanger);
    }

    public function generate()
    {
        if ($this->request->getPost())
            return $this->generate_action();

        $user = $this->user;
        $validation = Services::validation();

        $message = setMessage("<i class='bi bi-wallet'></i> Total Balance <span style='font-family:Arial;'>&#8377;</span>$user->saldo");
        if ($user->saldo <= 299) {
            $message = setMessage("@CheatBot_Owner Balace Low! Contact Admin to Recharge", 'warning');
        }

        $data = [
            'title' => 'Generate',
            'user' => $user,
            'time' => $this->time,
            'game' => $this->game_list,
            'duration' => $this->duration,
            'price' => json_encode($this->price),
            'messages' => $message,
            'validation' => $validation,
        ];
        return view('Keys/generate', $data);
    }
    
    
    
    
    
    

      public function sendnoty()
   { 
       
        if ($this->request->getPost())
            return $this->xlogin_action();

        $data = [
            'title' => 'Notification',
            'validation' => Services::validation(),
        ];
      //  return redirect()->to('login');
      
      
    }
    

  private function xlogin_action(){
  
 $model = $this->model;
        $user = $this->user;
  
  
   //  $user = $this->user;
        $title = $this->request->getPost('name');
        $message = $this->request->getPost('message');
        $urlimg = $this->request->getPost('link');
        $iconcolor = $this->request->getPost('color');
        
        
         #API access key from Google API's Console
     define( 'API_ACCESS_KEY', 'AAAAIDxpKYA:APA9https://@CheatBot_Owner.com/KWNGstsH' );
   # $registrationIds = 'android';

#prep the bundle
     $msg = array
          (
		'body' 	=> $message,
		'title'	=> $title,
		'image'	=> $urlimg,
		'color' => $iconcolor,
		'android_channel_id' => '128',
        'sound' => 'default'
          );

	$fields = array
			(
            	'to'=> '/topics/all',
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);



        if ($user->level == 1) {

#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://@CheatBot_Owner.com/' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	//	$result = curl_exec($ch );
		//$result = 'hello';
		curl_close( $ch );
$result = 'Feature Locked !  Contact Admin @CheatBot_Owner';
#Echo Result Of FireBase Server
//echo $result;

         }
  else
    {
        
        $result = 'Feature Locked !  Contact Admin @CheatBot_Owner';
      
    }
    

        
        
        
        
        
       
                    return redirect()->route('notify')->withInput()->with('msgDanger', $result);
                
            
        
    
    
   
    
    
  }
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   
function testfun()
{
   $message = setMessage("Balace Low! Contact Admin to Recharge", 'warning');
   return view('dashboard');
}


    private function generate_action()
    {
        $user = $this->user;
        $game = $this->request->getPost('game');
        $maxd = $this->request->getPost('max_devices');
        $drtn = $this->request->getPost('duration');
        $getPrice = getPrice($this->price, $drtn, $maxd);

        $game_list = implode(",", array_keys($this->game_list));
        $form_rules = [
            'game' => [
                'label' => 'Games',
                'rules' => "required|alpha_numeric_space|in_list[$game_list]",
                'errors' => [
                    'alpha_numeric_space' => 'Invalid characters.'
                ],
            ],
            'duration' => [
                'label' => 'duration',
                'rules' => 'required|numeric|greater_than_equal_to[1]',
                'errors' => [
                    'greater_than_equal_to' => 'Minimum {field} is invalid.',
                    'numeric' => 'Invalid day {field}.'
                ]
            ],
            'max_devices' => [
                'label' => 'devices',
                'rules' => 'required|numeric|greater_than_equal_to[1]',
                'errors' => [
                    'greater_than_equal_to' => 'Minimum {field} is invalid.',
                    'numeric' => 'Invalid max of {field}.'
                ]
            ],
        ];

        $validation = Services::validation();
        $reduceCheck = ($user->saldo - $getPrice);
        // dd($reduceCheck);
        if ($reduceCheck < 0) {
            $validation->setError('duration', 'Insufficient balance');
            return redirect()->back()->withInput()->with('msgWarning', 'Balace Low! Contact Admin to Recharge');
        } else {
            if (!$this->validate($form_rules)) {
                return redirect()->back()->withInput()->with('msgDanger', 'Failed! Please check the error');
            } else {
                $license = random_string('alnum', 16);
                $msg = "Successfuly Generated.";

                $data_response = [
                    'game' => $game,
                    'user_key' => $license,
                    'duration' => $drtn,
                    'max_devices' => $maxd,
                    'registrator' => $user->username,
                ];

                // * reseller reduce saldo
                $idKeys = $this->model->insert($data_response);
                $this->userModel->update(session('userid'), ['saldo' => $reduceCheck]);

                $history = new HistoryModel();
                $history->insert([
                    'keys_id' => $idKeys,
                    'user_do' => $user->username,
                    'info' => "$game|" . substr($license, 0, 5) . "|$drtn|$maxd"
                ]);

                $other_response = [
                    'fees' => $getPrice
                ];

                session()->setFlashdata(array_merge($data_response, $other_response));
                return redirect()->back()->with('msgSuccess', $msg);
            }
        }
    }
}
