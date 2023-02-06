<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
      $id = $this->input->get('id');
      $this->session->set_userdata(['reff' => $id]);
      redirect('ppdb');
    }

}