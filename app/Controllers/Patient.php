<?php

namespace App\Controllers;

use App\Models\LibraryModel;
use App\Models\PatientModel;
use App\Models\PatientContactModel;
use App\Models\PatientAddressModel;

use App\Libraries\CustomObj;
use Config\Database;
use CodeIgniter\Encryption\Encryption;
use DateTime;


class Patient extends BaseController
{


    public function __construct()

    {
        
        $this->librarymodel = new LibraryModel();
        $this->patientmodel = new PatientModel();
        $this->patientcontactmodel = new PatientContactModel();
        $this->patientaddressmodel = new PatientAddressModel();

        $this->customobj = new CustomObj();

        $this->validation = \Config\Services::validation();
        $this->db = Database::connect();
        $this->encrypter = \Config\Services::encrypter();

        $this->session = session();
        helper(['form','html','cookie','array', 'test', 'url']);
    }


    public function index_add(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        try{

            $getBloodtype_all = $this->librarymodel->getBloodtype_all();
            $getCivilStatus_all = $this->librarymodel->getCivilStatus_all();
            $getNationality_all = $this->librarymodel->getNationality_all();
            $getReligion_all = $this->librarymodel->getReligion_all();
            $getSex_all = $this->librarymodel->getSex_all();
            $getSuffix_all = $this->librarymodel->getSuffix_all();
            $getMunCity_all = $this->librarymodel->getMunCity_all();
            $getProvince_all = $this->librarymodel->getProvince_all();
            $getRegion_all = $this->librarymodel->getRegion_all();

            if(!$getBloodtype_all['success']){
                throw new \Exception($getBloodtype_all['message']);
            }

            if(!$getCivilStatus_all['success']){
                throw new \Exception($getCivilStatus_all['message']);
            }

            if(!$getNationality_all['success']){
                throw new \Exception($getNationality_all['message']);
            }

            if(!$getReligion_all['success']){
                throw new \Exception($getReligion_all['message']);
            }

            if(!$getSex_all['success']){
                throw new \Exception($getSex_all['message']);
            }

            if(!$getSuffix_all['success']){
                throw new \Exception($getSuffix_all['message']);
            }

            if(!$getProvince_all['success']){
                throw new \Exception($getProvince_all['message']);
            }

            if(!$getRegion_all['success']){
                throw new \Exception($getRegion_all['message']);
            }
    
    
            $data = [
                'title' => 'Patient',
                'sub_title' => 'Patient Registration Form',
                'navactive' => 'patient',
                'navsubactive' => 'patient_add',
                'getbloodtype' => $getBloodtype_all['data'],
                'getcivilstatus' => $getCivilStatus_all['data'],
                'getnationality' => $getNationality_all['data'],
                'getreligion' => $getReligion_all['data'],
                'getsex' => $getSex_all['data'],
                'getsuffix' => $getSuffix_all['data'],
                'getmuncity' => $getMunCity_all['data'],
                'getprovince' => $getProvince_all['data'],
                'getregion' => $getRegion_all['data']
            ];
            


        } catch (\Exception $e) {

            log_message('error', 'An Error occured. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress() . ', Error: ' . $e->getMessage());
            return $this->response->setStatusCode(403)->setBody(json_encode(['error' => $e->getMessage()]));
            
        }

       
        return view('patient_add', $data);

    }

    public function getMunicipalityDetail(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getHeaderLine('X-CSRF-Token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    try {

                        $muncity = $this->request->getPost('muncity');
                        $district_city = [137501, 137601, 137602, 137502, 137401, 133900, 137402, 137603, 137503, 137604, 137605, 137403, 137404, 137405, 137607, 137504, 137606, 133901, 133902, 133903, 133904, 133905, 133906, 133907, 133908, 133909, 133910, 133911, 133912, 133913, 133914];

                        $data = [];

                        $getMunCityBycityCode = $this->librarymodel->getMunCityBycityCode($muncity);
                        $getBrgyByMun = $this->librarymodel->getBrgyByMun($muncity);
                        $district = $this->librarymodel->getDistrictMun($muncity);
                        
                        
                        if(!$getBrgyByMun['success']){
                            throw new \Exception($getBrgyByMun['message']);
                        }
                        if(!$district['success']){
                            throw new \Exception($district['message']);
                        }
                        if(!$getMunCityBycityCode['success']){
                            throw new \Exception($getMunCityBycityCode['message']);
                        }

                        $data = [
                            'success' => true,
                            'zipcode' => $getMunCityBycityCode['data']['city_zipcode'],
                            'province' => $getMunCityBycityCode['data']['city_province'],
                            'region' => $getMunCityBycityCode['data']['city_region'],
                            'brgy' => $getBrgyByMun['data'],
                            'brgyKeys' => ['textKey' => 'brgy', 'valueKey' => 'brgy_code'],
                        ];


                        if (in_array($muncity, $district_city)) {

                            $data['dist_true'] = true;
                            $data['district'] = $district['data'];
                            $data['districtKeys'] = ['textKey' => 'district', 'valueKey' => 'district_code'];
                            
                        }else{
                            $data['dist_true'] = false;
                        }

                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        log_message('error', 'Error Data: ' . $e->getMessage());
                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in getMunicipalityDetail(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in getMunicipalityDetail(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }
    }

    public function registerPatient(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getPost('csrf_token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    try {
                        
                        $data = [];
                        $logged_user = session()->get('logged_user');
                        $district_city = [137501, 137601, 137602, 137502, 137401, 133900, 137402, 137603, 137503, 137604, 137605, 137403, 137404, 137405, 137607, 137504, 137606, 133901, 133902, 133904, 133905, 133906, 133907, 133908, 133909, 133910, 133911, 133912, 133913, 133914];
                        //Removed (133903)
                        $same_address = $this->request->getPost('same_address');
                        $pat_current_city = $this->request->getPost('pat_current_city');
                        $pat_permanent_city = $this->request->getPost('pat_permanent_city');

                        
                        $rules = [
                            'pat_lname' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please enter Lastname',
                                ],
                            ],
                            'pat_fname' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please enter Firstname',
                                ],
                            ],
                            'pat_mname' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please enter Middlename',
                                ],
                            ],
                            'pat_bdate' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select Birthdate',
                                ],
                            ],
                            'pat_sex' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select Sex',
                                ],
                            ],
                            'pat_current_city' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select City/Municipality',
                                ],
                            ],
                            'pat_current_brgy' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select Barangay',
                                ],
                            ],
                            
                        ];
                        
                        if (in_array($pat_current_city, $district_city)) {
                            $rules['pat_current_district'] = [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select District',
                                ],
                            ];
                        }


                        if (!$same_address) { // Checkbox is not checked

                            $rules['pat_permanent_city'] = [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select City/Municipality',
                                ],
                            ];
                            $rules['pat_permanent_brgy'] = [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Please select Barangay',
                                ],
                            ];

                            if (in_array($pat_permanent_city, $district_city)) {
                                $rules['pat_permanent_district'] = [
                                    'rules' => 'required',
                                    'errors' => [
                                        'required' => 'Please select District',
                                    ],
                                ];
                            }
                        }

                        if($this->validate($rules))
                        { 
                            $patient_code = $this->patientmodel->generatePatientCode();
                            $muncity_current = $this->librarymodel->getMunCityBycityCode($pat_current_city);
                            $muncity_permanent = $this->librarymodel->getMunCityBycityCode($pat_permanent_city);
                            
                            if(!$patient_code['success']){
                                throw new \Exception($patient_code['message']);
                            }
                            if(!$muncity_current['success']){
                                throw new \Exception($muncity_current['message']);
                            }
                            if(!$muncity_permanent['success']){
                                throw new \Exception($muncity_permanent['message']);
                            }


                            $pat_code = $patient_code['code'];

                            $pat_lname = $this->request->getPost('pat_lname');
                            $pat_fname = $this->request->getPost('pat_fname');
                            $pat_mname = $this->request->getPost('pat_mname');
                            $pat_bdate = $this->request->getPost('pat_bdate');
                            $pat_suffix = $this->request->getPost('pat_suffix');
                            $pat_sex = $this->request->getPost('pat_sex');
                            $pat_civilstatus = $this->request->getPost('pat_civilstatus');
                            $pat_blood_type = $this->request->getPost('pat_blood_type');
                            $pat_nationality = $this->request->getPost('pat_nationality');
                            $pat_religion = $this->request->getPost('pat_religion');

                            $pat_contact_mobile = $this->request->getPost('pat_contact_mobile');
                            $pat_contact_telephone = $this->request->getPost('pat_contact_telephone');
                            $pat_contact_email = $this->request->getPost('pat_contact_email');
                            $pat_contact_person_name = $this->request->getPost('pat_contact_person_name');
                            $pat_contact_person_address = $this->request->getPost('pat_contact_person_address');
                            $pat_contact_person_mobile = $this->request->getPost('pat_contact_person_mobile');

                            $pat_current_street = $this->request->getPost('pat_current_street');
                            $pat_current_city = $this->request->getPost('pat_current_city');
                            $pat_current_brgy = $this->request->getPost('pat_current_brgy');
                            $pat_current_district = $this->request->getPost('pat_current_district');
                            $pat_current_zip = $this->request->getPost('pat_current_zip');
                            $pat_current_province = $muncity_current['data']['city_province'];
                            $pat_current_region = $muncity_current['data']['city_region'];
                            $pat_current_country = "PHILIPPINES";

                            if($same_address){
                                $pat_permanent_street = $this->request->getPost('pat_current_street');
                                $pat_permanent_city = $this->request->getPost('pat_current_city');
                                $pat_permanent_brgy = $this->request->getPost('pat_current_brgy');
                                $pat_permanent_district = $this->request->getPost('pat_current_district');
                                $pat_permanent_zip = $this->request->getPost('pat_current_zip');
                                $pat_permanent_province = $muncity_current['data']['city_province'];
                                $pat_permanent_region = $muncity_current['data']['city_region'];
                                $pat_permanent_country = "PHILIPPINES";
                            }else{
                                $pat_permanent_street = $this->request->getPost('pat_permanent_street');
                                $pat_permanent_city = $this->request->getPost('pat_permanent_city');
                                $pat_permanent_brgy = $this->request->getPost('pat_permanent_brgy');
                                $pat_permanent_district = $this->request->getPost('pat_permanent_district');
                                $pat_permanent_zip = $this->request->getPost('pat_permanent_zip');
                                $pat_permanent_province = $muncity_permanent['data']['city_province'];
                                $pat_permanent_region = $muncity_permanent['data']['city_region'];
                                $pat_permanent_country = "PHILIPPINES";
                            }
                            

                            $personnal_data = [
                                'patient_code' => $pat_code,
                                'p_lname' => strtoupper($pat_lname),
                                'p_fname' => strtoupper($pat_fname),
                                'p_mname' => strtoupper($pat_mname),
                                'p_bdate' => $pat_bdate,
                                'p_suffix' => !empty($pat_suffix) ? $pat_suffix : NULL,
                                'p_sex' => $pat_sex,
                                'p_civil_status' => !empty($pat_civilstatus) ? $pat_civilstatus : NULL,
                                'p_blood' => !empty($pat_blood_type) ? $pat_blood_type : NULL,
                                'p_nationality' => !empty($pat_nationality) ? $pat_nationality : NULL,
                                'p_religion' => !empty($pat_religion) ? $pat_religion : NULL,
                                'created_by' => $logged_user,
                                'last_modified_by' => $logged_user,
                            ];

                            $contact_data = [
                                'patient_code' => $pat_code,
                                'pc_mobile' => !empty($pat_contact_mobile) ? $pat_contact_mobile : NULL,
                                'pc_tel' => !empty($pat_contact_telephone) ? $pat_contact_telephone : NULL,
                                'pc_email' => !empty($pat_contact_email) ? $pat_contact_email : NULL,
                                'pc_ref_name' => !empty($pat_contact_person_name) ? $pat_contact_person_name : NULL,
                                'pc_ref_address' => !empty($pat_contact_person_address) ? $pat_contact_person_address : NULL,
                                'pc_ref_number' => !empty($pat_contact_person_mobile) ? $pat_contact_person_mobile : NULL,
                                'created_by' => $logged_user,
                                'last_modified_by' => $logged_user,
                            ];

                            $address_data = [
                                'patient_code' => $pat_code,
                                'pa_cur_street' => !empty($pat_current_street) ? $pat_current_street : NULL,
                                'pa_cur_citymun' => $pat_current_city,
                                'pa_cur_barangay' => $pat_current_brgy,
                                'pa_cur_district' => !empty($pa_cur_district) ? $pa_cur_district : NULL,
                                'pa_cur_zip' => !empty($pat_current_zip) ? $pat_current_zip : NULL,
                                'pa_cur_province' => $pat_current_province,
                                'pa_cur_region' => $pat_current_region,
                                'pa_cur_country' => $pat_current_country,
                                'pa_per_street' => !empty($pat_permanent_street) ? $pat_permanent_street : NULL,
                                'pa_per_citymun' => $pat_permanent_city,
                                'pa_per_barangay' => $pat_permanent_brgy,
                                'pa_per_district' => !empty($pa_per_district) ? $pa_per_district : NULL,
                                'pa_per_zip' => !empty($pat_permanent_zip) ? $pat_permanent_zip : NULL,
                                'pa_per_province' => $pat_permanent_province,
                                'pa_per_region' => $pat_permanent_region,
                                'pa_per_country' => $pat_permanent_country,
                                'created_by' => $logged_user,
                                'last_modified_by' => $logged_user,
                            ];

                            $this->db->transStart();

                            
                            $insertPatient = $this->patientmodel->insertPatient($personnal_data);
                            $insertContact = $this->patientcontactmodel->insertContact($contact_data);
                            $insertAddress = $this->patientaddressmodel->insertAddress($address_data);

                            if (!$insertPatient['success']) {
                                throw new \Exception($insertPatient['message']);
                            }
                            if (!$insertContact['success']) {
                                throw new \Exception($insertContact['message']);
                            }
                            if (!$insertAddress['success']) {
                                throw new \Exception($insertAddress['message']);
                            }


                            $this->db->transComplete();

                            if ($this->db->transStatus() === false) {
                                throw new \Exception('An Error occured while registering patient. Rolling-back changes...');
                            }

                            $data = [
                                'success' => true,
                                'message' => "Patient Registered Successfully!"
                            ];

                        } else {   
    
                            $data = [
                                'success' => false,
                                'formnotvalid' => true,
                                'data' => [
                                    'pat_lname' => $this->validation->getError('pat_lname'),
                                    'pat_fname' => $this->validation->getError('pat_fname'),
                                    'pat_mname' => $this->validation->getError('pat_mname'),
                                    'pat_bdate' => $this->validation->getError('pat_bdate'),
                                    'pat_sex' => $this->validation->getError('pat_sex'),
                                    'pat_current_city' => $this->validation->getError('pat_current_city'),
                                    'pat_current_brgy' => $this->validation->getError('pat_current_brgy'),
                                    'pat_current_district' => $this->validation->getError('pat_current_district'),
                                    'pat_permanent_city' => $this->validation->getError('pat_permanent_city'),
                                    'pat_permanent_brgy' => $this->validation->getError('pat_permanent_brgy'),
                                    'pat_permanent_district' => $this->validation->getError('pat_permanent_district'),
                                ],
                            ];
                            
                        }

                        
                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        $this->db->transRollback();

                        log_message('error', 'Error Data: ' . $e->getMessage());
                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in registerPatient(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in registerPatient(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }
    }





    public function index(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        $data = [
            'title' => 'Patient',
            'sub_title' => 'View Patient List',
            'navactive' => 'patient',
            'navsubactive' => 'patient_list'
        ];

        return view('patient_view', $data);

    }


    public function patientView(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getHeaderLine('X-CSRF-Token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    try {

                        $table_data = [];
                        $limit = $this->request->getPost('length');   // Rows per page
                        $offset = $this->request->getPost('start'); 
                        $searchValue = $this->request->getPost('search')['value'] ?? null;  

                        $pat_idFilter = $this->request->getPost('pat_idFilter') ? $this->request->getPost('pat_idFilter')  : "";
                        $pat_lnameFilter = $this->request->getPost('pat_lnameFilter') ? $this->request->getPost('pat_lnameFilter')  : "";
                        $pat_fnameFilter = $this->request->getPost('pat_fnameFilter') ? $this->request->getPost('pat_fnameFilter')  : "";
                        $pat_mnameFilter = $this->request->getPost('pat_mnameFilter') ? $this->request->getPost('pat_mnameFilter')  : "";
                        $pat_bdateFilter = $this->request->getPost('pat_bdateFilter') ? $this->request->getPost('pat_bdateFilter')  : "";

                        $filterValue = [
                            'pat_idFilter' => $pat_idFilter,
                            'pat_lnameFilter' => $pat_lnameFilter,
                            'pat_fnameFilter' => $pat_fnameFilter,
                            'pat_mnameFilter' => $pat_mnameFilter,
                            'pat_bdateFilter' => $pat_bdateFilter,
                        ];

                        $getPatient = $this->patientmodel->getPatient_all($limit, $offset, $searchValue, $filterValue);

                        if(!$getPatient['success']){
                                throw new \Exception($getPatient['message']);
                        }

                        foreach($getPatient['data'] as $pdata){

                            $suffix = !empty($pdata['p_suffix']) ? " " . $pdata['p_suffix'] : "" ;
                            $street = !empty($pdata['pa_cur_street']) ? $pdata['pa_cur_street'] . ", " : "";
                            //$district = !empty($pdata['district']) ? ", " . $pdata['district'] : "";
                            $district = "";
                            $province = !empty($pdata['province']) ? ", " . $pdata['province'] : "";
                            $zipcode = !empty($pdata['pa_cur_zip']) ? " " . $pdata['pa_cur_zip'] : "";

                            $address = $street.ucwords(strtolower($pdata['brgy'] . ", " . $pdata['city'].$district.$province)).$zipcode;

                            $btn = '<div class="btn-group">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"><i class="fa fa-info-circle"></i> Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right text-left">
                                            <li class="dropdown-header">
                                                <i class="fa fa-user pull-right"></i> <strong>Patient Action</strong>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="'.bin2hex($this->encrypter->encrypt($pdata['patient_code'])).'" class="view-detail">
                                                    <i class="fa fa-file-text-o pull-right"></i>
                                                    View Data
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="'.base_url('patient/edit/'.bin2hex($this->encrypter->encrypt($pdata['patient_code']))).'">
                                                    <i class="fa fa-pencil pull-right"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="'.bin2hex($this->encrypter->encrypt($pdata['patient_code'])).'" class="delete-patient-btn">
                                                    <i class="fa fa-trash pull-right"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>';

                            $table_data[] = [
                                'pat_id' => $pdata['patient_code'],
                                'pat_name' => $pdata['p_lname'] . ", " . $pdata['p_fname'] . " " . $pdata['p_mname'] . $suffix,
                                'pat_sex' => $pdata['sex'],
                                'pat_bdate' => date('F d, Y', strtotime($pdata['p_bdate'])),
                                'pat_address' => $address,
                                'action' => $btn,
                            ];

                        }

                        $data = [
                            "draw" => intval($this->request->getPost('draw')),
                            "recordsTotal" => $getPatient['totalRecords'],
                            "recordsFiltered" => $getPatient['recordsFiltered'],
                            "data" => $table_data
                        ];
                        

                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        log_message('error', 'Error Data: ' . $e->getMessage());
                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in patientView(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in patientView(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }
    }

    

    public function patientView2(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getHeaderLine('X-CSRF-Token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    try {

                        $table_data = [];

                        $getPatient = $this->patientmodel->getPatient_all();

                        if(!$getPatient['success']){
                                throw new \Exception($getPatient['message']);
                        }

                        foreach($getPatient['data'] as $pdata){

                            $suffix = !empty($pdata['p_suffix']) ? " " . $pdata['p_suffix'] : "" ;
                            $street = !empty($pdata['pa_cur_street']) ? $pdata['pa_cur_street'] . ", " : "";
                            //$district = !empty($pdata['district']) ? ", " . $pdata['district'] : "";
                            $district = "";
                            $province = !empty($pdata['province']) ? ", " . $pdata['province'] : "";
                            $zipcode = !empty($pdata['pa_cur_zip']) ? " " . $pdata['pa_cur_zip'] : "";

                            $address = $street.ucwords(strtolower($pdata['brgy'] . ", " . $pdata['city'].$district.$province)).$zipcode;

                            $btn = '<div class="btn-group">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"><i class="fa fa-info-circle"></i> Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right text-left">
                                            <li class="dropdown-header">
                                                <i class="fa fa-user pull-right"></i> <strong>Patient Action</strong>
                                            </li>
                                             <li>
                                                <a href="javascript:void(0)" data-id="'.bin2hex($this->encrypter->encrypt($pdata['patient_code'])).'" class="view-detail">
                                                    <i class="fa fa-file-text-o pull-right"></i>
                                                    View Data
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="'.base_url('patient/edit/'.bin2hex($this->encrypter->encrypt($pdata['patient_code']))).'">
                                                    <i class="fa fa-pencil pull-right"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="'.bin2hex($this->encrypter->encrypt($pdata['patient_code'])).'" class="delete-patient-btn">
                                                    <i class="fa fa-trash pull-right"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>';

                            $table_data[] = [
                                'pat_id' => $pdata['patient_code'],
                                'pat_name' => $pdata['p_lname'] . ", " . $pdata['p_fname'] . " " . $pdata['p_mname'] . $suffix,
                                'pat_sex' => $pdata['sex'],
                                'pat_bdate' => date('F d, Y', strtotime($pdata['p_bdate'])),
                                'pat_address' => $address,
                                'action' => $btn,
                            ];

                        }
                        

                        return $this->response->setJSON($table_data);

                    } catch (\Exception $e) {

                        log_message('error', 'Error Data: ' . $e->getMessage());
                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in patientView2(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in patientView2(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }
    }


    public function getPatientData(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getHeaderLine('X-CSRF-Token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    try {

                        $id = $this->request->getPost('id');
                        $patient_code = $this->encrypter->decrypt(hex2bin($id));

                        $getPatientById = $this->patientmodel->getPatientById($patient_code);
                        
                        if(!$getPatientById['success']){
                            throw new \Exception($getPatientById['message']);
                        }
                        $pdata = $getPatientById['data'];
                        $suffix = !empty($pdata['p_suffix']) ? " " . $pdata['p_suffix'] : "" ;
                        $pat_name = $pdata['p_lname'] . ", " . $pdata['p_fname'] . " " . $pdata['p_mname'] . $suffix;
                        $date_today = date('Y-m-d');
                        $bdate = $pdata['p_bdate'];

                        $date1 = new DateTime($date_today);
                        $date2 = new DateTime($bdate);
                        $diff = $date1->diff($date2);

                        $data = [
                            'success' => true,
                            'pat_code' => $pdata['patient_code'],
                            'pat_name' => $pat_name,
                            'pat_sex' => $pdata['sex'],
                            'pat_bdate' => date('F d, Y', strtotime($pdata['p_bdate'])),
                            'pat_age' => $diff->y . " years, " . $diff->m . " months, " . $diff->d . " days.",
                            'pat_cs' => !empty($pdata['civil_status']) ? $pdata['civil_status'] : "N/A",
                            'pat_blood' => !empty($pdata['blood_type']) ? $pdata['blood_type'] : "N/A",
                            'pat_nationality' => !empty($pdata['nationality']) ? $pdata['nationality'] : "N/A",
                            'pat_religion' => !empty($pdata['religion']) ? $pdata['religion'] : "N/A",

                            'pat_mobile' => !empty($pdata['pc_mobile']) ? $pdata['pc_mobile'] : "N/A",
                            'pat_tel' => !empty($pdata['pc_tel']) ?$pdata['pc_tel'] : "N/A",
                            'pat_email' => !empty($pdata['pc_email']) ? $pdata['pc_email'] : "N/A",
                            'pat_ref_name' => !empty($pdata['pc_ref_name']) ? $pdata['pc_ref_name'] : "N/A",
                            'pat_ref_address' =>!empty( $pdata['pc_ref_address']) ? $pdata['pc_ref_address'] : "N/A",
                            'pat_ref_number' => !empty($pdata['pc_ref_number']) ? $pdata['pc_ref_number'] : "N/A",

                            'pat_cur_street' => !empty($pdata['pa_cur_street']) ? $pdata['pa_cur_street'] : "N/A",
                            'pat_cur_city' => $pdata['city_cur'],
                            'pat_cur_brgy' => $pdata['brgy_cur'],
                            'pat_cur_district' => !empty($pdata['district_cur']) ? $pdata['district_cur'] : "N/A",
                            'pat_cur_zip' => !empty($pdata['pa_cur_zip']) ? $pdata['pa_cur_zip'] : "N/A",
                            'pat_cur_province' => $pdata['province_cur'],

                            'pat_per_street' => !empty($pdata['pa_per_street']) ? $pdata['pa_per_street'] : "N/A",
                            'pat_per_city' => $pdata['city_per'],
                            'pat_per_brgy' => $pdata['brgy_per'],
                            'pat_per_district' => !empty($pdata['district_per']) ? $pdata['district_per'] : "N/A",
                            'pat_per_zip' => !empty($pdata['pa_per_zip']) ? $pdata['pa_per_zip'] : "N/A",
                            'pat_per_province' => $pdata['province_per'],

                        ];
                        
                        

                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        log_message('error', 'Error Data: ' . $e->getMessage());
                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in getPatientData(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in getPatientData(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }
    }


    public function deletePatient(){

        if(!session()->has('logged_user')){
            return redirect()->to(base_url()); 
        }

        if ($this->request->isAJAX()) {

            if ($this->request->getMethod() === 'POST') {

                $csrfToken = $this->request->getHeaderLine('X-CSRF-Token');

                if (!empty($csrfToken) && $this->customobj->validateCSRFToken($csrfToken)) {

                    $this->db->transStart();

                    try {

                        $id = $this->request->getPost('id');
                        $logged_user = session()->get('logged_user');

                        $deleteData = [
                            'success' =>true,
                            'is_deleted' => 1,
                            'deleted_at' => date("Y-m-d H:i:s"),
                            'deleted_by' => $logged_user,
                            'status' => "I",
                        ];

                        $patient_code = $this->encrypter->decrypt(hex2bin($id));

                        $deletePatient = $this->patientmodel->updatePatient($patient_code,$deleteData);
                        $deleteContact = $this->patientcontactmodel->updateContact($patient_code,$deleteData);
                        $deleteAddress = $this->patientaddressmodel->updateAddress($patient_code,$deleteData);


                        if(!$deletePatient['success']){
                            throw new \Exception("Deletion failed on Patient data. Rolling-back changes...");
                        }

                        if(!$deleteContact['success']){
                            throw new \Exception("Deletion failed on Patient Contact data. Rolling-back changes...");
                        }

                        if(!$deleteAddress['success']){
                            throw new \Exception("Deletion failed on Patient Address data. Rolling-back changes...");
                        }

                        $data = [
                            'success' => true,
                            'message' => 'Patient Deleted Successfully!'
                        ];
                    
                        $this->db->transComplete();

                        if ($this->db->transStatus() === false) {
                            throw new \Exception('Error deleting patient. Please contact your system administrator.');
                        }
                        
                        return $this->response->setJSON($data);

                    } catch (\Exception $e) {

                        $this->db->transRollback();
                        log_message('error', 'Error adding objective Creation: ' . $e->getMessage());

                        $data = [
                            'success' => false,
                            'message' => $e->getMessage(),
                            'reload' => true,
                        ];

                        return $this->response->setJSON($data);
                        
                    }

                }else{
                    
                    log_message('error', 'Invalid CSRF token. URL: ' . current_url() . ', IP: ' . $this->request->getIPAddress());
                    return $this->response->setStatusCode(403)->setBody(json_encode(['error' => 'Invalid CSRF token']));

                }
                
            }else{
                
                log_message('error', 'An error occurred in deletePatient(): Method Not Allowed.');
                return $this->response->setStatusCode(405)->setBody(json_encode(['error' => 'Method not Allowed']));

            }

        }else{

            log_message('error', 'An error occurred in deletePatient(): Invalid Ajax Request.');
            return $this->response->setStatusCode(400)->setBody(json_encode(['error' => 'Invalid Ajax Request']));

        }

    }

    
}
