<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_home extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    function daftar_acara($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('acara', $limit, $start);
        return $query;
    }

    function daftar_acara_kat($limit, $start, $uniq)
    {
        $data_kat =  $this->db->get_where('kategori_acara', ['uniq' => $uniq])->row_array();
        $this->db->where('id_kat', $data_kat['id']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('acara', $limit, $start);
        return $query;
    }


    function daftar_gallery($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('gallery', $limit, $start);
        return $query;
    }

    function daftar_gallery_kat($limit, $start, $uniq)
    {
        $data_kat =  $this->db->get_where('kategori_gallery', ['uniq' => $uniq])->row_array();
        $this->db->where('id_kat', $data_kat['id']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('gallery', $limit, $start);
        return $query;
    }
}
