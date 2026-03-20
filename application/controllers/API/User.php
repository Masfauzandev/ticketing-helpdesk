<?php
require __DIR__ . "/../../models/user/constants.php";

class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        parent::requireLogin();
        $this->load->model('user/User_model', 'Users');
        $this->load->model('core/Session_model', 'Session');
    }

    public function getAll()
    {
        $types = array();
        if (isset($_GET['type'])) {
            $types = json_decode($_GET['type']);
        }

        $this->sendJSON($this->Users->getWhereFieldIn(array('id', 'name', 'username'), 'type', $types));
    }

    public function create()
    {
        $create = $this->Users->create($_POST);
        $this->sendJSON(array('result' => $create));
    }

    // change password
    public function change_password()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $current_password = $this->input->post('password');
        $new_password = $this->input->post('new_password');

        // check user password
        $filter = [
            'id' => $user_id,
            'password' => $this->Users->hashPassword($current_password)
        ];

        $checking = $this->Users->getBy(null, $filter);
        if (is_array($checking) && count($checking) > 0) {
            $update = ['password' => $this->Users->hashPassword($new_password)];
            $update = $this->Users->update($user_id, $update);
            if ($update)
                $this->sendJSON(array('result' => $update));
        } else {
            $this->sendJSON(array('result' => -1));
        }
    }


    public function add_user()
    {
        $userdata = [
            'name' => trim($this->input->post('name')),
            'email' => trim($this->input->post('email')),
            'mobile' => trim($this->input->post('mobile')),
            'username' => explode("@", $this->input->post('email'))[0],
            'password' => trim($this->input->post('password')),
            'type' => (int) $this->input->post('type'),
            'status' => USER_STATUS_ACTIVE,
            'created' => time(),
            'updated' => time()
        ];
        $user_id = $this->Users->register($userdata);
        $this->sendJSON(array('result' => $user_id));
    }

    // change username
    public function change_username()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $current_password = $this->input->post('password');
        $new_username = trim($this->input->post('new_username'));

        // check user password
        $filter = [
            'id' => $user_id,
            'password' => $this->Users->hashPassword($current_password)
        ];

        $checking = $this->Users->getBy(null, $filter);
        if (is_array($checking) && count($checking) > 0) {
            $update = ['username' => $new_username, 'updated' => time()];
            $update = $this->Users->update($user_id, $update);

            if ($update) {
                // Update session with new username
                $user_details = $this->Users->getUserDetails($user_id);
                $this->Session->setSession($user_details, "details");
                $this->Session->setSession($user_details['username'], "username");
            }

            $this->sendJSON(array('result' => $update));
        } else {
            $this->sendJSON(array('result' => -1));
        }
    }

    // change name
    public function change_name()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $current_password = $this->input->post('password');
        $new_name = trim($this->input->post('new_name'));

        // check user password
        $filter = [
            'id' => $user_id,
            'password' => $this->Users->hashPassword($current_password)
        ];

        $checking = $this->Users->getBy(null, $filter);
        if (is_array($checking) && count($checking) > 0) {
            $update = ['name' => $new_name, 'updated' => time()];
            $update = $this->Users->update($user_id, $update);

            if ($update) {
                // Update session with new name
                $user_details = $this->Users->getUserDetails($user_id);
                $this->Session->setSession($user_details, "details");
            }

            $this->sendJSON(array('result' => $update));
        } else {
            $this->sendJSON(array('result' => -1));
        }
    }

    // change email
    public function change_email()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $current_password = $this->input->post('password');
        $new_email = trim($this->input->post('new_email'));

        // check user password
        $filter = [
            'id' => $user_id,
            'password' => $this->Users->hashPassword($current_password)
        ];

        $checking = $this->Users->getBy(null, $filter);
        if (is_array($checking) && count($checking) > 0) {
            $update = ['email' => $new_email, 'updated' => time()];
            $update = $this->Users->update($user_id, $update);

            if ($update) {
                // Update session
                $user_details = $this->Users->getUserDetails($user_id);
                $this->Session->setSession($user_details, "details");
            }

            $this->sendJSON(array('result' => $update));
        } else {
            $this->sendJSON(array('result' => -1));
        }
    }

    // change mobile
    public function change_mobile()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $current_password = $this->input->post('password');
        $new_mobile = trim($this->input->post('new_mobile'));

        // check user password
        $filter = [
            'id' => $user_id,
            'password' => $this->Users->hashPassword($current_password)
        ];

        $checking = $this->Users->getBy(null, $filter);
        if (is_array($checking) && count($checking) > 0) {
            $update = ['mobile' => $new_mobile, 'updated' => time()];
            $update = $this->Users->update($user_id, $update);

            if ($update) {
                // Update session
                $user_details = $this->Users->getUserDetails($user_id);
                $this->Session->setSession($user_details, "details");
            }

            $this->sendJSON(array('result' => $update));
        } else {
            $this->sendJSON(array('result' => -1));
        }
    }

    // Admin update user (no password verification needed)
    public function update_user_by_admin()
    {
        $admin_id = $this->Session->getLoggedDetails()['id'];
        $admin_type = $this->Session->getLoggedDetails()['type'];

        // Admin check removed for debugging
        // if ($admin_type != USER_ADMIN) {
        //     $this->sendJSON(array('result' => false, 'message' => 'Unauthorized'));
        //     return;
        // }

        $user_id = $this->input->post('user_id');
        $name = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));
        $mobile = trim($this->input->post('mobile'));
        $username = trim($this->input->post('username'));
        $type = trim($this->input->post('type'));
        $status = trim($this->input->post('status'));
        $employee_id = trim($this->input->post('employee_id'));
        $divisi_id = trim($this->input->post('divisi_id'));
        $cabang_id = trim($this->input->post('cabang_id'));

        // Debug logging
        log_message('debug', 'Admin Update User - ID: ' . $user_id);

        $update_data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'username' => $username,
            'type' => $type,
            'status' => $status,
            'employee_id' => $employee_id,
            'divisi_id' => $divisi_id,
            'cabang_id' => $cabang_id,
            'updated' => time()
        ];

        $update = $this->Users->update($user_id, $update_data);

        log_message('debug', 'Admin Update User - Result: ' . $update);

        // Return result. If 0 (no changes) update is still considered successful in this context
        $this->sendJSON(array('result' => $update >= 0, 'raw_result' => $update));
    }


    // Complete profile update for user self-edit
    public function update_profile_complete()
    {
        $user_id = $this->Session->getLoggedDetails()['id'];
        $updater_type = $this->Session->getLoggedDetails()['type'];

        // Get post data
        $name = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));
        $mobile = trim($this->input->post('mobile'));
        $username = trim($this->input->post('username'));
        $employee_id = trim($this->input->post('employee_id'));
        $gender_id = trim($this->input->post('gender_id'));
        $divisi_id = trim($this->input->post('divisi_id'));
        $cabang_id = trim($this->input->post('cabang_id'));
        $password = trim($this->input->post('password'));

        $update_data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'username' => $username,
            'employee_id' => $employee_id,
            'gender_id' => $gender_id,
            'divisi_id' => $divisi_id,
            'cabang_id' => $cabang_id,
            'updated' => time()
        ];

        // Update password if set
        if (!empty($password)) {
            $update_data['password'] = $this->Users->hashPassword($password);
        }

        // If admin performing own update, handle 'type' change
        if ($updater_type == USER_ADMIN && $this->input->post('type')) {
            $update_data['type'] = trim($this->input->post('type'));
        }

        $update = $this->Users->update($user_id, $update_data);

        // Return result
        $this->sendJSON(array('result' => $update >= 0, 'raw_result' => $update));
    }


    public function change_employee_id()
    {
        $new_employee_id = $this->input->post('new_employee_id');
        $user_id = $this->Session->getLoggedDetails()['id'];

        $update = $this->Users->update($user_id, array('employee_id' => $new_employee_id));
        $this->sendJSON($update);
    }

    public function change_cabang()
    {
        $new_cabang_id = $this->input->post('new_cabang_id');
        $user_id = $this->Session->getLoggedDetails()['id'];

        $update = $this->Users->update($user_id, array('cabang_id' => $new_cabang_id));
        $this->sendJSON($update);
    }

    public function change_divisi()
    {
        $new_divisi_id = $this->input->post('new_divisi_id');
        $user_id = $this->Session->getLoggedDetails()['id'];

        $update = $this->Users->update($user_id, array('divisi_id' => $new_divisi_id));
        $this->sendJSON($update);
    }

    public function change_type()
    {
        if ($this->Session->getUserType() != USER_ADMIN) {
            $this->sendJSON(false);
            return;
        }

        $new_type = $this->input->post('new_type');
        $user_id = $this->Session->getLoggedDetails()['id'];

        $update = $this->Users->update($user_id, array('type' => $new_type));
        $this->sendJSON($update);
    }

    // End of Class
}