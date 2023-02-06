<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if (isset($params['student_id'])) {
            $this->db->where('siswa.id', $params['student_id']);
        }
        if (isset($params['id'])) {
            $this->db->where('siswa.id', $params['id']);
        }

        if (isset($params['multiple_id'])) {
            $this->db->where_in('siswa.id', $params['multiple_id']);
        }

        if (isset($params['siswa_search'])) {
            $this->db->where('nis', $params['siswa_search']);
            $this->db->or_like('nama', $params['siswa_search']);
        }

        if (isset($params['student_nis'])) {
            $this->db->where('siswa.nis', $params['student_nis']);
        }

        if (isset($params['nis'])) {
            $this->db->like('nis', $params['nis']);
        }

        if (isset($params['password'])) {
            $this->db->like('password', $params['password']);
        }

        if (isset($params['nama'])) {
            $this->db->where('siswa.nama', $params['nama']);
        }

        if (isset($params['status'])) {
            $this->db->where('siswa.status', $params['status']);
        }

        if (isset($params['date'])) {
            $this->db->where('date_created', $params['date']);
        }

        if (isset($params['id_pend'])) {
            $this->db->where('siswa.id_pend', $params['id_pend']);
        }

        if (isset($params['class_id'])) {
            $this->db->where('id_kelas', $params['class_id']);
        }

        if (isset($params['majors_id'])) {
            $this->db->where('siswa.id_majors', $params['majors_id']);
        }

        if (isset($params['class_name'])) {
            $this->db->like('nama', $params['class_name']);
        }

        if (isset($params['group'])) {

            $this->db->group_by('siswa.id_kelas');
        }


        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'asc');
        } else {
            $this->db->order_by('siswa.nama', 'asc');
        }
        $this->db->select('siswa.id, point, nik, nis, siswa.nama, email, no_hp, password, jk, ttl, prov, kab, alamat, nama_ayah, nama_ibu, pek_ayah, pek_ibu, nama_wali, pek_wali, peng_ortu, no_telp, thn_msk, sekolah_asal, kelas, img_siswa, img_kk, img_ijazah, img_ktp, siswa.id_pend, id_majors, id_kelas, status, date_created, role_id');
        $this->db->select('id_kelas, data_kelas.nama as class_name');
        $this->db->select('id_majors, data_jurusan.nama as majors_name');
        $this->db->join('data_pendidikan', 'data_pendidikan.id = siswa.id_pend', 'left');
        $this->db->join('data_kelas', 'data_kelas.id = siswa.id_kelas', 'left');
        $this->db->join('data_jurusan', 'data_jurusan.id = siswa.id_majors', 'left');
        $res = $this->db->get('siswa');
        if (isset($params['id'])) {
            return $res->row_array();
        } else if (isset($params['nis'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function get_pend($params = array())
    {
        if (isset($params['id'])) {
            $this->db->where('id', $params['id']);
        }

        if (isset($params['nama'])) {
            $this->db->where('nama', $params['nama']);
        }


        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'asc');
        } else {
            $this->db->order_by('id', 'asc');
        }

        $this->db->select('id, nama');
        $res = $this->db->get('data_pendidikan');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function get_majors($params = array())
    {
        if (isset($params['id'])) {
            $this->db->where('id', $params['id']);
        }

        if (isset($params['majors_name'])) {
            $this->db->where('nama', $params['majors_name']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'asc');
        } else {
            $this->db->order_by('id', 'asc');
        }

        $this->db->select('id, nama');
        $res = $this->db->get('data_jurusan');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }


    function get_class($params = array())
    {
        if (isset($params['id'])) {
            $this->db->where('id', $params['id']);
        }

        if (isset($params['class_name'])) {
            $this->db->where('nama', $params['class_name']);
        }

        if (isset($params['id_pend'])) {
            $this->db->where('id_pend', $params['id_pend']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'asc');
        } else {
            $this->db->order_by('id', 'asc');
        }

        $this->db->select('id, nama');
        $res = $this->db->get('data_kelas');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array())
    {
        if (isset($data['id'])) {
            $this->db->set('id', $data['id']);
        }

        if (isset($data['nis'])) {
            $this->db->set('nis', $data['nis']);
        }

        if (isset($data['id_pend'])) {
            $this->db->set('id_pend', $data['id_pend']);
        }

        if (isset($data['id_majors'])) {
            $this->db->set('id_majors', $data['id_majors']);
        }

        if (isset($data['id_kelas'])) {
            $this->db->set('id_kelas', $data['id_kelas']);
        }

        if (isset($data['status'])) {
            $this->db->set('status', $data['status']);
        }

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('siswa');
            $id = $data['id'];
        } else {
            $this->db->insert('siswa');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);

        return $this->db->count_all_results('siswa') > 0 ? TRUE : FALSE;
    }

}
