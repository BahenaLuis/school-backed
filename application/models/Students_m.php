<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students_m extends CI_Model {
    
    function get_dateNow(){
        date_default_timezone_set('America/Hermosillo');
        return date('Y-m-d H:i:s');
    }
    
    function get_students(){
        $this->db->select('student_id, first_name, middle_name, last_name, gender');
		$this->db->from('students');
		$result = $this->db->get();
		return $result->result_array();
    }
    
    function update_dataStudent($data, $student_id){
        $data->updated_on = $this->get_dateNow();
        $this->db->where('student_id', $student_id);
        return $this->db->update('students', $data); 
    }
    
    function exist_email($email){
        $this->db->select('email');
		$this->db->from('email');
		$this->db->where('email', $email);
		$result = $this->db->get();
		$result = $result->num_rows();
		if ($result > 0) {
		    return TRUE;
		} else return FALSE;
    }
    
    function register_student($student_data, $email_data, $phone_data, $address_data){
        $this->db->trans_start();
        $date_create = $this->get_dateNow();
        /* Insert data of student */
        $student_data->created_on = $date_create;
        $this->db->insert('students', $student_data);
        $student_id = $this->db->insert_id();
        /* Insert data of email */
        $email_data->created_on = $date_create;
        $email_data->student_id = $student_id;
        $this->db->insert('email', $email_data);
        /* Insert data of phone */
        $phone_data->created_on = $date_create;
        $phone_data->student_id = $student_id;
        $this->db->insert('phone', $phone_data);
        /* Insert data of address */
        $address_data->student_id = $student_id;
        $this->db->insert('address', $address_data);
        /* End transaction */
        $this->db->trans_complete();
	    if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        else return TRUE;
    }
    
    function remove_student($student_id){
        return $this->db->delete('students', array('student_id' => $student_id)); 
    }
    
    function remove_email($student_id, $email){
        return $this->db->delete('email', array('student_id' => $student_id, 'email'=>$email)); 
    }
    
    function remove_phone($student_id, $phone_id){
        return $this->db->delete('phone', array('student_id' => $student_id, 'phone_id'=>$phone_id)); 
    }
    
    function remove_address($student_id, $address_id){
        return $this->db->delete('address', array('student_id' => $student_id, 'address_id'=>$address_id)); 
    }
    
    function add_email($data_email){
        $data_email->created_on = $this->get_dateNow();
        $this->db->insert('email', $data_email);
        $student_id = $this->db->insert_id();
        return $student_id;
    }
    
    function add_phone($data_phone){
        $data_phone->created_on = $this->get_dateNow();
        $this->db->insert('phone', $data_phone);
        $phone_id = $this->db->insert_id();
        return $phone_id;
    }
    
    function add_address($data_address){
        $this->db->insert('address', $data_address);
        $address_id = $this->db->insert_id();
        return $address_id;
    }
    
    function update_email($email, $email_type){
        $object_update = array(
                'email_type'=>$email_type,
                'updated_on'=>$this->get_dateNow()
            );
        $this->db->where('email', $email);
        return $this->db->update('email', $object_update); 
    }
    
    function update_phone($data, $phone_id){
        $data->updated_on = $this->get_dateNow();
        $this->db->where('phone_id', $phone_id);
        return $this->db->update('phone', $data); 
    }
    
    function update_address($data, $address_id){
        $this->db->where('address_id', $address_id);
        return $this->db->update('address', $data); 
    }
    
    function getEmails_student($student_id){
        $this->db->select('student_id, email, email_type');
		$this->db->from('email');
		$this->db->where('student_id', $student_id);
		$result = $this->db->get();
		return $result->result_array();
    }
    
    function getPhones_student($student_id){
        $this->db->select('student_id, phone, phone_type, country_code, area_code');
		$this->db->from('phone');
		$this->db->where('student_id', $student_id);
		$result = $this->db->get();
		return $result->result_array();    
    }
    
    function getAddress_student($student_id){
        $this->db->select('student_id, address_line, city, zip_postcode, state');
		$this->db->from('address');
		$this->db->where('student_id', $student_id);
		$result = $this->db->get();
		return $result->result_array();
    }
  
}