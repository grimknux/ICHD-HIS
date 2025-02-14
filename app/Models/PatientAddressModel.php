<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientAddressModel extends Model
{
    protected $table      = 'tx_pataddress';
    protected $primaryKey = 'pa_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['patient_code','pa_cur_street','pa_cur_citymun','pa_cur_barangay','pa_cur_district','pa_cur_zip','pa_cur_province','pa_cur_region','pa_cur_country','pa_per_street','pa_per_citymun','pa_per_barangay','pa_per_district','pa_per_zip','pa_per_province','pa_per_region','pa_per_country','created_at','created_by','last_modified_at','last_modified_by','is_deleted','deleted_at','deleted_by','status'];


    public function insertAddress($data){
        
        try {

            $this->insert($data);

            log_message('info', 'Operation successful: Patient Address saved.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Address did not save.'
            ];
        }
    
    }

    public function updateAddress($id,$data){
        
        try {

            $this->where('patient_code', $id)->set($data)->update();

            log_message('info', 'Operation successful: Patient Address updated.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Address did not update.'
            ];
        }
    
    }


}