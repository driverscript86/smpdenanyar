<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class Update extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->model('Kredit_model');
    }

    public function update_kelas()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('kelas');
        $peng = $this->input->post('karyawan');

        if (!empty($peng)) {
            $karyawan = $this->input->post('karyawan');
        } else {
            $karyawan = $this->input->post('karyawan1');
        }
        $data = [
            'nama' => $nama,
            'id_pend' => $this->input->post('pendidikan'),
            'id_jurus' => $this->input->post('jurusan'),
            'id_peng' => $karyawan
        ];
        $this->db->where('id', $id);
        $this->db->update('data_kelas', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Kelas <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/kelas');
    }


    public function update_pelanggaran()
    {
        $id    = $this->input->post('id');
        $jen  = $this->input->post('jenis');
        $id_pelang_lama = $this->input->post('id_pelang_lama');

        $pelang = $this->db->get_where('data_pelanggaran', ['id' => $jen])->row_array();

        $takzir = $this->db->get_where('pelanggaran', ['id' => $id])->row_array();
        $nama = $this->db->get_where('siswa', ['id' => $takzir['id_siswa']])->row_array();

        $this->db->set('id_pelang', $jen);
        $this->db->set('tgl', $this->input->post('tanggal'));
        $this->db->where('id', $id);
        $this->db->update('pelanggaran');

        $pelang_lama = $this->db->get_where('data_pelanggaran', ['id' => $id_pelang_lama['id']])->row_array();
        //Mengurangi Point
        $point = $this->db->get_where('siswa', ['id' => $takzir['id_siswa']])->row_array();
        $this->db->set('point', $point['point'] + $pelang_lama['point'] - $pelang['point']);
        $this->db->where('id', $takzir['id_siswa']);
        $this->db->update('siswa');

        $jum_ = $pelang_lama['jumlah'] - 1;

        //Update Jumlah data pelanggaran
        $this->db->set('jumlah', max($jum_, 0));
        $this->db->where('id', $pelang_lama['id']);
        $this->db->update('data_pelanggaran');

        //Update Jumlah data pelanggaran
        $top_pelang = $this->db->get_where('data_pelanggaran', ['id' => $pelang['id']])->row_array();
        $this->db->set('jumlah', $top_pelang['jumlah'] + 1);
        $this->db->where('id', $pelang['id']);
        $this->db->update('data_pelanggaran');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Pelanggaran <strong>' . $nama['nama'] . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/pelanggaran');
    }


    public function tutup_absen_kelas()
    {
        $seg_daftar = $this->uri->segment(4);
        $id      = $this->input->get('id');

        $absen  = $this->db->get_where('daftar_absen', ['id' => $id])->row_array();
        $cek  = $this->db->get_where('absen', ['role_absen' => $id, 'status' => 'Belum Absen'])->row_array();
        $kelas  = $this->db->get_where('data_kelas', ['id' => $absen['id_kelas']])->row_array();

        if ($cek['status']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> Masih ada yang <strong>Belum Absen</strong>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            if ($seg_daftar == 'daftar_absen') {
                    redirect('admin/daftar_absen');
            } else {
                    redirect('admin/absen/' . $absen['tgl'] . '?id=' . $id . '');
            }
        } else {
            $data = [
                'status' => 'Selesai'
            ];
            $this->db->where('id', $id);
            $this->db->update('daftar_absen', $data);

            if ($seg_daftar == 'daftar_absen') {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absen tanggal <strong>' . mediumdate_indo(date($absen['tgl'])) . '</strong> dari kelas <b>' . $kelas['nama'] . '</b> berhasil ditutup.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
                    redirect('admin/daftar_absen');
            } else {
                $this->session->set_flashdata('messageA', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data absen tanggal <strong>' . mediumdate_indo(date($absen['tgl'])) . '</strong> dari kelas <b>' . $kelas['nama'] . '</b> berhasil ditutup.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
                    redirect('admin/absen/' . $absen['tgl'] . '?id=' . $id . '');
            }
        }
    }

    public function update_perizinan()
    {
        $url_seg      = $this->uri->segment(3);
        $id           = $this->input->post('id');

        $id_san = $this->input->post('siswa');
        $jenis = $this->input->post('jenis');
        $cek = $this->db->get_where('siswa', ['id' => $id_san])->row_array();
        $cek_izin = $this->db->get_where('data_perizinan', ['id' => $jenis])->row_array();

        $data = [
            'id_izin' => $jenis,
            'keterangan' => $this->input->post('keterangan'),
            'tgl' => $this->input->post('tanggal'),
            'expired' => $this->input->post('expired')
        ];
        $this->db->where('id', $id);
        $this->db->update('perizinan', $data);
        if ($url_seg == 'siswa') {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Perizinan <strong>' . $cek_izin['nama'] . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('siswa/perizinan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Perizinan <strong>' . $cek_izin['nama'] . '</strong> dari siswa <strong>' . $cek['nama'] . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/perizinan');
        }
    }

    public function update_pending_izin()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('nama');
        $izin  = $this->input->post('izin');
        $data = [
            'status' => 'Proses'
        ];
        $this->db->where('id', $id);
        $this->db->update('perizinan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Data perizinan <strong>' . $nama . '</strong> dengan izin <strong>' . $izin . '</strong> berhasil diproses.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/perizinan');
    }

    public function update_proses_izin()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('nama');
        $izin  = $this->input->post('izin');
        $data = [
            'status' => 'Success'
        ];
        $this->db->where('id', $id);
        $this->db->update('perizinan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Data perizinan <strong>' . $nama . '</strong> dengan izin <strong>' . $izin . '</strong> berhasil diupdate.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/perizinan');
    }

    public function update_data_perizinan()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('izin');
        $data = [
            'nama' => $nama,
            'point' => $this->input->post('point')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_perizinan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data perizinan <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_perizinan');
    }

    public function update_data_month()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('bulan');
        $data = [
            'month_name' => $nama
        ];
        $this->db->where('id', $id);
        $this->db->update('month', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data bulan <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('manage/month');
    }

    public function update_data_pendidikan()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('pendidikan');

        $data = [
            'nama' => $nama,
            'majors' => $this->input->post('majors')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_pendidikan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Pendidikan <strong>' . $nama . '</strong> berhasil diubah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_pendidikan');
    }

    public function update_data_jurusan()
    {
        $id    = $this->input->post('id');
        $nama = $this->input->post('jurusan');
        $data = [
            'nama' => $nama,
            'id_pend' => $this->input->post('pendidikan')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_jurusan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data jurusan <strong>' . $nama . '</strong> berhasil diubah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_jurusan');
    }

    public function data_pembayaran()
    {
        $id    = $this->input->post('id');
        $nama = $this->input->post('nama');
        $data = [
            'nama' => $nama,
            'jumlah' => $this->input->post('jumlah')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_pembayaran', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pembayaran <strong>' . $nama . '</strong> berhasil diubah
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('manage/pembayaran_ppdb');
    }

    public function update_status_absen()
    {
        $id    = $this->input->post('id');
        $status  = $this->input->post('absen');
        $izin  = $this->input->post('izin');

        $cek = $this->db->get_where('absen', ['id' => $id])->row_array();

        if ($status == $cek['status']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        siswa <strong>' . $cek['siswa'] . '</strong> sudah hadir.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>');
                redirect('admin/absen/' . $cek['tgl'] . '?id=' . $cek['role_absen'] . '');
        }

        $this->db->set('ket', $izin);
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('absen');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data siswa <strong>' . $cek['siswa'] . '</strong> berhasil diupdate dengan status <strong>' . $status . '</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/absen/' . $cek['tgl'] . '?id=' . $cek['role_absen'] . '');
    }

    public function tutup_konseling()
    {
        $segmen = $this->uri->segment(3);
        $tgl = date('Y-m-d');
        $id    = $this->input->post('id');
        $nama  = $this->input->post('siswa');
        $topik  = $this->input->post('topik');
        $penutup = $this->input->post('penutup');
        $data = [
            'tgl_tutup' => $tgl,
            'penutup' => $penutup,
            'status' => 'Selesai'
        ];
        $this->db->where('id', $id);
        $this->db->update('konseling', $data);

        if ($segmen == 'admin') {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data Konseling <strong>' . $topik . '</strong> dari <strong>' . $nama . '</strong> berhasil ditutup.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>');
            redirect('admin/konseling');
        } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Konseling <strong>' . $topik . '</strong> berhasil ditutup.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('siswa/konseling');
        }
    }


    public function update_data_pelanggaran()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('jenis');
        $data = [
            'kode' => $this->input->post('kode'),
            'nama' => $nama,
            'point' => $this->input->post('point')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_pelanggaran', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Jenis pelanggaran <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_pelanggaran');
    }

    public function update_data_kursi()
    {
        $id     = $this->input->post('id');
        $nama   = $this->input->post('kursi');
        $kelas = $this->input->post('kelas');

        $cek_kelas = $this->db->get_where('data_kelas', ['id' => $kelas])->row_array();

        $cek = $this->db->get_where('data_kursi', ['nama' => $nama, 'id_kelas' => $kelas])->row_array();

        if ($cek['nama']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data Kursi <strong>' . $nama . '</strong> di kelas <strong>' . $cek_kelas['nama'] . '</strong> sudah ada.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('admin/data_kursi');
        } else {
            $data = [
                'nama' => $nama,
                'tipe' => $this->input->post('tipe'),
                'id_kelas'  => $kelas
            ];
            $this->db->where('id', $id);
            $this->db->update('data_kursi', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data Kursi <strong>' . $nama . '</strong> di kelas <strong>' . $cek_kelas['nama'] . '</strong> berhasil diupdate.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>');
            redirect('admin/data_kursi');
        }
    }

    public function update_isi_kursi()
    {
        $id     = $this->input->post('id');
        $id_san   = $this->input->post('siswa');

        $cek = $this->db->get_where('data_kursi', ['id_siswa' => $id_san])->row_array();
        $nama = $this->db->get_where('siswa', ['id' => $id_san])->row_array();
        $cek1 = $this->db->get_where('data_kursi', ['id' => $id])->row_array();
        $kelas1 = $this->db->get_where('data_kelas', ['id' => $cek1['id_kelas']])->row_array();
        $id_kelas = $kelas1['id'];

        if ($cek['siswa']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            siswa <strong>' . $nama['nama'] . '</strong> sudah punya kursi.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/data_kursi');
        } else {

            $this->db->set('id_siswa', $id_san);
            $this->db->where('id', $id);
            $this->db->update('data_kursi');

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Isi kursi dengan nama <strong>' . $nama['nama'] . '</strong> berhasil diubah.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>'
            );
            redirect('admin/view_kelas/' . $id_kelas . '');
        }
    }

    public function update_isi_kursi_kosong()
    {
        $id     = $this->input->post('id');

        $cek1 = $this->db->get_where('data_kursi', ['id' => $id])->row_array();
        $kelas1 = $this->db->get_where('data_kelas', ['id' => $cek1['id_kelas']])->row_array();
        $id_kelas = $kelas1['id'];

        $this->db->set('id_siswa', 0);
        $this->db->where('id', $id);
        $this->db->update('data_kursi');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Isi kursi berhasil di kosongkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>'
        );
            redirect('admin/view_kelas/' . $id_kelas . '');
    }

    public function update_konseling()
    {
        $segmen = $this->uri->segment(3);
        $id     = $this->input->post('id');

        $data = [
            'topik' => $this->input->post('topik'),
            'solusi' => $this->input->post('solusi')
        ];
        $this->db->where('id', $id);
        $this->db->update('konseling', $data);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data konseling <strong>' . $this->input->post('topik') . '</strong> berhasil diubah.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>'
        );
        if ($segmen == 'siswa') {
            redirect('siswa/konseling');
        } else {
            redirect('admin/konseling');
        }
    }

    public function Logo()
    {
        $gambar        = $_FILES['gambar'];

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('messagelogo', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Logo Header gagal diubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/website');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('website')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['logo']);
        $data = [
            'logo' => $gambar
        ];

        $this->db->update('website', $data);
        $this->session->set_flashdata('messagelogo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Logo Header baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/website');
    }

    public function LogoFav()
    {
        $gambar = $_FILES['fav'];

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|ico|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('fav')) {
                $this->session->set_flashdata('messagelogo', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Logo Favicon gagal diubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/website');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('website')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['fav']);
        $data = [
            'fav' => $gambar
        ];

        $this->db->update('website', $data);
        $this->session->set_flashdata('messagelogo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Logo Favicon baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/website');
    }

    public function imgUser()
    {
        $gambar = $_FILES['imgUser'];

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|ico|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('imgUser')) {
                $this->session->set_flashdata('messagelogo', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Gambar login user gagal diubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/website');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('website')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['img_login']);
        $data = [
            'img_login' => $gambar
        ];

        $this->db->update('website', $data);
        $this->session->set_flashdata('messagelogo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Gambar login user baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/website');
    }

    public function imgAdmin()
    {
        $gambar = $_FILES['imgAdmin'];

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|ico|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('imgAdmin')) {
                $this->session->set_flashdata('messagelogo', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Gambar login admin gagal diubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/website');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('website')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['img_login_admin']);
        $data = [
            'img_login_admin' => $gambar
        ];

        $this->db->update('website', $data);
        $this->session->set_flashdata('messagelogo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Gambar login admin baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/website');
    }



    public function update_karyawan()
    {
        $id    = $this->input->post('id');
        $this->form_validation->set_rules('nama', 'Nama Karyawan', 'required');

        $nama = $this->input->post('nama');
        $data = [
            'id_fingerprint' => $this->input->post('id_fp'),
            'nama' => $nama,
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'alamat' => $this->input->post('alamat'),
            'telp' => $this->input->post('telp'),
            'id_divisi' => $this->input->post('divisi'),
            'dept' => $this->input->post('dept'),
            'intensif' => $this->input->post('intensif'),
            'jam_mengajar' => $this->input->post('jam_mengajar'),
            'nominal_jam' => $this->input->post('nominal_jam'),
            'bpjs' => $this->input->post('bpjs'),
            'koperasi' => $this->input->post('koperasi'),
            'simpanan' => $this->input->post('simpanan'),
            'tabungan' => $this->input->post('tabungan'),
            'id_pend' => $this->input->post('pendidikan'),
            'id_kelas' => $this->input->post('kelas'),
            'status' => $this->input->post('status'),
            'role_id' => $this->input->post('level')

        ];
        $this->db->where('id', $id);
        $this->db->update('karyawan', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
           Data karyawan <strong>' . $nama . '</strong> berhasil diupdate!
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
          </div>');
        redirect('admin/karyawan');
    }



    public function update_kategori_acara()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('nama');
        $uniq  = strtolower($nama);
        $data = [
            'nama' => $nama,
            'uNiq' => preg_replace("/[^A-Za-z0-9 ]/", "", $uniq)
        ];
        $this->db->where('id', $id);
        $this->db->update('kategori_acara', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Kategori Acara <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/kategori_acara');
    }



    public function update_kategori_gallery()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('nama');
        $uniq  = strtolower($nama);
        $data = [
            'nama' => $nama,
            'uNiq' => preg_replace("/[^A-Za-z0-9 ]/", "", $uniq)
        ];
        $this->db->where('id', $id);
        $this->db->update('kategori_gallery', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Kategori Acara <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/kategori_gallery');
    }


    public function gambar_utama()
    {
        $gambar        = $_FILES['gambar'];
        $id = $this->input->post('id');

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('messageimg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Gambar About Gagal di Ubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/utama');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('home')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['img']);
        $data = [
            'img' => $gambar
        ];

        $this->db->update('home', $data);
        $this->session->set_flashdata('messageimg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Gambar baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/utama');
    }


    public function img_about()
    {
        $gambar        = $_FILES['gambar'];
        $id = $this->input->post('id');

        if ($gambar = '') {
        } else {
            $config['upload_path'] = './assets/img/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']  = '8048';
            $config['remove_space'] = TRUE;

            $this->load->library('upload', $config); // Load konfigurasi uploadnya
            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('messageimg', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Gambar About Gagal di Ubah :(
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  </div>');
                redirect('admin/about');
            } else {
                $gambar = $this->upload->data('file_name');
            }
        }
        $g =  $this->db->get('about')->row_array();
        //hapus gambar di path
        unlink("./assets/img/" . $g['img']);

        $this->db->set('img', $gambar);
        $this->db->where('id', $id);
        $this->db->update('about');
        $this->session->set_flashdata('messageimg', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Gambar baru berhasil diubah :)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/about');
    }


    public function link_sosmed()
    {
        $id    = $this->input->post('id');

        $data = [
            'link_fb' => $this->input->post('link_fb'),
            'link_ig' => $this->input->post('link_ig'),
            'link_tw' => $this->input->post('link_tw')
        ];
        $this->db->where('id', $id);
        $this->db->update('website', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>Success!</strong>  Data link sosmed website berhasil diupdate!
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
          </div>');
        redirect('admin/website');
    }



    private function ppdbEmail($id)
    {
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
        $data['web'] =  $this->db->get('website')->row_array();

        $data['ppdb'] =  $this->db->get_where('ppdb', ['id' => $id])->row_array();
        $email = $data['ppdb']['email'];

        $web = $data['web'];

        $esen =  $this->db->get('email_sender')->row_array();
        $mail = new PHPMailer(true);
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $esen['host'];                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $esen['email'];                     // SMTP username
        $mail->Password   = $esen['password'];                               // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = $esen['port'];
        // $config = [
        //     'protocol'  => $esen['protocol'],
        //     'smtp_host' => $esen['host'],
        //     'smtp_user' => $esen['email'],
        //     'smtp_pass' => $esen['password'],
        //     'smtp_port' => $esen['port'],
        //     'mailtype'  => 'html',
        //     'charset'   => $esen['charset'],
        //     'newline'   => "\r\n"
        // ];


        // $this->load->library('email', $config);
        // $this->email->set_newline("\r\n");
        // $this->email->set_header('Content-Type', 'text/html');

        $mail->setFrom($esen['email'], $web['nama']);
        $mail->addReplyTo($email);
        $mail->addAddress($email, $web['nama']);

        $data['link_web'] = base_url();
        $data['email'] = $email;

        $body = $this->load->view('email/ppdb', $data, TRUE);
        $mail->isHTML(true);
        $mail->Subject = ('Selamat Anda di Konfirmasi');
        $mail->Body = ($body);

        if ($mail->send()) {
            return true;
        } else {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            die;
        }
    }

    public function konfirmasi_ppdb()
    {
        
        $find = array("https://","http://");
        $replace = "www.";
        $arr = site_url();
        $site = str_replace($find,$replace,$arr);

        $id    = $this->input->get('id');
        $staff    = $this->input->get('staff');
        $data = [
            'status' => 1,
            'staff_konfirmasi' => $staff
        ];

        $this->db->where('id', $id);
        $this->db->update('ppdb', $data);

        $ppdb =  $this->db->get_where('ppdb', ['id' => $id])->row_array();
        $no = $ppdb['no_hp'];
        $pesan = 'Pendaftaran PPDB anda telah berhasil dengan data :

Nama : '.$ppdb['nama'].'
Nomor Pendaftaran : '.$ppdb['no_daftar'].'
NIS : '.$ppdb['nis'].'
Email : '.$ppdb['email'].'

Untuk pengumuman PPDB akan di infokan melalui website :
' . $site . '

Terimakasih.';
        wa_api($no, $pesan);

        $this->ppdbEmail($id);



        $this->session->set_flashdata('messageInfo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data ppdb berhasil di konfirmasi.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/edit_ppdb?id=' . $id);
    }


    public function batal_konfirmasi_ppdb()
    {
        $id    = $this->input->get('id');

        $this->db->set('status', 0);
        $this->db->where('id', $id);
        $this->db->update('ppdb');
        $this->session->set_flashdata('messageInfo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data ppdb berhasil di batalkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/edit_ppdb?id=' . $id);
    }

    public function tolak_ppdb()
    {
        $id    = $this->input->post('id');

        $data = [
            'alasan' => $this->input->post('alasan'),
            'status' => 2
        ];

        $this->db->where('id', $id);
        $this->db->update('ppdb', $data);
        $this->session->set_flashdata('messageInfo', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data ppdb berhasil di batalkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
            redirect('admin/edit_ppdb?id=' . $id);
    }

    public function update_data_divisi()
    {
        $id    = $this->input->post('id');
        $nama  = $this->input->post('nama');
        $data = [
            'nama' => $nama,
            'gaji' => $this->input->post('gaji'),
            'tunjangan' => $this->input->post('tunjangan'),
            'role_id' => $this->input->post('level')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_divisi', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data divisi <strong>' . $nama . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_Divisi');
    }


    public function update_data_cicilan()
    {
        $id    = $this->input->post('id');
        $nama = $this->input->post('nama');
        $peng = $this->input->post('karyawan');
        if (!empty($peng)) {
            $karyawan = $this->input->post('karyawan');
        } else {
            $karyawan = $this->input->post('karyawan1');
        }

        $this->db->where('id', $karyawan);
        $cek_peng =  $this->db->get('karyawan')->row_array();

        $data = [
            'nama' => $nama,
            'id_peng' => $karyawan,
            'nominal' =>  $this->input->post('nominal'),
            'tenor' =>  $this->input->post('tenor')
        ];
        $this->db->where('id', $id);
        $this->db->update('data_cicilan', $data);

        //Status Lunas
        $get_cicilan = $this->db->get_where('data_cicilan', ['id' => $id])->row_array();
        if ($get_cicilan['tenor'] == 0) {
            $tgl = date('Y-m-d');
            $this->db->set('tgl_lunas', $tgl);
            $this->db->set('status', 'Lunas');
            $this->db->where('id', $id);
            $this->db->update('data_cicilan');
        }
        
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data cicilan <strong>' . $nama . '</strong> dengan nama <strong>' . $cek_peng['nama'] . '</strong> berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/data_cicilan');
    }

    public function tutup_absen_pegawai()
    {
        $segmen = $this->uri->segment(3);
        $tgll = $this->uri->segment(4);
        $id    = $this->input->get('id');

        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('data_absen_pegawai');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data absen pegawai tanggal <strong>' . mediumdate_indo(date($tgll)) . '</strong> berhasil di tutup.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        if ($segmen == 'daftar_absen') {
            redirect('admin/absen_pegawai');
        } else if ($segmen == 'view_absen') {
            redirect('admin/view_absen_pegawai/' . $tgll . '?id=' . $id . '');
        }
        
    }

    public function batal_absen_pegawai()
    {
        $tgl = $this->uri->segment(3);
        $id    = $this->input->get('id');

        $this->db->set('status', 0);
        $this->db->where('id', $id);
        $this->db->update('data_absen_pegawai');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data absen pegawai tanggal <strong>' . mediumdate_indo(date($tgl)) . '</strong> berhasil di batalkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/absen_pegawai');
    }


    public function update_status_absen_pegawai()
    {
        $id    = $this->input->post('id');
        $status  = $this->input->post('absen');

        $cek = $this->db->get_where('absen_pegawai', ['id' => $id])->row_array();
        $nama = $this->db->get_where('karyawan', ['id' => $cek['id_peng']])->row_array();

        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('absen_pegawai');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data absen pegawai <strong>' . $nama['nama'] . '</strong> berhasil di update.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/view_absen_pegawai/' . $cek['tgl'] . '?id=' . $cek['role_absen'] . '');
    }

    public function update_time_absen_pegawai()
    {
        $id    = $this->input->post('id');
        $jam_keluar  = $this->input->post('jam_keluar');

        $cek = $this->db->get_where('absen_pegawai', ['id' => $id])->row_array();
        $nama = $this->db->get_where('karyawan', ['id' => $cek['id_peng']])->row_array();

        $date1 = new DateTime($cek['tgl'] . 'T' . $cek['jam_masuk']);
        $date2 = new DateTime($cek['tgl'] . 'T' . $jam_keluar);

        $diff = $date2->diff($date1);

        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);

        $this->db->set('jam_keluar', $jam_keluar);
        $this->db->set('sum_jam', $hours);
        $this->db->where('id', $id);
        $this->db->update('absen_pegawai');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data absen pegawai <strong>' . $nama['nama'] . '</strong> berhasil di update.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/view_absen_pegawai/' . $cek['tgl'] . '?id=' . $cek['role_absen'] . '');
    }

    public function batal_penggajian()
    {
        $id    = $this->input->get('id');
        $cek = $this->db->get_where('penggajian', ['id' => $id])->row_array();
        $nama = $this->db->get_where('karyawan', ['id' => $cek['id_peng']])->row_array();

        $this->db->set('status', 0);
        $this->db->where('id', $id);
        $this->db->update('penggajian');

        //Status Lunas
        $get_cicilan = $this->db->get_where('data_cicilan', ['id_peng' => $cek['id_peng'], 'tenor' => 0])->row_array();
        if ($get_cicilan['tenor'] == 0) {
            $this->db->set('tgl_lunas', 0);
            $this->db->set('status', 'Belum Lunas');
            $this->db->where('id_peng', $nama['id']);
            $this->db->where('tenor', 0);
            $this->db->update('data_cicilan');
        }

        $this->db->set('tenor', 'tenor+1', FALSE);
        $this->db->where('id_peng', $nama['id']);
        $this->db->update('data_cicilan');

        $kredit = $this->db->get_where('kredit', ['gaji' => 1, 'user_user_id' => $id])->row_array();
      
        $this->db->where('kredit_id', $kredit['kredit_id']);
        $this->db->delete('kredit');
        
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data penggajian <strong>' . $nama['nama'] . '</strong> berhasil di batalkan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/penggajian');
    }

    public function update_penggajian()
    {
        $id = $this->input->post('id');
        $id_peng = $this->input->post('id_peng');
        $nama = $this->db->get_where('karyawan', ['id' => $id_peng])->row_array();

        //sum hdir
        $get_penggajian = $this->db->get_where('penggajian', ['id' => $id])->row_array();
        $tgl_akhir = $get_penggajian['tgl_akhir'];
        
        $this->db->set('tgl_akhir', $tgl_akhir);
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('penggajian');

        $this->db->set('tenor', 'tenor-1', FALSE);
        $this->db->where('id_peng', $nama['id']);
        $this->db->update('data_cicilan');

        //Status Lunas
        $get_cicilan = $this->db->get_where('data_cicilan', ['id_peng' => $id_peng, 'tenor' => 0])->row_array();
        if ($get_cicilan['tenor'] == 0) {
            $tgl = date('Y-m-d');
            $this->db->set('tgl_lunas', $tgl);
            $this->db->set('status', 'Lunas');
            $this->db->where('id_peng', $nama['id']);
            $this->db->where('tenor', 0);
            $this->db->update('data_cicilan');
        }

        $guru = $this->db->get_where('karyawan', ['id' => $id_peng])->row_array();
        $divisi = $this->db->get_where('data_divisi', ['id' => $nama['id_divisi']])->row_array();
        $data_cicilan = $this->db->get_where('data_cicilan', ['id_peng' => $id_peng, 'tenor !=' => 0])->result_array();
        $penggajian = $this->db->get('penggajian')->result_array();
        foreach($penggajian as $d){
        $this->db->where('tgl >=', $d['tgl_awal']);
        $this->db->where('tgl <=', $d['tgl_akhir']);
        $this->db->where('id_peng', $d['id_peng']);
        $this->db->where('status', '1');
        $sum_hadir = $this->db->get('absen_pegawai')->num_rows();
        //sum Total Jam
        $this->db->select_sum('sum_jam');
        $this->db->where('tgl >=', $d['tgl_awal']);
        $this->db->where('tgl <=', $d['tgl_akhir']);
        $sum_jam = $this->db->get_where('absen_pegawai', ['id_peng' => $d['id_peng']])->row_array();
        }
        $sum = 0;
        foreach($data_cicilan as $c){
            $sum += $c['nominal'];
        }
        $jumlah_gaji = $divisi['gaji'] + $divisi['tunjangan'] + $guru['intensif'] * $sum_hadir + $guru['nominal_jam'] * $sum_jam['sum_jam'];
        $sum_bkst = $guru['bpjs'] + $guru['koperasi'] + $guru['simpanan'] + $guru['tabungan'];
        $total_diterima = $jumlah_gaji - $sum - $sum_bkst;
        $params['kredit_date'] = date('Y-m-d');
        $params['kredit_value'] = $total_diterima;
        $params['user_user_id'] = $id;
        $params['kredit_desc'] = 'Penggajian';
        $params['kredit_input_date'] = date('Y-m-d H:i:s');
        $params['kredit_last_update'] = date('Y-m-d H:i:s');
        $params['gaji'] = 1;
        $this->Kredit_model->add($params);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Penggajian <strong>' . $nama['nama'] . '</strong> berhasil diupdate :)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>');
        redirect('admin/penggajian');
    }


    public function password_siswa()
    {
        $id    = $this->input->post('id');
        $psswrd = $this->input->post('password');

        $this->db->set('password', password_hash($psswrd, PASSWORD_DEFAULT));
        $this->db->where('id', $id);
        $this->db->update('siswa');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Password <strong>Siswa</strong> berhasil di Update.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/update_siswa?id=' . $id);
    }

    public function password_karyawan()
    {
        $id    = $this->input->post('id');
        $psswrd = $this->input->post('password');

        $this->db->set('password', password_hash($psswrd, PASSWORD_DEFAULT));
        $this->db->where('id', $id);
        $this->db->update('karyawan');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Password <strong>Karyawan</strong> berhasil di Update.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/update_karyawan?id=' . $id);
    }


    public function password_ppdb()
    {
        $id    = $this->input->post('id');
        $psswrd = $this->input->post('password');

        $this->db->set('password', password_hash($psswrd, PASSWORD_DEFAULT));
        $this->db->where('id', $id);
        $this->db->update('ppdb');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Password baru berhasil di Update.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('admin/edit_ppdb?id=' . $id);
    }

    public function update_periode()
    {
        $id    = $this->input->post('id');
        if(!empty($this->input->post('period_end'))){
            $period_end = $this->input->post('period_end');
        }else{
            $period_end = $this->input->post('period_start')+1;
        }

        $data = [
            'period_start' =>  $this->input->post('period_start'),
            'period_end' => $period_end,
            'period_status' => $this->input->post('status')

        ];
        $this->db->where('id', $id);
        $this->db->update('period', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data period berhasil diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>');
        redirect('manage/period');
    }

    public function reset_point()
    {
      $id = $this->input->get('id');
      $this->db->set('point', 100);
      $this->db->where('id', $id);
      $this->db->update('siswa');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Reset point ke 100 berhasil.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
      redirect('admin/daftar_siswa');
    }

    public function edit_keluaran()
    {
    $id = $this->input->post('id');
    $data = [
        'kredit_desc' =>  $this->input->post('kredit_desc'),
        'kredit_value' =>  $this->input->post('kredit_value'),
        'kredit_last_update' =>  date('Y-m-d H:i:s')
    ];
    $this->db->where('kredit_id', $id);
    $this->db->update('kredit', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Data Pengeluaran berhasil di update.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
      redirect('manage/keluaran');
    }

    public function edit_masukan()
    {
    $id = $this->input->post('id');
    $data = [
        'debit_desc' =>  $this->input->post('debit_desc'),
        'debit_value' =>  $this->input->post('debit_value'),
        'debit_last_update' =>  date('Y-m-d H:i:s')
    ];
    $this->db->where('debit_id', $id);
    $this->db->update('debit', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Data Pemasukan berhasil di update.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
      redirect('manage/masukan');
    }

    public function withdraw()
    {
    $id = $this->input->post('id');
    $jumlah = $this->input->post('jumlah');
    $get_staff = $this->db->get_where('karyawan', ['id' => $id])->row_array();
    if($jumlah > $get_staff['jumlah_reff']){
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Jumlah point referral tidak cukup untuk di Withdraw
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('admin/karyawan');
    }
    $total = $get_staff['jumlah_reff'] - $jumlah;
    
    $this->db->set('jumlah_reff', $total);
    $this->db->where('id', $id);
    $this->db->update('karyawan');
      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Withdraw point referral berhasil.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
      redirect('admin/karyawan');
    }

    public function update_raport()
    {
    $id = $this->input->post('id');
    $rap = $this->input->post('raport');
    $this->db->set('raport', $rap);
    $this->db->where('id', $id);
    $this->db->update('ppdb');
      $this->session->set_flashdata('messageRap', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Raport berhasil di update.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>');
      redirect('admin/edit_ppdb?id='.$id);
    }

    
    public function faq()
    {
        $id = $this->input->post('id');
        $data = [
                'pertanyaan'    => $this->input->post('pertanyaan'),
                'jawaban'       => $this->input->post('jawaban'),
                'role'          => $this->input->post('role')
            ];
        
        $this->db->where('id', $id);
        $this->db->update('ppdb', $data);
          $this->session->set_flashdata('messageRap', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Faq berhasil di update.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>');
          redirect('admin/faq');
    }
}
