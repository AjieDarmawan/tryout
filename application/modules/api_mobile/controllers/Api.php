<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
      // $this->load->model(array('auth/auth_model'));
		
    }

    function absen(){
        

        $id_kar = $this->input->post('id_kar');

        $lat = $this->input->post('lat');
        $lang = $this->input->post('lang');


        $kar  = $this->db->query("select * from m_karyawan where id_karyawan = '".$id_kar."'")->Row();
        $kantor  = $this->db->query("select * from m_kantor where ktr_id = '".$kar->ktr_id."'")->Row();
        $lat_kantor = $kantor->lat;
        $long_kantor = $kantor->long;

        $jadwal  = $this->db->query("select * from jadwal where id_karyawan = '".$id_kar."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();


        // echo "<pre>";
        // print_r($kar);
        // die;

        if($jadwal->jenis_masuk=='WFO'){

            $lat_tujuan = $kantor->lat;
            $long_tujuan = $kantor->long;

        }else if($jadwal->jenis_masuk=='WFH'){

            $lat_tujuan = $kar->lat;
            $long_tujuan = $kar->long;
        }



       // error_reporting(0);


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$lat_tujuan.",".$long_tujuan."&origins=-6.507369,106.843742&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";


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
            //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

            //   return $result;

            $output = json_decode($result);


            // echo "<pre>";
            // print_r($output->rows[0]->elements[0]->distance->value);
            //echo json_encode($output);

            $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

           //echo "<br>";
            
            // echo "<pre>";
            // print_r();
            // die;

            $jarak_orang = $kar->radius;


              $jarak_orang * 1000;
              //40317  >=   500
             if($jarak_skrang <= $jarak_orang){


                $check_absen = $this->db->query("select * from absen where id_karyawan = ".$id_kar." and date(masuk) = '".date('Y-m-d')."'")->row();

                // echo "<pre>";
                // print_r($check_absen);
                // die;

                if($check_absen){

                        // jika dia sif 3 cek pulang kalo ada tambah/insert
                    if($check_absen->pulang){

                        $data_insert = array(
                            'id_karyawan'=>$id_kar,
                            'masuk'=>date('Y-m-d H:i:s'),
                            'pulang'=>'',
                            'alasan'=>'',
                            'ket'=>'',
                        );
        
                        $this->db->insert('absen',$data_insert);

                    }else{

                        $data_insert = array(
                            'id_karyawan'=>$id_kar,
                          //  'masuk'=>date('Y-m-d H:i:s'),
                            'pulang'=>date('Y-m-d H:i:s'),
                            'alasan'=>'',
                            'ket'=>'',
                        );
        
                        $this->db->update('absen',$data_insert, array('id_absen' => $check_absen->id_absen));

                    }

                  

                }else{

                    $data_insert = array(
                        'id_karyawan'=>$id_kar,
                        'masuk'=>date('Y-m-d H:i:s'),
                        'pulang'=>'',
                        'alasan'=>'',
                        'ket'=>'',
                    );
    
                    $this->db->insert('absen',$data_insert);

                }
                

                $data_array = array(
                    'status'=>200,
                    'message'=>"Success",
                 );



                    
             }else{
                   $data_array = array(
                       'status'=>400,
                       'message'=>"Lokasi Kejauhan",
                    );

             }

             echo json_encode($data_array);

    }


    function check_absen(){


        $id_kar = $this->input->post('id_kar');

        $lat = $this->input->post('lat');
        $long = $this->input->post('long');


        $kar  = $this->db->query("select * from m_karyawan where id_karyawan = '".$id_kar."'")->Row();
        $kantor  = $this->db->query("select * from m_kantor where ktr_id = '".$kar->ktr_id."'")->Row();


        $jadwal  = $this->db->query("select * from jadwal where id_karyawan = '".$id_kar."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();


        // echo "<pre>";
        // print_r($kar);
        // die;

        if($jadwal->jenis_masuk=='WFO'){

            $lat_tujuan = $kantor->lat;
            $long_tujuan = $kantor->long;

        }else if($jadwal->jenis_masuk=='WFH' || $jadwal->jenis_masuk=='M'){

            $lat_tujuan = $kar->lat;
            $long_tujuan = $kar->long;
        }

        
       



       // error_reporting(0);


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$lat_tujuan.",".$long_tujuan."&origins=".$lat.",".$long."&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";


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
            //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

            //   return $result;

            $output = json_decode($result);


            // echo "<pre>";
            // print_r($output->rows[0]->elements[0]->distance->value);
           // echo json_encode($output);

            $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

           //echo "<br>";
            
            // echo "<pre>";
            // print_r();
            // die;

            $jarak_orang = $kar->radius;


            $jarak_orang * 1000;
              //40317  >=   500

              $check_absen = $this->db->query("select * from absen where id_karyawan = ".$id_kar." and date(masuk) = '".date('Y-m-d')."'")->row();

              error_reporting(0);

               if($check_absen->masuk){
                    $status_button = "sudah_masuk";
               }elseif($check_absen->pulang){
                    $status_button = "sudah_pulang";
               }else{
                    $status_button = "belum_masuk";
               }


                 $data_json = array(
                  'jenis_masuk'=>$jadwal->jenis_masuk,
                  'tujuan_lat'=>$lat_tujuan,
                  'tujuan_long'=>$long_tujuan,
                  'posisi_lat'=>$lat,
                  'posisi_long'=>$long,
                  'jarak_skrang'=>"".$jarak_skrang."",
                  'status_button'=> $status_button,
                  'radius'=>$kar->radius,
                  'kantor'=>$kantor->kantor_nama
              );

              echo json_encode($data_json);
            

    }


    


    

   

}
