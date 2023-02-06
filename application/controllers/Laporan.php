<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->library('Pdf');
    }

    function encode_img_base64($img_path = false, $img_type = 'jpg'){
        if( $img_path ){
            //convert image into Binary data
            $img_data = fopen ( $img_path, 'rb' );
            $img_size = filesize ( $img_path );
            $binary_image = fread ( $img_data, $img_size );
            fclose ( $img_data );
    
            //Build the src string to place inside your img tag
            $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", base64_encode($binary_image));
    
            return $img_src;
        }
    
        return false;
    }

    public function laporan_perizinan()
    {
        $data['title'] = 'Laporan Perizinan';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id_rib     = $this->input->post('pendidikan');
        $id_kam     = $this->input->post('kelas');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $siswa = $this->db->get_where('siswa', ['id_kelas' => $id_kam])->row_array();
        $pendidikan = $this->db->get_where('data_pendidikan', ['id' => $id_rib])->row_array();
        $kelas = $this->db->get_where('data_kelas', ['id' => $id_kam])->row_array();
        $jurus = $this->db->get_where('data_jurusan', ['id_pend' => $pendidikan['id']])->row_array();
        
        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $tgl_akhir);
        $this->db->where('id_kelas', $id_kam);

        $data['laporan'] = $this->db->get('perizinan')->result_array();
        if($pendidikan['majors'] == 1){
            $data['jurus'] = ' - '.$jurus['nama'];
        }else{
            $data['jurus'] = '';
        }
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['siswa'] = $siswa;
        $data['pendidikan'] = $pendidikan['nama'];
        $data['kelas'] = $kelas['nama'];

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-perizinan ' . $pendidikan['nama'] . '_' . $kelas['nama'] . ' .pdf';

        $this->pdf->load_view('laporan/laporan_perizinan', $data);
    }


    public function laporan_pelanggaran()
    {
        $data['title'] = 'Laporan Pelanggaran';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id_rib     = $this->input->post('pendidikan');
        $id_kam     = $this->input->post('kelas');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $siswa = $this->db->get_where('siswa', ['id_kelas' => $id_kam])->row_array();
        $pendidikan = $this->db->get_where('data_pendidikan', ['id' => $id_rib])->row_array();
        $kelas = $this->db->get_where('data_kelas', ['id' => $id_kam])->row_array();
        $jurus = $this->db->get_where('data_jurusan', ['id_pend' => $pendidikan['id']])->row_array();

        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $tgl_akhir);
        $this->db->where('id_kelas', $id_kam);
        $data['laporan'] = $this->db->get('pelanggaran')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['siswa'] = $siswa;
        $data['pendidikan'] = $pendidikan['nama'];
        $data['kelas'] = $kelas['nama'];
        if($pendidikan['majors'] == 1){
            $data['jurus'] = ' - '.$jurus['nama'];
        }else{
            $data['jurus'] = '';
        }

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-pelanggaran ' . $pendidikan['nama'] . '_' . $kelas['nama'] . ' .pdf';

        $this->pdf->load_view('laporan/laporan_pelanggaran', $data);
    }


    public function laporan_pelanggaran_siswa()
    {
        $data['title'] = 'Laporan Pelanggaran';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id_san     = $this->input->post('siswa');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $siswa = $this->db->get_where('siswa', ['id' => $id_san])->row_array();

        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $tgl_akhir);
        $this->db->where('id_siswa', $id_san);
        $data['laporan'] = $this->db->get('pelanggaran')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['siswa'] = $siswa['nama'];


        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-pelanggaran ' . $siswa['nama'] . ' .pdf';

        $this->pdf->load_view('laporan/laporan_pelanggaran', $data);
    }


    public function laporan_absen()
    {
        $data['title'] = 'Laporan Absen';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id     = $this->input->post('id');

        $this->db->where('role_absen', $id);
        $data['laporan'] = $this->db->get('absen')->result_array();

        $this->db->where('id', $id);
        $data['daftar_absen'] = $this->db->get('daftar_absen')->row_array();
        $id_pend = $data['daftar_absen']['id_pend'];
        $id_kelas = $data['daftar_absen']['id_kelas'];

        $data['pendidikan'] =  $this->db->get_where('data_pendidikan', ['id' => $id_pend])->row_array();
        $data['kelas'] =  $this->db->get_where('data_kelas', ['id' => $id_kelas])->row_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'Laporan-absen_' . $data['pendidikan']['nama'] . '_' . $data['kelas']['nama'] . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen', $data);
    }

    public function laporan_absen_pegawai()
    {
        $data['title'] = 'Laporan Absen Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id     = $this->input->post('id');

        $this->db->where('role_absen', $id);
        $data['laporan'] = $this->db->get('absen_pegawai')->result_array();

        $this->db->where('id', $id);
        $data['daftar_absen'] = $this->db->get('data_absen_pegawai')->row_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'Laporan-absen-pegawai_' . mediumdate_indo(date($data['daftar_absen']['tgl'])) . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen_pegawai', $data);
    }


    public function laporan_konseling()
    {
        $data['title'] = 'Laporan Absen';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id     = $this->input->post('id');

        $this->db->where('role_konseling', $id);
        $this->db->order_by('id', 'asc');
        $data['laporan'] = $this->db->get('balas_konseling')->result_array();

        $this->db->where('id', $id);
        $data['konseling'] = $this->db->get('konseling')->row_array();
        $id_san = $data['konseling']['id_siswa'];

        $data['siswa'] = $this->db->get('siswa', ['id' => $id_san])->row_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-konseling_' . $data['konseling']['topik'] . '_' . $data['siswa']['nama'] . '.pdf';

        $this->pdf->load_view('laporan/laporan_konseling', $data);
    }

    public function cetak_formulir()
    {
        $data['title'] = 'Cetak Formulir';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id     = $this->input->get('id');
        $id = $this->secure->decrypt($id);

        $data['ppdb'] = $this->db->get_where('ppdb', ['id' => $id])->row_array();
        $data['period'] = $this->db->get_where('period', ['id' => $data['ppdb']['thn_msk']])->row_array();

        // $data['header'] = $this->encode_img_base64('assets/img/formulir/header.jpg');
        // $data['footer'] = $this->encode_img_base64('assets/img/formulir/footer.jpg');


        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'cetak_formulir_' . $data['ppdb']['nama'] . '.pdf';
        $this->pdf->load_view('laporan/cetakformulir', $data);
    }

    public function laporan_slip()
    {
        $data['title'] = 'Laporan Slip Gaji';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $id     = $this->input->post('id');
        $gajian = $this->db->get_where('penggajian', ['id' => $id])->row_array();
        $users = $this->db->get_where('karyawan', ['id' => $gajian['id_peng']])->row_array();

        $data['gaji'] = $gajian;
        $data['cicilan'] = $this->db->get_where('data_cicilan', ['id_peng' => $gajian['id_peng']])->result_array();

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan_slip_gaji_' . $users['nama'] . '.pdf';

        $this->pdf->load_view('laporan/laporan_slip', $data);
    }

    public function laporan_absen_pegawai_bulanan()
    {
        $data['title'] = 'Laporan Absen Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $this->db->where('role_id !=', 1);
        $data['karyawan'] = $this->db->get('karyawan')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan-absen_tanggal' . mediumdate_indo(date($tgl_awal)) . ' - ' . mediumdate_indo(date($tgl_akhir)) . '.pdf';

        $this->pdf->load_view('laporan/laporan_absen_pegawai_bulanan', $data);
    }

    public function laporan_data_absensi_pegawai()
    {
        $data['title'] = 'Laporan Data Absensi Pegawai';
        $data['web'] =  $this->db->get('website')->row_array();
        $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

        $pendidikan  = $this->input->post('pendidikan');
        $divisi  = $this->input->post('divisi');
        $tgl_awal  = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        if (!empty($pendidikan)) {
            $this->db->where('id_pend', $pendidikan);
        }
        if (!empty($divisi)) {
            $this->db->where('id_divisi', $divisi);
        }
        $this->db->where('role_id !=', 1);
        $data['karyawan'] = $this->db->get('karyawan')->result_array();

        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;

        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'laporan_data_absen_tanggal' . mediumdate_indo(date($tgl_awal)) . ' - ' . mediumdate_indo(date($tgl_akhir)) . '.pdf';

        $this->pdf->load_view('laporan/laporan_data_absensi_pegawai', $data);
    }
    
    public function cetak_invoice()
    {
        $data['title'] = 'Invoice PPDB';
        $data['web'] =  $this->db->get('website')->row_array();
        $id     = $this->input->get('id');
        $id = $this->secure->decrypt($id);
        $data['user'] = $this->db->get_where('ppdb', ['id' => $id])->row_array();

        $data['pay'] = $this->db->get_where('data_pembayaran', ['jenis' => 'PPDB'])->result_array();
        
        $this->pdf->setPaper('A4', 'potrait');
        $this->pdf->filename = 'invoice_ppdb_' . $data['user']['nama'] . '.pdf';

        $this->pdf->load_view('laporan/invoicePPDB', $data);
    }

}
