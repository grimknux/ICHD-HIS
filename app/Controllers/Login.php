<?php

namespace App\Controllers;


use App\Models\LoginModel;

use App\Libraries\CustomObj;
use Config\Database;

class Login extends BaseController
{

    public $loginModel;

    public $session;
    public $validation;
    public $customobj;

    public function __construct()
    {

        $this->loginModel = new LoginModel();

        $this->customobj = new CustomObj();
        $this->session = session();
        $this->validation = \Config\Services::validation();
        $this->db = Database::connect();

        helper(['form','html','cookie','array','test']);
        
    }

    public function index()

    {

        if(session()->has('logged_user')){
            return redirect()->to(base_url('patient/add')); 
        }

        $custom = $this->customobj;
        $data = [];

        $data['username'] = null;
        $data['password'] = null;
        $data['error'] = null;
        $data['validation'] = null;
        $data['test'] = null;
        //$data['test'] = true;
        
        return view('login_page',$data);
    }


    public function loginQuery(){

        if(session()->has('logged_user')){

            return redirect()->to(base_url('patient/add'));
            
        }



        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getPost('csrf_token');
                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    $this->db->transStart();

                    try {

                        $logged_user = $this->session->get('logged_user');

                        $rules = [
                            'username' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please enter Username!',
                                ],
                            ],
                            'password' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please enter Password!',
                                ],
                            ],
                            
                        ];

                        if($this->validate($rules))
                        {

                            $username = $this->request->getVar('username');
                            $password = $this->request->getVar('password');

                                $userdata = $this->loginModel->verifyUser($username);  
                                if($userdata) {

                                    if(password_verify($password, trim($userdata['password']))){

                                        $loginInfo = [

                                            'username' => $userdata['username'],
                                            'agent' => $this->getUserAgentInfo(),
                                            'ip' => $this->request->getIPAddress()
            
                                        ];

                                        $lastID = $this->loginModel->saveLoginInfo($loginInfo);

                                        if(!$lastID['success']){
                                            throw new \Exception('Sorry, ' . $lastID['message']);
                                        }

                                        $this->session->set('logged_info',$lastID['lastid']);
                                        $this->session->set('logged_user',$userdata['username']);

                                        $data = [
                                            'success' => true, 
                                            'redirect_to' => base_url('patient/add'),
                                        ];


                                    }else{

                                        throw new \Exception('Sorry, wrong password for that Username.');

                                    }

                                }else{

                                    throw new \Exception('Sorry, Username does not exists.');
                                        
                                }

                                

                        } else {   
    
                            $data = [
                                'success' => false,
                                'formnotvalid' => true,
                                'data' => [
                                    'username' => $this->validation->getError('username'),
                                    'password' => $this->validation->getError('password'),
                                ],
                            ];
                            
                        }

                        $this->db->transComplete();

                        if ($this->db->transStatus() === false) {
                            throw new \Exception('Error signing-in. Please contact your system administrator.');
                        }
                        
                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        $this->db->transRollback();
                        log_message('error', 'Error login: ' . $e->getMessage());

                        $data = [
                            'success' => false,
                            'message' => $e->getMessage() // Return the exception message
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in loginQuery(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in loginQuery(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }

    }



    public function getUserAgentInfo()
    {
        $agent = $this->request->getUserAgent();
        if($agent->isBrowser())
        {
            $currentAgent = $agent->getBrowser();
        }
        elseif($agent->isRobot())
        {
            $currentAgent = $this->agent->isRobot();
        }
        elseif($agent->isMobile())
        {
            $currentAgent = $agent->isMobile();   
        }
        else
        {
            $currentAgent = "Unidentified User Agent";
        }

        return $currentAgent;
        
    }



    public function logout()
    {
        if(session()->has('logged_info')){
            $lastid = session()->get('logged_info');
            $this->loginModel->updateLogoutTime($lastid);
        }

        session()->remove('logged_user');
        session()->remove('logged_info');
        session()->destroy(); 
        return redirect()->to(base_url());
    }





}
