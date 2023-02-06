<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Set_pembayaran extends CI_Controller
{

  public function __construct()
  {
    parent::__construct(TRUE);
    $users = $this->session->userdata('email');
    $user = $this->db->get_where('karyawan', ['email' => $users])->row_array();
        if ($user['role_id'] < '1') {
            redirect('auth/blocked');
        }elseif($user['role_id'] > '6'){
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
    $this->load->model(['M_pembayaran', 'Student_model', 'Bulan_model', 'Bebas_model']);
  }

  // payment view in list
  public function index($offset = NULL)
  {
    $data['menu'] = 'jenis_pembayaran';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
  
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
    // Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['search'] = $f['n'];
    }

    $params['limit'] = 20;
    $params['offset'] = $offset;
    $params['order_by_pay'] = 'desc';
    $data['pembayaran'] = $this->M_pembayaran->get($params);
    $data['pos'] = $this->db->get('pos')->result_array();
    $data['period'] = $this->db->get_where('period', ['period_status' => '1'])->result_array();

    $data['title'] = 'Jenis Pembayaran';
    $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/manage/jenis_pem/jenis_pembayaran', $data);
    $this->load->view('template/footer_admin');
  }

  // Add payment and Update
  public function add($id = NULL)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('pos_id', 'Jenis Pembayaran', 'trim|required|xss_clean');
    $this->form_validation->set_rules('period_id', 'Tahun Pelajaran', 'trim|required|xss_clean');

    $this->form_validation->set_rules('payment_type', 'Tipe', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST and $this->form_validation->run() == TRUE) {

      if ($this->input->post('payment_id')) {
        $params['payment_id'] = $this->input->post('payment_id');
      } else {
        $params['payment_input_date'] = date('Y-m-d H:i:s');
      }

      $params['payment_last_update'] = date('Y-m-d H:i:s');
      $params['payment_type'] = $this->input->post('payment_type');
      $params['period_id'] = $this->input->post('period_id');
      $params['pos_id'] = $this->input->post('pos_id');

      $status = $this->M_pembayaran->add($params);
      $paramsupdate['payment_id'] = $status;
      $this->M_pembayaran->add($paramsupdate);

      if ($this->input->post('payment_id')) {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Jenis pembayaran berhasil di update!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('manage/jenis_pembayaran');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Jenis pembayaran berhasil di tambahkan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('manage/jenis_pembayaran');
      }
    } else {
      redirect('manage/jenis_pembayaran');
    }
  }

  // View data detail
  public function view_bulan($id = NULL, $student_id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'view_bulan';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
  
    // Apply Filter
    // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

    if (isset($q['pend']) && !empty($q['pend']) && $q['pend'] != '') {
      $params['id_pend'] = $q['pend'];
      $data['pendkkn'] = $this->db->get_where('data_pendidikan', ['id' => $q['pend']])->row_array();
    }
    // Kelas
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
      $params['majors_id'] = $q['k'];
    }

    $params['payment_id'] = $id;
    $params['group'] = TRUE;
    $data['student_id'] = $student_id;
    $data['pend'] = $this->Student_model->get_pend($params);
    $data['class'] = $this->Student_model->get_class($params);
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['student'] = $this->Bulan_model->get($params);
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/manage/jenis_pem/view_bulan', $data);
    $this->load->view('template/footer_admin');
  }

  // View data detail
  public function view_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL)
  {

    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'view_bulan';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
  
    // Apply Filter
    // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

    // Kelas
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
      $params['majors_id'] = $q['k'];
    }
    if (isset($q['pend']) && !empty($q['pend']) && $q['pend'] != '') {
      $params['id_pend'] = $q['pend'];
      $data['pendkkn'] = $this->db->get_where('data_pendidikan', ['id' => $q['pend']])->row_array();
    }

    $params['payment_id'] = $id;
    $params['group'] = TRUE;
    $data['student_id'] = $student_id;
    $data['pend'] = $this->Student_model->get_pend();
    $data['class'] = $this->Student_model->get_class($params);
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['student'] = $this->Bebas_model->get($params);
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['title'] = 'Tarif Tagihan';
    $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/manage/jenis_pem/view_bebas', $data);
    $this->load->view('template/footer_admin');
  }


  public function add_payment_bulan_student($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'view_bulan';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
  
    $this->load->library('form_validation');
    $this->form_validation->set_rules('student_id', 'Pilih Kelas dan Siswa', 'trim|required|xss_clean');
    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST and $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $check = $this->Bulan_model->get(array('student_id' => $this->input->post('student_id'), 'payment_id' => $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];
        for ($i = 0; $i < $cpt; $i++) {
          $param['bulan_bill'] = $title[$i];
          $param['month_id'] = $month[$i];
          $param['bulan_input_date'] = date('Y-m-d H:i:s');
          $param['bulan_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $this->input->post('student_id');

          if (count($check) == 0) {

            $this->Bulan_model->add($param);

          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Duplikat data jenis pembayaran!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('manage/jenis_pembayaran/view_bulan/' . $id);
          }
        }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Berhasil menambahkan jenis pembayaran!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bulan/' . $id);
    } else {
      $data['student'] = $this->Student_model->get(array('status' => 1));
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran Siswa';
      $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/manage/jenis_pem/add_bulan_student', $data);
    $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bulan_pend($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_pend';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST and $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $student = $this->Student_model->get(array('id_pend' => $this->input->post('id_pend'), 'status' => 1));
        $check = $this->Bulan_model->get(array('id_pend' => $this->input->post('id_pend'), 'payment_id' => $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];

        foreach ($student as $row) {
          for ($i = 0; $i < $cpt; $i++) {
            $param['bulan_bill'] = $title[$i];
            $param['month_id'] = $month[$i];
            $param['bulan_input_date'] = date('Y-m-d H:i:s');
            $param['bulan_last_update'] = date('Y-m-d H:i:s');
            $param['payment_id'] = $id;
            $param['student_id'] = $row['id'];

            if (count($check) == 0) {
              $this->Bulan_model->add($param);
            } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Duplikat data jenis pembayaran!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
              redirect('manage/jenis_pembayaran/view_bulan/' . $id);
            }
          }
           
        }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Berhasil menambahkan jenis pembayaran!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bulan/' . $id);
    } else {

      $data['pend'] = $this->Student_model->get_pend();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bulan_pend', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bulan($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bulan';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST and $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $student = $this->Student_model->get(array('id_kelas' => $this->input->post('class_id'), 'status' => 1));
        $check = $this->Bulan_model->get(array('class_id' => $this->input->post('class_id'), 'payment_id' => $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];

        foreach ($student as $row) {
          for ($i = 0; $i < $cpt; $i++) {
            $param['bulan_bill'] = $title[$i];
            $param['month_id'] = $month[$i];
            $param['bulan_input_date'] = date('Y-m-d H:i:s');
            $param['bulan_last_update'] = date('Y-m-d H:i:s');
            $param['payment_id'] = $id;
            $param['student_id'] = $row['id'];

            if (count($check) == 0) {
              $this->Bulan_model->add($param);
            } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Duplikat data jenis pembayaran!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
              redirect('manage/jenis_pembayaran/view_bulan/' . $id);
            }
          }
           
        }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Berhasil menambahkan jenis pembayaran!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bulan/' . $id);
    } else {

      $data['pend'] = $this->Student_model->get_pend();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bulan', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bulan_majors($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bulan_majors';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bulan_bill[]', 'Tarif Bulanan', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    if ($_POST and $this->form_validation->run() == TRUE) {

      if (!$this->input->post('payment_id')) {

        $month = $this->Bulan_model->get_month();
        $student = $this->Student_model->get(array('majors_id' => $this->input->post('majors_id'), 'class_id' => $this->input->post('class_id'), 'status' => 1));
        $check = $this->Bulan_model->get(array('majors_id' => $this->input->post('majors_id'), 'class_id' => $this->input->post('class_id'), 'payment_id' => $id));
        $title = $_POST['bulan_bill'];
        $cpt = count($_POST['bulan_bill']);
        $month = $_POST['month_id'];
        foreach ($student as $row) {
          for ($i = 0; $i < $cpt; $i++) {
            $param['bulan_bill'] = $title[$i];
            $param['month_id'] = $month[$i];
            $param['bulan_input_date'] = date('Y-m-d H:i:s');
            $param['bulan_last_update'] = date('Y-m-d H:i:s');
            $param['payment_id'] = $id;
            $param['student_id'] = $row['id'];

            if (count($check) == 0) {

              $this->Bulan_model->add($param);
            } else {
              $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Duplikat data pembayaran!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
              redirect('manage/jenis_pembayaran/view_bulan/' . $id);
            }
          }
        }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Setting Tarif berhasil
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bulan/' . $id);
    } else {

      $data['majors'] = $this->Student_model->get_majors();
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['month'] = $this->Bulan_model->get_month();
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bulan_majors', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function edit_payment_bulan($id = NULL, $student_id = NULL)
  {
    if ($id == NULL and $student_id == NULL or $student_id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bulan_majors';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    if ($_POST  == TRUE) {

      $title = $_POST['bulan_bill'];
      $bulan_id = $_POST['bulan_id'];
      $cpt = count($_POST['bulan_bill']);

      for ($i = 0; $i < $cpt; $i++) {
        $param['bulan_id'] = $bulan_id[$i];
        $param['bulan_bill'] = $title[$i];
        $param['bulan_last_update'] = date('Y-m-d H:i:s');
        $this->Bulan_model->add($param);
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Update pembayaran Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bulan/' . $id);
    } else {
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id' => $student_id));
      $data['title'] = 'Edit Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/edit_bulan', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function delete_payment_bulan($id = NULL, $student_id = NULL)
  {
    if ($id == NULL and $student_id == NULL or $student_id == NULL) {
      redirect('manage/jenis_pembayaran');
    }

    $bulan_id = $id;
    $cpt = count($_POST['bulan_id']);

    for ($i = 0; $i < $cpt; $i++) {
      $param['bulan_id'] = $bulan_id[$i];

      $this->Bulan_model->delete($param);
    }

    $this->session->set_flashdata('success', ' Pembayaran berhasil');
    redirect('manage/jenis_pembayaran/view_bulan/' . $id);
  }

  public function add_payment_bebas_student($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bebas_student';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    if ($_POST  == TRUE) {
      if (empty($this->input->post('student_id'))) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Nama siswa tidak boleh kosong!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('manage/jenis_pembayaran/add_payment_bebas_student/' . $id);
      }

      if (!$this->input->post('payment_id')) {

        $check = $this->Bebas_model->get(array('student_id' => $this->input->post('student_id'), 'payment_id' => $id));

          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_desc'] = $this->input->post('bebas_desc');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $this->input->post('student_id');

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Duplikat data!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('manage/jenis_pembayaran/view_bebas/' . $id);
          }
      }

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Setting Tarif Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bebas/' . $id);
    } else {
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bebas_student', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bebas_pend($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bebas_student';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('id_pend' => $this->input->post('id_pend')));
        $check = $this->Bebas_model->get(array('id_pend' => $this->input->post('id_pend'), 'payment_id' => $id));

        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_desc'] = $this->input->post('bebas_desc');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['id'];

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Duplikat data pembayaran!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('manage/jenis_pembayaran/view_bebas/' . $id);
          }
        }
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Setting Tarif Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bebas/' . $id);
    } else {
      $data['pend'] = $this->Student_model->get_pend();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bebas_pend', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bebas($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bebas_student';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('class_id' => $this->input->post('class_id')));
        $check = $this->Bebas_model->get(array('class_id' => $this->input->post('class_id'), 'payment_id' => $id));

        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_desc'] = $this->input->post('bebas_desc');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['id'];

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Duplikat data pembayaran!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('manage/jenis_pembayaran/view_bebas/' . $id);
          }
        }
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Setting Tarif Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bebas/' . $id);
    } else {
      $data['pend'] = $this->Student_model->get_pend();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bebas', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function add_payment_bebas_majors($id = NULL)
  {
    if ($id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bebas_student';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    if ($_POST  == TRUE) {

      if (!$this->input->post('payment_id')) {

        $student = $this->Student_model->get(array('majors_id' => $this->input->post('majors_id'), 'class_id' => $this->input->post('class_id')));
        $check = $this->Bebas_model->get(array('majors_id' => $this->input->post('majors_id'), 'class_id' => $this->input->post('class_id'), 'payment_id' => $id));

        foreach ($student as $row) {
          $param['bebas_bill'] = $this->input->post('bebas_bill');
          $param['bebas_desc'] = $this->input->post('bebas_desc');
          $param['bebas_input_date'] = date('Y-m-d H:i:s');
          $param['bebas_last_update'] = date('Y-m-d H:i:s');
          $param['payment_id'] = $id;
          $param['student_id'] = $row['id'];

          if (count($check) == 0) {

            $this->Bebas_model->add($param);
          } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Duplikat data pembayaran!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('manage/jenis_pembayaran/view_bebas/' . $id);
          }
        }
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Setting Tarif Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bebas/' . $id);
    } else {

      $data['majors'] = $this->Student_model->get_majors();
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['title'] = 'Tambah Tarif Pembayaran';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/add_bebas_majors', $data);
      $this->load->view('template/footer_admin');
    }
  }

  public function edit_payment_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL)
  {
    
    if ($id == NULL and $student_id == NULL or $bebas_id == NULL) {
      redirect('manage/jenis_pembayaran');
    }
    $data['menu'] = 'add_payment_bebas_student';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();


    if ($_POST  == TRUE) {
      $param['bebas_id'] = $bebas_id;
      $param['bebas_bill'] = $this->input->post('bebas_bill');
      $param['bebas_desc'] = $this->input->post('bebas_desc');
      $param['bulan_last_update'] = date('Y-m-d H:i:s');
      $this->Bebas_model->add($param);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Update Tagihan berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('manage/jenis_pembayaran/view_bebas/' . $id);
    } else {
      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id' => $student_id));
      $data['title'] = 'Edit Tarif Tagihan';
      $this->load->view('template/header', $data);
      if ($data['user']['role_id'] !== '1') {
          $this->load->view('template/sidebar_karyawan', $data);
      }else{
          $this->load->view('template/sidebar_admin', $data);
      }
      $this->load->view('template/topbar_admin', $data);
      $this->load->view('admin/manage/jenis_pem/edit_bebas', $data);
      $this->load->view('template/footer_admin');
    }
  }
}
