<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class Auth extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("Auth_model");
        $this->load->model("User_model");
    }
    
    function index(){

	if( $this->input->get('logout') ){
      	$this->session->unset_userdata('user_data');
		$this->session->sess_destroy();
    }

    $this->load->view('user/login');
  }

    function login(){
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        $valid = $this->Auth_model->validate($email, $pass);
        
        if ($valid){
            $user = $this->User_model->getByEmail($email)[0];
            $data = array(
                'user' => $email,
                'name' => $user->first,
                'is_logged_in' => true,
                'id_user' => $user->ID,
                );
            $this->session->set_userdata('user_data', $data);
            redirect( base_url('') );
        } else {
            redirect(base_url('user/login'));
        }
    }
}
?>
