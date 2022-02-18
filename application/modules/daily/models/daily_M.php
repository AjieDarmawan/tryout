<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daily_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_master_wfh(){
        $sql = $this->db->query('select * from wfh_master ORDER by wfh_aktifitas asc');
        return $sql->result();
    }

 
}
