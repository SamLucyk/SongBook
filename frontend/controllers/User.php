<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class User extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("User_model");
    }
    
    function sign_up(){
        $this->load->view('user/sign-up');
    }
    
    function login(){
        $this->load->view('user/login');
    }

    function hashpassword($password) {
        return md5($password);
    }
    
    function create_user(){
        
        $email = $this->input->post('email');
        if (!$this->user_exists($email)){
            $user_data = array(
            'first' => $this->input->post('first'),
            'last' => $this->input->post('last'),
            'email' => $email,
            'password' => $this->hashpassword($this->input->post('pass'))
            );
            $insert = $this->User_model->insert($user_data);
            $this->load->view( 'pages/welcome' );
        } else {
            redirect(base_url('sign-up/user-exists'));
        }
    }
    
    function user_exists( $email ){
        $user = $this->User_model->getByEmail($email);
        return (isset($user) && (count($user) > 0));
    }
    
}
?>