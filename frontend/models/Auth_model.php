<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;


class Auth_model extends CI_Model{

    function validate($email, $pass){
        $this->db->where("email", $email);
        $this->db->where('password', md5($pass));
        $q = $this->db->get('user')->result();

        if( count($q) == 1 ){
            return true;
        }
    }
   
}   
?>