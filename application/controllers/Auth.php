<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        sess_expired();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('nis')) {
            redirect('siswa');
        }

        $this->form_validation->set_rules('nis', 'Nomor', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login siswa';
            $data['web'] =  $this->db->get('website')->row_array();

            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        } else {
            // validasinya success
            $this->_login();
        }
    }

    public function admin()
    {
        if ($this->session->userdata('email')) {
            redirect('admin');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login Admin';
            $data['web'] =  $this->db->get('website')->row_array();

            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login_admin');
            $this->load->view('template/auth_footer');
        } else {
            // validasinya success
            $this->_login_admin();
        }
    }


    private function _login()
    {
        $nis = $this->input->post('nis');
        $password = $this->input->post('password');

        $user = $this->db->get_where('siswa', ['nis' => $nis])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['status'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'nis' => $user['nis'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 5) {

                        $this->session->set_flashdata(
                            'message',
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Susccess!</strong> Anda berhasil login! :)
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>'
                        );
                        redirect('siswa');
                    } else {
                        $this->load->view('auth/blocked');
                    }
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Password salah!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 </div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nomor Induk ini belum diaktifkan!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nomor induk tidak terdaftar!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
            );
            redirect('auth');
        }
    }


    private function _login_admin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('karyawan', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['status'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Susccess!</strong> Anda berhasil login! :)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>'
                    );
                    redirect('admin');
                } else {
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     Password salah!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
                 </div>'
                    );
                    redirect('auth/admin');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email ini belum diaktifkan!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
                );
                redirect('auth/admin');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Email tidak terdaftar!
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             </div>'
            );
            redirect('auth/admin');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('nis');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Anda berhasil Keluar :)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>'
        );
        redirect('auth');
    }


    public function logout_admin()
    {
        $this->session->unset_userdata('email');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Anda berhasil Keluar :)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>'
        );
        redirect('auth/admin');
    }


    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
