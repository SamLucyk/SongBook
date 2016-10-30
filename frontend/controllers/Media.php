<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require '../vendor/autoload.php';
use Aws\S3\S3Client;

use Mailgun\Mailgun;
class Media extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("User_model");
        $this->load->model("Media_model");
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
            );
        }
    }

    function index(){
        redirect(site_url());
    }    
     
    public function upload($type, $song_id){
        header('Content-Type: application/json');
        if( $this->is_ajax() ){
            $sourcePath = $_FILES['file-upload']['tmp_name'];
            $valid = $this->validate($sourcePath, $type);
            if (!$valid['result']){
                echo json_encode(array('error' =>'You are not allowed to upload such a file. Type: '.$valid['type']));
            } else {
                $name = $_FILES['file-upload']['name'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $id = $this->insert($song_id, $name, $ext, $type);
                $key = $this->get_key($type, $id, $ext);
                $src = BucketUrl.$key;

                $result = $this->client->putObject(array(
                    'Content-Type' => $valid['type'],
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
                    $preview = $this->get_preview($type, $src, $valid['type']);
                    $config = array(
                        'filetype' => $valid['type'],
                        'caption' => $name,
                        'frameAttr' => array('style' => 'height:80px')
                    );

                    echo json_encode(array('initialPreview' => $preview, 'initialPreviewConfig' => $config));
                } else {
                    $this->delete($id, $type);
                    echo json_encode(array('error' =>'The file was not uploaded. Please try again.'));
                }
            }
        }
    }
    
    function update_name($id, $name, $type){
        header('Content-Type: application/json');
        if( $this->is_ajax()){
            $data = array(
                'name' => str_replace('%20', ' ', $name),
            );
            $this->Media_model->update($id, $data, $type);
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
    
    function insert($song_id, $name, $ext, $type){
        $data = array(
            'song_id' => $song_id,
            'name' => $name
        );
        $id = $this->Media_model->insert($data, $type);
        $key = $this->get_key($type, $id, $ext);
        $src = BucketUrl.$key;
        $srcdata = array(
            'src' => $src,
            's3key' => $key
        );
        $this->Media_model->update($id, $srcdata, $type);
        return $id;
    }
    
    function delete($id, $type){
        header('Content-Type: application/json');
        if( true ){
            $media = $this->Media_model->get($id, $type);
            $result = $this->client->deleteObject(array(
                'Bucket'       => Bucket,
                'Key'          => $media->s3key
            ));
            if($result){
                $this->Media_model->delete($id, $type);
            }
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
                    'result'=> true,
                    'type' => $type
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
                    'result'=> true,
                    'type' => $type
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
        if ($type == Audio){
            return BucketAudio.$this->user->ID.'/'.$id.'.'.$ext;
        } else if ($type == Video) {
            return BucketVideo.$this->user->ID.'/'.$id.'.'.$ext;
        }
    }
    
    function is_ajax(){
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
    
    function validate($sourcePath, $type){
        if ($type == Audio){
            return $this->validate_audio($sourcePath);
        } else if ($type == Video) {
            return $this->validate_video($sourcePath);
        }
    }
    
    function get_preview($type, $src, $prev_type){
        if ($type == Audio){
            return "<audio class='kv-preview-data' controls=''><source src='".$src."' type='".$prev_type."'></audio>";
        } else if ($type == Video) {
            return "<video style='height:100px' class='kv-preview-data' controls=''><source src='".$src."' type='".$prev_type."'></video>";;
        }
    }    
}
    