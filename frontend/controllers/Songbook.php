<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require '../vendor/autoload.php';
use Aws\S3\S3Client;

use Mailgun\Mailgun;
class Songbook extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Songbook_model");
        $this->userdata = $this->session->userdata('user_data');
        if( !$this->verify()){
            redirect(site_url());
        }
        else {
            $this->client = S3Client::factory(array(
                'profile' => 'default',
                'region' => 'us-east-1',
                'version' => 'latest'
            ));
            $this->user = $this->User_model->getByEmail($this->userdata['user'])[0];
            
            $this->data = array(
                "user" => $this->user,
                "songbooks" => $this->Songbook_model->getSongbooks($this->user->ID),
                "songs" => $this->formatSongs($this->Songbook_model->getSongs($this->user->ID)),
                "albums" => $this->formatAlbums($this->Songbook_model->getAlbums($this->user->ID)),
                "statuses" => $this->Songbook_model->getStatuses()
            );
        }
    }

    function index(){
        $this->load->view('songbook/main', $this->data);
    }
    
    ////////////
    // SONGS //
    //////////
    function newsong(){
        if (isset($_GET['aid'])) {
            $this->data['aid'] = $_GET['aid'];
        }else{
            $this->data['aid'] = 'none';
        }
        $this->load->view('songbook/songs/newsong', $this->data);
    }
    
    function create_song(){
        $data = new stdClass;
        $artist = $this->user->first.' '.$this->user->last;
        $data->song_data = array(
            'name' => $this->input->post('name'),
            'artist' => $artist,
            'user_id' => $this->user->ID,
            'created_at' => date("Y-m-d H:i:s"),
            'status_id' => $this->input->post('status')
        );
        
        $data->song_album_data = array(
            'album_id' => $this->input->post('album')
        );
        
        $data->lyrics_data = array(
            'content' => $this->input->post('lyrics')
        );
            
        $this->Songbook_model->insertSong($data);
        redirect(site_url('songbook'));
    }
    
    function delete_song($song_id){
        $this->Songbook_model->deleteSong($song_id);
        redirect(site_url('songbook'));
    }

    
    function song( $type, $song_id){
        $song = $this->Songbook_model->getSong( $song_id );
        $this->data['song'] = $this->formatSong($song);
        $this->data['audios'] = $this->getAll($song_id, Audio);
        $this->data['videos'] = $this->getAll($song_id, Video);
        $this->load->view('songbook/songs/song_'.$type, $this->data);
    }
    
    public function update_song_field($field, $song_id){
        header('Content-Type: application/json');
        $new_value = $this->input->post('update');
        if( $this->is_ajax() ){
            $data = new stdClass;
            if ($field == 'album_id'){
                $data->song_album_data = array(
                    $field => $new_value,
                    'song_id' => $song_id
                );
                $this->Songbook_model->updateSong($song_id, $data);
                echo json_encode(array('result' => true));
            } else if ($field == 'lyrics'){
                $data->lyrics_data = array(
                    'song_id' => $song_id,
                    'content' => $new_value
                );
                $this->Songbook_model->updateSong($song_id, $data);
                echo json_encode(array('result' => true));
            } else {
                if ($field == 'created_at'){ $new_value = date('Y-m-d H:i:s', strtotime($new_value)); }
                $data->song_data = array(
                    $field => $new_value,
                );
                $this->Songbook_model->updateSong($song_id, $data);
                echo json_encode(array('result' => true));
            }
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    public function update_song($song_id){
        $data = new stdClass;    
        $data->lyrics_data = array(
            'song_id' => $song_id,
            'content' => $this->input->post('lyrics')
        );
        $this->Songbook_model->updateSong($song_id, $data);
        redirect(site_url('songbook/song/e/'.$song_id));
    }
    
    public function update_album_field($field, $album_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $new_value = $this->input->post('update');
            $data = new stdClass;
            if ($field == 'created_at'){
                $new_value = date('Y-m-d H:i:s', strtotime($new_value)); 
            }
            $data->album_data = array(
                $field => $new_value
            );
            $this->Songbook_model->updateAlbum($album_id, $data);
            echo json_encode(array('result' => true));
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
        $album = $this->formatSongAlbum($album);
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
    
    /////////////
    // Albums //
    ///////////
    
    function newalbum(){
        $this->load->view('songbook/albums/newalbum', $this->data);
    }
    
    function album( $type, $album_id){
        $album = $this->Songbook_model->getAlbum( $album_id );
        $album = $this->formatAlbum($album);
        $this->data['album'] = $album;
        $this->load->view('songbook/albums/album_'.$type, $this->data);
    }
    
    function create_album(){
        $data = array(
        'name' => $this->input->post('name'),
        'user_id' => $this->user->ID,
        'created_at' => date("Y-m-d H:i:s"),
        'status_id' => $this->input->post('status')
        );
            
        $this->Songbook_model->insertAlbum($data);
        redirect(site_url('songbook'));
    }
    
    public function update_album($album_id){
        $dateTime = strtotime($this->input->post('created_at')); 
        $timestamp = date('Y-m-d H:i:s', $dateTime); 
        $data = array(
            'name' => $this->input->post('name'),
            'status_id' => $this->input->post('status'),
            'created_at' => $timestamp
        );
        
          $this->Songbook_model->updateAlbum($album_id, $data);
          redirect(site_url('songbook/album/v/'.$album_id));
    }
    
    function delete_album($album_id){
        $this->delete_album_picture($album_id);
        $this->Songbook_model->deleteAlbum($album_id);
        redirect(site_url('songbook'));
    }
    
    function delete_album_picture($album_id){
        $this->load->model("Media_model");
        $picture = $this->Media_model->getById(Picture, 'album_id', $album_id);
        if(isset($picture) && !empty($picture)){
            $result = $this->client->deleteObject(array(
                'Bucket'       => Bucket,
                'Key'          => $picture->s3key
            ));
            if($result){
                $this->Media_model->delete($picture->ID, Picture);
            }
        }
    }
    
    public function upload_album_pic($album_id){
        $this->upload();
        redirect(site_url('songbook/album/v/'.$album_id));
    }
    
    public function upload(){
        $target_dir = base_url("public_files/");
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
    }
    
    function formatSongAlbum( $album ){
        $this->load->model("Media_model");
        if($album->name != 'No Album'){
            $pic = $this->Media_model->getById(Picture, 'album_id', $album->ID);
        }
        if (!isset($pic) or empty($pic) ){
            $pic = new stdClass;
            $pic->src = base_url('img/default-album-art.png');
        }
        $album->pic = $pic;
        return $album;
    }
    
    function formatAlbum( $album ){
        $this->load->model("Media_model");
        $status = $this->Songbook_model->getStatus( $album->status_id );
        $songs = $this->formatSongs($this->Songbook_model->getSongsByAlbum($album->ID));
        $pic = $this->Media_model->getById(Picture, 'album_id', $album->ID);
        $timestamp = strtotime($album->created_at);
        $album->created_at = date('m/d/Y', $timestamp);
        $album->status = $status;
        $album->songs = $songs;
        if (!isset($pic) or empty($pic)){
            $pic = new stdClass;
            $pic->src = base_url('img/default-album-art.png');
        }
        $album->pic = $pic;
        return $album;
    }
    
    function formatAlbums( $albums ){
        foreach($albums as $album){
            $album = $this->formatAlbum($album);
        }
        return $albums;
    }
    //Audio//
    function getAll($song_id, $type){
        $this->load->model("Media_model");
        return $this->Media_model->getAll($song_id, $type);
    }
    
    function get($id, $type){
        $this->load->model("Media_model");
        return $this->Media_model->get($id, $type);
    }

    ///Helpers///
    function verify(){
        $result = ( isset($this->userdata['is_logged_in']) && $this->userdata['is_logged_in'] == true );
        return $result;
    }
    
    function is_ajax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
            
}
?>