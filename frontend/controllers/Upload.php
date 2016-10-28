<?php
  
   class Upload extends CI_Controller {
	
      public function __construct() { 
         parent::__construct(); 
         $this->load->helper(array('form', 'url')); 
      }
		
      public function index() { 
         $this->load->view('upload_form', array('error' => ' ' )); 
      } 
		
      public function do_upload() { 
            $config['upload_path'] = 'uploads/';
            $path=$config['upload_path'];
            $config['allowed_types'] = 'gif|jpg|jpeg|png|mp3';
            $config['max_size'] = '1024';
            $config['max_width'] = '1920';
            $config['max_height'] = '1280';
            $this->load->library('upload', $config);
            foreach ($_FILES as $fieldname => $fileObject){
            if (!empty($fileObject['name'])){
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($fieldname)){
                    $errors = $this->upload->display_errors();
                    flashMsg($errors);
                }
                else
                {
                     // Code After Files Upload Success GOES HERE
                }
            }
         }
      }
       
       
   } 
?>