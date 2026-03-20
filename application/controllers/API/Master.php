<?php
require __DIR__ . "/../../models/user/constants.php";

class Master extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        parent::requireLogin();
        $this->load->model('Master_model', 'Master');
        $this->load->model('core/Session_model', 'Session');
    }

    public function add_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $nama_cabang = trim($this->input->post('nama_cabang'));

        if (empty($nama_cabang)) {
            $this->sendJSON(array('result' => false, 'message' => 'Nama Cabang is required'), true);
            return;
        }

        if ($this->Master->exists_cabang($nama_cabang)) {
            $this->sendJSON(array('result' => false, 'message' => 'Cabang already exists'), true);
            return;
        }

        // Generate short unique code: CBG + 4 random digits (Total 7 chars, fits in varchar(10))
        $kode = 'CBG' . rand(1000, 9999);
        $data = [
            'kode' => $kode,
            'nama_cabang' => $nama_cabang,
            'is_active' => 1
        ];

        log_message('error', 'Inserting Cabang Data: ' . json_encode($data));

        $result = $this->Master->add_cabang($data);
        if ($result) {
            $this->sendJSON(array('result' => true), true);
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Cabang DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']), true);
        }
    }

    public function add_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $nama_divisi = trim($this->input->post('nama_divisi'));

        if (empty($nama_divisi)) {
            $this->sendJSON(array('result' => false, 'message' => 'Nama Divisi is required'));
            return;
        }

        if ($this->Master->exists_divisi($nama_divisi)) {
            $this->sendJSON(array('result' => false, 'message' => 'Divisi already exists'));
            return;
        }

        $data = [
            'nama_divisi' => $nama_divisi,
            'is_active' => 1
        ];

        log_message('error', 'Inserting Divisi Data: ' . json_encode($data));

        $result = $this->Master->add_divisi($data);
        if ($result) {
            $this->sendJSON(array('result' => true), true);
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Divisi DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']), true);
        }
    }

    public function delete_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_cabang($id);
        $this->sendJSON(array('result' => $result), true);
    }

    public function delete_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_divisi($id);
        $this->sendJSON(array('result' => $result), true);
    }

    public function update_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $nama_cabang = trim($this->input->post('nama_cabang'));

        if (empty($id) || empty($nama_cabang)) {
            $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'), true);
            return;
        }

        $data = ['nama_cabang' => $nama_cabang];
        $result = $this->Master->update_cabang($id, $data);
        $this->sendJSON(array('result' => $result), true);
    }

    public function update_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $nama_divisi = trim($this->input->post('nama_divisi'));

        if (empty($id) || empty($nama_divisi)) {
            $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'), true);
            return;
        }

        $data = ['nama_divisi' => $nama_divisi];
        $result = $this->Master->update_divisi($id, $data);
        $this->sendJSON(array('result' => $result), true);
    }

    public function add_category()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $name = trim($this->input->post('name'));

        if (empty($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'Category Name is required'), true);
            return;
        }

        if ($this->Master->exists_category($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'Category already exists'), true);
            return;
        }

        $data = [
            'name' => $name,
            'is_active' => 1
        ];

        log_message('error', 'Inserting Category Data: ' . json_encode($data));

        $result = $this->Master->add_category($data);
        if ($result) {
            $this->sendJSON(array('result' => true), true);
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Category DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']), true);
        }
    }

    public function delete_category()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_category($id);
        $this->sendJSON(array('result' => $result), true);
    }

    public function update_category()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $name = trim($this->input->post('name'));

        if (empty($id) || empty($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'), true);
            return;
        }

        $data = ['name' => $name];
        $result = $this->Master->update_category($id, $data);
        $this->sendJSON(array('result' => $result), true);
    }

    public function add_subject()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $name = trim($this->input->post('name'));

        if (empty($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'Subject Name is required'), true);
            return;
        }

        if ($this->Master->exists_subject($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'Subject already exists'), true);
            return;
        }

        $data = [
            'name' => $name,
            'is_active' => 1
        ];

        log_message('error', 'Inserting Subject Data: ' . json_encode($data));

        $result = $this->Master->add_subject($data);
        if ($result) {
            $this->sendJSON(array('result' => true), true);
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Subject DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']), true);
        }
    }

    public function delete_subject()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_subject($id);
        $this->sendJSON(array('result' => $result), true);
    }

    public function update_subject()
    {
        if ($this->Session->getUserType() != USER_ADMIN && $this->Session->getUserType() != USER_MANAGER) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'), true);
            return;
        }

        $id = $this->input->post('id');
        $name = trim($this->input->post('name'));

        if (empty($id) || empty($name)) {
            $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'), true);
            return;
        }

        $data = ['name' => $name];
        $result = $this->Master->update_subject($id, $data);
        $this->sendJSON(array('result' => $result), true);
    }
}
