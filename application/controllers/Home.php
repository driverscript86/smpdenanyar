<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        sess_expired();
    }

    public function index()
    {
        $data['menu'] = 'home';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $data['tagline'] =  $this->db->get('tagline')->result_array();
        $this->db->order_by('role', 'asc');
        $data['faq'] =  $this->db->get('faq')->result_array();
        $data['sum_siswa'] = $this->db->get("siswa")->num_rows();
        $data['sum_karyawan'] = $this->db->get("karyawan")->num_rows();
        $data['sum_pendidikan'] = $this->db->get("data_pendidikan")->num_rows();
        $data['sum_kelas'] = $this->db->get("data_kelas")->num_rows();
        $this->db->order_by('id', 'DESC');
        $data['acara'] =  $this->db->get('acara', 3)->result_array();
        $data['kategori'] =  $this->db->get('kategori_gallery', 6)->result_array();
        $data['about'] =  $this->db->get('about')->row_array();
        $this->db->order_by('id', 'DESC');
        $data['gallery'] =  $this->db->get('gallery', 6)->result_array();


        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/home', $data);
        $this->load->view('frontend/footer', $data);
    }
}
