<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class Songbook extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Songbook_model");
    }

    function index(){
        $userdata = $this->session->userdata('user_data');
        if( isset($userdata['is_logged_in']) && $userdata['is_logged_in'] == true ){
            $user = $this->User_model->getByEmail($userdata['user'])[0];
            $songbooks = $this->Songbook_model->getSongbooks($user->ID);
            $songs = $this->Songbook_model->getSongs($user->ID);
            $albums = $this->Songbook_model->getAlbums($user->ID);
            $data = array(
                "user" => $user,
                "songbooks" => $songbooks,
                "songs" => $songs,
                "albums" => $albums
            );
            $this->load->view('songbook/main', $data);
        } else {
            $this->load->view('pages/welcome');
        }
            
    }

}
?>