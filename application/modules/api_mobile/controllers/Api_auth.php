<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_auth extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
       $this->load->model(array('auth/auth_model'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function login()
    {
        $user = $this->auth_model->login(
            $this->input->post('username'), 
            $this->input->post('password'));

            if($user){
                $data = array(
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$user,
                );
            }else{

                $data = array(
                    'status'=>404,
                    'message'=>'gagal',
                    'data'=>array(),
                );

            }

            echo json_encode($data);


           
    }

   

    // log the user out
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', false);
    }

    function error(){
        $this->load->view('errors/html/error_404');
    }
    function tes(){

        $this->load->view('layouts/template');

    }

}
