<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_irt extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        
		
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
    



    function hitung_irt(){

          $soal = $this->db->query('select * from soalonline where materi_id = 217')->result();

          $jawaban = $this->db->query('select * from jawaban where mode="1" and materi_id = 217')->result();


        


         foreach($jawaban as $j){


              //error_reporting(0);

              $a = $this->objToArray(json_decode($j->jawaban));

                 // echo "<pre>";
                 // print_r($a);
                 // die;


              foreach($a as $key => $hasil_jawaban){

                $soal_materi = $this->db->query('select * from soalonline where materi_id = 217')->result();

              

                     foreach($soal_materi as  $key){
                        $key1[] = $key;
                    }

                 



              }

                 // echo "<pre>";
                 // print_r($soal_materi);


              foreach($key1 as $key){

                         
                          if($key->id==$a['ans_'.$key->id]['soal']){
                
                        //hitung benar
                        if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                            $data_array_jawaban[$key->id] = array(
                                'soal_id'=>$key->id,
                                'hasil_pilihan'=>1,
                            );







                            //  echo "benar";
                        }elseif($a['ans_'.$key->id]['jawaban']!=$key->jawaban){
                                //ga di isi 
                                 $data_array_jawaban[$key->id] = array(
                                'soal_id'=>$key->id,
                                'hasil_pilihan'=>0,
                            );
                            //  echo "ga disi";
                        }
            
                    }else{
                        echo "gagal";
                    }



              }



              $data_jawaban[] = array(
                'email'=>$j->email,
                'skor'=>$j->skor,
                'benar'=>$j->benar,
                'id_jawaban'=>$j->id_jawaban,
                //'jawaban'=>$a,
                'data_array_jawaban'=>$data_array_jawaban,
              );
           
         }

          //  echo "<pre>";
          // print_r($data_jawaban);
          // die;



        // mencari rata" persoal




          $soal_materi2 = $this->db->query('select * from soalonline where materi_id = 217')->result();

                     foreach($soal_materi2 as  $key){
                        $key12[] = $key;
          }



          foreach($key12 as $k){


                    $hitung = 0;
                   foreach($data_jawaban as $j){

                    // echo "<pre>";
                    // print_r($j['data_array_jawaban'][$k->id]);
                    

            // echo "<pre>";
            // print_r($k->id);
            // die;
                      if($j['data_array_jawaban'][$k->id]['soal_id']==$k->id){




                              $hitung +=  $j['data_array_jawaban'][$k->id]['hasil_pilihan'];

                            $data_array_rata_rata[$k->id] = array(
                                'soal_id'=>$k->id,
                                'jumlah'=>$hitung,
                            );
                      }

                    // echo "<pre>";
                    // print_r($j['data_array_jawaban']['3078']);
                 }

          }



         $data = array(
            'jumlah_soal'=>count($soal),
            'jumlah_peserta'=>count($jawaban),
            'data_array_rata_rata'=>$data_array_rata_rata,
            'data_'=>$data_jawaban,
         );

         echo json_encode($data);
    }
}


?>