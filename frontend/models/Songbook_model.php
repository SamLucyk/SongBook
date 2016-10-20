<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;


class Songbook_model extends CI_Model{

    function insert( $user_data ){
        try{
            $this->db->insert('user', $user_data );
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
    
    function getSongbooks( $u_id){
        $this->db->select('songbook.*');
        $this->db->from('songbook');
        $this->db->where('songbook.user_id', $u_id);
        return $this->db->get()->result();
    }
    
    function getSongs( $u_id){
        $this->db->select('song.*');
        $this->db->from('song');
        $this->db->where('song.user_id', $u_id);
        return $this->db->get()->result();
    }
    
    function getAlbums( $u_id){
        $this->db->select('album.*');
        $this->db->from('album');
        $this->db->where('album.user_id', $u_id);
        return $this->db->get()->result();
    }
    
   
}   
?>