<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Irt_tarik extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
		if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Event_M','Materi_M','Jenis_M','Kategori_M','Irt_tarik_M'));
		
    }


     // redirect if needed, otherwise display the user list
     public function index()
     {
       
         $data["title"] = "List Data Master Event";
         $this->template->load('template','irt_tarik/irt_tarik_v',$data);
      
     }


     public function ajax_list()
     {
 
 
        
 
 
         header('Content-Type: application/json');
         $list = $this->Event_M->get_datatables();
         $data = array();
         $no = $this->input->post('start');
         //looping data mahasiswa
         foreach ($list as $data_Event) {
 
 
            
             if($data_Event->mode=='event'){
                 $mode_model = 1;
             }elseif($data_Event->mode=='latihan'){
                 $mode_model = 2;
             }
            
             $total_peserta = $this->db->query("select email from jawaban where mode ='".$mode_model."' and id_event = '".$data_Event->id_event."'  group by email")->result();
             $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Irt_tarik/detail/'.base64_encode($data_Event->id_event).'/'.count($total_peserta))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
            

             $no++;
             $row = array();
             $row[] = $no;
             $row[] = $data_Event->judul;
             $row[] = $data_Event->kategori_nama;
 
             
             $row[] = date('d-m-Y',strtotime($data_Event->tgl_mulai));
             $row[] = date('d-m-Y',strtotime($data_Event->tgl_selesai));
             $row[] = $data_Event->desc;
           
             $row[] = count($total_peserta);
             $row[] = $data_Event->mode;
             $sess = $this->session->userdata();
             if($sess['pegawai']->role==1){
                 $row[] = $edit;
             }else{
                 $row[] = "";
             }
           
 
             $data[] = $row;
         }
         $output = array(
             "draw" => $this->input->post('draw'),
             "recordsTotal" => $this->Event_M->count_all(),
             "recordsFiltered" => $this->Event_M->count_filtered(),
             "data" => $data,
         );
         //output to json format
         $this->output->set_output(json_encode($output));
     }

     function detail($id_event,$total_peserta){
        $data["title"] = "List Data ";

          
       $data['total_peserta'] = $total_peserta;
        $data['id_event'] = base64_decode($id_event);
        $this->template->load('template','irt_tarik/irt_tarik_detail',$data);
     }

     function ajax_list_skor($id_event){

        error_reporting(0);
        header('Content-Type: application/json');
        $list = $this->Irt_tarik_M->get_datatables($id_event);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa

        //$id_event = 49;
        foreach ($list as $data_irt) {

            $peserta = $this->db->query("select * from peserta where email = '".$data_irt->email."' and id_event = '".$id_event."'" )->row();
             
              
            $count_materi = $this->db->query("select materi_id from materi where id_event = '".$id_event."'" )->result();


           
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $peserta->nama;
            $row[] = $data_irt->email;
            $row[] = $peserta->asal_sekolah;
            $row[] = round($data_irt->skor2/count($count_materi),2);
           
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Irt_tarik_M->count_all($id_event),
            "recordsFiltered" => $this->Irt_tarik_M->count_filtered($id_event),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
     }


     function print($id_event){
        error_reporting(0);
        
  
  
  
  
  
  
           //$sql = $this->db->query("select * from irt where  id_event = '" . $id_event . "' and email != '' group by email")->result();
  
           $sql = $this->db->query("select *,sum(skor) as skor2  from irt where  id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc ")->result();
  
  
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
  
               $jawaban = $this->db->query("select tgl_mulai,create_add from jawaban where email = '".$s->email."' and id_event = '".$id_event."'" )->row();
  
                $count_materi = $this->db->query("select materi_id from materi where id_event = '".$id_event."'" )->result();

                $nama_event = $this->db->query('select judul from event where id_event="'.$id_event.'"')->row();

                
  
                 $waktu_awal        = strtotime($jawaban->tgl_mulai);
                $waktu_akhir    = strtotime($jawaban->create_add); // bisa juga waktu sekarang now()
  
              //menghitung selisih dengan hasil detik
              $diff    = $waktu_akhir - $waktu_awal;
  
  
              //  $skor = 0;
              // foreach($irt as $i){
              //      $skor += round($i->skor,2);
              // }
  
            //   echo "<pre>";
            //   print_r($nama_event);
            //   die;
  
             
  
              $data_api[] = array(
  
                 
                  //'no'=>$no_ranking2++,
                  'nama_judul'=>$nama_event->judul,
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

        //   echo "<pre>";
        //   print_r($data_api);
        //   die;
  
  
        //   if($data_api){
        //         echo json_encode($data_api);
        //     }else{
        //       $data_error = array(
  
        //           'status'=>400,
        //           'message'=>"tidak ditemukan",
  
        //       );
  
        //       echo json_encode($data_error);
  
        //    }

        $data['data_api'] = $data_api;
        //$this->template->load('template','irt_tarik/print_irt_tarik.php',$data);

        $this->load->view('irt_tarik/print_irt_tarik.php',$data);
     }

     function irt_cron($page=null){
        echo $page;
     }


    

  



    
    
}
