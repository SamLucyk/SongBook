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
    
   
}   
?>
