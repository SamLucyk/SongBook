<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class User extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model("User_model");
        $this->load->model("Songbook_model");
        $this->userdata = $this->session->userdata('user_data');
        if( $this->verify()){
            $this->user = $this->User_model->getByEmail($this->userdata['user'])[0];
            $this->data = array(
                "user" => $this->user,
                "themes" => $this->User_model->getThemes(),
                "schemes" => $this->User_model->getSchemes(),
                "songbooks" => $this->Songbook_model->getSongbooks($this->user->ID),
                "songs" => $this->formatSongs($this->Songbook_model->getSongs($this->user->ID)),
                "albums" => $this->Songbook_model->getAlbums($this->user->ID),
                "statuses" => $this->Songbook_model->getStatuses()
            );
        }
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
    
    function profile(){
        $this->load->view('user/profile', $this->data);
    }
    
      ///Helpers///
    function verify(){
        $result = ( isset($this->userdata['is_logged_in']) && $this->userdata['is_logged_in'] == true );
        return $result;
    }
    
    function is_ajax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
    
    public function update_user_field($field, $new_name, $u_id){
        header('Content-Type: application/json');
        if( true ){
            $data = array(
                $field => str_replace('%20', ' ', $new_name)
            );
            $result = $this->User_model->update($u_id, $data);
            if($result){
                $new = $this->User_model->getField($field, $u_id);
                $key = str_replace('_id', '', $field);
                $this->session->set_userdata($key, $new);
            }
            echo json_encode(array('result' => $result));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function formatSong( $song ){
        $album = new stdClass;
        $album->name = 'No Album';
        if(isset($song->album_id)){
            $album = $this->Songbook_model->getAlbum( $song->album_id );
        } 
        $timestamp = strtotime($song->created_at);
        $song->status = $this->Songbook_model->getStatus( $song->status_id );
        $song->lyrics = $this->Songbook_model->getLyrics( $song->ID );
        $song->created_at = date('m/d/Y', $timestamp);
        $song->album = $album;
        return $song;
    }
    
    function formatSongs( $songs ){
        foreach($songs as $song){
            $song = $this->formatSong($song);
        }
        return $songs;
    }
    
}
?>