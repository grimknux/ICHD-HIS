<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientContactModel extends Model
{
    protected $table      = 'tx_patcontact';
    protected $primaryKey = 'pc_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['patient_code','pc_mobile','pc_tel','pc_email','pc_ref_name','pc_ref_address','pc_ref_number','created_at','created_by','last_modified_at','last_modified_by','is_deleted','deleted_at','deleted_by','status'];

   

    public function insertContact($data){
        
        try {

            $this->insert($data);

            log_message('info', 'Operation successful: Patient Contact saved.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Contact did not save.'
            ];
        }
    
    }

    public function updateContact($id,$data){
        
        try {

            $this->where('patient_code', $id)->set($data)->update();

            log_message('info', 'Operation successful: Patient Contact updated.');
            return [
                'success' => true,
            ];
           

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Operation unsuccessful: Patient Contact did not update.'
            ];
        }
    
    }


}