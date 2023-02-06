<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('nis')) {
        redirect('auth');
    } else {
        $queryMenu = $ci->db->get_where('siswa')->row_array();
        $role_id = $queryMenu['role_id'];

        if ($role_id < 1) {
            redirect('auth/blocked');
        }
    }
}

function sess_expired() 
{
    $ci = get_instance();
    $date = date('Y-m-d');
    $ci->db->where('expired <', $date);
    $izin = $ci->db->get('perizinan')->result_array();
    
    foreach($izin as $z){
        
        $sis = $ci->db->get_where('siswa', ['id' => $z['id_siswa']])->row_array();
        $data_izin = $ci->db->get_where('data_perizinan', ['id' => $z['id_izin']])->row_array();
        $sum = $sis['point'] - $data_izin['point'];
        if($z['status'] == 'Proses'){
            $ci->db->set('point', max($sum, 0));
            $ci->db->where('id', $sis['id']);
            $ci->db->update('siswa');

            $ci->db->set('status', 'Expired');
            $ci->db->where('id_siswa', $sis['id']);
            $ci->db->update('perizinan');
        }
    }
}
