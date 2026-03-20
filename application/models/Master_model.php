<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model
{
    // Ambil data jenis kelamin
    public function get_gender()
    {
        return $this->db->order_by('id', 'ASC')->get('mst_gender')->result();
    }

    // Ambil data cabang
    public function get_cabang_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('nama_cabang', 'ASC')
            ->get('mst_cabang')
            ->result();
    }

    // Ambil data jabatan
    public function get_divisi_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('nama_divisi', 'ASC')
            ->get('mst_divisi')
            ->result();
    }

    // Tambah Cabang
    public function add_cabang($data)
    {
        return $this->db->insert('mst_cabang', $data);
    }

    // Cek Cabang Exist
    public function exists_cabang($name)
    {
        return $this->db->where('nama_cabang', $name)->count_all_results('mst_cabang') > 0;
    }

    // Tambah Divisi
    public function add_divisi($data)
    {
        return $this->db->insert('mst_divisi', $data);
    }

    // Cek Divisi Exist
    public function exists_divisi($name)
    {
        return $this->db->where('nama_divisi', $name)->count_all_results('mst_divisi') > 0;
    }

    // Delete Cabang (Soft Delete)
    public function delete_cabang($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_cabang', array('is_active' => 0));
    }

    // Delete Divisi (Soft Delete)
    public function delete_divisi($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_divisi', array('is_active' => 0));
    }

    // Update Cabang
    public function update_cabang($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_cabang', $data);
    }

    // Update Divisi
    public function update_divisi($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_divisi', $data);
    }

    // Ambil data category
    public function get_category_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('name', 'ASC')
            ->get('mst_category')
            ->result();
    }

    // Tambah Category
    public function add_category($data)
    {
        return $this->db->insert('mst_category', $data);
    }

    // Cek Category Exist
    public function exists_category($name)
    {
        return $this->db->where('name', $name)->count_all_results('mst_category') > 0;
    }

    // Delete Category (Soft Delete)
    public function delete_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_category', array('is_active' => 0));
    }

    // Update Category
    public function update_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_category', $data);
    }

    // Ambil data subject
    public function get_subject_active()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('name', 'ASC')
            ->get('mst_subject')
            ->result();
    }

    // Tambah Subject
    public function add_subject($data)
    {
        return $this->db->insert('mst_subject', $data);
    }

    // Cek Subject Exist
    public function exists_subject($name)
    {
        return $this->db->where('name', $name)->count_all_results('mst_subject') > 0;
    }

    // Delete Subject (Soft Delete)
    public function delete_subject($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_subject', array('is_active' => 0));
    }

    // Update Subject
    public function update_subject($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mst_subject', $data);
    }
}
