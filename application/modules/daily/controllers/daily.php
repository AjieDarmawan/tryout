<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends CI_Controller {


	function __construct(){
		parent::__construct();
		$sess = $this->session->userdata();
		// if(!$sess['pegawai']['kar_pvl']=='U'){
		// 	redirect('auth');
		// }
        $this->load->model(array('auth/Auth_model','Daily_M'));
		
    }

	public function index()
	{

	
		$data['active_menu'] 	= 'list_kategori';
		

		$data['wfh_master'] = $this->Daily_M->get_master_wfh();
		

		$this->template->load('template','v_daily', $data);
	}

	
}
