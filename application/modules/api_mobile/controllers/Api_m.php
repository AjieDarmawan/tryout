<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_m extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        
		
    }


    // untuk merubah tag lebih kecil dan besar jadi fontawesome antisipasi error di pilihan
function ubahtag($str)
{
    $str = str_replace("<", "<i class='fas fa-chevron-left mx-2'></i>", $str);
    $str = str_replace(">", "<i class='fas fa-chevron-right mx-2'></i>", $str);
    return $str;
}


// untuk merubah tag lebih kecil dan besar jadi kode html, terutama untuk pdf, gunakan sblm ubahkotak
function ubahkecilgede($str)
{
    $str = str_replace("<br>", "ngenter", $str);
    $str = str_replace("<", "&lt;", $str);
    $str = str_replace(">", "&gt;", $str);
    $str = str_replace("ngenter", "<br>", $str);
    return $str;
}


// untuk merubah tag kotak cutom jadi tag html, gunakan setelah ubahkecilgede
function ubahkotak($str)
{   




    $str = str_replace("[b]", "<b>", $str);
    $str = str_replace("[/b]", "</b>", $str);
    $str = str_replace("[i]", "<i>", $str);
    $str = str_replace("[/i]", "</i>", $str);
    $str = str_replace("[u]", "<u>", $str);
    $str = str_replace("[/u]", "</u>", $str);
    $str = str_replace("[sup]", "<sup>", $str);
    $str = str_replace("[/sup]", "</sup>", $str);
    $str = str_replace("[sub]", "<sub>", $str);
    $str = str_replace("[/sub]", "</sub>", $str);

    return $str;

    //die;


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


    // function login()
    // {
    //     error_reporting(0);
    //     $email   = $this->input->post('email');
    //     $mypassword = $this->input->post('password');
    //     $users = $this->db->query('select * from edu_apps.app_userdata where email  = "' . $email . '"')->row();

    //     $info = $this->db->query('select * from edu_apps.edu_userinfo where email  = "' . $email . '"')->row();


    //     // echo "<pre>";
    //     // print_r($info);
    //     // die;




    //     if ($users) {

    //         $dbpassword = $users->password;

    //         $password = sha1(md5($mypassword));


    //         if ($dbpassword == $password) {
    //             if ($users->userstatus == 1) {
    //                 $data['status'] = 200;
    //                 $data['message'] = "success";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //                 $data['nama'] = $info->namalengkap;
    //                 $data['no_wa'] = $info->nowa;
    //                 $data['no_tlp'] = $info->notlp;
    //             } else if ($users->userstatus == 2) {
    //                 $data['status'] = 300;
    //                 $data['message'] = "Anda Belum Reset Password";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //             } else if ($users->userstatus == 0) {
    //                 $data['status'] = 205;
    //                 $data['message'] = "Akun Anda Belum verifikasi";
    //                 $data['key'] = $users->keycode;
    //                 $data['email'] = $users->email;
    //             }
    //         } else {
    //             $data['status'] = 405;
    //             $data['message'] = "email/password anda salah";
    //             $data['key'] = "`12345";
    //             $data['email'] = "12345";
    //         }
    //     } else {
    //         $data['status'] = 405;
    //         $data['message'] = "Akun Anda Belum Aktif";
    //         $data['key'] = "`12345";
    //         $data['email'] = "12345";
    //     }

    //     echo json_encode($data);
    // }

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
            // print_r($output);
            // die;

            echo json_encode($output);
    }



    function event()
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

        //$hariini = '2022-03-06';

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



            if ($hariini >= $s->tgl_mulai) {

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


    function latihan()


    {

        error_reporting(0);
        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();

        // echo "<pre>";
        // print_r($sql);
        // die;

        foreach ($sql as $s) {




            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api[] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                        "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,

                    );
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



    function detail($id_event){

        $id_event2 = base64_decode($id_event);
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '" . $id_event2 . "' order by m.no_urut asc")->result();


        foreach ($sql as $s) {

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();




            $data_api[] = array(

                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "id_jurusan" => $s->id_jurusan,
                "waktu" => $s->waktu,
                "jurusan" => $jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,
                'jumlah_soal' => count($soal),

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
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai" => TanggalIndo($sql[0]->tgl_mulai_materi),
            "tgl_selesai" => TanggalIndo($sql[0]->tgl_selesai_materi),
            'kategori' => $kategori->kategori_nama,


            "desc" => $sql[0]->desc,
            "img" => $sql[0]->img,
            "status" => $sql[0]->status,
            "mode" => $sql[0]->mode,
            "jumlah_soal" => $jumlah_soal,
            "jumlah_waktu" => $jumlah_waktu,
            "data" => $data_api,
        );

        echo json_encode($data_api_api);
    }



    function detail2($id_event)
    {

        $id_event2 = base64_decode($id_event);
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '" . $id_event2 . "' order by m.no_urut asc")->result();


        foreach ($sql as $s) {

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = " . $s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = " . $s->materi_id)->result();




            $data_api[] = array(

                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "id_jurusan" => $s->id_jurusan,
                "waktu" => $s->waktu,
                "jurusan" => $jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,
                'jumlah_soal' => count($soal),

            );


            $data_api_jenis[$jenis->jenis_nama][] = array(

                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "id_jurusan" => $s->id_jurusan,
                "waktu" => $s->waktu,
                "jurusan" => $jurusan->jurusan_nama,
                'jenis' => $jenis->jenis_nama,
                'jenis_label' => $jenis->label,
                'jumlah_soal' => count($soal),

            );
        }


        // echo "<pre>";
        // print_r($data_api);
        // die;


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach ($data_api as $d) {
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }


        

        $result = array();
    foreach ($data_api as $key => $record) {
        if (!isset($result[$record['materi_id']])) {

           
               
            

            $result[$record['jenis']] = array(
                'jenis' => $record['jenis'],
                'jenis_label' => $record['jenis_label'],
               


                'list' => array(
                   
                        //"datanya" => array_search("TPS",$data_api[0],true),

                          "datanya" => $data_api_jenis[$record['jenis']],
                      
                        
                    
                ),
            );
            
        }
        else {
            $result[$record['materi_id']]['materi_nama'][] = array($record['materi_id'],$record['materi_nama']);
        }
    }
    $result = array_values($result);

   // print_r($result);




        $data_api_api = array(

            "id_event" => $sql[0]->id_event,
            "judul" => $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai" => TanggalIndo($sql[0]->tgl_mulai_materi),
            "tgl_selesai" => TanggalIndo($sql[0]->tgl_selesai_materi),
            'kategori' => $kategori->kategori_nama,


            "desc" => $sql[0]->desc,
            "img" => $sql[0]->img,
            "status" => $sql[0]->status,
            "mode" => $sql[0]->mode,
            "jumlah_soal" => $jumlah_soal,
            "jumlah_waktu" => $jumlah_waktu,
            "data" => $result
        );

        echo json_encode($data_api_api);
    }



    function datadiri()
    {

        $email = $this->input->post('email');
        $nama = $this->input->post('nama');
        $no_wa = $this->input->post('no_wa');
        $wilayah = $this->input->post('wilayah');
        $kampus_impian = $this->input->post('kampus_impian');
        $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
        $asal_sekolah = $this->input->post('asal_sekolah');
        $id_event = $this->input->post('id_event');

        // $email = "tes";
        // $nama = "tes";
        // $no_wa = "tes";
        // $wilayah = "tes";
        // $kampus_impian = "tes";
        // $jurusan_diinginkan = "tes";
        // $asal_sekolah = "1";


        $data_insert = array(
            'email' => $email,
            'nama' => $nama,
            'no_wa' => $no_wa,
            'wilayah' => $wilayah,
            'kampus_impian' => $kampus_impian,
            'jurusan_diinginkan' => $jurusan_diinginkan,
            'asal_sekolah' => $asal_sekolah,
            'create_add' => date('Y-m-d H:i:s'),
            'id_event' => base64_decode($id_event),
        );

        // echo "<pre>";
        // print_r($data_insert);
        // die;

        $simpan = $this->db->insert('peserta', $data_insert);
        $id_peserta_h = $this->db->insert_id();

        if ($simpan) {
            $data['status'] = 200;
            $data['message'] = "sukses";
            $data['id_peserta'] = $id_peserta_h;
        } else {
            $data['status'] = 404;
            $data['message'] = "gagal";
            $data['id_peserta'] = 0;
        }
        echo json_encode($data);
    }

    function soal($materi_id)
    {

        $materi_id2 = base64_decode($materi_id);


        $materi_ = $this->db->query('select * from materi where publish = 1 and materi_id = "' . $materi_id2 . '"')->row();

        $soal = $this->db->query('select * from soalonline where materi_id = "' . $materi_id2 . '"')->result_array();


        // echo "<pre>";
        // print_r($soal);

        // die;

        foreach ($soal as $s) {




            $pilihan = json_decode($s['pilihan']);



            foreach ($pilihan as $pi) {

                if ($pi->code == '1') {
                    $folder_jawaban = 'jawaban_a';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '2') {
                    $folder_jawaban = 'jawaban_b';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '3') {
                    $folder_jawaban = 'jawaban_c';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '4') {
                    $folder_jawaban = 'jawaban_d';
                    $nama_file_jawaban = $pi->name;
                } elseif ($pi->code == '5') {
                    $folder_jawaban = 'jawaban_e';
                    $nama_file_jawaban = $pi->name;
                }

                $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;


                if (file_exists($Path_jawaban)) {
                    $Path2_jawaban = $Path_img_jawaban;
                    $type = 'gambar';
                } else {
                    $Path2_jawaban =  $pi->name;
                    $type = 'text';
                }




                $pil[$s['id']][] = array(
                    'code' => $pi->code,
                    'name' => $Path2_jawaban,
                    'type' => $type,
                );
            }

            $Path_img = base_url("assets/file_upload/soalonline/soal/" . $s['img']);

            $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $s['img'];

            if (file_exists($Path)) {
                $Path1 = $s['img'];
                if ($Path1) {
                    $Path2 = $Path_img;
                } else {
                    $Path2 = "";
                }
            } else {
                $Path2 = "";
            }


            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $this->ubahkotak($s['pertanyaan']),
                'img' => $Path2,
                'pilihan' => $pil[$s['id']],
                'pembahasan' => $s['pembahasan'],

            );
        }


        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "hingga" => count($data_soal),
                "totaldata" => count($data_soal),
                "totalhalaman" => 1,

                'materi_nama' => $materi_->materi_nama,
                "datanya" => $data_soal,
                'waktu' => $materi_->waktu,
            )
        );

        echo json_encode($data_api);
    }

     function soal_event($id_event)
    {

        $id_event2 = base64_decode($id_event);



        $materi = $this->db->query('select materi_id,materi_nama,waktu from  materi where id_event = "' . $id_event2 . '" order by no_urut asc')->result_array();




        foreach ($materi as $m) {
            $soal = $this->db->query('select * from soalonline where materi_id = "' . $m['materi_id'] . '"')->result_array();



            foreach ($soal as $s) {
                $pilihan = json_decode($s['pilihan']);



                foreach ($pilihan as $pi) {

                    if ($pi->code == '1') {
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '2') {
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '3') {
                        $folder_jawaban = 'jawaban_c';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '4') {
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    } elseif ($pi->code == '5') {
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/" . $folder_jawaban . "/" . $nama_file_jawaban);
                    $Path_jawaban = FCPATH . 'assets/file_upload/soalonline/' . $folder_jawaban . "/" . $nama_file_jawaban;

                    if ($nama_file_jawaban) {
                        if (file_exists($Path_jawaban)) {
                            $Path2_jawaban = $Path_img_jawaban;
                            $type = 'gambar';
                        } else {
                            $Path2_jawaban =  $pi->name;
                            $type = 'text';
                        }
                    } else {
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }



                    $pil[$s['id']][] = array(
                        'code' => $pi->code,
                        'name' => (string) $Path2_jawaban,
                        'type' => $type,
                    );
                }


                //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                $Path_img = base_url("assets/file_upload/soalonline/soal/" . $s['img']);

                $Path = FCPATH . 'assets/file_upload/soalonline/soal/' . $s['img'];


                if (file_exists($Path)) {
                    $Path1 = $s['img'];
                    if ($Path1) {
                        $Path2 = $Path_img;
                    } else {
                        $Path2 = "";
                    }
                } else {
                    $Path2 = "";
                }

                $data_soal[$m['materi_id']][] =
                    array(
                       'no' => $s['id'],
                        'materi_id' => $s['materi_id'],
                        'pertanyaan' => $this->ubahkotak($s['pertanyaan']),
                        'img' => base_url('assets/file_upload/soalonline/' . $s['img']),
                        'img' => $Path2,
                        'pilihan' => $this->ubahkotak($this->ubahkecilgede($pil[$s['id']])),
                    );
            }

            $j_materi_id[] = array(
                'materi_id' => base64_encode($m['materi_id']),
                'materi_nama' => $m['materi_nama'],
                'datanya' => $data_soal[$m['materi_id']],
                "totalhalaman" => 1,
                "hingga" => count($soal),
                "totaldata" => count($soal),
                'waktu' => $m['waktu'],
                // 'waktu' => 1,
            );
        }

        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "datanya" => $j_materi_id,

            )
        );

        echo json_encode($data_api);
    }

     function detail_latihan($judul)
    {
        // echo "tes";
        // die;
        error_reporting(0);
        //$judul = "Pekan-I---Latihan-Soal";


        $event_latihan = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' and REPLACE(judul, ' ', '-' ) = '" . $judul . "'")->result();

        // echo "<pre>";
        // print_r($event_latihan);

        // die;

        foreach ($event_latihan as $s) {

            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = " . $s->id_event)->result();


            // echo "<pre>";
            // print_r($materi);

            // die;

            foreach ($materi[$s->id_event] as $e) {

                //$jenis = $this->db->query("select * from jenis where id_kategori = ".$s->id_kategori)->row();

                $soal = $this->db->query("select * from soalonline where materi_id = " . $e->materi_id)->result();

                $jurusan = $this->db->query("select * from jurusan where id_jurusan = " . $e->id_jurusan)->row();

                $jenis = $this->db->query("select * from jenis where id_jenis = " . $jurusan->id_jenis)->row();



                $data[$s->kategori_nama][]  = array(
                    'materi_nama' => $e->materi_nama,
                    'materi_id' => $e->materi_id,
                    'jenis' => $jenis->jenis_nama,
                    'jenis_label' => $jenis->label,
                    'waktu' => $e->waktu,
                    'soal' => count($soal),
                    'jurusan' => $jurusan->jurusan_nama,
                    'kategori'=>$s->kategori_nama


                );


                 $data_api2[]  = array(
                    'materi_nama' => $e->materi_nama,
                    'materi_id' => $e->materi_id,
                    'jenis' => $jenis->jenis_nama,
                    'jenis_label' => $jenis->label,
                    'waktu' => $e->waktu,
                    'soal' => count($soal),
                    'jurusan' => $jurusan->jurusan_nama,
                    'kategori'=>$s->kategori_nama


                );
            }


           
        }



        $result = array();
    foreach ($data_api2 as $key => $record) {
        if (!isset($result[$record['materi_id']])) {


            $result[$record['kategori']] = array(
                // 'jenis' => $record['jenis'],
                // 'jenis_label' => $record['jenis_label'],
                'list' => array(
                        //"datanya" => array_search("TPS",$data_api[0],true),
                          "datanya" => $data[$record['kategori']],
                ),
            );
            
        }
        else {
            $result[$record['materi_id']]['materi_nama'][] = array($record['materi_id'],$record['materi_nama']);
        }
    }
    $result = array_values($result);

        $data_api = array(
            'status' => 200,
            //'kategori' => $kategori->kategori_nama,
            'tanggal' => TanggalIndo($event_latihan[0]->tgl_mulai) . '-' . TanggalIndo($event_latihan[0]->tgl_selesai),
            'event' => $event_latihan[0]->judul,
            'datanya' => $result,

        );

        echo json_encode($data_api);
    }


    function wilayah(){

    

                  $url = "https://api.edunitas.com/mod/edun-load-g";

                  $postData = array(
                     "format"=> "json",
                    "formdata_groupjkt"=> 1,
                    "formdata_listmod"=> "Kabupaten-Kota",
                    "formdata_origin"=> "pt",
                    "formdata_type"=> "1",
                    "setdata_mod"=> "list-wilayah",

                );




            // for sending data as json type
            $fields = json_encode($postData);

             

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
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

          //   return $result;

            $output = json_decode($result);

            echo json_encode($output);

      

    }




     function news(){

                  // $url = "https://api.edulearning.me/me-forum/kirim?cid=ajhyTjJXSkxDZUE9";

                       $url = "https://dev-api.edunitas.com/edu_tryout";




                  


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
           // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
          //  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);

          //   return $result;

            $output = json_decode($result);

            echo json_encode($output);

    }




   
    

   

    
    
}
