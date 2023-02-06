<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Manage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $users = $this->session->userdata('email');
        $this->load->model(['Main_model', 'Student_model', 'Kredit_model', 'Debit_model', 'Period_model', 'Bulan_model', 'Bebas_model', 'Bebas_pay_model', 'Logs_model', 'Pos_model']);
        $this->load->helper('tgl_indo');

        $user = $this->db->get_where('karyawan', ['email' => $users])->row_array();
        if ($user['role_id'] !== '1' && $user['role_id'] !== '5') {
            redirect('admin');
        } elseif ($user['role_id'] < '1') {
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
    }

    public function month()
    {
        $data['menu'] = 'menu-2';
        $data['title'] = 'Data Bulan';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $this->db->order_by('id', 'ASC');
        $data['month'] =  $this->db->get('month')->result_array();

        $this->form_validation->set_rules('bulan', 'Bulan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar_admin', $data);
            $this->load->view('template/topbar_admin', $data);
            $this->load->view('admin/manage/month', $data);
            $this->load->view('template/footer_admin');
        } else {
            $nama = $this->input->post('bulan');

            $data = [
                'month_name' => $nama,
            ];
            $this->db->insert('month', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data bulan <strong>' . $nama . '</strong> berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('manage/month');
        }
    }

    public function period()
    {
        $data['menu'] = 'menu-2';
        $data['title'] = 'Data Periode';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $this->db->order_by('id', 'ASC');
        $data['period'] =  $this->db->get('period')->result_array();

        $this->form_validation->set_rules('period_start', 'Periode Awal', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar_admin', $data);
            $this->load->view('template/topbar_admin', $data);
            $this->load->view('admin/manage/period', $data);
            $this->load->view('template/footer_admin');
        } else {

            $data = [
                'period_start' =>  $this->input->post('period_start'),
                'period_end' => $this->input->post('period_end'),
                'period_status' => $this->input->post('status')

            ];
            $this->db->insert('period', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data periode berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('manage/period');
        }
    }


	// kredit view in list
	public function Keluaran($offset = NULL)
	{
        $data['menu'] = 'Keluaran';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
		// Apply Filter
		// Get $_GET variable
		$f = $this->input->get(NULL, TRUE);

		$data['f'] = $f;

		$params = array();
		// Nip
		if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
			$params['kredit_desc'] = $f['n'];
		}

		$params['limit'] = 5;
		$params['offset'] = $offset;
        $this->db->where('gaji !=', 1);
		$data['kredit'] = $this->Kredit_model->get($params);

		$data['title'] = 'Pengeluaran Umum';
		$this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/manage/keluaran', $data);
        $this->load->view('template/footer_admin');
	}

	// Add kredit and Update
	public function add_keluaran($id = NULL)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kredit_date', 'Tanggal', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kredit_value', 'Nilai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kredit_desc', 'Keterangan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

		if ($_POST and $this->form_validation->run() == TRUE) {

			if ($this->input->post('kredit_id')) {
				$params['kredit_id'] = $this->input->post('kredit_id');
			} else {
				$params['kredit_input_date'] = date('Y-m-d H:i:s');
			}

			$params['kredit_date'] = $this->input->post('kredit_date');
			$params['kredit_value'] = $this->input->post('kredit_value');
			$params['kredit_desc'] = $this->input->post('kredit_desc');
			$params['kredit_last_update'] = date('Y-m-d H:i:s');
			$params['user_user_id'] = $this->session->userdata('uid');

			$status = $this->Kredit_model->add($params);
			$paramsupdate['kredit_id'] = $status;
			$this->Kredit_model->add($paramsupdate);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Pengeluaran berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
			redirect('manage/keluaran');
		} else {
			redirect('manage/keluaran');
		}
	}



	// debit view in list
	public function masukan($offset = NULL)
	{
        $data['menu'] = 'masukan';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();
		// Apply Filter
		// Get $_GET variable
		$f = $this->input->get(NULL, TRUE);

		$data['f'] = $f;

		$params = array();
		// Nip
		if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
			$params['debit_desc'] = $f['n'];
		}

		$params['limit'] = 5;
		$params['offset'] = $offset;
		$data['debit'] = $this->Debit_model->get($params);

		$data['title'] = 'Pemasukan Umum';
		$this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/manage/masukan', $data);
        $this->load->view('template/footer_admin');
	}

	// Add debit and Update
	public function add_masukan($id = NULL)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('debit_date', 'Tanggal', 'trim|required|xss_clean');
		$this->form_validation->set_rules('debit_value', 'Nilai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('debit_desc', 'Keterangan', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

		if ($_POST and $this->form_validation->run() == TRUE) {

			if ($this->input->post('debit_id')) {
				$params['debit_id'] = $this->input->post('debit_id');
			} else {
				$params['debit_input_date'] = date('Y-m-d H:i:s');
			}

			$params['debit_date'] = $this->input->post('debit_date');
			$params['debit_value'] = $this->input->post('debit_value');
			$params['debit_desc'] = $this->input->post('debit_desc');
			$params['debit_last_update'] = date('Y-m-d H:i:s');
			$params['user_user_id'] = $this->session->userdata('uid');

			$status = $this->Debit_model->add($params);
			$paramsupdate['debit_id'] = $status;
			$this->Debit_model->add($paramsupdate);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Pengeluaran berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
			redirect('manage/masukan');
		} else {
			redirect('manage/masukan');
		}
	}

    public function data_pembayaran()
    {
        $data['menu'] = 'pembayaran_ppdb';
        $data['title'] = 'Pembayaran PPDB';
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $data['pembayaran'] =  $this->db->get('data_pembayaran')->result_array();

        $this->form_validation->set_rules('nama', 'Nama pembayaran', 'required');
        $this->form_validation->set_rules('jumlah', 'Nominal', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
                    if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
            $this->load->view('template/topbar_admin', $data);
            $this->load->view('admin/manage/pem_ppdb', $data);
            $this->load->view('template/footer_admin');
        } else {
            $nama = $this->input->post('nama');
            $data = [
                'nama' => $nama,
                'jumlah' => $this->input->post('jumlah')
            ];
            $this->db->insert('data_pembayaran', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pembayaran <strong>' . $nama . '</strong> berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('manage/pembayaran_ppdb');
        }
    }

    // pos view in list
    public function pos($offset = NULL)
    {
        $data['menu'] = 'pos';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $f = $this->input->get(NULL, TRUE);

        $data['f'] = $f;

        $params = array();
        // Nip
        if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
            $params['pos_name'] = $f['n'];
        }

        $params['limit'] = 10;
        $params['offset'] = $offset;
        $data['pos'] = $this->Pos_model->get($params);

        $data['title'] = 'Nama Pembayaran';
        $this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/manage/pos_list', $data);
        $this->load->view('template/footer_admin');
    }

    // Add pos and Update
    public function add_pos($id = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pos_name', 'Pos Bayar', 'trim|required|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST and $this->form_validation->run() == TRUE) {

            if ($this->input->post('pos_id')) {
                $params['pos_id'] = $this->input->post('pos_id');
            }

            $params['pos_name'] = $this->input->post('pos_name');
            $params['pos_description'] = $this->input->post('pos_description');

            $status = $this->Pos_model->add($params);
            $paramsupdate['pos_id'] = $status;
            $this->Pos_model->add($paramsupdate);


            // activity log
            $this->Logs_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Pos Bayar',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:null;Title:' . $params['pos_name']
                )
            );
            if ($this->input->post('pos_id')) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data pembayaran <strong>' . $params['pos_name'] . '</strong> berhasil diupdate :)
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
                redirect('manage/pos');
            }else{
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pembayaran <strong>' . $params['pos_name'] . '</strong> berhasil ditambahkan :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('manage/pos');
            }
        } else {
            redirect('manage/pos');
        }
    }


	// payment view in list
	public function report($offset = NULL)
	{
		$data['menu'] = 'report';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
		
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		// Date start
		if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
			$params['date_start'] = $q['ds'];
		}

		// Date end
		if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
			$params['date_end'] = $q['de'];
		}


		$paramsPage = $params;
		$data['period'] = $this->Period_model->get($params);
		$data['student'] = $this->Bulan_model->get(array('group' => true));
		$data['bulan'] = $this->Bulan_model->get($params);
		$data['month'] = $this->Bulan_model->get(array('grup' => true));
		$data['py'] = $this->Bulan_model->get(array('paymentt' => true));
		$data['bebas'] = $this->Bebas_model->get(array('grup' => true));
		$data['free'] = $this->Bebas_model->get($params);
		$data['dom'] = $this->Bebas_pay_model->get($params);

        $data['bulan'] = $this->Bulan_model->get($params);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_pay_model->get($params);
		$data['kredit'] = $this->Kredit_model->get($params);
		$data['debit'] = $this->Debit_model->get($params);


		$config['base_url'] = site_url('manage/report/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['total_rows'] = count($this->Bulan_model->get($paramsPage));

		$data['title'] = 'Laporan Keuangan';
        $this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/manage/report_list', $data);
        $this->load->view('template/footer_admin');
	}
  

	public function report_kelas()
	{
        
        $data['menu'] = 'report_kelas';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();
		$param = array();
		$stu = array();
		$free = array();


		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
			$param['period_id'] = $q['p'];
			$stu['period_id'] = $q['p'];
			$free['period_id'] = $q['p'];
		}

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id'] = $q['c'];
			$param['class_id'] = $q['c'];
			$stu['class_id'] = $q['c'];
			$free['class_id'] = $q['c'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
			$param['majors_id'] = $q['k'];
			$stu['majors_id'] = $q['k'];
			$free['majors_id'] = $q['k'];
		}

        if (isset($q['pd']) && !empty($q['pd']) && $q['pd'] != '') {
            $params['id_pend'] = $q['pd'];
			$param['id_pend'] = $q['pd'];
			$stu['id_pend'] = $q['pd'];
			$free['id_pend'] = $q['pd'];

            $data['pendkkn'] = $this->db->get_where('data_pendidikan', ['id' => $q['pd']])->row_array();
        }


		$param['paymentt'] = TRUE;
		$params['grup'] = TRUE;
		$stu['group'] = TRUE;

		$data['period'] = $this->Period_model->get($params);
        $data['pend'] = $this->Student_model->get_pend($params);
		$data['class'] = $this->Student_model->get_class($params);
		$data['majors'] = $this->Student_model->get_majors($params);
		$data['student'] = $this->Bulan_model->get($stu);
		$data['bulan'] = $this->Bulan_model->get($free);
		$data['month'] = $this->Bulan_model->get($params);
		$data['py'] = $this->Bulan_model->get($param);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_model->get($free);

		$config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$data['title'] = 'Rekapitulasi';
        $this->load->view('template/header', $data);
        if ($data['user']['role_id'] !== '1') {
            $this->load->view('template/sidebar_karyawan', $data);
        }else{
            $this->load->view('template/sidebar_admin', $data);
        }
        $this->load->view('template/topbar_admin', $data);
        $this->load->view('admin/manage/report_kelas', $data);
        $this->load->view('template/footer_admin');
	}

}
