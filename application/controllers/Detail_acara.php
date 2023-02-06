<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_acara extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $id = $this->input->get('id');
        $data['menu'] = 'acara';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $data['detail'] =  $this->db->get_where('acara', ['id' => $id])->result_array();
        $data['kategori'] =  $this->db->get('kategori_acara')->result_array();
        $this->db->where_not_in('id', $id);
        $data['acara_lain'] =  $this->db->get('acara', 5)->result_array();

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/detail_acara', $data);
        $this->load->view('frontend/footer', $data);
    }
}
