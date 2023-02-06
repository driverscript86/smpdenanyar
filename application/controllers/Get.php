<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Main_model', 'M_payment']);
    }

    public function getsiswa($id)
    {
        // Search term
        $searchTerm = $this->input->post('search');

        // Get siswa
        $response = $this->Main_model->getsiswa($id, $searchTerm);


        echo json_encode($response);
    }


    public function getsiswa_pendidikan()
    {
        $sesi = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $pendidikan = $sesi['pendidikan'];
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getsiswa_pendidikan($pendidikan, $searchTerm);

        echo json_encode($response);
    }

    public function getKaryawan()
    {
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getKaryawan($searchTerm);

        echo json_encode($response);
    }


    public function getsiswa_kelas()
    {
        $kelas = $this->uri->segment(3);
        // Search term
        $searchTerm = $this->input->post('search');
        // Get siswa
        $response = $this->Main_model->getsiswa_kelas($kelas, $searchTerm);

        echo json_encode($response);
    }


    public function get_point()
    {
        $jenis = $this->input->post('jenis');
        if (isset($jenis)) {
            $this->db->where('id', $jenis);
            $query  =  $this->db->get('data_pelanggaran');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                foreach ($result as $value) {
                    $options  = $value['point'];
                }
                echo $options;
            }
        }
    }

    public function get_pelanggaran()
    {
        $jenis = $this->input->post('jenis');
        if (isset($jenis)) {
            $this->db->where('id', $jenis);
            $query  =  $this->db->get('data_pelanggaran');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                foreach ($result as $value) {
                    $options  = $value['nama'];
                }
                echo $options;
            }
        }
    }

    public function get_izin()
    {
        $absen = $this->input->post('absen');
        if (isset($absen)) {
            $query  =  $this->db->get('data_perizinan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Perizinan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_majors()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_jurusan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Jurusan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_id_majors()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id', $pendidikan);
            $query  =  $this->db->get('data_pendidikan');
            $result =  $query->row_array();
            $options = $result['majors'];
            echo $options;
        }
    }

    public function get_kelas_majors()
    {
        $majors = $this->input->post('majors');
        if (isset($majors)) {
            $this->db->where('id_jurus', $majors);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kelas_all()
    {
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kelas_ajax()
    {
        $f = $this->input->get(NULL, TRUE);
        $data['f'] = $f;
        $params = array();
        // Nip
        if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
            $params['class_id'] = $f['pr'];
        }

        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option' . (isset($f['pr']) and $f['pr'] == $value['id']) ? 'selected' : '' . ' value="' . $value['id'] . '">' . $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kelas()
    {
        $role_id = $this->input->post('role_id');
        $id_peng = $this->input->post('id_peng');
        $pendidikan = $this->input->post('pendidikan');
        if (isset($pendidikan)) {
            if ($role_id !== '1') {
                $this->db->where('id_peng', $id_peng);
            }
            $this->db->where('id_pend', $pendidikan);
            $query  =  $this->db->get('data_kelas');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected value="">- Pilih Kelas -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota()
    {
        $seg = $this->uri->segment(3);
        $prov = $this->input->post('prov');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                if ($seg == 'daftar') {
                    $options .= '<option selected value="">- Pilih provinsi saja -</option>';
                } else {
                    $options .= '<option selected disabled>- Pilih Kota -</option>';
                }
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota_ppdb()
    {
        $prov = $this->input->post('prov');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Kota -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kec()
    {
        $kab = $this->input->post('kab');
        if (isset($kab)) {
            $this->db->order_by('nama', 'asc');
            $this->db->where('id_kab', $kab);
            $query  =  $this->db->get('kecamatan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Kecamatan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kec'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kel()
    {
        $kec = $this->input->post('kec');
        if (isset($kec)) {
            $this->db->order_by('nama', 'asc');
            $this->db->where('id_kec', $kec);
            $query  =  $this->db->get('kelurahan');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Kelurahan -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['id_kel'] . '">' .
                        $value['nama'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_kota_edit()
    {
        $prov = $this->input->post('prov1');
        if (isset($prov)) {
            $this->db->order_by('nama_kab', 'asc');
            $this->db->where('id_prov', $prov);
            $query  =  $this->db->get('kabupaten');
            $result =  $query->result_array();
            if (isset($result[0]) && is_array($result)) {
                $options = '';
                $options .= '<option selected disabled>- Pilih Kota -</option>';
                foreach ($result as $value) {
                    $options  .= '<option value="' . $value['nama_kab'] . '">' .
                        $value['nama_kab'] . '</option>';
                }
                echo $options;
            }
        }
    }

    public function get_ket_point()
    {
        $id = $this->input->post('jenis');
        if (isset($id)) {
            $this->db->where('id', $id);
            $query  =  $this->db->get('data_perizinan')->row_array();
            $options['div'] = '<div class="alert alert-dark" role="alert">
                                Jika Expired point berkurang -' . $query['point'] . '
                            </div>';
            $options['id'] = $id;
            echo json_encode($options);
        }
    }

    public function get_jenis_pay()
    {
        $chanel = $this->M_payment->get_chanel();

        if (isset($chanel[0]) && is_array($chanel)) {
            $options = '<div class="row mb-3">
                            <h5>Virtual Account Bank :</h5>';
            foreach ($chanel as $value) {
                if ($value['active'] == true) {
                    if ($value['group'] == 'Virtual Account') {
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="' . $value['code'] . '" value="' . $value['code'] . '"/>
                                    <label for="' . $value['code'] . '" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                               <img src="' . $value['icon_url'] . '" alt="' . $value['icon_url'] . '" width="80" height="35"/>
                                        </div>
                                            <p class="text-center">' . $value['code'] . '</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            $options .= '<div class="row mb-3">
                            <h5>Convenience Store :</h5>';
            foreach ($chanel as $value) {
                if ($value['active'] == true) {
                    if ($value['group'] == 'Convenience Store') {
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="' . $value['code'] . '" value="' . $value['code'] . '"/>
                                    <label for="' . $value['code'] . '" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                            <img src="' . $value['icon_url'] . '" alt="' . $value['icon_url'] . '" width="80" height="35">
                                        </div>
                                        <p class="text-center">' . $value['code'] . '</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            $options .= '<div class="row mb-3">
                            <h5>E-Wallet :</h5>';
            foreach ($chanel as $value) {
                if ($value['active'] == true) {
                    if ($value['group'] == 'E-Wallet') {
                        $options .= '<input type="checkbox" name="pay[]" class="cb" id="' . $value['code'] . '" value="' . $value['code'] . '"/>
                                    <label for="' . $value['code'] . '" class="card bg shadow col-md-4">
                                        <div class="card-body">
                                            <img src="' . $value['icon_url'] . '" alt="' . $value['icon_url'] . '" width="80" height="35">
                                        </div>
                                        <p class="text-center">' . $value['name'] . '</p>
                                    </label>';
                    }
                }
            }
            $options .= '</div>';
            echo $options;
        }
    }
}
