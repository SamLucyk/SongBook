<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class Pages extends CI_Controller{

    function __construct(){
        parent::__construct();

    }

    function index(){
        $userdata = $this->session->userdata('user_data');
        if( isset($userdata['is_logged_in']) && $userdata['is_logged_in'] == true ){
            $this->load->view('pages/home');
        } else {
            $this->load->view('pages/welcome');
        }
            
    }

}
?>
