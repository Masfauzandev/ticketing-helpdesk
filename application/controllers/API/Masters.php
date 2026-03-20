<?php
require __DIR__ . "/../../models/user/constants.php";

class Masters extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        log_message('error', 'API Masters Loaded');
        parent::requireLogin();
        $this->load->model('Master_model', 'Master');
        $this->load->model('core/Session_model', 'Session');
    }

    public function add_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
            return;
        }

        $nama_cabang = trim($this->input->post('nama_cabang'));

        if (empty($nama_cabang)) {
            $this->sendJSON(array('result' => false, 'message' => 'Nama Cabang is required'));
            return;
        }

        if ($this->Master->exists_cabang($nama_cabang)) {
             $this->sendJSON(array('result' => false, 'message' => 'Cabang already exists'));
             return;
        }

        $data = [
            'nama_cabang' => $nama_cabang,
            'is_active' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->Session->getLoggedDetails()['id']
        ];
        
        log_message('error', 'Inserting Cabang Data: ' . json_encode($data));

        $result = $this->Master->add_cabang($data);
        if ($result) {
            $this->sendJSON(array('result' => true));
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Cabang DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']));
        }
    }

    public function add_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
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
            'is_active' => 1,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->Session->getLoggedDetails()['id']
        ];
        
        log_message('error', 'Inserting Divisi Data: ' . json_encode($data));

        $result = $this->Master->add_divisi($data);
        if ($result) {
            $this->sendJSON(array('result' => true));
        } else {
            $err = $this->db->error();
            log_message('error', 'Add Divisi DB Error: ' . json_encode($err));
            $this->sendJSON(array('result' => false, 'message' => 'Failed to add data to database. Error: ' . $err['message']));
        }
    }

    public function delete_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_cabang($id);
        $this->sendJSON(array('result' => $result));
    }

    public function delete_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
            return;
        }

        $id = $this->input->post('id');
        $result = $this->Master->delete_divisi($id);
        $this->sendJSON(array('result' => $result));
    }

    public function update_cabang()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
            return;
        }

        $id = $this->input->post('id');
        $nama_cabang = trim($this->input->post('nama_cabang'));

        if (empty($id) || empty($nama_cabang)) {
             $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'));
             return;
        }

        $data = ['nama_cabang' => $nama_cabang];
        $result = $this->Master->update_cabang($id, $data);
        $this->sendJSON(array('result' => $result));
    }

    public function update_divisi()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
            return;
        }

        $id = $this->input->post('id');
        $nama_divisi = trim($this->input->post('nama_divisi'));

        if (empty($id) || empty($nama_divisi)) {
             $this->sendJSON(array('result' => false, 'message' => 'ID and Name are required'));
             return;
        }

        $data = ['nama_divisi' => $nama_divisi];
        $result = $this->Master->update_divisi($id, $data);
        $this->sendJSON(array('result' => $result));
    }
}
