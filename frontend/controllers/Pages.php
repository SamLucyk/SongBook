<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Mailgun\Mailgun;
class Pages extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model("Songbook_model");
        $this->load->model("User_model");
        $this->userdata = $this->session->userdata('user_data');
        if ($this->userdata['is_logged_in']){
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
        $userdata = $this->session->userdata('user_data');
        if( isset($userdata['is_logged_in']) && $userdata['is_logged_in'] == true ){
            $this->load->view('pages/home');
        } else {
            $this->load->view('pages/welcome');
        }
            
    }
    
    function song($item_id){
        $item = $this->Songbook_model->get(Song, $item_id);
        if($item->public_enabled){
            $song = $this->Songbook_model->getSong( $item_id );
            $this->data['song'] = $this->formatSong($song);
            $this->data['audios'] = $this->getAll($item_id, Audio);
            $this->data['videos'] = $this->getAll($item_id, Video);
            $this->load->view('songbook/songs/song_p', $this->data);
        } else {
            redirect(site_url('errors/not-public'));
        }
    }
    
    function formatSong( $song ){
        $timestamp = strtotime($song->created_at);
        $song->status = $this->Songbook_model->getStatus( $song->status_id );
        $song->lyrics = $this->Songbook_model->getLyrics( $song->ID );
        $song->created_at = date('m/d/Y', $timestamp);
        $song->album = $this->getAlbum($song->album_id);
        return $song;
    }
    
    function formatSongs( $songs ){
        foreach($songs as $song){
            $song = $this->formatSong($song);
        }
        return $songs;
    }
    
    function getAll($song_id, $table){
        $this->load->model("Media_model");
        return $this->Media_model->getAll($song_id, $table);
    }
    
    function get($id, $table){
        $this->load->model("Media_model");
        return $this->Media_model->get($id, $table);
    }
    
    function getAlbum( $album_id ){
        if(isset($album_id)){
            $album = $this->Songbook_model->getAlbum( $album_id );
            $album->path = 'songbook/album/v/'.$album_id;
        } else {
            $album = new stdClass;
            $album->name = 'No Album';
            $album->path = $album->path = 'songbook';
        }
        return $this->formatSongAlbum($album);
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
        $album->status = $this->Songbook_model->getStatus( $album->status_id );
        $album->songs = $this->formatSongs($this->Songbook_model->getSongsByAlbum($album->ID));
        $album->pic = $this->getAlbumPic($album->ID);
        $album->created_at = date('m/d/Y', strtotime($album->created_at));
        return $album;
    }
    
    function formatAlbums( $albums ){
        foreach($albums as $album){
            $album = $this->formatAlbum($album);
        }
        return $albums;
    }
    
    function getAlbumPic($album_id){
        $pic = $this->Media_model->getById(Picture, 'album_id', $album_id);
        if (!isset($pic) or empty($pic)){
            $pic = new stdClass;
            $pic->src = base_url('img/default-album-art.png');
        }
        return $pic;
    }

}
?>
