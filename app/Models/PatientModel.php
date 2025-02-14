<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table      = 'tx_patient';
    protected $primaryKey = 'patient_code';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['patient_code','p_lname','p_fname','p_mname','p_bdate','p_suffix','p_sex','p_civil_status','p_blood','p_nationality','p_religion','created_at','created_by','last_modified_at','last_modified_by','is_deleted','deleted_at','deleted_by','status'];

    // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';



    public function insertPatient($data){
        
        try {

            $this->insert($data);

            log_message('info', 'Operation successful: Patient Data saved.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Data did not save.'
            ];
        }
    
    }

    public function updatePatient($id,$data){
        
        try {

            $this->update($id,$data);

            log_message('info', 'Operation successful: Patient Data updated.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Data did not update.'
            ];
        }
    
    }



    public function getPatient_all($limit = null,$offset = null,$searchValue = null,$filterValue = null){

        try{
            $limit = intval($limit);
            $offset = intval($offset);
    
        
            $builder = $this->select('tx_patient.*, ls.sex, pa.pa_cur_street, lc.city, lb.brgy, lp.province, pa.pa_cur_zip, ld.district')
                                ->join('tx_pataddress pa', 'tx_patient.patient_code = pa.patient_code', 'left')
                                ->join('tx_patcontact pc', 'tx_patient.patient_code = pc.patient_code', 'left')
                                ->join('lib_sex ls', 'tx_patient.p_sex = ls.sex_code', 'left')
                                ->join('lib_city lc', 'pa.pa_cur_citymun = lc.city_code', 'left')
                                ->join('lib_brgy lb', 'pa.pa_cur_barangay = lb.brgy_code', 'left')
                                ->join('lib_district ld', 'pa.pa_cur_district = ld.district_code', 'left')
                                ->join('lib_province lp', 'pa.pa_cur_province = lp.province_code', 'left')
                                ->where('tx_patient.is_deleted', 0)
                                ->where('tx_patient.status', 'A');

                    if (!empty($searchValue)) {
                        $builder->groupStart()
                                ->like('tx_patient.patient_code', $searchValue)
                                ->orLike('tx_patient.p_lname', $searchValue)
                                ->orLike('tx_patient.p_fname', $searchValue)
                                ->orLike('tx_patient.p_mname', $searchValue)
                                ->orLike('ls.sex', $searchValue)
                                ->orLike('tx_patient.p_bdate', $searchValue)
                                ->orLike('pa.pa_cur_street', $searchValue)
                                ->orLike('pa.pa_cur_zip', $searchValue)
                                ->orLike('lc.city', $searchValue)
                                ->orLike('lb.brgy', $searchValue)
                                ->orLike('lp.province', $searchValue)
                                ->groupEnd();
                    }
                    
                    if(!empty($filterValue['pat_idFilter'])){
                        $builder->like('tx_patient.patient_code', $filterValue['pat_idFilter']);
                    }
                    if(!empty($filterValue['pat_lnameFilter'])){
                        $builder->like('tx_patient.p_lname', $filterValue['pat_lnameFilter']);
                    }
                    if(!empty($filterValue['pat_fnameFilter'])){
                        $builder->like('tx_patient.p_fname', $filterValue['pat_fnameFilter']);
                    }
                    if(!empty($filterValue['pat_mnameFilter'])){
                        $builder->like('tx_patient.p_mname', $filterValue['pat_mnameFilter']);
                    }
                    if(!empty($filterValue['pat_bdateFilter'])){
                        $builder->like('tx_patient.p_bdate', $filterValue['pat_bdateFilter']);
                    }

                    $builder->orderBy('tx_patient.p_lname', 'ASC');

                    if(!empty($limit)){
                        $get_query = $builder->limit($limit, $offset)->findAll();
                    }else{
                        $get_query = $builder->findAll();
                    }
                    $totalRecords = $this->countAll();  // Total unfiltered records
                    $filteredRecords = $builder->countAllResults(false); // Total after filtering
                                

            $totalRecords = $this->countAll();
            return [
                'success' => true,
                'data' => $get_query,
                'totalRecords' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getPatientById($patient_code){

        try{    
        
            $get_query = $this->select('tx_patient.*, pc.pc_mobile, pc.pc_tel, pc.pc_email, pc.pc_ref_name, pc.pc_ref_address, pc.pc_ref_number, pa.pa_cur_street, pa.pa_cur_citymun, pa.pa_cur_barangay, pa.pa_cur_district, pa.pa_cur_zip, pa.pa_cur_province, pa.pa_cur_region, pa.pa_per_street, pa.pa_per_citymun, pa.pa_per_barangay, pa.pa_per_district, pa.pa_per_zip, pa.pa_per_province, pa.pa_per_region, ls.sex, lcs.civil_status, lbt.blood_type, ln.nationality, lr.religion, lc.city as city_cur, lb.brgy as brgy_cur, ld.district as district_cur, lp.province as province_cur, lc_per.city as city_per, lb_per.brgy as brgy_per, ld_per.district as district_per, lp_per.province as province_per')
                            ->join('tx_patcontact pc', 'tx_patient.patient_code = pc.patient_code', 'left')
                            ->join('tx_pataddress pa', 'tx_patient.patient_code = pa.patient_code', 'left')
                            ->join('lib_sex ls', 'tx_patient.p_sex = ls.sex_code', 'left')
                            ->join('lib_civil_status lcs', 'tx_patient.p_civil_status = lcs.civil_status_id', 'left')
                            ->join('lib_bloodtype lbt', 'tx_patient.p_blood = lbt.blood_code', 'left')
                            ->join('lib_nationality ln', 'tx_patient.p_nationality = ln.nationality_code', 'left')
                            ->join('lib_religion lr', 'tx_patient.p_religion = lr.religion_code', 'left')
                            ->join('lib_city lc', 'pa.pa_cur_citymun = lc.city_code', 'left')
                            ->join('lib_brgy lb', 'pa.pa_cur_barangay = lb.brgy_code', 'left')
                            ->join('lib_district ld', 'pa.pa_cur_district = ld.district_code', 'left')
                            ->join('lib_province lp', 'pa.pa_cur_province = lp.province_code', 'left')
                            ->join('lib_city lc_per', 'pa.pa_per_citymun = lc.city_code', 'left')
                            ->join('lib_brgy lb_per', 'pa.pa_per_barangay = lb.brgy_code', 'left')
                            ->join('lib_district ld_per', 'pa.pa_per_district = ld.district_code', 'left')
                            ->join('lib_province lp_per', 'pa.pa_per_province = lp.province_code', 'left')
                            ->where('tx_patient.patient_code', $patient_code)
                            ->where('tx_patient.is_deleted', 0)
                            ->where('tx_patient.status', 'A')->first();
                            

            return [
                'success' => true,
                'data' => $get_query,
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }




    public function generatePatientCode(){

        $this->db->transStart();

        try {
            
            $year = date('Y');
            $uniqueCode = '';

            do {

                $maxSequence = $this->select('MAX(patient_code) as max_code')
                                    ->like('patient_code', 'H'.$year.'-')
                                    ->first();

                $currentSequence = 0;
                if ($maxSequence && $maxSequence['max_code']) {
                    $currentSequence = (int)substr($maxSequence['max_code'], 6);
                }

                $newSequence = str_pad($currentSequence + 1, 9, '0', STR_PAD_LEFT);
                $uniqueCode = "H{$year}-{$newSequence}";


                $existingCode = $this->where('patient_code', $uniqueCode)->first();
            
            } while ($existingCode);


            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Failed to generate unique code');
            }


            return [
                'success' => true,
                'code' => $uniqueCode,
            ];

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }


    }


}