<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_irt extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// $sess = $this->session->userdata();
		// if($sess['pegawai']->username){
		// 	//redirect('auth');
		// }else{
    //         redirect('auth');
    //     }
      // $this->load->model(array('Hasil_latihan_M',));
		
    }

    function sd_square($x, $mean) { return pow($x - $mean,2); }

    // Function to calculate standard deviation (uses sd_square)    
    function sd($array) {
        // square root of sum of squares devided by N-1
        return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
    }
    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        $url = "https://backend.edunovasi.com/api_mobile/api_irt/hitung_irt_testing/217";

            $headers = array (
                    'Content-Type: application/json'  );

            $ch = curl_init($url);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json', // if the content type is json
                    //  'bearer: '.$token // if you need token in header
                )
            );
            //  curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

            //   return $result;

            $data['irt'] = json_decode($result);


         



            $data["title"] = "List Hasil IRT";

            $this->load->view('hasil_irt/print_materi_irt',$data);
          //  $this->template->load('template',);

            // echo json_encode($output);
     
    }


    public function irt(){

      $materi_id = 217;

      
      $url = "https://backend.edunovasi.com/api_mobile/api_irt/hitung_irt/".$materi_id;

      $headers = array (
              'Content-Type: application/json'  );

      $ch = curl_init($url);
      curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
              'Content-Type: application/json', // if the content type is json
              //  'bearer: '.$token // if you need token in header
          )
      );
      //  curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $data['irt'] = json_decode($result);

  
      $this->load->view('hasil_irt/irt',$data);
    }

   


  
   

}
