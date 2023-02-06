<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $users = $this->session->userdata('email');
        $this->load->model(['Student_model', 'Main_model']);
        $this->load->helper('tgl_indo');
        $this->load->library('email');

        $user = $this->db->get_where('karyawan', ['email' => $users])->row_array();
        if ($user['role_id'] == '5') {
            redirect('siswa');
        } elseif ($user['role_id'] < '1') {
            redirect('auth/blocked');
        }

        if (!$users) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
             Silahkan masuk terlebih dahulu!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
         </div>');
            redirect('auth/admin');
        }
    }

    public function index()
    {

    }

    
    public function upgrade($offset = NULL)
    {
        $data['menu'] = 'menu-2';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
      
        $f = $this->input->get(NULL, TRUE);
        $data['f'] = $f;
        $params = array();
        // Nip
        if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
        $params['class_id'] = $f['pr'];
        }

        if (isset($f['majors']) && !empty($f['majors']) && $f['majors'] != '') {
        $params['majors_id'] = $f['majors'];
        }
        
        if (isset($f['pend']) && !empty($f['pend']) && $f['pend'] != '') {
        $params['id_pend'] = $f['pend'];
        $data['pendkkn'] = $this->db->get_where('data_pendidikan', ['id' => $f['pend']])->row_array();
        }

        $params['status'] = 1;

        $paramsPage = $params;
        $params['offset'] = $offset;
        $data['student'] = $this->Student_model->get($params);
        $data['pend'] = $this->Student_model->get_pend();
        $data['majors'] = $this->Student_model->get_majors();
        $data['class'] = $this->Student_model->get_class($params);
        $data['upgrade'] = $this->Student_model->get_class();
        $config['base_url'] = site_url('student');
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['total_rows'] = count($this->Student_model->get($paramsPage));

        $data['title'] = 'Kenaikan Kelas';
        $data['main'] = 'student/upgrade';
        $this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/student/upgrade', $data);
        $this->load->view('template/footer_admin');
    }

    public function pass($offset = NULL)
    {
      $data['menu'] = 'menu-2';
      $data['title'] = 'Kelulusan';
      $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
      $data['web'] =  $this->db->get('website')->row_array();
    

      $f = $this->input->get(NULL, TRUE);
      $data['f'] = $f;
      $params = array();
      // Nip
      if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
        $params['class_id'] = $f['pr'];
      }
      if (isset($f['majors']) && !empty($f['majors']) && $f['majors'] != '') {
        $params['majors_id'] = $f['majors'];
        }
      if (isset($f['pend']) && !empty($f['pend']) && $f['pend'] != '') {
      $params['id_pend'] = $f['pend'];
      $data['pendkkn'] = $this->db->get_where('data_pendidikan', ['id' => $f['pend']])->row_array();
      }

      $paramsPage = $params;
      $params['status'] = TRUE;
      $params['offset'] = $offset;
      $data['notpass'] = $this->Student_model->get($params);
      $data['pass'] = $this->Student_model->get(array('status' => 0));
      $data['pend'] = $this->Student_model->get_pend();
      $data['majors'] = $this->Student_model->get_majors();
      $data['class'] = $this->Student_model->get_class($params);
      $config['base_url'] = site_url('student');
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config['total_rows'] = count($this->Student_model->get($paramsPage));
  
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/student/pass', $data);
      $this->load->view('template/footer_admin');
    }
    
  function multiple()
  {
    $action = $this->input->post('action');
    $pend = $this->input->post('pend');
    $majors = $this->input->post('majors');
    $pr = $this->input->post('pr');

    $print = array();
    $idcard = array();
    if ($action == "pass") {
      $pass = $this->input->post('msg');
      for ($i = 0; $i < count($pass); $i++) {
        $this->Student_model->add(array('id' => $pass[$i], 'status' => 0));
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Proses Kelulusan berhasil.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
      }
      redirect('student/pass?pend='.$pend.'&majors='.$majors.'&pr='.$pr);
    } elseif ($action == "notpass") {
      $notpass = $this->input->post('msg');
      for ($i = 0; $i < count($notpass); $i++) {
        $this->Student_model->add(array('id' => $notpass[$i], 'status' => 1));
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Proses Kembali berhasil.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
      }
      redirect('student/pass?pend='.$pend.'&majors='.$majors.'&pr='.$pr);
    } elseif ($action == "upgrade") {
      $pendd = $this->db->get_where('data_pendidikan', ['id' => $pend])->row_array();
        if($pendd['majors'] == 1){
            $jurus = $this->input->post('jurusan');
        }elseif($pendd['majors'] == 0){
            $jurus = '';
        }
      $upgrade = $this->input->post('msg');
      for ($i = 0; $i < count($upgrade); $i++) {
        $this->Student_model->add(array('id' => $upgrade[$i], 'id_pend' => $this->input->post('pendidikan'), 'id_majors' => $jurus, 'id_kelas' => $this->input->post('kelas')));
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Berhasil memproses kenaikan kelas.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
					</div>');
      }
      redirect('student/upgrade?pend='.$pend.'&majors='.$majors.'&pr='.$pr);
    } elseif ($action == "printPdf") {
      $this->load->helper(array('dompdf'));
      $idcard = $this->input->post('msg');
      for ($i = 0; $i < count($idcard); $i++) {
        $print[] = $idcard[$i];
      }

      $data['student'] = $this->Student_model->get(array('multiple_id' => $print));

    //   for ($i = 0; $i < count($data['student']); $i++) {
    //     $this->barcode2($data['student'][$i]['student_nis'], '');
    //   }
    //   $html = $this->load->view('student/student_multiple_pdf', $data, true);
    //   $data = pdf_create($html, 'KARTU_' . date('d_m_Y'), TRUE, 'A4', 'potrait');
    }
  }


}