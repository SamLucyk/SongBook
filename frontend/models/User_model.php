<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;


class User_model extends CI_Model{

    function insert( $user_data ){
        try{
            $this->db->insert('user', $user_data );
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
    
    function getByEmail( $email){
        $this->db->select('user.*');
        $this->db->from('user');
        $this->db->where('user.email', $email);
        return $this->db->get()->result();
    }
    
    function getField($field, $id ){
        if ($field == 'theme_id'){
            return $this->getTheme($id);
        } else if ($field == 'scheme_id'){
            return $this->getScheme($id);
        }else {
            $this->db->select('user.'.$field);
            $this->db->from('user');
            $this->db->where('user.ID', $id);
            return $this->db->get()->result()[0];
        }
    }
    
    function getTheme( $id ){
        $this->db->select('theme.*');
        $this->db->from('user');
        $this->db->join('theme', 'user.theme_id = theme.ID', 'left'); 
        $this->db->where('user.ID', $id);
        return $this->db->get()->result()[0];
    }
    
    function getScheme( $id ){
        $this->db->select('scheme.*');
        $this->db->from('user');
        $this->db->join('scheme', 'user.scheme_id = scheme.ID', 'left'); 
        $this->db->where('user.ID', $id);
        return $this->db->get()->result()[0];
    }
    
    function getThemes( ){
        $this->db->select('theme.*');
        $this->db->from('theme');
        return $this->db->get()->result();
    }
    
    function getSchemes( ){
        $this->db->select('scheme.*');
        $this->db->from('scheme');
        return $this->db->get()->result();
    }
    
    public function update($user_id, $data){
        $this->db->trans_start();
        $this->db->where('ID', $user_id);
        $this->db->update('user', $data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
   
}   
?>
