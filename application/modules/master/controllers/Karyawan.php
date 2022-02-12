<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
        $this->load->model(array('Karyawan_M','Divisi_M','Jabatan_M','Kantor_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
        

        //$data["Karyawan"] = $this->Karyawan_M->getAll();
        $data["title"] = "List Data Master Karyawan";
        $this->template->load('template','karyawan/karyawan_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Karyawan_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Karyawan) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Karyawan/update/'.base64_encode($data_Karyawan->ktr_id))."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			 $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Karyawan->ktr_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Karyawan->nik_ktp;
            $row[] = $data_Karyawan->nik_kantor;
            $row[] = $data_Karyawan->nama_karyawan;
            $row[] = $data_Karyawan->tempat_lahir;
            $row[] = $data_Karyawan->tanggal_lahir;

            $row[] = $data_Karyawan->jenis_kelamin;
            
            $row[] = $data_Karyawan->agama;

            $row[] = $data_Karyawan->status_perkawinan;
            
            $row[] = $data_Karyawan->no_wa;
            $row[] = $data_Karyawan->pendidikan;
            $row[] = $data_Karyawan->sekolah_terakhir;
            $row[] = $data_Karyawan->tahun_masuk;
            $row[] = $data_Karyawan->tahun_keluar;
            $row[] = $data_Karyawan->nilai;


            $row[] = $data_Karyawan->nama_keluarga;
            $row[] = $data_Karyawan->hubungan_keluarga;
            $row[] = $data_Karyawan->no_hp_keluarga;
      


           
            $row[] = $data_Karyawan->tanggal_join;
           	$row[] = $edit." ".$delete;

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Karyawan_M->count_all(),
            "recordsFiltered" => $this->Karyawan_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah(){
          //$data["Karyawan"] = $this->Karyawan_M->getAll();
          $data["title"] = "List Data Master Karyawan";
          $data["divisi"] = $this->Divisi_M->getAll();
          $data["kantor"] = $this->Kantor_M->getAll();


          $data["jabatan"] = $this->Jabatan_M->getAll();
          $this->template->load('template','karyawan/karyawan_tambah',$data);
    }

    function simpan(){
        $nik_kantor =  $this->input->post('nik_kantor');
        $nik_ktp =  $this->input->post('nik_ktp');
        $nama_karyawan =  $this->input->post('nama_karyawan');
        $ktr_id =  $this->input->post('ktr_id');
        $div_id =  $this->input->post('div_id');
        $jbt_id =  $this->input->post('jbt_id');
        $no_wa = $this->input->post('no_wa');
        $no_hp = $this->input->post('no_hp');
        $alamat = $this->input->post('alamat');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $status_perkawinan = $this->input->post('status_perkawinan');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $agama = $this->input->post('agama');
        $pendidikan = $this->input->post('pendidikan');
        $sekolah_terakhir = $this->input->post('sekolah_terakhir');




        $tahun_masuk = $this->input->post('tahun_masuk');
        $tahun_keluar = $this->input->post('tahun_keluar');
        $jurusan = $this->input->post('jurusan');
        $nilai = $this->input->post('nilai');
        $email = $this->input->post('email');
        $nama_keluarga = $this->input->post('nama_keluarga');
        $hubungan_keluarga = $this->input->post('hubungan_keluarga');
        $no_hp_keluarga = $this->input->post('no_hp_keluarga');
        $tanggal_join = $this->input->post('tanggal_join');
        $no_kk = $this->input->post('no_kk');
        $no_npwp = $this->input->post('no_npwp');
       

        $data = array(
        'nik_kantor' =>  $nik_kantor,
        'nik_ktp' =>  $nik_ktp,
        'nama_karyawan' =>  $nama_karyawan,
        'ktr_id' =>  $ktr_id,
        'div_id' =>  $div_id,
        'jbt_id' =>  $jbt_id,
        'no_wa' => $no_wa,
        'no_hp' => $no_hp,
        'alamat' => $alamat,
        'tempat_lahir' => $tempat_lahir,
        'tanggal_lahir' => date('Y-m-d',strtotime($tanggal_lahir)),
        'status_perkawinan' => $status_perkawinan,
        'jenis_kelamin' => $jenis_kelamin,
        'agama' => $agama,
        'pendidikan' => $pendidikan,
        'sekolah_terakhir' => $sekolah_terakhir,




        'tahun_masuk' => $tahun_masuk,
        'tahun_keluar' => $tahun_keluar,
        'jurusan' => $jurusan,
        'nilai' => $nilai,
        'email' => $email,
        'nama_keluarga' => $nama_keluarga,
        'hubungan_keluarga' => $hubungan_keluarga,
        'no_hp_keluarga' => $no_hp_keluarga,
        'tanggal_join' => $tanggal_join,
        'no_kk' => $no_kk,
        'no_npwp' => $no_npwp,
        );

        // echo "<pre>";
        // print_r($data);
        // die;

        //$simpan = $this->db->insert('m_karyawan', $data);
        $simpan = $this->Karyawan_M->save($data);

        if($simpan){

        //     echo "sukses";
        //       echo "<pre>";
        // print_r($data);
        // die;



           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
            
            redirect('master/Karyawan/');
        
        }else{

        }
    }

    function update($id){
         

        $data['Karyawan'] = $this->Karyawan_M->getById(base64_decode($id));

       

        $data["title"] = "List Data Master Karyawan";
        $this->template->load('template','Karyawan/Karyawan_edit',$data);
    }

    function update_simpan(){

        $ktr_id =  $this->input->post('ktr_id');


        $Karyawan_nama =  $this->input->post('Karyawan_nama');

        $kode_Karyawan =  $this->input->post('kode_Karyawan');

        $koordinator =  $this->input->post('koordinator');
        $lat =  $this->input->post('lat');
        $long =  $this->input->post('long');


        $data = array(
            'ktr_nm' =>$Karyawan_nama,
            'ktr_kd' =>$kode_Karyawan,
            'ktr_koordinator'=>$koordinator,
            'ktr_lat' =>$lat,
            'ktr_long' =>$long,
            'ktr_aktif' => 'A',
        );


        $simpan = $this->Karyawan_M->update($ktr_id,$data);

        if($simpan){
           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Karyawan/');
        
        }else{

        }


    }

    function hapus(){
        $ktr_id = $this->input->post('id');

		$this->db->where('ktr_id',$ktr_id);
		$sql = $this->db->delete('ktr_master');
		if($sql){
			$datas= array(
				'status' =>true,
			);
		}else{
			$datas= array(
				'status' =>false,
			);
		}

		echo json_encode($datas);
    }


    
    
}
