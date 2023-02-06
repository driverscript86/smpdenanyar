<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('M_home');
    }

    public function index()
    {
        $data['menu'] = 'gallery';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $data['kategori'] =  $this->db->get('kategori_gallery')->result_array();



        $this->db->from("gallery");

        $config = array();
        $config['base_url'] = site_url('gallery'); //site url
        $config['total_rows'] = $this->db->count_all_results(); //total row
        $config['per_page'] = 6;  //show record per halaman
        $config["num_links"] = 5;

        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = '⇤ First';
        $config['last_link']        = 'Last ⇥';
        $config['next_link']        = 'Next →';
        $config['prev_link']        = '← Prev';
        $config['full_tag_open']    = '<ul>';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a>';
        $config['cur_tag_close']    = '</a></li>';
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']  = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']  = 'Next</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']  = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['daftar'] = $this->M_home->daftar_gallery($config["per_page"], $data['page'])->result_array();

        $data['pagination'] = $this->pagination->create_links();
        $data['total'] = $config['total_rows'];
        //end pagination


        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/gallery', $data);
        $this->load->view('frontend/footer', $data);
    }
}
