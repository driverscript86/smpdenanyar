<?php
defined('BASEPATH') or exit('No direct script access allowed');

class siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        sess_expired();
        $this->load->helper(['tgl_indo']);
        $this->load->model(array('M_pembayaran', 'Student_model', 'Period_model', 'Pos_model', 'Bulan_model', 'Bebas_model', 'Bebas_pay_model', 'Letter_model', 'Log_trx_model'));
    }

    public function index()
    {
        $data['menu'] = '';
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
        $id_siswa = $data['user']['id'];

        $data['majors'] =  $this->db->get_where("data_jurusan", ['id' => $data['user']['id_majors']])->row_array();
        
        $data['sum_siswa'] = $this->db->get("siswa")->num_rows();
        $data['sum_pendidikan'] = $this->db->get("data_pendidikan")->num_rows();
        $data['sum_kelas'] = $this->db->get("data_kelas")->num_rows();

        $data['sum_izin'] = $this->db->get_where("perizinan", ['id_siswa' => $id_siswa])->num_rows();
        $data['sum_takzir'] = $this->db->get_where("pelanggaran", ['id_siswa' => $id_siswa])->num_rows();

        $data['about'] = $this->db->get("about")->row_array();
        $data['sum_konsel'] = $this->db->get_where("konseling", ['id_siswa' => $id_siswa])->num_rows();

        $this->db->where('jk', 'L');
        $data['sum_pria'] = $this->db->get("siswa")->num_rows();

        $this->db->where('jk', 'P');
        $data['sum_wanita'] = $this->db->get("siswa")->num_rows();

        $data['perizinan'] = $this->db->limit(7)->get_where('perizinan', ['id_siswa' => $id_siswa])->result_array();
        $data['pelanggaran'] = $this->db->limit(7)->get_where('pelanggaran', ['id_siswa' => $id_siswa])->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('siswa/index', $data);
        $this->load->view('template/footer');
    }

    public function perizinan()
    {

        $data['menu'] = 'menu-2';
        $data['title'] = 'Perizinan';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
        $id_pend = $data['user']['id_pend'];
        $id_kelas = $data['user']['id_kelas'];

        $this->db->order_by('id', 'desc');
        $data['perizinan'] =  $this->db->get_where('perizinan', ['id_siswa' => $data['user']['id']])->result_array();
        $data['data_izin'] =  $this->db->get('data_perizinan')->result_array();

        $this->form_validation->set_rules('siswa', 'siswa', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('jenis', 'Jenis', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('expired', 'Expired', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('siswa/perizinan', $data);
            $this->load->view('template/footer');
        } else {

            $id_san = $this->input->post('siswa');
            $id_izin = $this->input->post('jenis');

            $cek_izin = $this->db->get_where('data_perizinan', ['id' => $id_izin])->row_array();

            $data = [
                'id_siswa' => $id_san,
                'id_izin' => $cek_izin['id'],
                'keterangan' => $this->input->post('keterangan'),
                'tgl' => $this->input->post('tanggal'),
                'expired' => $this->input->post('expired'),
                'status' => 'Pending',
                'id_pend' => $id_pend,
                'id_kelas' => $id_kelas
            ];

            $this->db->insert('perizinan', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data perizinan <strong>' . $cek_izin['nama'] . '</strong> berhasil dibuat :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('siswa/perizinan');
        }
    }


    public function profile()
    {
        $data['menu'] = 'menu-3';
        $data['title'] = 'Setting Akun';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
        $id = $data['user']['id'];
        $id_kelas = $data['user']['id_kelas'];
        $id_pend = $data['user']['id_pend'];
        $id_majors = $data['user']['id_majors'];

        $data['prov'] = $this->db->get('provinsi')->result_array();
        $data['pendidikan'] = $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();
        $data['kelas'] = $this->db->get_where('data_kelas', ['id' => $id_kelas])->row_array();
        $data['majors'] = $this->db->get_where('data_jurusan', ['id' => $id_majors])->row_array();
        $this->db->where('id', $data['user']['thn_msk']);
        $data['thn_msk'] = $this->db->get('period')->row_array();

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('siswa/profile', $data);
            $this->load->view('template/footer');
        } else {

            $nama = $this->input->post('nama');
            $id_prov = $this->input->post('prov');

            $provinsi = $this->db->get_where('provinsi', ['id_prov' => $id_prov])->row_array();

            $data = [
                'nik' => $this->input->post('nik'),
                'nis' => $this->input->post('nis'),
                'nama' => $nama,
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'jk' => $this->input->post('jk'),
                'ttl' => $this->input->post('ttl'),
                'prov' => $provinsi['nama'],
                'kab' => $this->input->post('kab'),
                'alamat' => $this->input->post('alamat'),
                'nama_ayah' => $this->input->post('nama_ayah'),
                'nama_ibu' => $this->input->post('nama_ibu'),
                'pek_ayah' => $this->input->post('pek_ayah'),
                'pek_ibu' => $this->input->post('pek_ibu'),
                'nama_wali' => $this->input->post('nama_wali'),
                'pek_wali' => $this->input->post('pek_wali'),
                'peng_ortu' => $this->input->post('peng_ortu'),
                'no_telp' => $this->input->post('no_telp'),
                'thn_msk' => $this->input->post('thn_msk'),
                'sekolah_asal' => $this->input->post('sekolah_asal'),
                'kelas' => $this->input->post('kelas')
            ];

            $this->db->where('id', $id);
            $this->db->update('siswa', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Data akun kamu berhasil diupdate :)
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('siswa/profile');
        }
    }


    public function edit_pass()
    {
        $data['menu'] = 'menu-4';
        $data['title'] = 'Setting Akun';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $this->form_validation->set_rules('old_password', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password Baru', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password tidak sama!', 'min_length' => 'Password terlalu pendek'
        ]);
        $this->form_validation->set_rules('password2', 'Konfirmasi Password Baru', 'required|trim|min_length[3]|matches[password1]', [
            'matches' => 'Password tidak sama!', 'min_length' => 'Password terlalu pendek'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('siswa/edit_pass', $data);
            $this->load->view('template/footer');
        } else {
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('password1');
            if (!password_verify($old_password, $data['user']['password'])) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Password lama salah!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
         </div>'
                );
                redirect('siswa/edit_pass');
            } else {
                if ($old_password == $new_password) {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Password baru tidak boleh sama dengan Password saat ini!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>'
                    );
                    redirect('siswa/edit_pass');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('nis', $this->session->userdata('nis'));
                    $this->db->update('siswa');

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Password berhasil di ubah! :)
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
                    );
                    redirect('siswa/edit_pass');
                }
            }
        }
    }


    public function konseling()
    {

        $data['menu'] = 'menu-1';
        $data['title'] = 'Konseling';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
        $id_siswa = $data['user']['id'];
        $id_kelas = $data['user']['id_kelas'];

        $cek_karyawan = $this->db->get_where('data_kelas', ['id' => $id_kelas])->row_array();
        $karyawan     = $cek_karyawan['id_peng'];

        $data['konseling'] =  $this->db->get_where('konseling', ['id_siswa' => $id_siswa, 'id_peng' => $karyawan])->result_array();
        $data['konsel'] =  $this->db->get_where('balas_konseling', ['id_siswa' => $id_siswa, 'id_peng' => $karyawan])->row_array();

        $this->form_validation->set_rules('siswa', 'siswa', 'required');
        $this->form_validation->set_rules('topik', 'Topik', 'required');
        $this->form_validation->set_rules('solusi', 'Solusi', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('siswa/konseling', $data);
            $this->load->view('template/footer');
        } else {
            $id_san = $this->input->post('siswa');
            $topik = $this->input->post('topik');

            $data = [
                'id_siswa' => $id_san,
                'id_peng' => $karyawan,
                'id_kelas' => $id_kelas,
                'topik' => $topik,
                'solusi' => $this->input->post('solusi'),
                'tgl_pengajuan' => date('Y-m-d'),
                'pembuka' => 'siswa',
                'status' => 'Pending',
            ];

            $this->db->insert('konseling', $data);

            $cek_id = $this->db->get_where('konseling', ['topik' => $topik])->row_array();
            $id = $cek_id['id'];

            $data2 = [
                'pengirim'  => 'siswa',
                'id_peng'  => $karyawan,
                'id_siswa'  => $id_san,
                'balasan'   => $this->input->post('solusi'),
                'tgl'       => date('Y-m-d'),
                'waktu'     => date('h:i:s'),
                'role_konseling' => $id
            ];
            $this->db->insert('balas_konseling', $data2);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data konseling <strong>' . $topik . '</strong> berhasil dibuat :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('siswa/konseling');
        }
    }


    public function balas_konseling()
    {
        $id_konseling = $this->input->get('id');
        $id_konseling = $this->secure->decrypt($id_konseling);
        $data['menu'] = 'menu-1';
        $data['title'] = 'Konseling';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $data['konseling'] =  $this->db->get_where('konseling', ['id' => $id_konseling])->row_array();
        $data['balas_konseling'] =  $this->db->get_where('balas_konseling', ['role_konseling' => $id_konseling]);

        if ($data['konseling']['status']  !== 'Respon siswa') {
            $this->db->set('status', 'Terbaca siswa');
            $this->db->where('id', $id_konseling);
            $this->db->update('konseling');
        }

        $this->form_validation->set_rules('balasan', 'Balasan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('siswa/balas_konseling', $data);
            $this->load->view('template/footer');
        } else {
            $this->db->set('status', 'Respon siswa');
            $this->db->where('id', $id_konseling);
            $this->db->update('konseling');

            $id_peng = $data['konseling']['id_peng'];

            $id = $this->input->post('id');
            $tgl = date('Y-m-d');
            $data = [
                'pengirim'  => 'siswa',
                'id_peng'  => $id_peng,
                'id_siswa'  => $this->input->post('nama'),
                'balasan'   => $this->input->post('balasan'),
                'tgl'       => $tgl,
                'waktu'     => date('h:i:s'),
                'role_konseling' => $id
            ];
            $this->db->insert('balas_konseling', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Balasan Terkirim!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('siswa/balas_konseling?id=' . $this->secure->encrypt($id_konseling) . '');
        }
    }

    public function pelanggaran()
    {

        $data['menu'] = 'menu-5';
        $data['title'] = 'Pelanggaran';
        $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $id_san = $data['user']['id'];

        $data['pelanggaran'] =  $this->db->get_where('pelanggaran', ['id_siswa' => $id_san])->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('siswa/pelanggaran', $data);
        $this->load->view('template/footer');
    }


    
  // payment view in list
  public function payout($offset = NULL, $id = NULL)
  {
    $data['menu'] = 'payout';
    $data['user'] = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
    $data['web'] =  $this->db->get('website')->row_array();
    // Apply Filter
    // Get $_GET variable
    $f = [
        'n' => $data['user']['thn_msk'],
        'r' => $data['user']['nis']
    ];

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

    $data['title'] = 'Data Transaksi Pembayaran';
    $this->load->view('template/header', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('template/topbar', $data);
    $this->load->view('siswa/payout_list', $data);
    $this->load->view('template/footer');
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

      $data['title'] = 'Data Tagihan';
      // $data['main'] = 'payout/payout_add_bebas';
      $this->load->view('payout/payout_add_bebas', $data);
    }
  }

  public function payout_bulan($id = NULL, $student_id = NULL)
  {
    $data['class'] = $this->Student_model->get_class();
    $data['period'] = $this->Period_model->get();
    $data['payment'] = $this->M_pembayaran->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
    $data['student'] = $this->Student_model->get(array('id' => $student_id));
    $data['title'] = 'Data Transaksi Pembayaran';
   
    $this->load->view('payout/payout_add_bulan', $data);
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
    $sis = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
    $kelas = $this->db->get_where('data_kelas', ['id' => $sis['id_kelas']])->row_array();
    $data['user'] = $this->db->get_where('karyawan', ['id' => $kelas['id_peng']])->row_array();
    
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

    $sis = $this->db->get_where('siswa', ['nis' => $this->session->userdata('nis')])->row_array();
    $kelas = $this->db->get_where('data_kelas', ['id' => $sis['id_kelas']])->row_array();
    $data['user'] = $this->db->get_where('karyawan', ['id' => $kelas['id_peng']])->row_array();
    
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
}
