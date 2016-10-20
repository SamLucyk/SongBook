<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //$this->output->set_status_header('404');
        $data = array();
        //$data['content'] = 'error_404'; // View name

        $this->load->view('errors/error404', $data);//loading in my template
    }
    
    public function user_exists(){
        $this->load->view('errors/user-exists');
    }
    
}
?>
