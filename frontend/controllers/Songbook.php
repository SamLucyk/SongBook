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
        $this->client = S3Client::factory(array(
            'profile' => 'default',
            'region' => 'us-east-1',
            'version' => 'latest'
        ));
        if( !$this->verify()){
            redirect(site_url());
        }
        else {
            $this->user = $this->User_model->getByEmail($this->userdata['user'])[0];
            
            $this->data = array(
                "user" => $this->user,
                "songbooks" => $this->Songbook_model->getSongbooks($this->user->ID),
                "songs" => $this->formatSongs($this->Songbook_model->getSongs($this->user->ID)),
                "albums" => $this->Songbook_model->getAlbums($this->user->ID),
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
        $this->load->view('songbook/songs/newsong', $this->data);
    }
    
    function create_song(){
        $data = new stdClass;
        $data->song_data = array(
            'name' => $this->input->post('name'),
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
        $this->data['audios'] = $this->get_audios($song_id);
        $this->data['videos'] = $this->get_videos($song_id);
        $this->load->view('songbook/songs/song_'.$type, $this->data);
    }
    
    public function update_song($song_id){
        $dateTime = strtotime($this->input->post('created_at')); 
        $timestamp = date('Y-m-d H:i:s', $dateTime); 
        $data = new stdClass;
        $data->song_data = array(
            'name' => $this->input->post('name'),
            'status_id' => $this->input->post('status'),
            'created_at' => $timestamp
        );
        
        $data->lyrics_data = array(
            'song_id' => $song_id,
            'content' => $this->input->post('lyrics')
        );
        
        $data->song_album_data = array(
            'song_id' => $song_id,
            'album_id' => $this->input->post('album')
        );

      $this->Songbook_model->updateSong($song_id, $data);
      redirect(site_url('songbook/song/v/'.$song_id));
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
        $this->Songbook_model->deleteAlbum($album_id);
        redirect(site_url('songbook'));
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
    
    function formatAlbum( $album ){
        $status = $this->Songbook_model->getStatus( $album->status_id );
        $timestamp = strtotime($album->created_at);
        $album->created_at = date('m/d/Y', $timestamp);
        $album->status = $status;
        return $album;
    }
    
    function formatAlbums( $albums ){
        foreach($albums as $album){
            $album = $this->formatAlbum($album);
        }
        return $albums;
    }
    
    /////////////
    /// Audio //
    ///////////
    function get_audios($song_id){
        return $this->Songbook_model->getAudios($song_id);
    }
    
    function get_audio($audio_id){
        return $this->Songbook_model->getAudio($audio_id);
    }
    
    public function upload_audio($song_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $sourcePath = $_FILES['audio-upload']['tmp_name'];
            $valid = $this->validate_audio($sourcePath);
            if (!$valid['result']){
                echo json_encode(array('error' =>'You are not allowed to upload such a file. Type: '.$valid['type']));
            } else {
                $name = $_FILES['audio-upload']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $audio_id = $this->insert_audio($song_id, $name, $ext);
                $key = $this->get_key(BucketAudio, $audio_id, $ext);
                $src = BucketUrl.$key;

                $result = $this->client->putObject(array(
                    'Content-Type' => 'audio/'.$ext,
                    'Bucket'       => Bucket,
                    'Key'          => $key,
                    'SourceFile'   => $sourcePath,
                    'ACL'          => 'public-read'
                ));

                $this->client->waitUntil('ObjectExists', array(
                    'Bucket' => Bucket,
                    'Key'    => $key
                ));
                
                if ($result){
                    $a = "<audio class='kv-preview-data' controls=''><source src='".$src."' type='audio/".$ext."'></audio>";
                    $b = array(
                        'type' => 'audio',
                        'filetype' => 'audio/'.$ext,
                        'url' => base_url('songbook/delete_audio/'.$audio_id),
                        'caption' => $name,
                        'frameAttr' => array('style' => 'height:80px')
                    );

                    echo json_encode(array('initialPreview' => $a, 'initialPreviewConfig' => $b));
                } else {
                    $this->delete_audio($audio_id);
                    echo json_encode(array('error' =>'The file was not uploaded. Please try again.'));
                }
            }
        }
    }
    
    function insert_audio($song_id, $name, $ext){
        $data = array(
            'song_id' => $song_id,
            'name' => $name
        );
        $audio_id = $this->Songbook_model->insertAudio($data);
        $key = $this->get_key(BucketAudio, $audio_id, $ext);
        $src = BucketUrl.$key;
        $srcdata = array(
            'src' => $src,
            's3key' => $key
        );
        $this->Songbook_model->updateAudio($audio_id, $srcdata);
        return $audio_id;
    }
    
    function delete_audio($audio_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $audio = $this->Songbook_model->getAudio($audio_id);
            $result = $this->client->deleteObject(array(
                'Bucket'       => Bucket,
                'Key'          => $audio->s3key
            ));
            if($result){
                $this->Songbook_model->deleteAudio($audio_id);
            }
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function update_audio_name($audio_id, $name){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $data = array(
                'name' => str_replace('%20', ' ', $name),
            );
            $this->Songbook_model->updateAudio($audio_id, $data);
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function validate_audio($file){

        $info = new finfo(FILEINFO_MIME);
        $type = $info->buffer(file_get_contents($file));
        $arr = explode(";", $type);
        $type = $arr[0];

        switch ($type) {
            case 'audio/mpeg':
            case 'audio/ogg':
            case 'audio/wav':
            case 'audio/x-matroska':
            case 'audio/mp4':
            case 'audio/mp3':
                return array(
                    'result'=> true
                );
            break;
            default:
                return array(
                    'result'=> false,
                    'type' => $type
                );
            break;
        }
    }
    
    /////////////
    /// Video //
    ///////////
    function get_videos($song_id){
        return $this->Songbook_model->getVideos($song_id);
    }
    
    function get_video($audio_id){
        return $this->Songbook_model->getVideo($audio_id);
    }
    
    public function upload_video($song_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $sourcePath = $_FILES['video-upload']['tmp_name'];
            $valid = $this->validate_video($sourcePath);
            if (!$valid['result']){
                echo json_encode(array('error' =>'You are not allowed to upload such a file. Type: '.$valid['type']));
            } else {
                $name = $_FILES['video-upload']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $video_id = $this->insert_video($song_id, $name, $ext);
                $key = $this->get_key(BucketVideo, $video_id, $ext);
                $src = BucketUrl.$key;

                $result = $this->client->putObject(array(
                    'Content-Type' => 'video/'.$ext,
                    'Bucket'       => Bucket,
                    'Key'          => $key,
                    'SourceFile'   => $sourcePath,
                    'ACL'          => 'public-read'
                ));

                $this->client->waitUntil('ObjectExists', array(
                    'Bucket' => Bucket,
                    'Key'    => $key
                ));
                
                if ($result){
                    $a = "<video style='height:100px' class='kv-preview-data' controls=''><source src='".$src."' type='video/mp4'></video>";
                    $b = array(
                        'type' => 'video',
                        'url' => base_url('songbook/delete_video/'.$video_id),
                        'caption' => $name
                    );
                    echo json_encode(array('initialPreview' => $a, 'initialPreviewConfig' => $b));
                } else {
                    $this->delete_video($video_id);
                    echo json_encode(array('error' =>'The file was not uploaded. Please try again.'));
                }
            }
        }
    }
    
    function insert_video($song_id, $name, $ext){
        $data = array(
            'song_id' => $song_id,
            'name' => $name
        );
        $video_id = $this->Songbook_model->insertVideo($data);
        $key = $this->get_key(BucketVideo, $video_id, $ext);
        $src = BucketUrl.$key;
        $srcdata = array(
            'src' => $src,
            's3key' => $key
        );
        $this->Songbook_model->updateVideo($video_id, $srcdata);
        return $video_id;
    }
    
    function delete_video($video_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $video = $this->Songbook_model->getVideo($video_id);
            $result = $this->client->deleteObject(array(
                'Bucket'       => Bucket,
                'Key'          => $video->s3key
            ));
            if($result){
                $this->Songbook_model->deleteVideo($video_id);
            }
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function update_video_name($video_id, $name){
        header('Content-Type: application/json');
        if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            $data = array(
                'name' => str_replace('%20', ' ', $name),
            );
            $this->Songbook_model->updateVideo($video_id, $data);
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function validate_video($file){

        $info = new finfo(FILEINFO_MIME);
        $type = $info->buffer(file_get_contents($file));
        $arr = explode(";", $type);
        $type = $arr[0];
        switch ($type) {
            case 'video/mp4':
            case 'video/avi':
            case 'video/mpeg':
            case 'video/mpg':
                return array(
                    'result'=> true
                );
            break;
            default:
                return array(
                    'result'=> false,
                    'type' => $type
                );
            break;
        }
    }

    ///Helpers///
    function verify(){
        $result = ( isset($this->userdata['is_logged_in']) && $this->userdata['is_logged_in'] == true );
        return $result;
    }
    
    function get_key($type, $id, $ext){
        return $type.$this->user->ID.'/'.$id.'.'.$ext;
    }
    
    function is_ajax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
            
}
?>