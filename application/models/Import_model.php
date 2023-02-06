<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function simpan($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('siswa', $data);
        }
    }

    function simpan_absen($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('absen_pegawai', $data);
        }
    }
}
