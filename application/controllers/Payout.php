<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payout extends CI_Controller
{

  public function __construct()
  {
    parent::__construct(TRUE);
    $users = $this->session->userdata('email');
    $user = $this->db->get_where('karyawan', ['email' => $users])->row_array();
    if ($user['role_id'] < '1') {
        redirect('auth/blocked');
    } elseif($user['role_id'] > '6'){
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
    $this->load->helper('tgl_indo');
    $this->load->model(array('M_pembayaran', 'Student_model', 'Period_model', 'Pos_model', 'Bulan_model', 'Bebas_model', 'Bebas_pay_model', 'Letter_model', 'Log_trx_model'));
  }

  // payment view in list
  public function index($offset = NULL, $id = NULL)
  {
    $data['menu'] = 'payout';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;
    $siswa['id'] = '';
    $params = array();
    $param = array();
    $pay = array();
    $cashback = array();
    $logs = array();

    // Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      $cashback['period_id'] = $f['n'];
      $logs['period_id'] = $f['n'];
    }

    // Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $cashback['student_nis'] = $f['r'];
      $logs['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('nis' => $f['r']));
    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
    }

    $params['group'] = TRUE;
    $pay['paymentt'] = TRUE;
    $param['status'] = 1;
    $cashback['status'] = 1;
    $pay['student_id'] = $siswa['id'];
    $cashback['student_id'] = $siswa['id'];
    $logs['student_id'] = $siswa['id'];
    $cashback['date'] = date('Y-m-d');
    $cashback['bebas_pay_input_date'] = date('Y-m-d');
    $logs['limit'] = 3;
    $paramsPage = $params;
    $data['period'] = $this->Period_model->get($params);
    $data['siswa'] = $this->Student_model->get(array('student_id' => $siswa['id'], 'group' => TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $siswa['id']));
    $data['bebas'] = $this->Bebas_model->get($pay);
    $data['free'] = $this->Bebas_pay_model->get($params);
    $data['dom'] = $this->Bebas_pay_model->get($params);
    $data['bill'] = $this->Bulan_model->get_total($params);
    $data['in'] = $this->Bulan_model->get_total($param);
    $data['month'] = $this->Bulan_model->get_total($cashback);
    $data['beb'] = $this->Bebas_pay_model->get($cashback);
    $data['log'] = $this->Log_trx_model->get($logs);

    // cashback
    $data['cash'] = 0;
    foreach ($data['month'] as $row) {
      $data['cash'] += $row['bulan_bill'];
    }

    $data['cashb'] = 0;
    foreach ($data['beb'] as $row) {
      $data['cashb'] += $row['bebas_pay_bill'];
    }

    // endcashback
    $data['total'] = 0;
    foreach ($data['bill'] as $key) {
      $data['total'] += $key['bulan_bill'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['pay_bill'] = 0;
    foreach ($data['dom'] as $row) {
      $data['pay_bill'] += $row['bebas_pay_bill'];
    }

    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bulan_model->get($paramsPage));

    $data['title'] = 'Transaksi Pembayaran Siswa';
    $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/payout/payout_list', $data);
    $this->load->view('template/footer_admin');
  }

  public function payout_bayar($id = NULL, $student_id = NULL)
  {
    $data['menu'] = 'payout_bayar';
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();

    $data['class'] = $this->Student_model->get_class();
    $data['period'] = $this->Period_model->get();
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
    $data['student'] = $this->Student_model->get(array('id' => $student_id));
    $data['title'] = 'Transaksi Pembayaran Siswa';
    $this->load->view('template/header', $data);
    if ($data['user']['role_id'] !== '1') {
        $this->load->view('template/sidebar_karyawan', $data);
    }else{
        $this->load->view('template/sidebar_admin', $data);
    }
    $this->load->view('template/topbar_admin', $data);
    $this->load->view('admin/payout/payout_bayar', $data);
    $this->load->view('template/footer_admin');
  }

  function printBill()
  {
    $this->load->library('Pdf');
    
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $siswa['id'] = '';
    $params = array();
    $pay = array();

    // Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
    }

    // Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('nis' => $f['r']));
    }
    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    $pay['student_id'] = $siswa['id'];
    $data['period'] = $this->Period_model->get($params);
    $data['siswa'] = $this->Student_model->get(array('student_id' => $siswa['id'], 'group' => TRUE));
    $data['bulan'] = $this->Bulan_model->get($pay);
    $data['bebas'] = $this->Bebas_model->get($pay);

    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = 'payout_bill_' . $siswa['nama'] . '.pdf';
    $this->pdf->load_view('laporan/payout_bill_pdf', $data, true);
  }

  function cetakBukti()
  {
    $this->load->library('Pdf');
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;
    $siswa['id'] = '';
    $params = array();
    $param = array();
    $pay = array();
    $cashback = array();

    // Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      $cashback['period_id'] = $f['n'];
    }

    // Siswa
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $siswa = $this->Student_model->get(array('nis' => $f['r']));
    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
      $cashback['date'] = $f['d'];
    }

    $params['group'] = TRUE;
    $pay['paymentt'] = TRUE;
    $param['status'] = 1;
    $param['student_id'] = $siswa['id'];
    $cashback['status'] = 1;
    $pay['student_id'] = $siswa['id'];
    $cashback['student_id'] = $siswa['id'];

    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    $data['period'] = $this->Period_model->get($params);
    $data['siswa'] = $this->Student_model->get(array('student_id' => $siswa['id'], 'group' => TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan'] = $this->Bulan_model->get($param);
    $data['bebas'] = $this->Bebas_model->get($pay);
    $data['free'] = $this->Bebas_pay_model->get($param);
    $data['s_bl'] = $this->Bulan_model->get_total($cashback);
    $data['s_bb'] = $this->Bebas_pay_model->get($cashback);

    //total
    $data['summonth'] = 0;
    foreach ($data['s_bl'] as $row) {
      $data['summonth'] += $row['bulan_bill'];
    }

    $data['sumbeb'] = 0;
    foreach ($data['s_bb'] as $row) {
      $data['sumbeb'] += $row['bebas_pay_bill'];
    }
  
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = 'Cetak_Struk_' . $siswa['nama'] . '_' . date('Y-m-d') . '.pdf';
    $this->pdf->load_view('laporan/payout_cetak_pdf', $data, true);
  }

  // View data detail
  public function view_bulan($id = NULL)
  {
    // Apply Filter
    // Get $_GET variable
    $q = $this->input->get(NULL, TRUE);

    $data['q'] = $q;
    $params = array();

    // Programs
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    $data['class'] = $this->Student_model->get_class($params);
    $data['student'] = $this->Student_model->get($params);
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bulan';
    $this->load->view('layout', $data);
  }

  // View data detail
  public function view_bebas($id = NULL)
  {

    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['bebas'] = $this->Bebas_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bebas';
    $this->load->view('layout', $data);
  }


  public function payout_bulan($id = NULL, $student_id = NULL)
  {

    if ($id == NULL and $student_id == NULL or $student_id == NULL) {
      redirect('payout');
    }

    $data['class'] = $this->Student_model->get_class();
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
    $data['in'] = $this->Bulan_model->get_total(array('status' => 1, 'payment_id' => $id, 'student_id' => $student_id));
    $data['student'] = $this->Student_model->get(array('id' => $student_id));

    $data['total'] = 0;
    foreach ($data['bulan'] as $key) {
      $data['total'] += $key['bulan_bill'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['ngapp'] = 'ng-app="App"';
    $data['title'] = 'Transaksi Pembayaran Siswa';
    $data['main'] = 'payout/payout_add_bulan';
    $this->load->view('layout', $data);
  }

  public function payout_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL, $pay_id = NULL)
  {
    if ($_POST == TRUE) {
      $lastletter = $this->Letter_model->get(array('limit' => 1));
      $student = $this->Bebas_model->get(array('id' => $this->input->post('bebas_id')));

      if ($lastletter['letter_year'] < date('Y') or count($lastletter) == 0) {
        $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nomor = sprintf('%05d', '00001');
        $nofull = date('Y') . date('m') . $nomor;
      } else {
        $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
        $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nofull = date('Y') . date('m') . $nomor;
      }
      if ($this->input->post('bebas_id')) {
        $param['bebas_id'] = $this->input->post('bebas_id');
      }
      $param['bebas_pay_number'] = $nofull;
      $param['bebas_pay_bill'] = $this->input->post('bebas_pay_bill');
      $param['increase_budget'] = $this->input->post('bebas_pay_bill');
      $param['bebas_pay_desc'] = $this->input->post('bebas_pay_desc');
      $param['user_user_id'] = $this->session->userdata('uid');
      $param['bebas_pay_input_date'] = date('Y-m-d H:i:s');
      $param['bebas_pay_last_update'] = date('Y-m-d H:i:s');
      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id' => $this->input->post('bebas_id')));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $this->input->post('payment_payment_id'), 'student_nis' => $this->input->post('student_nis')));
      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $sisa = $data['total'] - $data['total_pay'];

      if ($this->input->post('bebas_pay_bill') > $sisa or $this->input->post('bebas_pay_bill') == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Pembayaran yang anda masukkan melebihi total tagihan!!!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('payout?n=' . $student['period_period_id'] . '&r=' . $student['nis']);
      } else {

        $idd = $this->Bebas_pay_model->add($param);
        $this->Bebas_model->add(array('increase_budget' => $this->input->post('bebas_pay_bill'), 'bebas_id' =>  $this->input->post('bebas_id'), 'bebas_last_update' => date('Y-m-d H:i:s')));

        $log = array(
          'bulan_bulan_id' => NULL,
          'bebas_pay_bebas_pay_id' => $idd,
          'student_student_id' => $this->input->post('student_student_id'),
          'log_trx_input_date' =>  date('Y-m-d H:i:s'),
          'log_trx_last_update' => date('Y-m-d H:i:s'),
        );
        $this->Log_trx_model->add($log);
      }
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Pembayaran Tagihan berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      redirect('payout?n=' . $student['period_period_id'] . '&r=' . $student['nis']);
    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id' => $student_id));
      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id' => $bebas_id, 'student_id' => $student_id, 'payment_id' => $id));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $data['title'] = 'Tagihan Siswa';
      // $data['main'] = 'payout/payout_add_bebas';
      $this->load->view('admin/payout/payout_add_bebas', $data);
    }
  }

  function pay($payment_id = NULL, $student_id = NULL, $id = NULL)
  {

    $lastletter = $this->Letter_model->get(array('limit' => 1));
    $student = $this->Bulan_model->get(array('student_id' => $student_id, 'id' => $id));

    if ($lastletter['letter_year'] < date('Y') or count($lastletter) == 0) {
      $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
      $nomor = sprintf('%05d', '00001');
      $nofull = date('Y') . date('m') . $nomor;
    } else {
      $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
      $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
      $nofull = date('Y') . date('m') . $nomor;
    }

    $pay = array(
      'bulan_id' => $id,
      'bulan_number_pay' => $nofull,
      'bulan_date_pay' => date('Y-m-d H:i:s'),
      'bulan_last_update' => date('Y-m-d H:i:s'),
      'bulan_status' => 1,
      'user_user_id' => $this->session->userdata('uid')
    );

    $log = array(
      'bulan_bulan_id' => $id,
      'student_student_id' => $student_id,
      'bebas_pay_bebas_pay_id' => NULL,
      'log_trx_input_date' =>  date('Y-m-d H:i:s'),
      'log_trx_last_update' => date('Y-m-d H:i:s'),
    );

    $status = $this->Bulan_model->add($pay);
    $this->Log_trx_model->add($log);

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('messageKet', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Pembayaran Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      // redirect('payout?n=' . $student['period_period_id'] . '&r=' . $student['student_nis']);
      redirect('payout/payout_bayar/' . $student['payment_payment_id'] . '/' . $student_id);
    }
  }

  function not_pay($payment_id = NULL, $student_id = NULL, $id = NULL)
  {
    $student = $this->Bulan_model->get(array('student_id' => $student_id, 'id' => $id));
    $pay = array(
      'bulan_id' => $id,
      'bulan_number_pay' => NULL,
      'bulan_status' => 0,
      'bulan_date_pay' => NULL,
      'bulan_last_update' => date('Y-m-d H:i:s'),
      'user_user_id' => NULL
    );

    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bulan_id' => $id
    ));

    $this->Bulan_model->add($pay);
    if ($this->input->is_ajax_request()) {
      // echo $status;
    } else {
      $this->session->set_flashdata('messageKet', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Hapus Pembayaran Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      // redirect('payout?n=' . $student['period_period_id'] . '&r=' . $student['student_nis']);
      redirect('payout/payout_bayar/' . $student['payment_payment_id'] . '/' . $student_id);
    }
  }

  function update_pay_desc()
  {
    $id = $this->input->post('bulan_id');
    $student_nis = $this->input->post('student_nis');
    $student_id = $this->input->post('student_student_id');
    $period_id = $this->input->post('period_period_id');
    $payment_id = $this->input->post('payment_payment_id');
    $bulan_pay_desc = $this->input->post('bulan_pay_desc');
    $data = array(
      'bulan_id' => $id,
      'bulan_pay_desc' => $bulan_pay_desc,
    );
    $this->Bulan_model->add($data);
    if ($this->input->is_ajax_request()) {
    } else {
      $this->session->set_flashdata('messageKet', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Update Keterangan Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      // redirect('payout?n=' . $period_id . '&r=' . $student_nis);
      redirect('payout/payout_bayar/' . $payment_id . '/' . $student_id);
    }
  }

  function printPay($payment_id = NULL, $student_id = NULL, $id = NULL)
  {
    $this->load->library('Pdf');
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('payout/payout_bulan/' . $payment_id . '/' . $student_id);

    $data['printpay'] = $this->Bulan_model->get(array('id' => $id));

    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = $data['printpay']['nama'] . '_' . date('Y-m-d') . '.pdf';
    $this->pdf->load_view('laporan/payout_pdf', $data, true);
  }

  function printPayFree($payment_id = NULL, $student_id = NULL, $id = NULL)
  {
    $this->load->library('Pdf');
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('payout/payout_bebas/' . $payment_id . '/' . $student_id);

    $data['printpay'] = $this->Bebas_pay_model->get(array('id' => $id));

    $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id));

    $data['total_bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['total_bill'] += $key['bebas_total_pay'];
    }

    $data['bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['bill'] += $key['bebas_bill'];
    }

    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = $data['printpay']['nama'] . '_' . date('Y-m-d') . '.pdf';
    $this->pdf->load_view('laporan/payout_free_pdf', $data, true);
  }

  function multiple()
  {
    $this->load->library('Pdf');
    $this->load->helper(array('tanggal'));
    $action = $this->input->post('action');
    $print = array();
    if ($action == "printAll") {
      $bln = $this->input->post('msg');
      for ($i = 0; $i < count($bln); $i++) {
        $print[] = $bln[$i];
      }

      $data['printpay'] = $this->Bulan_model->get(array('multiple_id' => $print, 'group' => TRUE));
      $data['pay'] = $this->Bulan_model->get(array('multiple_id' => $print));

      $data['total_pay'] = 0;
      foreach ($data['pay'] as $row) {
        $data['total_pay'] += $row['bulan_bill'];
      }
      
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = 'Tagihan_Pembayaran' . '_' . date('Y-m-d') . '.pdf';
    $this->pdf->load_view('laporan/payout_bulan_multiple_pdf', $data, true);
    }
    redirect('payout');
  }

  function delete_pay_free($period_id = NULL, $student_id = NULL, $bebas_id = NULL, $id = NULL, $nis = NULL)
  {

    $total_pay = $this->Bebas_pay_model->get(array('id' => $id));

    $this->Bebas_model->add(
      array(
        'decrease_budget' => $total_pay['bebas_pay_bill'],
        'bebas_id' => $bebas_id
      )
    );

    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bebas_pay_id' => $id
    ));

    $this->Bebas_pay_model->delete($id);

    if ($this->input->is_ajax_request()) {
      // echo $status;
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
      Delete pembayaran Bebas Berhasil!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>');
      
      redirect('payout?n='. $period_id .'&r='.$nis);
    }
  }

  // Delete to database
  public function delete($id = NULL)
  {

    if ($_POST) {
      $this->M_pembayaran->delete($id);
      // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Jenis Pembayaran',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Jenis Pembayran berhasil');
      redirect('payment');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('payment/edit/' . $id);
    }
  }
}
