<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Irt_tarik_M extends CI_Model
{


    //set nama tabel yang akan kita tampilkan datanya
    var $table = 'irt';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array(null, 'email');

    var $column_search = array('email');
    // default order 
    var $order = array('id_irt' => 'asc');


    public $id_irt;
    public $email;
    




    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id_event)
    {

        //select *,sum(skor) as skor2  from irt where 
        // id_event = '" . $id_event . "' and email != '' group by email  order by skor2 desc limit 30
        $this->db->select('*,sum(skor) as skor2');
        $this->db->from($this->table);
        $this->db->where('id_event',$id_event);
        $this->db->group_by('email'); 
        $this->db->order_by('skor2', 'desc');

        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id_event)
    {
        $this->_get_datatables_query($id_event);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id_event)
    {
        $this->_get_datatables_query($id_event);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id_event)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }



    // private $_table = "jenis";

  

    public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_kategori" => $id])->row();
    }

    public function save($divisi)
    {
        // $post = $this->input->post();
        // $this->id_kategori = uniqid();
        // $this->kategori_nama = $divisi;
        $data = array(
            'kategori_nama'=>$divisi,
        );
        return $this->db->insert('kategori', $data);
    }

    public function update($id_kategori,$kategori_nama)
    {
        // $post = $this->input->post();
        // $this->id_kategori = $id_kategori;
        // $this->kategori_nama = $kategori_nama;

        $data = array(
            'kategori_nama'=>$kategori_nama,
        );

       
        return $this->db->update('kategori', $data, array('id_kategori' => $id_kategori));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_kategori" => $id));
    }
}