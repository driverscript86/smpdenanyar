<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['menu'] = 'about';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();
        $data['about'] =  $this->db->get('about')->row_array();

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/about', $data);
        $this->load->view('frontend/footer', $data);
    }
}
