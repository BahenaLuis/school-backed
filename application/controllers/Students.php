<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
    
    public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *'); //Da acceso a cualquier punto de origen de la peticion
	    $this->load->model('students_m');
    }
    
    function get_students(){
        $students = $this->students_m->get_students(); 
        if ($students === FALSE) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al obtener los estudiantes.'));
        } else {
            echo json_encode(array('error'=> FALSE, 'data'=>$students, 'message'=>''));
        }
    }
    
    function update_dataStudent(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->first_name) || !isset($data->middle_name) || !isset($data->last_name) || !isset($data->gender)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $student_id = $data->student_id;
            unset($data->student_id);
            $status = $this->students_m->update_dataStudent($data, $student_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar actualizar los datos del estudiante.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'Los datos del estudiante han sido actualizados correctamente.'));
            }
        }
    }
    
    function register_student(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_data) || !isset($data->email_data) || !isset($data->phone_data) || !isset($data->address_data)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $exist_email = $this->students_m->exist_email($data->email_data->email);
            if ($exist_email) {
                echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Ya existe un alumno con el correo electrónico ingresado.'));
            } else {
                $state =  $this->students_m->register_student($data->student_data, $data->email_data, $data->phone_data, $data->address_data); 
                if ($state) {
                    echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El estudiante ha sido registrado correctamente.'));
                } else {
                    echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar registrar al estudiante.'));
                }
            }
        }
    }
    
    function remove_student(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->remove_student($data->student_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar eliminar al estudiante.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El estudiante ha sido eliminado correctamente.'));
            }
        }
    }
    
    function remove_email(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->email)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->remove_email($data->student_id, $data->email);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar eliminar el correo electrónico.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El correo electrónico ha sido eliminado correctamente.'));
            }
        }
    }
    
    function remove_phone(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->phone_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
           $status = $this->students_m->remove_phone($data->student_id, $data->phone_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar eliminar el telefono.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El teléfono ha sido eliminado correctamente.'));
            } 
        }
    }
    
    function remove_address(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->address_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->remove_address($data->student_id, $data->address_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar eliminar la direccion.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'La direccion ha sido eliminada correctamente.'));
            }
        }
    }
    
    function add_email(){
        $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->email) || !isset($data->email_type)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $exist_email = $this->students_m->exist_email($data->email);
            if ($exist_email) {
                echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Este correo electronico ya se encuentra registrado.'));
            } else {
                $status = $this->students_m->add_email($data);
                if ($status === FALSE) {
                   echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar agregar el correo electronico.'));
                } else {
                    echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El correo electrónico ha sido agregado correctamente.'));
                }
            }
        }
    }
    
	function add_phone(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->phone) || !isset($data->phone_type) || !isset($data->country_code) || !isset($data->area_code)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->add_phone($data);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar agregar el telefono.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El teléfono ha sido agregado correctamente.'));
            }
        }
	}
	
	function add_address(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id) || !isset($data->address_line) || !isset($data->city) || !isset($data->zip_postcode) || !isset($data->state)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->add_address($data);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar agregar la direccion.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'La direccion ha sido agregada correctamente.'));
            }   
        }
	}
	
	function update_email(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->email) || !isset($data->email_type)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $status = $this->students_m->update_email($data->email, $data->email_type);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar actualizar el correo electronico.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El correo electrónico ha sido actualizado correctamente.'));
            }
        }
	}
	
	function update_phone(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->phone_id) || !isset($data->phone) || !isset($data->phone_type) || !isset($data->country_code) || !isset($data->area_code)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $phone_id = $data->phone_id;
            unset($data->phone_id);
            $status = $this->students_m->update_phone($data, $phone_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar actualizar el telefono.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'El teléfono ha sido actualizado correctamente.'));
            }
        }
	}
	
	function update_address(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->address_id) || !isset($data->address_line) || !isset($data->city) || !isset($data->zip_postcode) || !isset($data->state)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $address_id = $data->address_id;
            unset($data->address_id);
            $status = $this->students_m->update_address($data, $address_id);
            if ($status === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar actualizar la direccion.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>'', 'message'=>'La direccion ha sido actualizada correctamente.'));
            }   
        }
	}
	
	function getEmails_student(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $emails = $this->students_m->getEmails_student($data->student_id);
            if ($emails === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar los correos electronicos del estudiante.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>$emails, 'message'=>''));
            }   
        }
	}
	
	function getPhones_student(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $phones = $this->students_m->getPhones_student($data->student_id);
            if ($phones === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar los telefonos del estudiante.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>$phones, 'message'=>''));
            }   
        }
	}
	
	function getAddress_student(){
	    $data_post = file_get_contents("php://input");
        $data = json_decode($data_post);
        if (!isset($data->student_id)) {
            echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Los datos enviados son invalidos.'));
        } else {
            $addresses = $this->students_m->getAddress_student($data->student_id);
            if ($addresses === FALSE) {
               echo json_encode(array('error'=> TRUE, 'data'=>'', 'message'=>'Hubo un error al intentar las direcciones del estudiante.'));
            } else {
                echo json_encode(array('error'=> FALSE, 'data'=>$addresses, 'message'=>''));
            }   
        }
	}
	
	
}
