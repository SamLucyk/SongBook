<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;


class Media_model extends CI_Model{
    
    ////////////
    // Audio //
    ///////////
    
    function insert( $data, $type ){
        $this->db->insert($type, $data );
        return $this->db->insert_id();
    }
    
    public function update($id, $data, $type){
        $this->db->where('ID', $id);
        $this->db->update($type, $data);
    }
    
    function get( $id, $type ){
        $this->db->select('*');
        $this->db->from($type);
        $this->db->where('ID', $id);
        return $this->db->get()->result()[0];
    }
    
    function getById($table, $key, $val){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($key, $val);
        $result = $this->db->get()->result();
        if(!empty($result)){
            $result = $result[0];
        }
        return $result;
    }
    
    function getAll( $song_id, $type ){
        $this->db->select('*');
        $this->db->from($type);
        $this->db->where('song_id', $song_id);
        return $this->db->get()->result();
    }
    
    public function delete($id, $type){
        $this->db->where('ID', $id);
        $this->db->delete($type);
    }
    
}