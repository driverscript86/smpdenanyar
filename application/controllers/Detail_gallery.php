<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_gallery extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $id = $this->input->get('id');
        $data['menu'] = 'gallery';
        $data['home'] =  $this->db->get('home')->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
        $data['gallery'] =  $this->db->get_where('gallery', ['id' => $id])->result_array();
        $data['kategori'] =  $this->db->get('kategori_gallery')->result_array();

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/detail_gallery', $data);
        $this->load->view('frontend/footer', $data);
    }
}
