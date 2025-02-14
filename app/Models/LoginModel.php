<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'lib_users';
    protected $primaryKey = 'user_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id', 'username', 'password', 'employeee_id', 'roles', 'status'];



    public function verifyUser($user)
    {
        
        $result = $this->where('username', $user)->first();

        if(!$result){
            return false;
        }

        return $result;
    }

    public function saveLoginInfo($data)
    {

        $this->db->transStart();
        
        try{

            $builder = $this->db->table('login_activity');
            $insert = $builder->insert($data);
            
            if(!$insert){
                throw new \Exception("Login activity failed to insert.");
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Login activity failed.');
            }

            return [
                'success' => true,
                'lastid' => $this->db->insertID(),
            ];

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', "Error logging-in :{$e->getMessage()}");
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];
        }
    } 


    public function updateLogoutTime($id)
    {
        $builder = $this->db->table('login_activity');
        $builder->where('id',$id);
        $builder->update(['logout_time' => date('Y-m-d H:i:s')]);

        if($this->db->affectedRows() > 0)
        {
            return true;
        }
    }




    

}