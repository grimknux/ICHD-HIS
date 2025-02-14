<?php

namespace App\Models;

use CodeIgniter\Model;


class LibraryModel extends Model
{

    /*public function __construct()
    {

        $this->db = \Config\Database::connect();
        
    }*/


    public function getBloodtype_all(){

        try{
        
            $builder = $this->db->table('lib_bloodtype');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getCivilStatus_all(){

        try{
        
            $builder = $this->db->table('lib_civil_status');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getNationality_all(){

        try{
        
            $builder = $this->db->table('lib_nationality');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getReligion_all(){

        try{
        
            $builder = $this->db->table('lib_religion');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getSex_all(){

        try{
        
            $builder = $this->db->table('lib_sex');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getSuffix_all(){

        try{
        
            $builder = $this->db->table('lib_suffix');
            $builder->select('*');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }

    }

    public function getMunCity_all(){

        try{
        
            $builder = $this->db->table('lib_city lc');
            $builder->select('lc.*, lp.province');
            $builder->where('lc.status', 'A');
            $builder->where('city_code !=', '133900');
            $builder->join('lib_province lp', 'lc.city_province = lp.province_code');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

    public function getMunCityBycityCode($muncity){
        try{
        
            $builder = $this->db->table('lib_city');
            $builder->select('*');
            $builder->where('city_code', $muncity);
            $builder->where('status', 'A');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getRowArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

    public function getBrgyByMun($muncity){
        try{
        
            $builder = $this->db->table('lib_brgy');
            $builder->select('*');
            $builder->where('brgy_city', $muncity);
            $builder->where('status', 'A');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

    public function getDistrictMun($muncity){
        try{
        
            $builder = $this->db->table('lib_district');
            $builder->select('*');
            $builder->where('city_code', $muncity);
            $builder->where('status', 'A');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

    public function getProvince_all(){
        try{
        
            $builder = $this->db->table('lib_province');
            $builder->select('*');
            $builder->where('status', 'A');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

    public function getRegion_all(){
        try{
        
            $builder = $this->db->table('lib_region');
            $builder->select('*');
            $builder->where('status', 'A');

            $result = $builder->get();

            return [
                'success' => true,
                'data' => $result->getResultArray(),
            ];

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage() // Return the exception message
            ];

        }
    }

}