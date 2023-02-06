<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getAll()
    {
        $this->db->from('siswa'); //nama tabel harap disesuaikan dengan nama tabel milik sobat

        return $this->db->get();
    }

    function getPPDB()
    {
        $this->db->from('ppdb'); //nama tabel harap disesuaikan dengan nama tabel milik sobat

        return $this->db->get();
    }
}
