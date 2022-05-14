<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{


    function __construct(){
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
      // $this->load->model(array('auth/auth_model'));
        
    }

    protected function objToArray($obj)
    {
        // Not an object or array
        if (!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
    
        // Parse array
        foreach ($obj as $key => $value) {
            $arr[$key] = $this->objToArray($value);
        }
    
        // Return parsed array
        return $arr;
    }
    

    // function soal(){
      


    //     $data_api = array(
    //         'kode' => 001,
    //         'message' => "sukses",
    //         'listdata' => Array
    //     (
    //         'dari' => 1,
    //         'hingga' => 3,
    //         'totaldata' => 3,
    //         'totalhalaman' => 1,
    //         'datanya' => Array
    //             (
    //                 '0' => Array
    //                     (
    //                         'no' => 1,
    //                         'ccid' => "Nnc9PQb93bbfb93bbf",
    //                         'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
    //                         'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
    //                         'pilihan' => Array
    //                             (
    //                                 '0' => Array
    //                                     (
    //                                         'code' => 633,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
    //                                     ),

    //                                 '1' => Array
    //                                     (
    //                                         'code' => 631,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan." 
    //                                     ),

    //                                 '2' => Array
    //                                     (
    //                                         'code' => 632,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan." 
    //                                     ),

    //                                 '3' => Array
    //                                     (
    //                                         'code' => 634,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan." 
    //                                     ),

    //                                 ),

    //                     ),


    //                     '1' => Array
    //                     (
    //                         'no' => 2,
    //                         'ccid' => "Nnc9PQb93bbfb93bbf",
    //                         'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
    //                         'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
    //                         'pilihan' => Array
    //                             (
    //                                 '0' => Array
    //                                     (
    //                                         'code' => 633,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
    //                                     ),

    //                                 '1' => Array
    //                                     (
    //                                         'code' => 631,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan." 
    //                                     ),

    //                                 '2' => Array
    //                                     (
    //                                         'code' => 632,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan." 
    //                                     ),

    //                                 '3' => Array
    //                                     (
    //                                         'code' => 634,
    //                                         'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan." 
    //                                     ),

    //                                 ),

    //                     ),

                  

                   

    //             ),

    //         'waktunya' => 15
    //     )
    //     );

    //     echo json_encode($data_api);

       
    // }


    function soal2(){

        // echo base64_encode(22);
        // die;
        $soal = $this->db->query('select * from soalonline where materi_id = 21')->result_array();


        // echo "<pre>";
        // print_r($soal);

        foreach($soal as $s){

           


            $pilihan = json_decode($s['pilihan']);

                

            foreach($pilihan as $pi){

                if($pi->code=='1'){
                    $folder_jawaban = 'jawaban_a';
                    $nama_file_jawaban = $pi->name;
                }elseif($pi->code=='2'){
                    $folder_jawaban = 'jawaban_b';
                    $nama_file_jawaban = $pi->name;
                }elseif($pi->code=='3'){
                    $folder_jawaban = 'jawaban_c'; 
                    $nama_file_jawaban = $pi->name;   
                }elseif($pi->code=='4'){
                    $folder_jawaban = 'jawaban_d';
                    $nama_file_jawaban = $pi->name;
                }elseif($pi->code=='5'){
                    $folder_jawaban = 'jawaban_e';
                    $nama_file_jawaban = $pi->name;
                }

                $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
             
        
                if (file_exists($Path_jawaban) ){
                    $Path2_jawaban = $Path_img_jawaban;   
                    $type = 'gambar';
                }else{
                    $Path2_jawaban =  $pi->name;
                    $type = 'text';
                }

                


                $pil[$s['id']][] = array(
                    'code'=>$pi->code,
                    'name'=>$Path2_jawaban,
                    'type'=>$type,
                );
            }

            $Path_img = base_url("assets/file_upload/soalonline/soal/".$s['img']);

            $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$s['img'];

             if (file_exists($Path) ){
                 $Path1 = $s['img'];   
                     if($Path1){
                         $Path2 = $Path_img;
                     }else{
                         $Path2 = "";
                     }
             }else{
                 $Path2 = "";
             }

          
            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $s['pertanyaan'],
                'img' => $Path2,
                'pilihan' => $pil[$s['id']],
                'pembahasan'=>$s['pembahasan'],
               
            );
        }


        $data_api = array(
            'kode'=>1,
            'message'=>'sukses',
            'listdata'=>array(
                "dari"=> 1,
                "hingga"=> count($data_soal),
                "totaldata"=> count($data_soal),
                "totalhalaman"=> 1,
                "datanya"=>$data_soal,
                'waktu'=>40,
            )
        );

        echo json_encode($data_api);


       
    }



    function event(){
       echo base64_encode("1348");
       echo "<br>";
       echo base64_encode("refaaryani11@gmail.com");
        die;

        error_reporting(0);
        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();



         $hariini = date('Y-m-d');

      

        //$hariini = '2022-03-06';

        foreach($sql as $key => $s){


            if($hariini >= $s->tgl_mulai){

              

                

                   //jika hari ini kurang dari tgl selesai
                    if($s->tgl_selesai >= $hariini){

                       

                        $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and publish=1 and  id_event = ".$s->id_event)->result();
                        $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
    
    
    
                // $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();
    
    
    
    
                $wak = 0;
                foreach($waktu as $w){
    
                    $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
                    
                    
                    $wak += $w->waktu;
                }

                    $jumlah_soal = 0;
                    foreach($soal[$s->id_event] as $so){

                        // echo "<pre>";
                        //     print_r($so);

                        foreach($so as $sk){
                            $jumlah_soal += 1;
                        }
                    }

                // echo "<pre>";
                // print_r($sql);
                // die;

                

                    if($jumlah_soal!=0){
                        $data_api[] = array(
                            "id_event1"=> base64_encode($s->id_event),
                            "id_event"=> $s->id_event,
                            "judul"=> $s->judul,
                            "tgl_mulai"=> $s->tgl_mulai,
                            "tgl_selesai"=> $s->tgl_selesai,
                            "desc"=> $s->desc,
                            "img"=> $s->img,
                            "status"=> $s->status,
                            "mode"=> $s->mode,
                            // "materi_id" => $s->materi_id,
                            // "materi_nama"=> $s->materi_nama,
                        // "id_jurusan"=> $s->id_jurusan,
                            "waktu"=> $wak,
                            //"jurusan"=>$jurusan->jurusan_nama,
                            'jenis'=>$s->jenis_nama,
                            'kategori'=>$kategori->kategori_nama,
                            'jumlah_soal'=> $jumlah_soal,
                        );
                    }
                        
                    }


            }
             

            
        }

        echo json_encode($data_api);

        
    }




    function event_akan_datang()
    {

        error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();


        $hariini = date('Y-m-d');

        //$hariini = '2022-04-12';

        foreach ($sql as $key => $s) {





            // $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
            // $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();




            // $wak = 0;
            // foreach($waktu as $w){

            //     $soal[] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
            //     // $jumlah_soal = 0;
            //     // foreach($soal as $so){
            //     //     $jumlah_soal += count($soal);
            //     // }

            //     $wak += $w->waktu;
            // }

            // $j_soal = 0;
            // foreach($soal as $k){
            //     $j_soal += count($k);
            // }



            if ($hariini < $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {

                    $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = " . $s->id_event)->result();
                    $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = " . $s->id_kategori)->row();



                    // $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();




                    $wak = 0;
                    foreach ($waktu as $w) {

                        $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = " . $w->materi_id)->result();


                        $wak += $w->waktu;
                    }

                    $jumlah_soal = 0;
                    foreach ($soal[$s->id_event] as $so) {

                        // echo "<pre>";
                        //     print_r($so);

                        foreach ($so as $sk) {
                            $jumlah_soal += 1;
                        }
                    }

                    if ($jumlah_soal != 0) {
                        $data_api[] = array(
                            "id_event" => base64_encode($s->id_event),
                            "judul" => $s->judul,
                            "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                            "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                            "desc" => $s->desc,
                            "img" => $s->img,
                            "status" => $s->status,
                            "mode" => $s->mode,
                            // "materi_id" => $s->materi_id,
                            // "materi_nama"=> $s->materi_nama,
                            // "id_jurusan"=> $s->id_jurusan,
                            "waktu" => $wak,
                            //"jurusan"=>$jurusan->jurusan_nama,
                            'jenis' => $s->jenis_nama,
                            'kategori' => $kategori->kategori_nama,
                            'jumlah_soal' => $jumlah_soal,
                        );
                    }
                }
            }
        }

        if ($data_api) {

            $data_api_sukses = array(
                'status' => 200,
                'message' => "sukses",
                'datanya' => $data_api
            );
            echo json_encode($data_api_sukses);

            // echo json_encode($data_api);
        } else {
            $data_api_error = array(
                'status' => 400,
                'message' => "data kosong",
            );
            echo json_encode($data_api_error);
        }
    }


































    function latihan(){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();




        //         echo "<pre>";
        //         print_r($sql);
        // die;
        foreach ($sql as $s) {

            // $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = " . $s->id_event)->result();
            //  $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
            //  $jenis = $this->db->query("select jenis_nama from jenis where id_jenis = ".$s->id_jenis)->row();

            // $wak = 0;
            // $soal_total = 0;
            // foreach ($waktu as $w) {
            //       $soal = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
            //     $wak += $w->waktu;
            //     $soal_total += count($soal);
            // }


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api[] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            }
        }

        echo json_encode($data_api);

        
    }

    function detail($id_event){

        

        $id_event2 = base64_decode($id_event);   

        
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '".$id_event2."'")->result();

        // echo $id_event2;

        // echo "<pre>";
        // print_r($sql);
        // die;


        foreach($sql as $s){

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();

           


            $data_api[] = array(
                
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama"=> $s->materi_nama,
                "id_jurusan"=> $s->id_jurusan,
                "waktu"=> $s->waktu,
               "jurusan"=>$jurusan->jurusan_nama,
               'jenis'=>$jenis->jenis_nama,
               'jumlah_soal'=>count($soal),
               
            );
        }


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach($data_api as $d){
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }




        $data_api_api = array(
            "id_event"=> $sql[0]->id_event,
            "judul"=> $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai"=> $sql[0]->tgl_mulai_materi,
            "tgl_selesai"=> $sql[0]->tgl_selesai_materi,


            "desc"=> $sql[0]->desc,
            "img"=> $sql[0]->img,
            "status"=> $sql[0]->status,
            "mode"=> $sql[0]->mode,
            "jumlah_soal"=>$jumlah_soal,
            "jumlah_waktu"=>$jumlah_waktu,
            "data"=>$data_api
        );

        echo json_encode($data_api_api);



    }


    function jawaban(){
        // {
        //     "ccid":"N0E9PQb93bbfb93bbf",
        //     "ans_Nnc9PQb93bbfb93bbf":{
        //         "ans":"633",
        //         "time":""
        //     },
        //     "ans_NkE9PQb93bbfb93bbf":{
        //         "ans":"4233",
        //         "time":""
        //     },
        //     "ans_NlE9PQb93bbfb93bbf":{
        //         "ans":"4254",
        //         "time":""
        //     }
        // }



        // $data_array =array(
        //     'ccid'=>"N0E9PQb93bbfb93bbf",
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        // );



        $data_array =array(
            'materi_id'=>"18",
            'ans_192'=>array(
            
                'soal'=>192,
                'jawaban'=>'5'
            ),
            'ans_191'=>array(
            
                'soal'=>191,
                'jawaban'=>'5'
            ),
            'ans_190'=>array(
            
                'soal'=>190,
                'jawaban'=>'5'
            ),
            'ans_189'=>array(
            
                'soal'=>189,
                'jawaban'=>'5'
            ),
            
           
         
        );

          

      //  echo json_encode($data_array);
    //    echo "<pre>";
    //    print_r($data_array);


       $sql_soal = $this->db->query('select * from soalonline where materi_id = '.$data_array['materi_id'])->result();

       $event = $this->db->query('select id_event from materi where publish = 1 and materi_id = '.$data_array['materi_id'])->row();

       

    //    echo "<pre>";
    //    print_r($data_array);

       echo json_encode($data_array);
       die;

    foreach($sql_soal as $s=>$key){

       


        $total_nilai = 0;
        if($key->id==$data_array['ans_'.$key->id]['soal']){

            //hitung benar

            if($key->jawaban==$data_array['ans_'.$key->id]['jawaban']){
                $total_nilai +=  5;

              //  echo "benar";
            }elseif($data_array['ans_'.$key->id]['jawaban']==0){
                    //ga di isi 
                 $total_nilai +=  0;
               //  echo "ga disi";
            }else{

               // echo "salah";

                //salah
                $total_nilai +=   -1;
            }


        }


    }
       


       $data_jawaban = array(
           'materi_id'=>$data_array['materi_id'],
           'jawaban'=>json_encode($data_array),
           'skor'=>$total_nilai,
           'create_add'=>date('Y-m-d H:i:s'),
           'email'=>'ajie.darmawan106@gmail.com',
           'id_event'=>$event->id_event,
           'mode'=>2,
        );

       $q = $this->db->insert('jawaban',$data_jawaban);


       if($q){
           $data_api = array(
               'status'=>200,
               'message'=>'suksess',
               'skor'=>$total_nilai,
           );
       }

       echo json_encode($data_api);
       








    }


    function token(){

        $this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[256]');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[8]|max_length[256]');
		return Validation::validate($this, '', '', function($token, $output)
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$id = $this->Users->login($email, $password);
			if ($id != false) {
				$token = array();
				$token['id'] = $id;
				$output['status'] = true;
				$output['email'] = $email;
				$output['token'] = JWT::encode($token, $this->config->item('jwt_key'));
			}
			else
			{
				$output['errors'] = '{"type": "invalid"}';
			}
			return $output;
		});

        
    }

    function login(){

        $email = $this->input->post('email');
        $password = $this->input->post('password');
           $url = "https://dev-api.edunitas.com/login_api";




                  $postData = array(
                     "email"=>$email,
                    "password"=>$password,
                  

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
            // print_r($output->nama);
            // die;

            if($output->status==200){
                $data_log_login = array(
                    'email'=>$email,
                    'last_login'=>date('Y-m-d H:i:s'),
                    'device_id'=>'',
                    'nama'=>$output->nama,
                    'sekolah'=>$output->nama_sekolah,
                    'leveledu'=>$output->leveledu,
                );
                $this->db->insert('log_login',$data_log_login);
            }

            echo json_encode($output);
    }



    function login_salah(){


       



        $email   = $this->input->post('email');
      $mypassword = $this->input->post('password');
        $users = $this->db->query('select * from edu_apps.app_userdata where email  = "ajie.darmawan106@gmail.com"')->row();
 
 
         // echo "<pre>";
         // print_r($$users);
 
         if($users){
 
               $dbpassword = $users->password;
               $password = sha1(md5($mypassword));
 
                 if($users->userstatus==1){
                       $data['status'] = 200;
                       $data['message'] ="success";
                       $data['key'] = $users->keycode;
                       $data['email'] = $users->email;
                 }else if($users->userstatus==2){
                          $data['status'] = 300;
                         $data['message'] ="Anda Belum Reset Password";
                         $data['key'] = $users->keycode;
                         $data['email'] = $users->email;
                 }else{
                     $data['status'] = 405;
                     $data['message'] ="Akun Anda Belum Aktif";
                     $data['key'] = "`12345";
                     $data['email'] = "12345";
                 }
 
 
 
         }else{
                     $data['status'] = 405;
                     $data['message'] ="Akun Anda Belum Aktif";
                     $data['key'] = "`12345";
                     $data['email'] = "12345";
         }
 
         echo json_encode($data);
 
 
     }

     //jawaban di prod
     function jawaban_prod(){
        header('Content-type: application/json');
        // {
        //     "ccid":"N0E9PQb93bbfb93bbf",
        //     "ans_Nnc9PQb93bbfb93bbf":{
        //         "ans":"633",
        //         "time":""
        //     },
        //     "ans_NkE9PQb93bbfb93bbf":{
        //         "ans":"4233",
        //         "time":""
        //     },
        //     "ans_NlE9PQb93bbfb93bbf":{
        //         "ans":"4254",
        //         "time":""
        //     }
        // }



        // $data_array =array(
        //     'ccid'=>"N0E9PQb93bbfb93bbf",
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        // );


       $email = $this->input->post('email'); 
      $data_array2 = $this->input->post('res');

//       $data_array2 = $_POST;

      // echo "<pre>";
      // print_r($data_array2);
      // die;

      $data_array =  (array)json_decode($data_array2);



       //  $data_array =array(
       //      'materi_id'=>"22",
       //      'jawabannya'=>array(
       //       array(
       //          'soal'=>192,
       //          'jawaban'=>'5'
       //      ),
       //      array(
       //          'soal'=>191,
       //          'jawaban'=>'2'
       //      ),
       //      array(
       //          'soal'=>190,
       //          'jawaban'=>'3'
       //      ),
       //      array(
       //          'soal'=>189,
       //          'jawaban'=>'4'
       //      ),
           
       //   )
       //  );

       // echo json_encode($data_array);
       // echo "<pre>";
       // print_r($data_array);
       // die;


       $sql_soal = $this->db->query('select * from soalonline where materi_id = '.base64_decode($data_array['materi_id']))->result();

       $event = $this->db->query('select id_event from materi where publish = 1 and materi_id = '.base64_decode($data_array['materi_id']))->row();

       

    //    echo "<pre>";
    //    print_r($event);

    //    die;


         foreach($sql_soal as $s=>$key){

       


        $total_nilai = 0;
        if($key->id==$data_array['ans_'.$key->id]->soal){

            //hitung benar

            if($key->jawaban==$data_array['ans_'.$key->id]->jawaban){
                $total_nilai +=  5;

              //  echo "benar";
            }elseif($data_array['ans_'.$key->id]->jawaban==null){
                    //ga di isi 
                 $total_nilai +=  0;
               //  echo "ga disi";
            }else{

               // echo "salah";

                //salah
                $total_nilai +=   -1;
            }


        }


    }
       


       $data_jawaban = array(
           'materi_id'=>base64_decode($data_array['materi_id']),
           'jawaban'=>json_encode($data_array),
           //'jawaban'=>$data_array,
           'skor'=>$total_nilai,
           'create_add'=>date('Y-m-d H:i:s'),
           'email'=>$email,
           'id_event'=>$event->id_event,
        );

       $q = $this->db->insert('jawaban',$data_jawaban);


       if($q){
           $data_api = array(
               'status'=>200,
               'message'=>'suksess',
               'skor'=>$total_nilai,
           );
       }

       echo json_encode($data_api);
       








    }

   


     function jawaban_event(){
        $data_array =array(
           'event'=>'18',
           'datanya'=>  array(
               'mat_18'=>  array(
                'materi_id'=>"18",
                 'ans_192'=>   array(
                        'soal'=>192,
                        'jawaban'=>'5'
                    ),
                    'ans_191'=>  array(
                        'soal'=>191,
                        'jawaban'=>'2'
                    ),
                    'ans_190'=>  array(
                        'soal'=>190,
                        'jawaban'=>'3'
                    ),
                    'ans_189'=>  array(
                        'soal'=>189,
                        'jawaban'=>'4'
                    ),
   
            ),


            'mat_19'=>  array(
                'materi_id'=>"19",
                
                 'ans_193'=>   array(
                        'soal'=>193,
                        'jawaban'=>'2'
                    ),
                    'ans_194'=>  array(
                        'soal'=>194,
                        'jawaban'=>'5'
                    ),
                    'ans_195'=>  array(
                        'soal'=>195,
                        'jawaban'=>'5'
                    ),
                    'ans_196'=>  array(
                        'soal'=>196,
                        'jawaban'=>'2'
                    ),
          
                
            ),
            
            ),
    
        );

        // echo json_encode($data_array);

        // die;

        // echo "<pre>";
        // print_r($data_array['datanya']);

        // die;

        $total_nilai_perevent = 0;
        foreach($data_array['datanya'] as $a){
            // echo "<pre>";
            // print_r($a['materi_id']);
            // die;

            $sql_soal = $this->db->query('select * from soalonline where materi_id = '.$a['materi_id'])->result();
        
        
            $total_nilai = 0;
            foreach($sql_soal as $s=>$key){
   
         
           
                    if($key->id==$a['ans_'.$key->id]['soal']){
            
                        //hitung benar
            
                        if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                            $total_nilai +=  5;
            
                            //  echo "benar";
                        }elseif($a['ans_'.$key->id]['jawaban']==null){
                                //ga di isi 
                                $total_nilai +=  0;
                            //  echo "ga disi";
                        }else{
            
                            // echo "salah";
            
                            //salah
                            $total_nilai +=   -1;
                        }
            
            
                        }

                        $cari_user = $this->db->query('select * from jawaban where email="tes" and materi_id="'.$key->materi_id.'"')->row();
             
                        if($cari_user){
                            $mode =3;
                        }else{
                            $mode = 1;
                        }
   
   
            }

           

            $data_jawaban = array(
                'materi_id'=>$a['materi_id'],
                'jawaban'=>json_encode($a),
                //'jawaban'=>$data_array,
                'skor'=>$total_nilai,
                'create_add'=>date('Y-m-d H:i:s'),
                'email'=>'tes',
                'id_event'=>$data_array['event'],
                'mode'=>$mode,
             );
     
            $q = $this->db->insert('jawaban',$data_jawaban);

            $total_nilai_perevent += $total_nilai;

            

           
        }


        if($q){
            $data_api = array(
                'status'=>200,
                'message'=>'suksess',
                'skor'=>$total_nilai_perevent,
                
            );

            echo json_encode($data_api);
        }
     }




     function soal_event(){

        // echo base64_encode(8);
        // die;

        $materi = $this->db->query('select materi_id,materi_nama from  materi where id_event = 8 order by no_urut asc')->result_array();


        foreach($materi as $m){
            $soal = $this->db->query('select * from soalonline where materi_id = "'.$m['materi_id'].'"  ')->result_array();

            
            foreach($soal as $s){
                $pilihan = json_decode($s['pilihan']);

                

                foreach($pilihan as $pi){

                    if($pi->code=='1'){
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='2'){
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='3'){
                        $folder_jawaban = 'jawaban_c'; 
                        $nama_file_jawaban = $pi->name;   
                    }elseif($pi->code=='4'){
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='5'){
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                    $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                 
            
                    if (file_exists($Path_jawaban) ){
                        $Path2_jawaban = $Path_img_jawaban;   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }


                    $pil[$s['id']][] = array(
                        'code'=>$pi->code,
                        'name'=>$Path2_jawaban,
                        'type'=>$type,
                    );
                }


               //  $Path = './assets/file_upload/soalonline/'.$s['img'];
               $Path_img = base_url("assets/file_upload/soalonline/soal/".$s['img']);

               $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$s['img'];
                
           
                if (file_exists($Path) ){
                    $Path1 = $s['img'];   
                        if($Path1){
                            $Path2 = $Path_img;
                        }else{
                            $Path2 = "";
                        }
                }else{
                    $Path2 = "";
                }

                $data_soal[$m['materi_id']][] = 
                  array(
                    'no' => $s['id'],
                   //'materi_id' => $s['materi_id'],
                    'pertanyaan' => $s['pertanyaan'],
                    'img' => $Path2,
                    'pilihan'=>$pil[$s['id']], 
                );

            }

            // echo "<pre>";
            // print_r($data_soal);
            // die;

            $j_materi_id[] =array(
                    $m['materi_id'] => array(
                        'materi_id'=>$m['materi_id'],
                        'materi_nama'=>$m['materi_nama'],
                        'datanya'=>$data_soal[$m['materi_id']],
                        "totalhalaman"=> 1,
                        "hingga"=> count($soal),
                        "totaldata"=> count($soal),
                        'waktu'=>40,
                    ),
            );

        }

        $data_api = array(
            'kode'=>1,
            'message'=>'sukses',
            'listdata'=>array(
                "dari"=> 1,
                "datanya"=>$j_materi_id,
                
            )
        );

        echo json_encode($data_api);

       
     }


     function sortAssociativeArrayByKey($array, $key, $direction){

        switch ($direction){
            case "ASC":
                usort($array, function ($first, $second) use ($key) {
                    return $first[$key] <=> $second[$key];
                });
                break;
            case "DESC":
                usort($array, function ($first, $second) use ($key) {
                    return $second[$key] <=> $first[$key];
                });
                break;
            default:
                break;
        }
    
        return $array;
    }

     // total gabungan
     function list_skor(){

        //cari nama 

        error_reporting(0);
        $user = $this->db->query('select id_peserta,email,id_event,materi_id from jawaban where id_event = 8 group by email')->result();

        //looping cari nama
        foreach($user as $u){
                     
                    //cari materi nya apa aja
                    $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.id_event = 8' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    //dillooping materinya cari skor
                   
                    foreach($event_materi as $e)
                    {
                        $jawaban[$u->email][] = $this->db->query('select * from jawaban where mode = 1 and materi_id = "'.$e->materi_id.'" and email = "'.$u->email.'" order by id_jawaban desc')->row();

                    }


                  
                     $skor = 0;
                      foreach($jawaban[$u->email] as $j){
                        $skor += $j->skor;
                      }

                 $sekolah[$u->email] = $this->db->query('select asal_sekolah from peserta where id_peserta="'.$u->id_peserta.'"')->row();     
                 $event = $this->db->query('select judul from event where id_event='.$u->id_event)->row();     


                 $waktu_awal        =strtotime($jawaban[$u->email][0]->tgl_mulai);
                 $waktu_akhir    =strtotime($jawaban[$u->email][0]->create_add); // bisa juga waktu sekarang now()
                 
                 //menghitung selisih dengan hasil detik
                 $diff    =$waktu_akhir - $waktu_awal;

                 $data_api[] = array(
                    'email'=>$u->email,
                    'event'=>$event->judul,
                    'skor'=>$skor,
                    'waktu'=>floor($diff/60),
                    //'asal_sekolah'=>$sekolah[$u->email],
                  // 'jawaban'=>$jawaban[$u->email],
                   'waktu_pengerjaan'=> TanggalIndo(date('Y-m-d',strtotime($jawaban[$u->email][0]->tgl_mulai))) .' '.date('H:i:s',strtotime($jawaban[$u->email][0]->tgl_mulai)),
                   
                );

                
       }


       foreach($data_api as $a){

           // if($a['skor']==$a['skor']){
               
           // }else{

           // }
           $data_api_api[] = array(
               'email'=>$a['email'],
               'nama'=>$sekolah[$a['email']]->nama,
               'event'=>$a['event'],
               'skor'=>$a['skor'],
               'waktu'=>$a['waktu'],
               'asal_sekolah'=>$sekolah[$a['email']]->asal_sekolah,
                'waktu_pengerjaan'=>$a['waktu_pengerjaan'],
           );
       }

       $sort_by_skor = $this->sortAssociativeArrayByKey($data_api_api,'skor','DESC');

        

        echo json_encode($sort_by_skor);
       
        // foreach($sort_by_skor as $s){
        //     $data_api_api_skor[] = array(
        //         'email'=>$s['email'],
        //         'event'=>$s['event'],
        //         'skor'=>$s['skor'],
        //         'waktu'=>$s['waktu'],
        //     );
        // }

        // $sort_by_skor_and_waktu = $this->sortAssociativeArrayByKey($data_api_api_skor,'waktu','ASC');

        // echo json_encode($sort_by_skor);
        // die;
        

        // echo json_encode($data_api_api);

 
     }



     // total tpa /tps
     function list_skor_jenis(){


        $e = $this->db->query('select e.id_kategori,e.judul from event as e inner join kategori as k on e.id_kategori = k.id_kategori where e.id_event=8')->row();

        $jeni = $this->db->query('select * from jenis where id_kategori='.$e->id_kategori)->result();

        // echo "<pre>";
        // print_r($jeni);
        // die;
        //cari nama 
        $user = $this->db->query('select email,id_event,materi_id from jawaban where id_event = 8 group by email')->result();

        //looping cari nama
        foreach($jeni as $u){
                     
                    //cari materi nya apa aja
                    $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.id_jenis = "'.$u->id_jenis.'"' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    //dillooping materinya cari skor
                    $skor = 0;
                    foreach($event_materi as $e)
                    {
                        $jawaban[$u->jenis_nama][] = $this->db->query('select * from jawaban where materi_id = "'.$e->materi_id.'" and email = "ajie" order by id_jawaban desc')->row();
                        
                    
                    }



                      foreach($jawaban[$u->jenis_nama] as $j){
                        $skor += $j->skor;
                      }


               //  $event = $this->db->query('select judul from event where id_event='.$u->id_event)->row();     

                 $data_api[] = array(
                     'email'=>$u->jenis_nama,
                     'event'=>$e->judul,
                     'skor'=>$skor,
                    //'jawaban'=>$jawaban[$u->email],
                 );


        }

        

        echo json_encode($data_api);

 
     }



     function cari_nilai(){
         $id_event = 8;
         $email = 'tes';

        $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

        // echo "<pre>";
        // print_r($materi);
        foreach($materi as $m){
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

            
        }


        $benar = 0;
        $salah = 0;
        $kosong = 0;
       
        foreach($soal[$m->materi_id] as $m => $key){

            $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


            if($key->id==$a['ans_'.$key->id]['soal']){
            
                //hitung benar

                // echo $key->id;
                // die;
    
                if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                    $benar +=  1;
    
                    //  echo "benar";
                }elseif($a['ans_'.$key->id]['jawaban']==null){
                        //ga di isi 
                        $kosong +=  1;
                    //  echo "ga disi";
                }else{
    
                    // echo "salah";
    
                    //salah
                    $salah +=   1;
                }
    
    
            }
        }

        $skor = 0;
        foreach($jawaban as $j){
            $skor += $j->skor;
        }

        $data_api = array(
            'skor'=>$skor,
            'benar'=>$benar,
            'salah'=>$salah,
            'kosong'=>$kosong,
        );

        echo json_encode($data_api);



     }


     function pembahasan(){

     

        error_reporting(0);
        $id_event = 8;
        $email = 'ajie';

       $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

    //    echo "<pre>";
    //    print_r($materi);
       foreach($materi as $m){
           $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

           $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
           $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

          
           foreach($soal[$m->materi_id] as $k =>$key){

            // echo "tes";

            echo "<pre>";
            print_r($key);

            $pilihan = json_decode($key->pilihan);

                

                foreach($pilihan as $pi){

                    if($pi->code=='1'){
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='2'){
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='3'){
                        $folder_jawaban = 'jawaban_c'; 
                        $nama_file_jawaban = $pi->name;   
                    }elseif($pi->code=='4'){
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='5'){
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                    $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                 
                if($nama_file_jawaban){
                     if (file_exists($Path_jawaban) ){
                        $Path2_jawaban = $Path_img_jawaban;   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }
                }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                }
                   


                    $pil[$key->id][] = array(
                        'code'=>$pi->code,
                        'name'=>$Path2_jawaban,
                        'type'=>$type,
                    );
                }

             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));

            
             if($key->id==$a['ans_'.$key->id]['soal']){

              
                //  $Path = './assets/file_upload/soalonline/'.$s['img'];
               $Path_img = base_url("assets/file_upload/soalonline/soal/".$key->img);

               $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$key->img;
   
                if (file_exists($Path) ){
                    $Path1 = $key->img;   
                        if($Path1){
                            $Path2 = $Path_img;
                        }else{
                            $Path2 = "";
                        }
                }else{
                    $Path2 = "";
                }


                // pembahasan
                $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$key->pembahasan_img);

               $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$key->pembahasan_img;
   
                if (file_exists($Path) ){
                    $Path1_pembahasan_img = $key->pembahasan_img;   
                        if($Path1_pembahasan_img){
                            $Path2_pembahasan_img = $Path_pembahasan_img;
                        }else{
                            $Path2_pembahasan_img = "";
                        }
                }else{
                    $Path2_pembahasan_img = "";
                }

                

                
            
                $data_data[$key->materi_id][] = array(
                    'id' => $key->id,
                    'materi_id' => $key->materi_id,
                    'materi_nama' => $m->materi_nama,
                    
                    'pertanyaan' => $key->pertanyaan,
                    
                    'img' => $Path2,
  
                    'jawaban' => $key->jawaban,
                    'pilihan' => $pil[$key->id],
                    
                   
                    'pembahasan' => $key->pembahasan,
                    'pembahasan_img'=>$Path2_pembahasan_img,
                    'jawaban_anda'=>$a['ans_'.$key->id]['jawaban'],
              );
                
                
    
            }

              
           }


           $data_api[] = array(
            $m->materi_id => $data_data[$m->materi_id],

        );
    }

    echo json_encode($data_api);





     }



      // total tpa /tps
      function list_skor_jenis_gabungan(){


        $e = $this->db->query('select e.id_kategori,e.judul from event as e inner join kategori as k on e.id_kategori = k.id_kategori where e.id_event=8')->row();

        $jeni = $this->db->query('select * from jenis where id_kategori='.$e->id_kategori)->result();

        // echo "<pre>";
        // print_r($jeni);
        // die;
        //cari nama 
        
        //looping cari nama
        foreach($jeni as $u){

            $user = $this->db->query('select email,id_event,materi_id from jawaban where id_event = 8 group by email')->result();


            foreach($user as $us){

                $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.id_event = 8 and m.id_jenis="'.$u->id_jenis.'"' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    //dillooping materinya cari skor
                    $skor = 0;
                    foreach($event_materi as $e)
                    {
                        $jawaban[$us->email][$u->jenis_nama][] = $this->db->query('select * from jawaban where materi_id = "'.$e->materi_id.'" and email = "'.$us->email.'" order by id_jawaban desc')->row();
        
                    }


                      foreach($jawaban[$us->email][$u->jenis_nama] as $j){
                        $skor += $j->skor;
                      }

                      $event = $this->db->query('select judul from event where id_event='.$us->id_event)->row();     

                      $data_api_users[$u->jenis_nama][] = array(
                          'email'=>$us->email,
                          'event'=>$event->judul,
                          'skor'=>$skor,
                         //'jawaban'=>$jawaban[$us->email][$u->jenis_nama],
                      );

            }
                     
                       

                 $data_api[$u->jenis_nama] = array(
                     'email'=>$u->jenis_nama,
                     'event'=>$e->judul,
                     'data'=>$data_api_users[$u->jenis_nama],
                    //'jawaban'=>$jawaban[$us->email],
                 );


        }

        

        echo json_encode($data_api);

 
     }


     public function register()
    {

        
       
      // Konfigurasi email
        $config = [
            // 'mailtype'  => 'html',
            // 'charset'   => 'utf-8',
            // 'mailpath'=> '/usr/sbin/sendmail -bs',
            // 'protocol'  => 'smtp',
            // 'smtp_host' => 'mxgate.p2k.co.id',
            // 'smtp_user' => 'support@edunitas.com',  // Email gmail
            // 'smtp_pass'   => 'support2021',  // Password gmail
            // //'smtp_crypto' => 'ssl',
            // 'smtp_port'   => 2525,
            // 'crlf'    => '\r\n',
            // 'newline' => '\r\n'

            // 'protocol' => 'smtp',
            // 'smtp_host' => 'smtp.mailtrap.io',
            // 'smtp_port' => 2525,
            // 'smtp_user' => 'ee0a78e7342398',
            // 'smtp_pass' => 'b0d162e8ea6a83',
            // 'crlf' => "\r\n",
            // 'newline' => "\r\n"


            'protocol' => 'smtp',
            'smtp_host' => 'mxgate.p2k.co.id',
            'smtp_port' => 2525,
            'smtp_user' => 'support@edunitas.com',
            'smtp_pass' => 'support2021',
            'crlf' => "\r\n",
            'newline' => "\r\n"
        ];

        // Load library email dan konfigurasinya
       $this->load->library('email', $config);
    //    $this->load->library('email');
    //    $this->email->initialize($config);


        // Email dan nama pengirim
        $this->email->from('estipratiwi2404@edunitas.com', 'MasRud.com');

        // Email penerima
        $this->email->to('ajie.darmawan106@gmail.com'); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
      //  $this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

        // Subject email
        $this->email->subject('Kirim Email dengan SMTP Gmail CodeIgniter | MasRud.com');

        // Isi email
        $this->email->message("Ini adalah contoh email yang dikirim menggunakan SMTP Gmail pada CodeIgniter.<br><br> Klik <strong><a href='https://masrud.com/kirim-email-codeigniter/' target='_blank' rel='noopener'>disini</a></strong> untuk melihat tutorialnya.");

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
        } else {
            echo 'Error! email tidak dapat dikirim.';
             echo '<br />';
               echo $this->email->print_debugger();
        }
    }


    public function send(){

      //  error_reporting(0);
        $this->load->library('mailer');
        $email_penerima = $this->input->post('ajie.darmawan106@gmail.com');
        // $subjek = $this->input->post('subjek');
        // $pesan = $this->input->post('pesan');
        //$attachment = $_FILES['attachment'];

        $subjek = "cek";
        $pesan = "tes";

        $content = $this->load->view('content', array('pesan'=>$pesan), true); // Ambil isi file content.php dan masukan ke variabel $content
        $sendmail = array(
          'email_penerima'=>$email_penerima,
          'subjek'=>$subjek,
          'content'=>$content,
          //'attachment'=>$attachment
        );
        // if(empty($attachment['name'])){ // Jika tanpa attachment
        //   $send = $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
        // }else{ // Jika dengan attachment
        //   $send = $this->mailer->send_with_attachment($sendmail); // Panggil fungsi send_with_attachment yang ada di librari Mailer
        // }

        $send = $this->mailer->send($sendmail); 
        echo "<b>".$send['status']."</b><br />";
        
      }


      function datadiri(){
          $email = $this->input->post('email');
          $nama = $this->input->post('nama');
          $no_wa = $this->input->post('no_wa');
          $wilayah = $this->input->post('wilayah');
          $kampus_impian = $this->input->post('kampus_impian');
          $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
          $asal_sekolah = $this->input->post('asal_sekolah');

          $data_insert= array(
            'email'=>$email,
            'nama'=>$nama,
            'no_wa'=>$no_wa,
            'wilayah'=>$wilayah,
            'kampus_impian'=>$kampus_impian,
            'jurusan_diinginkan'=>$jurusan_diinginkan,
            'asal_sekolah'=>$asal_sekolah,
            'create_add'=>date('Y-m-d H:i:s'),
          );

          $simpan = $this->db->insert('userdata',$data_insert);

          if($simpan){
              $data['status'] = 200;
              $data['message'] = "sukses";
          }else{
            $data['status'] = 404;
            $data['message'] = "gagal";
          }
          echo json_encode($data);
      }

      function detail_latihan($judul){
          error_reporting(0);
        //$judul = "Pekan-I---Latihan-Soal";

  
        $event_latihan = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' and REPLACE(judul, ' ', '-' ) = 'CEK-Latihan'")->result();

        // echo "<pre>";
        // print_r($event_latihan);

        // die;

        foreach($event_latihan as $s){

            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = ".$s->id_event)->result();
          
           
            // echo "<pre>";
            // print_r($materi);
            
            // die;
         

            foreach($materi[$s->id_event] as $e){

                

           
                $soal = $this->db->query("select * from soalonline where materi_id = ".$e->materi_id)->result();

                $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$e->id_jurusan)->row();


                $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();


                $data[$s->kategori_nama][]  = array(
                    'materi_nama'=>$e->materi_nama,
                     'materi_id'=>$e->materi_id,
                    'jenis'=>$jenis->jenis_nama,
                    'waktu'=>$e->waktu,
                    'soal'=>count($soal),
                    'jurusan'=>$jurusan->jurusan_nama,
                
                
                );
            }

            
            // $data[$s->kategori_nama][] = array(
            //     'materi_nama'=>$materi[$s->id_event],
            //     // 'materi_id'=>$materi->materi_id,
            //     // 'jenis'=>$jenis->jenis_nama,
            //     // 'waktu'=>$materi->waktu,
            //     // 'soal'=>count($soal),
            //     // 'jurusan'=>$jurusan->jurusan_nama,
            // );
        }

        $data_api = array(
            'status'=>200,
            'tanggal'=> TanggalIndo($event_latihan[0]->tgl_mulai) .'-'. TanggalIndo($event_latihan[0]->tgl_selesai),
            'event'=>$event_latihan[0]->judul,
            'datanya'=>$data,

        );

        echo json_encode($data_api);






      }



      function cari_nilai_materi($email2,$id_jawaban2){
        

       
       $email = base64_decode($email2);
       $id_jawaban = base64_decode($id_jawaban2);

       $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
       $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
        

        
        foreach($materi as $m){

          // print_r($m->materi_id);
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where  materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where  id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

        // echo "<pre>";
        // print_r($soal);
       
        foreach($soal[$m->materi_id] as  $key){
             $key1[] = $key;
        }

            
        }


        


        // echo "<pre>";
        // print_r($key1);
        // die;

        $benar = 0;
        $salah = 0;
        $kosong = 0;
        $skor_benar = 0;
        $skor_salah = 0;
        $skor_gadisi = 0;
      
        foreach($key1 as $key){
             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


            if($key->id==$a['ans_'.$key->id]['soal']){
            
                //hitung benar

                // echo $key->id;
                // die;
    
                if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                   $benar +=  1;
                    $skor_benar += 4;
                
    
                    //  echo "benar";
                }elseif($a['ans_'.$key->id]['jawaban']==0){
                        //ga di isi 
                        $kosong +=  1;
                        $skor_gadisi += 0;
                     
                    //  echo "ga disi";
                }else{
    
                    // echo "salah";
    
                    //salah
                    $skor_salah +=   -1;
                     $salah +=  1;
                   
                }
    
    
            }
        }


        //die;

        //error_reporting(0);

       

        //  echo "<pre>";
        // print_r($soal);

        // // echo "<pre>";
        // // print_r($a);
       // die;

        // $skor = 0;
        // foreach($jawaban as $j){
        //     $skor += $j->skor;
        // }

        $hasil_hasil_nilai = $skor_benar+$skor_gadisi+$skor_salah;

        if($hasil_hasil_nilai <= 0){
            $hasil_hasil_nilai2 = 0;
        }else{
              $hasil_hasil_nilai2 = $hasil_hasil_nilai;
        }

        $data_api = array(
            'skor'=>$hasil_hasil_nilai2,

            'skor_benar'=>$skor_benar,
            'skor_gadisi'=>$skor_gadisi,
            'skor_salah'=>$skor_salah,


            'benar'=>$benar,
             'kosong'=>$kosong,
            'salah'=>$salah,
           
            'totalsoal'=>count($key1),
        );

        echo json_encode($data_api);



     }


     function pembahasan_materi($email2,$id_jawaban2){

        $email = base64_decode($email2);
       $id_jawaban = base64_decode($id_jawaban2);
     
        //$email = $this->input->post('email');

        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
 
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
 
        // echo "<pre>";
        // print_r($materi);

        // die;
        foreach($materi as $m){
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
           
            foreach($soal[$m->materi_id] as $k =>$key){
 
             $pilihan = json_decode($key->pilihan);
             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));
                 
 
                 foreach($pilihan as $pi){
 
                     if($pi->code=='1'){
                         $folder_jawaban = 'jawaban_a';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='2'){
                         $folder_jawaban = 'jawaban_b';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='3'){
                         $folder_jawaban = 'jawaban_c'; 
                         $nama_file_jawaban = $pi->name;   
                     }elseif($pi->code=='4'){
                         $folder_jawaban = 'jawaban_d';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='5'){
                         $folder_jawaban = 'jawaban_e';
                         $nama_file_jawaban = $pi->name;
                     }
 
                     $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                     $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                  
                 if($nama_file_jawaban){
                      if (file_exists($Path_jawaban) ){
                         $Path2_jawaban = $Path_img_jawaban;   
                         $type = 'gambar';
                     }else{
                         $Path2_jawaban =  $pi->name;
                         $type = 'text';
                     }
                 }else{
                         $Path2_jawaban =  $pi->name;
                         $type = 'text';
                 }
                    
 
 
                     $pil[$key->id][] = array(
                         'code'=>$pi->code,
                         'name'=>$Path2_jawaban,
                         'type'=>$type,
                     );
                 }
 
 
              if($key->id==$a['ans_'.$key->id]['soal']){
 
 
 
                  //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                $Path_img = base_url("assets/file_upload/soalonline/soal/".$key->img);
 
                $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$key->img;
    
                 if (file_exists($Path) ){
                     $Path1 = $key->img;   
                         if($Path1){
                             $Path2 = $Path_img;
                         }else{
                             $Path2 = "";
                         }
                 }else{
                     $Path2 = "";
                 }
 
 
                 // pembahasan
                 $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$key->pembahasan_img);
 
                $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$key->pembahasan_img;
    
                 if (file_exists($Path) ){
                     $Path1_pembahasan_img = $key->pembahasan_img;   
                         if($Path1_pembahasan_img){
                             $Path2_pembahasan_img = $Path_pembahasan_img;
                         }else{
                             $Path2_pembahasan_img = "";
                         }
                 }else{
                     $Path2_pembahasan_img = "";
                 }
 
 
             
                 $data_data[$key->materi_id][] = array(
                     'id' => $key->id,
                     'materi_id' => $key->materi_id,
                      'materi_nama' => $m->materi_nama,
                     
                     'pertanyaan' => $key->pertanyaan,
                      'img' => $Path2,
   
                     'jawaban' => $key->jawaban,
                     'pilihan' => $pil[$key->id],
                     'pertanyaan_img' => $key->pertanyaan_img,
                      'pembahasan' => $key->pembahasan,
                     'pembahasan_img'=>$Path2_pembahasan_img,
                     'jawaban_anda'=>$a['ans_'.$key->id]['jawaban'],
               );
                 
                 
     
             }
 
               
            }
 
 
            $data_api[] = array(
             $m->materi_id=>$data_data[$m->materi_id],
                
            );
        }
 
        echo json_encode($data_api);
 
 
      }


      function latihan_get_all(){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api['berlangsung'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            }
        }

        //berlalu
       
         foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            // if ($hariini <= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai <= $hariini) {
                    $data_api['lalu'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            // }
        }


        

        echo json_encode($data_api);

        
    }


    function latihan_berlangsung(){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api['berlangsung'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            }
        }

       


        

        echo json_encode($data_api);

        
    }

    function latihan_berlalu($paging=null){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        if($paging){
          //  echo "1";
            $offset = $paging;
        }else{
          // echo "2";
            $offset = 0;
        }
        //die;

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai LIMIT 10  OFFSET ".$offset.""
        )->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai <= $hariini) {
                    $data_api['berlalu'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            
        }

       


        

        echo json_encode($data_api);

        
    }


    function pembahasan_random(){

     

        error_reporting(0);
        $id_event = 8;
        $email = 'ajie';

       $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

    //    echo "<pre>";
    //    print_r($materi);
       foreach($materi as $m){

      
           $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

        //    $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
           $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'"')->result();

           echo "<pre>";
           print_r($jawaban_skor);
           die;
           foreach($jawaban_skor[$m->materi_id] as $k =>$key){

            

                 $soal_3 =  $this->db->query('select * from soalonline where materi_id =  "'.$key->materi_id.'" ')->result();
           
              

                 $a = $this->objToArray(json_decode($key->jawaban, true));

                $pilihan = json_decode($soal_3[$k]->pilihan);

                

                foreach($pilihan as $pi){

                 

                    if($pi->code=='1'){
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='2'){
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='3'){
                        $folder_jawaban = 'jawaban_c'; 
                        $nama_file_jawaban = $pi->name;   
                    }elseif($pi->code=='4'){
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='5'){
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                    $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                 
                if($nama_file_jawaban){
                     if (file_exists($Path_jawaban) ){
                        $Path2_jawaban = $Path_img_jawaban;   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }
                }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                }
                   


                    $pil[$soal_3[$k]->id][] = array(
                        'code'=>$pi->code,
                        'name'=>$Path2_jawaban,
                        'type'=>$type,
                    );
                }

               

                 if($soal_3[$k]->id==$a['ans_'.$soal_3[$k]->id]['soal']){

                  
                    

                    $Path_img = base_url("assets/file_upload/soalonline/soal/".$soal_3[$k]->img);

                    $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$soal_3[$k]->img;
        
                     if (file_exists($Path) ){
                         $Path1 = $soal_3[$k]->img;   
                             if($Path1){
                                 $Path2 = $Path_img;
                             }else{
                                 $Path2 = "";
                             }
                     }else{
                         $Path2 = "";
                     }
     
     
                     // pembahasan
                     $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$soal_3[$k]->pembahasan_img);
     
                    $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$soal_3[$k]->pembahasan_img;
        
                     if (file_exists($Path) ){
                         $Path1_pembahasan_img = $soal_3[$k]->pembahasan_img;   
                             if($Path1_pembahasan_img){
                                 $Path2_pembahasan_img = $Path_pembahasan_img;
                             }else{
                                 $Path2_pembahasan_img = "";
                             }
                     }else{
                         $Path2_pembahasan_img = "";
                     }
     
                     $data_data[$key->materi_id][] = array(
                         'id' => $a['ans_'.$soal_3[$k]->id]['soal'],
                         'materi_id' => $soal_3[$k]->materi_id,
                         'materi_nama' => $m->materi_nama,
                         'pertanyaan' => $soal_3[$k]->pertanyaan,
                         'img' => $Path2,
                         'jawaban' => $soal_3[$k]->jawaban,
                         'pilihan' => $pil[$soal_3[$k]->id],
                         'pembahasan' => $soal_3[$k]->pembahasan,
                         'pembahasan_img'=>$Path2_pembahasan_img,
                         'jawaban_anda'=>$a['ans_'.$soal_3[$k]->id]['jawaban'],
                   );

                  
            }
        
                }

                $data_api[] = array(
                    $m->materi_id => $data_data[$m->materi_id],
        
                );

            }


            echo json_encode($data_data);


     }


     function webinar_detail()
     {
        
 
         $id_webinar = 11;
         //echo $id_webinar;
 
         $k = $this->db->query("select * from webinar where id_webinar = " . $id_webinar . " order by id_webinar desc")->row();
 
        // echo "<pre>";
        // print_r($k->waktu);

        $wak = explode("-",$k->waktu);

        

       $wak_selesai = $wak[1];
 
       
 
 
        //   $hari_ini = date('Y-m-d');

        $jam = date('h:i');

        //$jam = '17:35';



        $hari_ini = '2022-04-26';
 
 
         if($k->tanggal==$hari_ini){
                
            if($wak_selesai>=$jam){
                $pulish_zoom = 1;
            }elseif($wak_selesai<$jam){
                $pulish_zoom = 2;
            }
             
 
         }else if($k->tanggal<$hari_ini){
           //   $template_mail = 'webinar-zoom';
              $pulish_zoom = 2;
 
         }
 
 
 
         else{
            
              //$template_mail = 'webinar-wa';
               $pulish_zoom = 0;
 
         }
 
 
 
 
 
         $gambar = base_url("assets/file_upload/webinar/" . $k->img);
 
         $data = array(
             'id_webinar' => $k->id_webinar,
             'topik' => $k->topik,
             'waktu' => $k->waktu,
             'tanggal' => TanggalIndo($k->tanggal),
             'foto' => $gambar,
             'pembicara' => $k->pembicara,
             'jabatan_pembicara' => $k->jabatan_pembicara,
             'moderator' => $k->moderator,
             'jabatan_moderator' => $k->jabatan_moderator,
              'desc'=>$k->desc,
               'share_link'=>$k->share_link,
               'link'=>$k->link,
               'publish_zoom'=>$pulish_zoom,
         );
 
         $data_data = array(
             'status' => 200,
             'message' => 'sukses',
             'data' => $data,
         );
 
         echo json_encode($data_data);
     }

    


    

   

}
