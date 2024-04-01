<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function getUsers($id)
    {
        /**
         * ID disini adalah untuk data yang tidak ingin ditampilkan. 
         * Maksud saya disini adalah 
         * tidak ingin menampilkan data user yang digunakan, 
         * pada managemen data user
         */
        $this->db->where('id_user !=', $id);
        return $this->db->get('user')->result_array();
    }

    public function getAllBarang()
    {
        // Tidak ada filter di sini, ambil semua data
        return $this->db->get('barang')->result_array();
    }

    public function getBarangByUserId($userId)
    {
        // Pastikan nama kolom sesuai dengan skema tabel Anda
        return $this->db->get_where('barang', ['id_user' => $userId])->result_array();
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function getBarangById($id)
    {
        // Assuming 'barang' is your table name
        $query = $this->db->get_where('barang', array('id_vendor' => $id));
        return $query->row_array();
    }
    public function printData($id_vendor)
    {
        // Implement logic to fetch data for the specified $id_vendor
        $data['barang'] = $this->admin_model->getDataById($id_vendor);

        // Load a view to display the data
        $this->load->view('barang/print_data_view', $data);
    }
    public function getDataById($id_vendor)
    {
        // Assuming you have a table named 'barang' in your database
        $query = $this->db->get_where('barang', array('id_vendor' => $id_vendor));
        // Check if data is found
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null; // or handle the case where no data is found
        }
    }
    public function get_barang_by_id_vendor($id_vendor)
    {
        return $this->db->get_where('barang', array('id_vendor' => $id_vendor))->result_array();
    }

    public function getUserById($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('user');
        return $query->row_array();
    }

    public function updateUser($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data);
    }
    public function getAllData()
    {
        // Ambil data dari database
        $query = $this->db->get('barang');
        return $query->result_array();
    }

    public function hitungDataBelumDiproses()
    {
        // Query untuk menghitung total data yang belum diproses
        $this->db->where('tgl_diterima', NULL); // Ubah kondisi sesuai kebutuhan Anda
        $this->db->from('barang');
        return $this->db->count_all_results();
    }
}
