<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Bebas_pay_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if (isset($params['id'])) {
            $this->db->where('bebas_pay.bebas_pay_id', $params['id']);
        }

        if (isset($params['student_id'])) {
            $this->db->where('bebas.student_student_id', $params['student_id']);
        }

        if (isset($params['student_nis'])) {
            $this->db->where('siswa.nis', $params['student_nis']);
        }

        if (isset($params['date'])) {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }

        if (isset($params['payment_id'])) {
            $this->db->where('bebas.payment_payment_id', $params['payment_id']);
        }

        if (isset($params['bebas_id'])) {
            $this->db->where('bebas_pay.bebas_bebas_id', $params['bebas_id']);
        }

        if (isset($params['class_id'])) {
            $this->db->where('siswa.id_kelas', $params['class_id']);
        }

        if (isset($params['bebas_pay_input_date'])) {
            $this->db->where('bebas_pay_input_date', $params['bebas_pay_input_date']);
        }

        if (isset($params['bebas_pay_last_update'])) {
            $this->db->where('bebas_pay_last_update', $params['bebas_pay_last_update']);
        }

        if (isset($params['date_start']) and isset($params['date_end'])) {
            $this->db->where('bebas_pay_input_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bebas_pay_input_date <=', $params['date_end'] . ' 23:59:59');
        }

        if (isset($params['date'])) {
            $this->db->where('bebas_pay_input_date', $params['date']);
        }

        if (isset($params['group'])) {

            $this->db->group_by('bebas_pay.bebas_bebas_id');
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('bebas_pay_last_update', 'asc');
        }

        $this->db->select('bebas_pay.bebas_pay_id, bebas_pay_bill, bebas_pay_number, bebas_pay_desc, bebas_pay_input_date, bebas_pay_last_update');
        $this->db->select('bebas_pay.bebas_bebas_id, bebas_bill, bebas_total_pay');
        // $this->db->select_sum('bebas_pay_bill');
        $this->db->select('student_student_id, nis, siswa.id_kelas, data_pendidikan.nama as pend_name, data_jurusan.nama as majors_name, data_kelas.nama as class_name, siswa.nama, nama_ibu, no_telp');
        $this->db->select('payment_payment_id, period.id as period_id, payment_type, period_start, period_end, pembayaran.pos_pos_id, pos_name');
        $this->db->select('user_user_id, karyawan.nama user_full_name');
        $this->db->join('bebas', 'bebas.bebas_id = bebas_pay.bebas_bebas_id', 'left');
        $this->db->join('siswa', 'siswa.id = bebas.student_student_id', 'left');
        $this->db->join('pembayaran', 'pembayaran.payment_id = bebas.payment_payment_id', 'left');
        $this->db->join('period', 'period.id = pembayaran.period_period_id', 'left');
        $this->db->join('pos', 'pos.pos_id = pembayaran.pos_pos_id', 'left');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
        $this->db->join('karyawan', 'karyawan.id = bebas_pay.user_user_id', 'left');

        $res = $this->db->get('bebas_pay');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Add and update to database
    function add($data = array())
    {

        if (isset($data['bebas_pay_id'])) {
            $this->db->set('bebas_pay_id', $data['bebas_pay_id']);
        }

        if (isset($data['bebas_id'])) {
            $this->db->set('bebas_bebas_id', $data['bebas_id']);
        }

        if (isset($data['bebas_pay_bill'])) {
            $this->db->set('bebas_pay_bill', $data['bebas_pay_bill']);
        }

        if (isset($data['bebas_pay_number'])) {
            $this->db->set('bebas_pay_number', $data['bebas_pay_number']);
        }

        if (isset($data['bebas_pay_desc'])) {
            $this->db->set('bebas_pay_desc', $data['bebas_pay_desc']);
        }

        if (isset($data['user_user_id'])) {
            $this->db->set('user_user_id', $data['user_user_id']);
        }

        if (isset($data['bebas_pay_input_date'])) {
            $this->db->set('bebas_pay_input_date', $data['bebas_pay_input_date']);
        }

        if (isset($data['bebas_pay_last_update'])) {
            $this->db->set('bebas_pay_last_update', $data['bebas_pay_last_update']);
        }

        if (isset($data['bebas_pay_id'])) {
            $this->db->where('bebas_pay_id', $data['bebas_pay_id']);
            $this->db->update('bebas_pay');
            $id = $data['bebas_pay_id'];
        } else {
            $this->db->insert('bebas_pay');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }


    // Delete to database
    function delete($id)
    {
        $this->db->where('bebas_pay_id', $id);
        $this->db->delete('bebas_pay');
    }
}
