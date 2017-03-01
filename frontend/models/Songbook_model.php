<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;


class Songbook_model extends CI_Model{
    
    function getSongbooks( $u_id){
        $this->db->select('songbook.*');
        $this->db->from('songbook');
        $this->db->where('songbook.user_id', $u_id);
        return $this->db->get()->result();
    }
    
    function getSongsByAlbum( $album_id){
        $this->db->select('*');
        $this->db->from('song');
        $this->db->join('song_album', 'song.ID = song_album.song_id', 'left');
        $this->db->where('song_album.album_id', $album_id);
        return $this->db->get()->result();
    }
    ///////////
    // Song //
    /////////
    function getSongs( $u_id){
        $this->db->select('*');
        $this->db->from('song');
        $this->db->where('song.user_id', $u_id);
        $this->db->join('song_album', 'song.ID = song_album.song_id', 'left');
        return $this->db->get()->result();
    }
    
    function getSong( $song_id ){
        $this->db->select('*');
        $this->db->from('song');
        $this->db->join('song_album', 'song.ID = song_album.song_id', 'left'); 
        $this->db->where('song.ID', $song_id);
        $result = $this->db->get()->result();
        if(!empty($result)) {
            return $result[0];
        } else {
            return $result;
        }
    }
    
    function insertSong( $data){
        $this->db->insert('song', $data->song_data );
        $song_id = $this->db->insert_id();
        if($data->song_album_data['album_id'] != 'none'){
            $data->song_album_data['song_id'] = $song_id;
            $this->db->insert('song_album', $data->song_album_data);
        }
        $data->lyrics_data['song_id'] = $song_id;
        $this->db->insert('lyrics', $data->lyrics_data );
    }
    
    public function deleteSong($song_id){
        $this->db->where('song_id', $song_id);
        $this->db->delete('lyrics');
        $this->db->where('song_id', $song_id);
        $this->db->delete('song_album');
        $this->db->where('ID', $song_id);
        $this->db->delete('song');
    }
    
    public function updateSong($song_id, $data){
        $this->db->trans_start();
        if (isset($data->song_data)){
            $this->db->where('ID', $song_id);
            $this->db->update('song', $data->song_data);
        }
        if (isset($data->song_album_data)){
            if($data->song_album_data['album_id'] == 'none'){
                $this->db->where('song_id', $song_id);
                $this->db->delete('song_album');
            } else {
                $this->db->where('song_id', $song_id);
                $this->db->delete('song_album');
                $this->db->insert('song_album', $data->song_album_data);
            }
        }
        if (isset($data->lyrics_data)){
            $this->db->where('song_id', $song_id);
            $this->db->update('lyrics', $data->lyrics_data);
        }   
        $this->db->trans_complete();
        return $this->db->trans_status();

    }
    
    public function updateAlbum($album_id, $data){
        if (isset($data->album_data)){
            $this->db->where('ID', $album_id);
            $this->db->update('album', $data->album_data);
        }
    }
    
    ////////////
    // Album //
    ///////////
    
    function getAlbums( $u_id){
        $this->db->select('album.*');
        $this->db->from('album');
        $this->db->where('album.user_id', $u_id);
        return $this->db->get()->result();
    }
    
    function getAlbum( $album_id ){
        $this->db->select('album.*');
        $this->db->from('album');
        $this->db->where('album.ID', $album_id);
        $result = $this->db->get()->result();
        if(!empty($result)) {
            return $result[0];
        } else {
            return $result;
        }   
    }
    
    function insertAlbum( $data ){
        $this->db->insert('album', $data );
    }
    
    public function deleteAlbum($album_id){
        $this->db->where('album_id', $album_id);
        $this->db->delete('song_album');
        $this->db->where('ID', $album_id);
        $this->db->delete('album');
    }
    
    ////////////
    // Status //
    ///////////
    
    function getStatuses(){
        $this->db->select('status.*');
        $this->db->from('status');
        return $this->db->get()->result();
    }
    
    function getStatus( $status_id ){
        $this->db->select('status.*');
        $this->db->from('status');
        $this->db->where('status.ID', $status_id);
        return $this->db->get()->result()[0];
    }
    
    ////////////
    // Lyrics //
    ///////////
    
    
    function getLyrics( $song_id ){
        $this->db->select('*');
        $this->db->from('lyrics');
        $this->db->where('song_id', $song_id);
        return $this->db->get()->result()[0];
    }
    
    
    //////////////
    // Helpers //
    ////////////
    
    function get( $table, $item_id){
        if ($table == Song){
            return $this->getSong($item_id);
        } if ($table == Album){
            return $this->getAlbum($item_id);
        } else {
            return false;
        }
    }
   
}   
?>