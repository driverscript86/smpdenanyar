<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['menu'] = 'kontak';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['home'] =  $this->db->get('home')->row_array();

        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('frontend/header', $data);
            $this->load->view('frontend/kontak', $data);
            $this->load->view('frontend/footer', $data);
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'subjek' => $this->input->post('subjek'),
                'pesan' => $this->input->post('pesan'),
                'tgl' => date('Y-m-d'),
                'status' => '1'
            ];

            $input = $this->db->insert('kontak', $data);
            if ($input) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}
