<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DS_CRUD extends CI_Controller{

	public $table; // The table in the data base this module will use
	public $module;
	public $public_mod; // Set if module is private or not.
	public $restricted_access; // Set if module is restricted to user role or not.
	public $userdata;
	public $data;

	public function __construct()
	{
		parent::__construct();

		$this->userdata = $this->session->userdata('user_data');

		// If user isn't logged in, then redir to login controller
		$this->check_loggin( site_url('login') );

		$this->data['module'] = (empty($this->module)) ? $this->table : $this->module; // Match with table name in DB
		$this->data['ds_crud_views'] = "ds_crud";
		$this->data['crud_folder_create'] = "";
		$this->data['crud_folder_list'] = "";
		$this->data['crud_folder_view'] = "";
		$this->data['crud_folder_update'] = "";
		$this->data['crud_folder_delete'] = "";


		// Check if user has access to the module
		$this->check_access( site_url('dashboard') );




		/* The text of the CRUD titles & buttons */
		$this->data['labels'] = array(
			'list' => 'Items',
			'list_view_button' => 'View',
			'list_edit_button' => 'Edit',
			'list_delete_button' => 'Delete',
			'update' => 'Edit',
			'update_submit_button' => 'Update',
			'update_cancel_button' => 'Cancel',
			'create' => 'Add new',
			'create_new_link' => 'New',
			'create_submit_button' => 'Create',
			'create_cancel_button' => 'Cancel',
			'delete' => 'Delete',
			'view' => 'View',
			'view_cancel_button' => 'Cancel'
		);

		/* The fields (from the db) to be shown in the list and forms  */
		$this->data['fields'] = array(
			'list' => array(
				//array('db_field' => 'ID', 'label' => 'ID'),
				//array('db_field' => 'user', 'label' => 'Usuario')
			),
			'search' => array(
				array('db_field' => 'ID', 'label' => 'ID'),
				array('db_field' => 'user', 'label' => 'User'),
				array('db_field' => 'email', 'label' => 'Email')
			),
			'list_show_new' => true,
            'list_show_edit' => true,
			'list_show_view' => true,
			'list_show_delete' => true,
			'form_create' => array(
				//array('db_field' => 'user', 'label' => 'Usuario'),
				//array('db_field' => 'pass', 'label' => 'Password')
			),
			'form_update' => array(
				//array('db_field' => 'user', 'label' => 'Usuario'),
				//array('db_field' => 'email', 'label' => 'Email')
			),
			'view_grid' => array(
				//array('db_field' => 'user', 'label' => 'Usuario'),
				//array('db_field' => 'email', 'label' => 'Email')
			)
		);
	}

	// INDEX
	function index($cid = null)
	{
		$this->listAll($cid);
	}


	// CREATE
	function init_create(){ return ;}
	function pre_create($d){ return $d;}
	function execute_create($fd){
		$exec = $this->db->insert( $this->table , $fd);
		if( $exec )
			$this->data['dbaction'] = 'insert';
		else
			$this->data['dbaction'] = 'not-insert';
		return $exec;
	}
	function post_create($d){ return $d;}
	function create()
	{
		$this->init_create();

		$formdata = $this->input->post('fd');

		if( $formdata ){
			$formdata = $this->pre_create($formdata);

			$insert = $this->execute_create($formdata);
			$this->post_create($insert);

		}

		$this->data['crud_folder'] = (!empty( $this->data['crud_folder_create'] )) ? $this->data['crud_folder_create'] : $this->data['ds_crud_views']."/create";
		$this->load->view('router', $this->data);
	}

	// GET BY ID
	function getByID( $id )
	{
		$element = $this->db->where('ID', $id)->get( $this->table )->result();
		return $element[0];
	}

    // PAGINATION
    function paginate( $list ){
        // PAGINATION
        $this->load->library('pagination');

        $config['base_url'] = site_url( $this->data['module'] );
        $config['total_rows'] = count( $list );
        $config['per_page'] = 20;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        // DESIGN
        $config['first_link'] = 'Primero';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Último';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
        $this->pagination->initialize( $config );
        $this->data['pagination'] = $this->pagination->create_links();

        $this->data['limit'] = $config['per_page'];
        $this->data['offset'] = ( $this->input->get('per_page') ) ? $this->input->get('per_page') : 0;

        $list = array_slice( $list, $this->data['offset']*$this->data['limit'], $this->data['limit'] );

        return $list;

    }

	// LIST ALL
	public function listAll()
	{
		$this->data['list'] = $this->db->get( $this->table )->result();
        $this->data['list_count'] = count($this->data['list']);

        // PAGINATION
        $this->data['list'] = $this->paginate( $this->data['list'] );

		$this->data['crud_folder'] = (!empty( $this->data['crud_folder_list'] )) ? $this->data['crud_folder_list'] : $this->data['ds_crud_views']."/list";
		$this->load->view('router', $this->data );
	}

	// VIEW
	function init_view($id){ return $id;}
	function post_view($id){ return $id;}
	function view( $id = null )
	{
		$this->init_view($id);
		if( $id ){
			$this->data['element'] = $this->getByID( $id );

			$this->post_view($this->data['element']);

			$this->data['crud_folder'] = (!empty( $this->data['crud_folder_view'] )) ? $this->data['crud_folder_view'] : $this->data['ds_crud_views']."/view";
			$this->load->view('router', $this->data);
		}
	}

	// UPDATE
	function init_update($id){ return $id; }
	function pre_update($fd, $id){ return $fd; }
	function execute_update($fd, $id){
		$this->db->trans_start();
		$exec = $this->db->update($this->table, $fd, array('ID' => $id));
		$this->db->trans_complete();

        $error = $this->db->error();

		if( $error['code'] == 0 ){
			$this->data['dbaction'] = 'update';
		}else{
			$this->data['dbaction'] = 'not-update';
		}

		return $exec;
	}
	function post_update($d, $id){ return $d;}
    function end_update($id, $up){ return;}
	function update( $id ){
        $update = 0;
		$this->init_update($id);
		// Update into DB
		$formdata = $this->input->post('fd');
		if( $formdata ){
			$formdata = $this->pre_update($formdata, $id);
			$update = $this->execute_update($formdata, $id);
			$this->post_update($update, $id);
		}

        $this->end_update($id, $update);

		// Get from DB
		$this->data['element'] = $this->getByID( $id );

		$this->data['crud_folder'] = (!empty( $this->data['crud_folder_update'] )) ? $this->data['crud_folder_update'] : $this->data['ds_crud_views']."/update";
		$this->load->view('router', $this->data);
	}

	// DELETE
	function init_delete(){ return ;}
	function pre_delete($d){ return $d;}
	function execute_delete($del_id){
		$exec = $this->db->delete( $this->table , array('ID' => $del_id));
		if( $this->db->affected_rows() )
			$this->data['dbaction'] = 'delete';
		else
			$this->data['dbaction'] = 'not-delete';

		return $exec;
	}
	function post_delete($d){ return $d;}

	function delete( $del_id )
	{
		$this->init_delete();

		if( isset($del_id) ){
			$this->pre_delete($del_id);

			$delete = $this->execute_delete($del_id);
			$this->post_delete($delete);

		}

		$this->data['crud_folder'] = (!empty( $this->data['crud_folder_delete'] )) ? $this->data['crud_folder_delete'] : $this->data['ds_crud_views']."/delete";
		$this->load->view('router', $this->data);
	}



	function search(){

		$s = $this->input->post('search');

		if( $s ){
			$this->db->like('user', $s);
		}
		$this->data['list'] = $this->db->get($this->table)->result();
        $this->data['list_count'] = count($this->data['list']);

        // PAGINATION
        $this->data['list'] = $this->paginate( $this->data['list'] );

		$this->data['crud_folder'] = (!empty( $this->data['crud_folder_search'] )) ? $this->data['crud_folder_search'] : $this->data['ds_crud_views']."/search";
		$this->load->view('router', $this->data);
	}


	// Module Security
	function check_loggin( $url ){
		if( !$this->public_mod ){
			if( !isset($this->userdata['is_logged_in']) || !$this->userdata['is_logged_in'] ){
                redirect( $url );
		    }
		}
	}

	function check_access( $url ){
		//if( !$this->restricted_access ){
        if( !$this->public_mod ){
			$uid = $this->userdata['id_user'];

			$this->db->select('user.ID');
			$this->db->join('role', 'role.ID = user.rol_id');
			$this->db->join('permission', 'permission.rol_id = role.ID');
			$this->db->join('module', 'module.ID = permission.module_id');
			$this->db->where('module.module_name', $this->data['module']);
			$this->db->where('user.ID', $uid);
			$query = $this->db->get('user')->result();

//            echo $this->db->last_query();
//            print_r( $query );

			if(count($query) < 1) redirect( $url );
        }
		//}
	}

	function get_currentuser(){
		return $this->userdata['id_user'];
	}

	function get_currentprofileID(){
		return $this->userdata['id_profile'];
	}


	function get_user_name( $id = null ){
        if( empty($id) )
           $id = $this->userdata['id_user'];

        $this->db->select('ID, user, email, rol_id, status, created, eliminado');
		$user = $this->db->where(array(
			'ID' => $id
		))->get('user')->result();

		return $user[0];
	}


	function get_rol( $id ){

		$this->db->select('role.ID, role.rol_name');
		$this->db->join('role', 'role.ID = user.rol_id');
		$this->db->where('user.ID', $id);
		$query = $this->db->get('user')->result();

		if(count($query) > 0){
			return $query[0];
			//print_r( $query[0] );
		}else{
			return false;
			//echo "false";
		}

	}

}
?>
