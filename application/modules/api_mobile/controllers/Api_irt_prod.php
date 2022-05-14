<?php

defined('BASEPATH') or exit('No direct script access allowed');


Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_irt_prod extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $sess = $this->session->userdata();

       ini_set('memory_limit', '-1');
    }






    function convertToObject($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
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



    function hitung_irt_testing()
    {

        $materi_id = 370;

        $soal = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();
      //  $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = ' . $materi_id)->result();

           // $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = "'.$materi_id.'" and email not in ("ari.einton@gmail.com","arisaldi@edunovasi.com","traffandy@edunovasi.com","traffandy@gmail.com","gilangalqadar@gmail.com") limit 100')->result();


$jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = "'.$materi_id.'" and email not in ("ari.einton@gmail.com","arisaldi@edunovasi.com","traffandy@edunovasi.com","traffandy@gmail.com","gilangalqadar@gmail.com","") limit 100')->result();




        foreach ($jawaban as $j) {


            //error_reporting(0);

            $a = $this->objToArray(json_decode($j->jawaban));

            // echo "<pre>";
            // print_r($a);
            // die;


            foreach ($a as $key => $hasil_jawaban) {

                $soal_materi = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();



                foreach ($soal_materi as  $key) {
                    $key1[] = $key;
                }
            }

            // echo "<pre>";
            // print_r($soal_materi);


            foreach ($key1 as $key) {


                if ($key->id == $a['ans_' . $key->id]['soal']) {

                    //hitung benar
                    if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                        $data_array_jawaban[$key->id] = array(
                            'soal_id' => $key->id,
                            'hasil_pilihan' => 1,
                        );







                        //  echo "salah";
                    } elseif ($a['ans_' . $key->id]['jawaban'] != $key->jawaban) {
                            

                            if($a['ans_' . $key->id]['jawaban'] ==0){

                                $data_array_jawaban[$key->id] = array(
                                    'soal_id' => $key->id,
                                    'hasil_pilihan' => 0,
                                );

                            }else{
                                $data_array_jawaban[$key->id] = array(
                                    'soal_id' => $key->id,
                                    'hasil_pilihan' => 2,
                                );
                            }

                    }










                } else {
                    echo "gagal";
                }
            }



            $data_jawaban[] = array(
                'email' => $j->email,
                'skor' => $j->skor,
                'benar' => $j->benar,
                'salah' => $j->salah,
                'kosong' => $j->kosong,
                'id_jawaban' => $j->id_jawaban,
                //'jawaban'=>$a,
                'data_array_jawaban' => $data_array_jawaban,
                'waktu'=>$j->create_add,
            );
        }

        //  echo "<pre>";
        // print_r($data_jawaban);
        // die;



        // mencari rata" persoal




        $soal_materi2 = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();

        foreach ($soal_materi2 as  $key) {
            $key12[] = $key;
        }



        foreach ($key12 as $k) {


            $hitung = 0;
            foreach ($data_jawaban as $j) {

                // echo "<pre>";
                // print_r($j['data_array_jawaban'][$k->id]);


                // echo "<pre>";
                // print_r($k->id);
                // die;
                if ($j['data_array_jawaban'][$k->id]['soal_id'] == $k->id) {




                    $hitung +=  $j['data_array_jawaban'][$k->id]['hasil_pilihan'];

                    $data_array_rata_rata[$k->id] = array(
                        'soal_id' => $k->id,
                        'jumlah' => $hitung,
                    );
                }

                // echo "<pre>";
                // print_r($j['data_array_jawaban']['3078']);
            }
        }



        $data = array(
            'jumlah_soal' => count($soal),
            'jumlah_peserta' => count($jawaban),
            'data_array_rata_rata' => $data_array_rata_rata,
            'data_' => $data_jawaban,
        );

        echo json_encode($data);

        //return $data;

    }




    function hitung_irt($materi_id)
    {

        //$materi_id = 217;

        error_reporting(0);

        $soal = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();
       $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = "'.$materi_id.'" and id_event = "49" limit 50 OFFSET 500 ')->result();



        foreach ($jawaban as $j) {


            //error_reporting(0);

            $a = $this->objToArray(json_decode($j->jawaban));

            // echo "<pre>";
            // print_r($a);
            // die;


            foreach ($a as $key => $hasil_jawaban) {

                $soal_materi = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();



                foreach ($soal_materi as  $key) {
                    $key1[] = $key;
                }
            }

            // echo "<pre>";
            // print_r($soal_materi);


            foreach ($key1 as $key) {


                if ($key->id == $a['ans_' . $key->id]['soal']) {

                    //hitung benar
                    if ($key->jawaban == $a['ans_' . $key->id]['jawaban']) {
                        $data_array_jawaban[$key->id] = array(
                            'soal_id' => $key->id,
                            'hasil_pilihan' => 1,
                        );







                        //  echo "benar";
                      } elseif ($a['ans_' . $key->id]['jawaban'] != $key->jawaban) {
                            

                            if($a['ans_' . $key->id]['jawaban'] ==0){

                                $data_array_jawaban[$key->id] = array(
                                    'soal_id' => $key->id,
                                    'hasil_pilihan' => 0,
                                );

                            }else{
                                $data_array_jawaban[$key->id] = array(
                                    'soal_id' => $key->id,
                                    'hasil_pilihan' => 2,
                                );
                            }

                    }
                } else {
                    echo "gagal";
                }
            }



            $data_jawaban[] = array(
                'email' => $j->email,
                'skor' => $j->skor,
                'benar' => $j->benar,
                'id_jawaban' => $j->id_jawaban,
                //'jawaban'=>$a,
                'data_array_jawaban' => $data_array_jawaban,
                 'waktu'=>$j->create_add,
            );
        }

        //  echo "<pre>";
        // print_r($data_jawaban);
        // die;



        // mencari rata" persoal




        $soal_materi2 = $this->db->query('select * from soalonline where materi_id = ' . $materi_id)->result();

        foreach ($soal_materi2 as  $key) {
            $key12[] = $key;
        }



        foreach ($key12 as $k) {


            $hitung = 0;
            foreach ($data_jawaban as $j) {

                // echo "<pre>";
                // print_r($j['data_array_jawaban'][$k->id]);


                // echo "<pre>";
                // print_r($k->id);
                // die;
                if ($j['data_array_jawaban'][$k->id]['soal_id'] == $k->id) {




                    $hitung +=  $j['data_array_jawaban'][$k->id]['hasil_pilihan'];

                    $data_array_rata_rata[$k->id] = array(
                        'soal_id' => $k->id,
                        'jumlah' => $hitung,
                    );
                }

                // echo "<pre>";
                // print_r($j['data_array_jawaban']['3078']);
            }
        }



        $data = array(
            'jumlah_soal' => count($soal),
            'jumlah_peserta' => count($jawaban),
            'data_array_rata_rata' => $data_array_rata_rata,
            'data_' => $data_jawaban,
        );

        //echo json_encode($data);

        return $data;
    }




    public function irt($materi_id)
    {


        // Function to calculate square of value - mean
        // function sd_square($x, $mean) { return pow($x - $mean,2); }
        // // Function to calculate standard deviation (uses sd_square)    
        // function sd($array) {

        //     // echo "<pre>";
        //     // print_r($array);
        //     // die;
        //     // square root of sum of squares devided by N-1
        //     return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
        // }

        // echo "tes";
        // die;

        //  $materi_id = 217;

        $materi = $this->db->query('select * from materi where materi_id=' . $materi_id)->row();


        $irt_hasil =  $this->hitung_irt($materi_id);



        // $data['irt'] = $this->convertToObject($irt_hasil);

        // $data['materi_id'] = $materi_id;
        // $data['materi_nama'] = $materi->materi_nama;
        // $this->load->view('hasil_irt/irt',$data);







        // echo "<pre>";
        // print_r($irt->data_->{0});
        // die;



        $irt = $this->convertToObject($irt_hasil);

        $materi_id = $materi_id;
        $materi_nama = $materi->materi_nama;



          foreach ($irt->data_ as $d) {

                foreach ($d->data_array_jawaban as $j) {


                    //    echo "<pre>";
                    //    print_r($j);

                        if ($j->hasil_pilihan == 1) {
                           
                            $hasil_benar[$d->email][]  = $j->hasil_pilihan;
                        }

                        else if ($j->hasil_pilihan == 2) {
                           
                            $hasil_salah[$d->email][]  = $j->hasil_pilihan;
                        }
                        
                        
                        else if ($j->hasil_pilihan == 0) {
                          
                            $hasil_kosong[$d->email][]  = $j->hasil_pilihan;
                        }
                    ?>


                  

                    <?php
                    }
            ?>

               

            <?php
                     error_reporting(0);
                        $data_desc[] = array(
                            'email'=>$d->email,
                            'waktu'=>$d->waktu,
                            'skor_benar'=>     count($hasil_benar[$d->email]),
                            'skor_salah'=>   count($hasil_salah[$d->email]),
                            'skor_kosong'=>    count($hasil_kosong[$d->email]),
                           'jawaban'=> $d->data_array_jawaban,
                            
                        );

     
                      
            }

           $data_hasil =  sortAssociativeArrayByKey($data_desc, 'skor_benar', 'DESC');
        $total_peserta = count($data_hasil);
        $kelompok_atas = floor(0.27 * $total_peserta);
        
         $kelompok_bawah = floor(0.27 * $total_peserta);
        
        $kelompok_tengah = $total_peserta - $kelompok_atas - $kelompok_bawah;

        




         //array perkelompok;
                $a_benar = array();
                $a_salah =  array();
                $b_benar =  array();
                $b_salah =  array();
                $a_ga_salah = array();
                $b_ga_salah =  array();
                $tot_ga_salah =  array();
              foreach($data_hasil as $d_no =>$key){
                  //kelompok atas

                  if($d_no < $kelompok_atas){
                      $data_k_atas[] = $key;

                     foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                                if($soal->hasil_pilihan==1){
                                    $a_benar[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $a_benar[$id_soal]['total'] += 1;

                                }

              
                                $a_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                $a_ga_salah[$id_soal]['total'] += 1;
                       
                                $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                $tot_ga_salah[$id_soal]['total'] += 1;
                       
                            
                        }
                        
                       elseif($soal->hasil_pilihan==2){

                            $a_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                            $a_salah[$id_soal]['total'] += 1;


                        }

                        

                       


                     }


                  }


                  else if($d_no >= $kelompok_atas+$kelompok_tengah){
                     $data_k_bawah[] = $key;


                     foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                                if($soal->hasil_pilihan==1){
                                    $b_benar[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $b_benar[$id_soal]['total'] += 1;

                                }
                                    $b_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $b_ga_salah[$id_soal]['total'] += 1;


                                    $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $tot_ga_salah[$id_soal]['total'] += 1;
                           
                            
                        }
                        
                       elseif($soal->hasil_pilihan==2){

                            $b_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                            $b_salah[$id_soal]['total'] += 1;


                        }

                
                     }




                  }

                  else{
                    $data_k_tengah[] = $key;


                    foreach($key['jawaban'] as $id_soal=>$soal){
                        if($soal->hasil_pilihan!=2){
                              

                                    $tot_ga_salah[$id_soal][$key['email']] = $soal->hasil_pilihan;
                                    $tot_ga_salah[$id_soal]['total'] += 1;
                           
                            
                        }
                        
                       

                
                     }


                    

                  }

                
                 // die;


                  foreach($key['jawaban'] as $id_soal=>$soal){

                    if($a_salah[$id_soal]['total']){
                        $a_salah_tot = $a_salah[$id_soal]['total'];
                    }else{
                        $a_salah_tot = 0;
                    }


                    if($a_ga_salah[$id_soal]['total']){
                        $a_ga_salah_tot = $a_ga_salah[$id_soal]['total'];
                    }else{
                        $a_ga_salah_tot = 0;
                    }


                    if($b_salah[$id_soal]['total']){
                        $b_salah_tot = $b_salah[$id_soal]['total'];
                    }else{
                        $b_salah_tot = 0;
                    }

                    if($b_ga_salah[$id_soal]['total']){
                        $b_ga_salah_tot = $b_ga_salah[$id_soal]['total'];
                    }else{
                        $b_ga_salah_tot = 0;
                    }


                    if($tot_ga_salah[$id_soal]['total']){
                        $tot_ga_salah_tot = $tot_ga_salah[$id_soal]['total'];
                    }else{
                        $tot_ga_salah_tot = 0;
                    }





                   


                        //tingsul Tingkat kesulitan = (asalah+bsalah)/(agasalah+bgasalah) 
                    $tingsul[$id_soal] = ($a_salah_tot +  $b_salah_tot)/($kelompok_atas +  $kelompok_bawah);

                   
                   
                    //tingsulmax Tingkat kesulitan max = (agasalah+bgasalah)/(agasalah+bgasalah)
                   // $tingsul_max[$id_soal] = ($a_ga_salah_tot +  $b_ga_salah_tot)/($a_ga_salah_tot +  $b_ga_salah_tot);
                   $tingsul_max[$id_soal] = 1;  

                    //ptingsul Point tingkat kesulitan = (tingsul / tingsulmax) * 100
                    $ptingsul[$id_soal] = ($tingsul[$id_soal] / $tingsul_max[$id_soal]) * 100;



                        //dayabeda Daya Beda = (bsalah-asalah)/totgasalah
                        // $dayabeda[$id_soal] = ($b_salah_tot -  $a_salah_tot)/$tot_ga_salah_tot;
                        $dayabeda[$id_soal] = ($b_salah_tot -  $a_salah_tot)/($kelompok_atas +  $kelompok_bawah);


                      
                        // dayabedamax = agasalah/totgasalah
                       // $dayabedamax[$id_soal] = $a_ga_salah_tot/$tot_ga_salah_tot;
                       $dayabedamax[$id_soal] = $kelompok_bawah/($kelompok_atas +  $kelompok_bawah);


                        // pdayabeda point dayabeda = dayabeda/(2*dayabedamax)*100
                        $pdayabeda[$id_soal] = $dayabeda[$id_soal]/(2*$dayabedamax[$id_soal])*100;





                        //Bobot soal = (ptingsul+pdayabeda)/2

                        $bobotsoal[$id_soal] = array('id_soal'=>$id_soal,
                    'bobot'=>($ptingsul[$id_soal]+$pdayabeda[$id_soal])/2);


                  }





              }



              $rata_rata = 0;
              foreach ($data_hasil as $d) {
                         $hitung_skor_kali = 0;
                    foreach ($d['jawaban'] as $j) {

                        // echo "<pre>";
                        // print_r($j);


                        if ($d['jawaban']->{$j->soal_id}->soal_id == $j->soal_id) {

                            if ($j->hasil_pilihan == 1) {


                               $hitung_skor_kali += $bobotsoal[$j->soal_id]['bobot'] * 1;

                               //echo $bobotsoal[$j->soal_id]['bobot'],'<br>';
                            }
                        }

                   

                       


                        
                    }

                    $rata_rata += $hitung_skor_kali;

                      
                    $arr[] = $hitung_skor_kali;  

                  }



                  // echo "<pre>";
                  // print_r($arr);
                  // die;






                   
            
        

          


           



        $rata_rata / $total_peserta;
        sd($arr);


        // echo "<pre>";
        // print_r($data_hasil);
        // die;

        foreach ($arr as $key => $a) {
            $z_score = ($a - ($rata_rata / $total_peserta)) / sd($arr);


           // $z_score; 500 + (100 * $z_score);;
            $hasil_ =  round(500 + (200 * $z_score),2); ?>

                        <?php 
                            if($hasil_ > 1000){
                                $hasil_akhir2 =  1000;
                            }elseif($hasil_ < 0){
                                $hasil_akhir2 = 0;
                            }
                            else{
                                $hasil_akhir2 =  $hasil_;
                            }
                      

           $z_score_hasil[$data_hasil[$key]['email']] =  $hasil_akhir2;

         //    $z_score_hasil[] =  1;
        }



        $datajson = array(
            'materi_id' => $materi_id,
            'materi_nama' => $materi_nama,
            'data' => $z_score_hasil,
        );
        //echo json_encode($data_json);


        return $datajson;
        // echo "<pre>";
        // print_r($z_score_hasil);





    }


    function irt_event($id_event)
    {

     //   $id_event = 29;

       //$id_event = 46;






        $event = $this->db->query('select * from materi where id_event=' . $id_event)->result();

        //   echo "<pre>";
        //   print_r($event);  
        // die;

        foreach ($event as $e) {
            $data_json[] = $this->irt($e->materi_id);
        }


        //     echo "<pre>";
        //   print_r($data_json);  
        // die;



        foreach($data_json as $key => $j){

                foreach($j['data'] as $email => $skor){

                    if($skor=='NAN'){
                        $skor2 = 0;
                    }else{
                        $skor2 = $skor;
                    }

                    $event = $this->db->query('select * from materi where materi_id='.$j['materi_id'])->row();

                    // echo "<pre>";
                    // print_r($event);
                    // die;

                    if($event->id_event){
                        $id_event2 = $event->id_event;
                    }else{
                        $id_event2 = 0;
                    }

                      $data_simpan = array(

                            'create_add'=>date('Y-m-d H:i:s'),
                            'materi_id'=>$j['materi_id'],
                            'id_event'=>$id_event2,
                            'email'=>$email,
                           
                             'skor'=>(string)$skor2,
                        );

                      $cek = $this->db->query('select * from irt where email="'.$email.'" and materi_id = "'.$j['materi_id'].'"')->row();


                      if($cek){
                        //update
                                $this->db->where('email',$email);
                                $this->db->where('materi_id',$j['materi_id']);

                        $q  =  $this->db->update('irt',$data_simpan);
                      }else{
                        //insert
                        $q  =  $this->db->insert('irt',$data_simpan);
                      }

                      

                }

          

       
        }



        if($q){
              $data_api['status'] = 200;
              $data_api['message'] = "sukses";

            

        }else{
            $data_api['status'] = 400;
              $data_api['message'] = "gagal";
        }

        return $data_api;

        //echo json_encode($data_api);


        // echo "<pre>";
        // print_r($data_simpan);
        // die;

       // $users = $data_json[0]['data'];



        // foreach ($users as $key => $u) {
        //     // echo "<pre>";
        //     // print_r($key);

        //     $skor = 0;
        //     foreach ($data_json as $key2 => $j) {

        //         // echo "<pre>";
        //         // print_r($j['data'][$key]);

        //         $data_akhir[$key] =  $skor += $j['data'][$key];
        //     }
        // }


        //skor per email


        // echo "<pre>";
        // print_r($data_akhir['ahmadreki31@gmail.com']);

       // echo json_encode($data_akhir);   




         //skor per materi
         //echo json_encode($data_json);
    }


    function kirim_irt_skor(){
        //   $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        // inner JOIN kategori as j on e.id_kategori=j.id_kategori
        //         where  e.mode='event'")->result();


        // $hariini = date('Y-m-d');


        //  foreach($sql as $key => $s){
        //      if ($hariini >= $s->tgl_mulai) {

        //         //jika hari ini kurang dari tgl selesai
        //         if ($s->tgl_selesai >= $hariini) {

        //            $q = $this->irt_event($s->id_event);


        //         }

        //      }
        //  }


          $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event' and id_event in  (48,49)")->result();


        $hariini = date('Y-m-d');


         foreach($sql as $key => $s){
            

                   $q = $this->irt_event($s->id_event);


               
         }




          if($q){
              $data_api['status'] = 200;
              $data_api['message'] = "sukses";
              $data_api['page'] = "1";

            

        }else{
            $data_api['status'] = 400;
              $data_api['message'] = "gagal";
        }

        echo json_encode($data_api);
    }






  function kirim_irt_modif(){
        //   $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        // inner JOIN kategori as j on e.id_kategori=j.id_kategori
        //         where  e.mode='event' and id_event = 48 ")->result();

           $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event' and id_event = 29 ")->result();


        $hariini = date('Y-m-d');


         foreach($sql as $key => $s){

            $q = $this->irt_event($s->id_event);
           
         }


          if($q){
              $data_api['status'] = 200;
              $data_api['message'] = "sukses";

            

        }else{
            $data_api['status'] = 400;
              $data_api['message'] = "gagal";
        }

        echo json_encode($data_api);
    }








    function hasil_skor_irt(){
        error_reporting(0);
        $email = $this->input->post('email');
        $id_event = $this->input->post('id_event');

      
       







        $sql = $this->db->query("select e.id_kategori,e.judul,i.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        
        inner join irt as i on i.id_event = e.id_event 
        
        inner join materi as m on i.materi_id = m.materi_id 

        where i.email = '".$email."' and m.publish = 1 and i.id_event = '" . $id_event . "' order by m.no_urut asc")->result();



        foreach ($sql as $s) {



            $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();


          //  $irt = $this->db->query("select * from irt where id_event = '".$s->id_event."' and email = '".$email."'")->row();

            





            $data_api[$jenis->jenis_nama][] = array(

                "materi_id" => base64_encode($s->materi_id),
                 "materi_id2" => $s->materi_id,
                "materi_nama" => $s->materi_nama,
                "id_jurusan" => $s->id_jurusan,
                "waktu" => $s->waktu,
                "jurusan" => $jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,

                'jumlah_soal' => count($soal),
                'skor'=>round($s->skor,2),
                'email'=>$s->email,


            );
        }


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach ($data_api as $d) {
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }




        $data_api_api = array(

            "id_event" => $sql[0]->id_event,
            "judul" => $sql[0]->judul,
             'kategori'=>$kategori->kategori_nama,
           


          
            "data" => $data_api
        );

        echo json_encode($data_api_api);



    
    }

    function list_hasil_rangking(){
         error_reporting(0);
      //  $email = $this->input->post('email');
        $id_event = $this->input->post('id_event');







         //$sql = $this->db->query("select * from irt where  id_event = '" . $id_event . "' and email != '' group by email")->result();

         $sql = $this->db->query("select *,sum(skor) as skor2  from irt where  id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc limit 30")->result();


         // echo "<pre>";
         // print_r($sql);
         // die;


        $skor = 0;
       // $no_ranking2 = 0;
        foreach ($sql as $s) {



             // $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();

            // $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            // $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

           // $irt = $this->db->query("select * from irt where email = '".$s->email."' and id_event = '".$id_event."'")->result();

             $peserta = $this->db->query("select * from peserta where email = '".$s->email."' and id_event = '".$id_event."'" )->row();

             $jawaban = $this->db->query("select * from jawaban where email = '".$s->email."' and id_event = '".$id_event."'" )->row();

              $count_materi = $this->db->query("select * from materi where id_event = '".$id_event."'" )->result();


               $waktu_awal        = strtotime($jawaban->tgl_mulai);
              $waktu_akhir    = strtotime($jawaban->create_add); // bisa juga waktu sekarang now()

            //menghitung selisih dengan hasil detik
            $diff    = $waktu_akhir - $waktu_awal;


            //  $skor = 0;
            // foreach($irt as $i){
            //      $skor += round($i->skor,2);
            // }

            // echo "<pre>";
            // print_r($skor);
            // die;

           

            $data_api[] = array(

               
                //'no'=>$no_ranking2++,
                'nama'=>$peserta->nama,
                'email'=>$s->email,
                'skor'=>round($s->skor2/count($count_materi),2),
                 'skor2'=>$s->skor2,
                'id_peserta'=>$peserta->id_peserta,
                'asal_sekolah'=>$peserta->asal_sekolah,
                'waktu' => floor($diff / 60),
                 'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($jawaban->tgl_mulai))) . ' ' . date('H:i:s', strtotime($jawaban->tgl_mulai)),

                 // 'waktu_pengerjaan' => $jawaban->tgl_mulai,

                 // 'waktu_pengerjaan' => TanggalIndo(date('Y-m-d', strtotime($peserta->create_add))) . ' ' . date('H:i:s', strtotime($peserta->create_add)),
                

            );
        }


        if($data_api){
              echo json_encode($data_api);
          }else{
            $data_error = array(

                'status'=>400,
                'message'=>"tidak ditemukan",

            );

            echo json_encode($data_error);

         }

      
    }


     function check_posisi_rangking(){
         error_reporting(0);
        $email = $this->input->post('email');
        $id_event = $this->input->post('id_event');







        $sql = $this->db->query("select *,sum(skor) as skor2  from irt where  id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc ")->result();


       //   echo "<pre>";
       // print_r($sql);
       // die;


       $count_materi = $this->db->query("select * from materi where id_event = '".$id_event."'" )->result();
        $count_peserta = $this->db->query("select email from jawaban where id_event = '".$id_event."' and mode = 1  group by email" )->result();
       // $no_ranking2 = 0;
        foreach ($sql  as $key => $s) {





             if($s->email==$email){
                $posisi_rangking = array(
                    'posisi'=>$key+1,
                     'skor'=>round($s->skor2/count($count_materi),2),
                    'skor2'=>round($s->skor2,2),
                     'totalpeserta'=> count($count_peserta),
                );
            }

           

           
        }




       

        echo json_encode($posisi_rangking);
    }
}
