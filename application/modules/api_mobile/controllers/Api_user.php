<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_user extends CI_Controller
{

	function register(){

		$url = "https://api.edunitas.com/mod/edun-regist-g";


		$email = $this->input->post('email');
	
		  $postData = array(
		        "format"=> "json",
		            "setdata_mod"=> "chekmail",
		            "formdata_email"=> $email,
		 );


  // echo "<pre>";
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




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
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);


      // echo "<pre>";
      // print_r($output);

      if($output->statuscode=="001"){
      	 $this->register2();
      }else{
      	$data['status']="gagal";
      	$data['message']=$output->message;

      	echo json_encode($data);
      }

      

	}

	function register2(){
		$url = "https://api.edunitas.com/mod/edun-regist-g";


		$email = $this->input->post('email');
		$nama = $this->input->post('nama');
		$no_tlp = $this->input->post('no_tlp');
		$no_wa = $this->input->post('no_wa');
		$pass = $this->input->post('pass');
		$repass = $this->input->post('repass');


		

			$postData = array(
		        "format"=> "json",
		        "setdata_mod"=> "regist",
		        "formdata_email"=> $email,
		        "formdata_nama"=> $nama,
		        "formdata_notlp"=> $no_tlp,
		        "formdata_nowa"=> $no_wa,
		          "formdata_pass"=> $pass,
           		 "formdata_repass"=> $repass,
		       
		        "formdata_lulusan"=> "SMA",
		        "formdata_alias"=> "tryout"
 			);

		


  
  


  // echo "<pre>";å
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




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
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);

      if($output->statuscode=="009"){
      	$data['status']="sukses";
      	$data['message']=$output->message;
      }else{
      	$data['status']="gagal";
      	$data['message']=$output->message;
      }

      echo json_encode($data);
     }




     	function send_code(){

   	$url = "https://api.edunitas.com/mod/edun-regist-g";


		

		
		$email 		= $this->input->post('email');
	


  
  $postData = array(
            "format"=> "json",
            "setdata_mod"=> "resend-verify",
            "formdata_email"=> $email,
            
       
 );


  // echo "<pre>";
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




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
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);

      // echo "<pre>";
      // print_r($output);

      // die;

      if($output->statuscode=="009"){
      	$data['status'] = 200;
      	$data['message']=$output->message;
      }

      else{
      	$data['status']=400;
      	$data['message']=$output->message;
      }

      echo json_encode($data);

   }


    


	/// AKTIVASI //



	function aktivasi(){
		$url = "https://api.edunitas.com/mod/edun-regist-g";


		$email = $this->input->post('email');
		$code = $this->input->post('code');
		

		$postData = array(
		        "format"=> "json",
		        "setdata_mod"=> "aktivasi",
		        "formdata_email"=> $email,
		        "formdata_code"=> $code,
		       
 		);



	 // for sending data as json type
      $fields = json_encode($postData);




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
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);



      // echo "<pre>";
      // print_r($output);
      // die;

      if($output->statuscode=="014"){
      	$data['status']="sukses";
      	$data['message']=$output->message;
      }else{
      	$data['status']="gagal";
      	$data['message']=$output->message;
      }

      echo json_encode($data);
     }





     

     function educrypt($crypt = array()){
     $output = false;
     $encrypt_method = "AES-256-CFB8";

     if(is_array($crypt)) {

       if((isset($crypt['cid']) && $crypt['cid'] <> '') && (isset($crypt['secret']) && $crypt['secret'] <> '')){
         $secret_f = $crypt['cid'];
         $secret_s = $crypt['secret'];
         //$secret_s = sha1('EDUPASBNIPAY-'.date('YmdHis'));

         if(isset($crypt['data']) && is_string($crypt['data'])){
           $string = $crypt['data'];
           if(is_string($secret_f) && is_string($secret_s)){
             $key = hash('sha256', $secret_f);
             $iv = substr(hash('sha256', $secret_s), 0, 16);

             if(isset($crypt['action']) && $crypt['action'] <> ''){
               if($crypt['action'] == 'encrypt') {
                 $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
                 $output = str_replace("=", "eniTas", base64_encode($output));
               }else if($crypt['action'] == 'decrypt'){
                 $output = openssl_decrypt(base64_decode(str_replace("eniTas", "=", $string)), $encrypt_method, $key, 0, $iv);
               }
             }
           }
         }
       }
     }

     return $output;
   }





    function pendaftar_webinar()
    {
        error_reporting(0);
        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $no_wa = $this->input->post('no_wa');
        $wilayah = $this->input->post('wilayah');
        // $kampus_impian = $this->input->post('kampus_impian');
        // $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
        // $asal_sekolah = $this->input->post('asal_sekolah');
        $id_event = $this->input->post('id_event');

        // tambahan
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $usia = $this->input->post('usia');
        $no_tlp = $this->input->post('no_tlp');
        $provinsi = $this->input->post('provinsi');
        $tingkatan = $this->input->post('tingkatan');
        $sumber_informasi = $this->input->post('sumber_informasi');
        
        // tambahan



        $cek = $this->db->query('select * from pendaftar where email="' . $email . '" and kategori = "webinar"  and id_event =' . base64_decode($id_event))->row();

        if ($cek) {

            $data['status'] = 203;
            $data['message'] = "email sudah terdaftar";
        } else {

            $data_insert = array(
                'email' => $email,
                'nama' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'usia' => $usia,
                'no_tlp' => $no_tlp,
                'no_wa' => $no_wa,
                'provinsi' => $provinsi,
                'wilayah' => $wilayah,
                // 'kampus_impian' => $kampus_impian,
                // 'jurusan_diinginkan' => $jurusan_diinginkan,
                // 'asal_sekolah' => $asal_sekolah,
                'tingkatan' => $tingkatan,
                'sumber_informasi' => $sumber_informasi,
                'create_add' => date('Y-m-d H:i:s'),
                'id_event' => base64_decode($id_event),
                'kategori'=>'webinar',
            );



            $simpan = $this->db->insert('pendaftar', $data_insert);
            // $id_peserta_h = $this->db->insert_id();

            if ($simpan) {
                $data['status'] = 200;
                $data['message'] = "sukses";
                //  $data['id_peserta'] = $id_peserta_h;


                 $id_event_decode = base64_decode($id_event);


                $this->cek_mail($email,$nama,$no_tlp,$no_wa);

                $this->kirim_email($email,$id_event_decode);
            } else {
                $data['status'] = 404;
                $data['message'] = "gagal";
                // $data['id_peserta'] = 0;
            }
        }



        echo json_encode($data);
    }




    function kirim_email($form_email,$id_webinar){

    	//$form_email = "ajie.darmawan106@gmail.com";
    

        $webinar = $this->db->query('select * from webinar where id_webinar =' . $id_webinar)->row();


        $hari_ini = date('Y-m-d');


        if($webinar->tanggal==$hari_ini){
             $template_mail = 'webinar-zoom';
             $pulish_zoom = 1;

        }else{
           
             $template_mail = 'webinar-wa';
              $pulish_zoom = 0;

        }

    	

    	 $url = "https://dev-api.edunitas.com/edunitas_cek_mail";


        $postData = array(
            "email" => $form_email,
        );


        // echo "<pre>";
        // print_r($postData);
        // for sending data as json type
        $fields = json_encode($postData);

        $ch2 = curl_init($url);
        curl_setopt(
            $ch2,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json', // if the content type is json
                //  'bearer: '.$token // if you need token in header
            )
        );

        //  curl_setopt($ch2, CURLOPT_HEADER, false);
        // curl_setopt ( $ch2, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch2);
        curl_close($ch2);

        //   return $result;

        $output = json_decode($result);


        // echo "<pre>";
        // print_r($output);
        // die;




       // $keycode = "f41a3bf7aea5e4fec3f3f140412d717cadbe941c";
       // $nama = "ajie";
         $keycode = $output->key;
         $nama = $output->nama_lengkap;


















    	error_reporting(0);
    	/* KIRIM EMAIL USER LOGIN */

		$maildata = array();

		$maildata[0]['reciver'] = $form_email;

		$maildata[0]['recivername'] = $nama;

		$maildata[0]['template'] = $template_mail;

		$maildata[0]['contentdata'] = array();

		$maildata[0]['contentdata']['nama'] = $nama;

		$maildata[0]['contentdata']['event'] = "nama event";

		$maildata[0]['contentdata']['email'] = $form_email;

		// $maildata[0]['contentdata']['grup_wa'] = 'https://web.whatsapp.com/send?phone=6281213449117&text=Hai,%20Kak%20...%0aSebutkan%20Nama%20Lengkap%20dan%20Nama%20Sekolah,%20Ada%20yang%20bisa%20Kami%20bantu?';

        $maildata[0]['contentdata']['grup_wa'] = $webinar->share_link;


		$maildata[0]['contentdata']['link_zoom'] =  $webinar->link;

		$maildata[0]['contentdata']['tanggal'] = date('Y-m-d H:i:s');



		$attr = array();

		$attr['cid'] = 'mail';

		$attr['secret'] = sha1(md5('maildata'));

		$attr['action'] = 'encrypt';

		$attr['data'] = json_encode($maildata);

		$listfile = $this->educrypt($attr);





		$email = array();

		$email['format'] = 'json';

		$email['setdata_mod'] = 'send-mail';

		$email['formdata_origin'] = 'list';

		$email['formdata_template'] = 'registrasi';

		$email['formdata_apikey'] = $keycode;

		$email['formdata_data'] = $listfile;

		$email['formdata_type'] = 'single';

		

		

		$data_emailnya = array();

		$data_emailnya['format'] = 'json';

		$data_emailnya['setdata_mod'] = 'list-sendmail';

		$data_emailnya['formdata_data'] = base64_encode(json_encode($email));

		

		$postdata = json_encode($data_emailnya);



		$ch = curl_init('https://api.edunitas.com/mod/edun-load-g'); 

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0); 

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$result_mail = curl_exec($ch);

		curl_close($ch);
    }


    function blast_webinar(){
         $peserta_webinar = $this->db->query('select * from pendaftar where kategori = "webinar" order by id_pendaftar asc')->result();


         // echo "<pre>";
         // print_r($peserta_webinar);
         // die;


         foreach($peserta_webinar as $w){
            $this->kirim_email($w->email,$w->id_event);
         }


          $data['status'] = 200;
          $data['message'] = "sukses";

          echo json_encode($data);

    }





     function pendaftar()
    {
       // error_reporting(0);
        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $no_wa = $this->input->post('no_wa');
        $wilayah = $this->input->post('wilayah');
        $kampus_impian = $this->input->post('kampus_impian');
        $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
        $asal_sekolah = $this->input->post('asal_sekolah');
        $id_event = $this->input->post('id_event');

        // tambahan
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $usia = $this->input->post('usia');
        $no_tlp = $this->input->post('no_tlp');
        $provinsi = $this->input->post('provinsi');
        $tingkatan = $this->input->post('tingkatan');
        $sumber_informasi = $this->input->post('sumber_informasi');

        // tambahan



        $cek = $this->db->query('select * from pendaftar where email="' . $email . '" and kategori = "tryout" and id_event =' . base64_decode($id_event))->row();

        if ($cek) {

            $data['status'] = 203;
            $data['message'] = "email sudah terdaftar";
        } else {

            $data_insert = array(
                'email'         => $email,
                'nama'          => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'usia'          => $usia,
                'no_tlp'        => $no_tlp,
                'no_wa'         => $no_wa,
                'provinsi'      => $provinsi,
                'wilayah'       => $wilayah,
                'kampus_impian'          => $kampus_impian,
                'jurusan_diinginkan'     => $jurusan_diinginkan,
                'asal_sekolah'           => $asal_sekolah,
                'tingkatan'              => $tingkatan,
                'sumber_informasi'       => $sumber_informasi,
                'create_add' => date('Y-m-d H:i:s'),
                'id_event' => base64_decode($id_event),
                 'kategori'=>'tryout',
            );



           $simpan = $this->db->insert('pendaftar', $data_insert);



           $this->cek_mail($email,$nama,$no_tlp,$no_wa);

          




            if ($simpan) {
                $data['status'] = 200;
                $data['message'] = "sukses";
                //  $data['id_peserta'] = $id_peserta_h;
            } else {
                $data['status'] = 404;
                $data['message'] = "gagal";
                // $data['id_peserta'] = 0;
            }
        }



        echo json_encode($data);
    }


    function cek_mail($email,$nama,$no_tlp,$no_wa){

        $url = "https://api.edunitas.com/mod/edun-regist-g";


        //$email = $this->input->post('email');
    
          $postData = array(
                "format"=> "json",
                    "setdata_mod"=> "chekmail",
                    "formdata_email"=> $email,
         );


  // echo "<pre>";
  // print_r($postData);

// for sending data as json type
      $fields = json_encode($postData);




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
      // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result = curl_exec($ch);
      curl_close($ch);

      //   return $result;

      $output = json_decode($result);


      // echo "<pre>";
      // print_r($output);

      if($output->statuscode=="001"){
         $this->regis_non_pass($email,$nama,$no_tlp,$no_wa);
      }else{
        $data['status']="gagal";
        $data['message']=$output->message;

        //echo json_encode($data);
      }

      

    }


    function regis_non_pass($email,$nama,$no_tlp,$no_wa){
        $url = "https://api.edunitas.com/mod/edun-regist-g";

                    $postData = array(
                        "format"=> "json",
                        "setdata_mod"=> "regist",
                        "formdata_email"=> $email,
                        "formdata_nama"=> $nama,
                        "formdata_notlp"=> $no_tlp,
                        "formdata_nowa"=> $no_wa,
                         //  "formdata_pass"=> $pass,
                         // "formdata_repass"=> $pass,
                       
                        "formdata_lulusan"=> "SMA",
                        "formdata_alias"=> "tryout-p"


                    );

            

            // for sending data as json type
              $fields = json_encode($postData);




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
              // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

              $result = curl_exec($ch);
              curl_close($ch);



               $output = json_decode($result);
    }


    function event_khusus(){


      $tanggal = '2022-04-19';

      if($tanggal >= date('Y-m-d')){

        $data_array = array(
          'nama_event'=>'Try Out Online UTBK 2022 Gratis',
          'pelaksanaan' => '9-10 Mei 2022',
          'batas_pendaftaran'=> '8 Mei 2022',
          'desc' => '1.Soal Standar UTBK
                    2.Penialaian menggunakan IRT
                    3.Download soal dan pembahasan
                    4.Ranking Nasional',
          'desc2' => 'Hanya Terbatas untuk 1000 Peserta !',
          'desc3' => 'Buruan daftar sebelum terlambat'
        );

        $data_hasil = array(
          'status'=>200,
          'data'=>$data_array
        );

      }else{
        $data_array = array(
          'nama_event'=>'Kosong',
          'pelaksanaan' => 'Kosong',
          'batas_pendaftaran' => 'Kosong',
          'desc' => 'Kosong',
          'desc2' => 'Kosong',
          'desc3' => 'Kosong',

        );

        $data_hasil = array(
          'status'=>400,
          'data'=>$data_array
        );
      }




      echo json_encode($data_hasil);
      


    }




    function banner(){
      $banner = $this->db->query('select * from banner ')->result();

      foreach($banner as $b){
        $data_b[] = array(
          'file'=>base_url('assets/file_upload/banner/').$b->img,
        );
      }

      if($data_b){
        $data_data = array(
          'status'=>200,
          'data'=>$data_b,
        );
      }else{
        $data_data = array(
          'status'=>400,
          'data'=>array('file'=>null),
        );
      }


      echo json_encode($data_data);

    }



     














}