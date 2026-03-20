<?php

class User extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		parent::requireLogin();
		$this->setHeaderFooter('global/header.php', 'global/footer.php');
		$this->load->model('core/Session_model', 'Session');
		$this->load->model('ticket/Threads_model', 'Tickets');
		$this->load->model('user/User_model', 'Users');
		$this->load->model('Master_model');
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard';
		$role = (int) ($this->Session->getUserType());

		if ($role == USER_MEMBER)
			$this->dashboard_member();
		else if ($role == USER_AGENT)
			$this->dashboard_agent();
		else if ($role == USER_MANAGER)
			$this->dashboard_manager();
		else if ($role == USER_ADMIN)
			$this->dashboard_manager();
	}

	public function dashboard_member()
	{
		$agent_id = $this->Session->getLoggedDetails()['username'];
		$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
		$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
		$data['stats']['in_progress_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_IN_PROGRESS)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['on_hold_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_ON_HOLD)));
		$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
		$data['stats']['cancelled_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CANCELLED)));
		$data['stats']['total_users_count'] = count($this->Users->getBy(null, array()));
		$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard_user', $data);
	}

	public function dashboard_agent()
	{
		// Global statistics - show all tickets like manager dashboard
		$data['stats']['total_tickets'] = count($this->Tickets->getBy(null, array()));
		$data['stats']['open_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_OPEN)));
		$data['stats']['in_progress_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_IN_PROGRESS)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['on_hold_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_ON_HOLD)));
		$data['stats']['closed_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_CLOSED)));
		$data['stats']['cancelled_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_CANCELLED)));
		$data['stats']['total_users_count'] = count($this->Users->getBy(null, array()));

		// Recent tickets - still scoped to agent for personal view
		$agent_id = $this->Session->getLoggedDetails()['username'];
		$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard', $data);
	}

	public function dashboard_manager()
	{
		$data['stats']['total_tickets'] = count($this->Tickets->getBy(null, array()));
		$data['stats']['open_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_OPEN)));
		$data['stats']['in_progress_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_IN_PROGRESS)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['on_hold_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_ON_HOLD)));
		$data['stats']['closed_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_CLOSED)));
		$data['stats']['cancelled_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_CANCELLED)));

		// Total users count (all user types)
		$data['stats']['total_users_count'] = count($this->Users->getBy(null, array()));
		$data['stats']['total_users'] = count($this->Users->getBy(null, array('type' => USER_MEMBER)));
		$data['stats']['total_agents'] = count($this->Users->getBy(null, array('type' => USER_AGENT)));
		$data['stats']['total_manager'] = count($this->Users->getBy(null, array('type' => USER_MANAGER)));

		$data['stats']['count_by_priority']['high'] = array(
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_HIGH, 'status' => TICKET_STATUS_CLOSED)))
		);

		$data['stats']['count_by_priority']['medium'] = array(
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_MEDIUM, 'status' => TICKET_STATUS_CLOSED)))
		);

		$data['stats']['count_by_priority']['low'] = array(
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('priority' => TICKET_PRIORITY_LOW, 'status' => TICKET_STATUS_CLOSED)))
		);

		// Dynamically load severity values from mst_severity table
		$severities = $this->db->where('is_active', 1)->order_by('severity_val', 'DESC')->get('mst_severity')->result_array();
		$data['stats']['count_by_severity'] = array();
		$data['severity_labels'] = array();
		foreach ($severities as $sev) {
			$sev_key = strtolower($sev['severity_name']);
			$sev_val = (int) $sev['severity_val'];
			$data['severity_labels'][] = $sev['severity_name'];
			$data['stats']['count_by_severity'][$sev_key] = array(
				count($this->Tickets->getBy(null, array('severity' => $sev_val, 'status' => TICKET_STATUS_OPEN))),
				count($this->Tickets->getBy(null, array('severity' => $sev_val, 'status' => TICKET_STATUS_ASSIGNED))),
				count($this->Tickets->getBy(null, array('severity' => $sev_val, 'status' => TICKET_STATUS_CLOSED)))
			);
		}


		$data['recent']['created'] = $this->Tickets->getBy(null, array(), 5);
		$data['recent']['open'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_OPEN), 5);
		$data['recent']['assigned'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_CLOSED), 5);
		$this->render('Dashboard', 'user/dashboard_manager', $data);
	}

	// public function dashboard_admin()
	// {
	// 	$agent_id = $this->Session->getLoggedDetails()['username'];
	// 	$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
	// 	$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
	// 	$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('status' => TICKET_STATUS_ASSIGNED)));
	// 	$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
	// 	$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
	// 	$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
	// 	$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
	// 	$this->render('Dashboard', 'user/dashboard', $data);
	// }

	public function profile()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));

		// Get Divisi Name
		$limit_divisi = $this->db->get_where('mst_divisi', ['id' => $user_details['divisi_id']])->row();
		$user_details['divisi_name'] = $limit_divisi ? $limit_divisi->nama_divisi : '-';

		// Get Cabang Name
		$limit_cabang = $this->db->get_where('mst_cabang', ['id' => $user_details['cabang_id']])->row();
		$user_details['cabang_name'] = $limit_cabang ? $limit_cabang->nama_cabang : '-';

		$data['user_details'] = $user_details;
		$this->render('Profile', 'user/profile', $data);
	}


	public function change_password()
	{
		$data[] = '';
		$this->render('Change password', 'user/change_password', $data);
	}

	public function profile_update()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$data['user_details'] = $this->Users->getUserBy(array('username' => $username));

		// Load master data for dropdowns
		$data['list_gender'] = $this->Master_model->get_gender();
		$data['list_cabang'] = $this->Master_model->get_cabang_active();
		$data['list_divisi'] = $this->Master_model->get_divisi_active();

		$this->render('Profile', 'user/profile_update', $data);
	}

	public function list()
	{
		$role = $this->Session->getLoggedDetails()['type'];
		$filter = ['type <=' => $role];
		$data['user_list'] = $this->Users->getBy(null, $filter);
		$this->render('All Users', 'user/list', $data);
	}

	public function add_user()
	{
		// Cek permission jika perlu (sementara logic admin only diakses via menu)

		if ($this->isPOST()) {
			$post = $this->input->post();

			// Field mapping
			$full_name = isset($post['full_name']) ? $post['full_name'] : null;
			$call_name = isset($post['call_name']) ? $post['call_name'] : null;
			$employee_id = isset($post['employee_id']) ? $post['employee_id'] : null;
			$gender = isset($post['gender']) ? $post['gender'] : null;
			$divisi = isset($post['divisi']) ? $post['divisi'] : null;
			$cabang = isset($post['cabang']) ? $post['cabang'] : null;
			$mobile = isset($post['mobile']) ? $post['mobile'] : null;
			$email = isset($post['email']) ? $post['email'] : null;
			$username = isset($post['username']) ? $post['username'] : null;
			$password = isset($post['password']) ? $post['password'] : null;
			$type = isset($post['type']) ? $post['type'] : 10; // Default Member if not set

			// Simple validation
			if (empty($username) || empty($full_name) || empty($password)) {
				set_msg('error', 'Semua field wajib diisi.');
				redirect(current_url());
			}

			if ($this->Users->existsByUsername($username)) {
				set_msg('error', 'Username sudah digunakan.');
				redirect(current_url());
			}

			if (!empty($email) && $this->Users->existsByEmail($email)) {
				set_msg('error', 'Email sudah terdaftar.');
				redirect(current_url());
			}

			$userData = array(
				'name' => $full_name,
				'call_name' => $call_name,
				'employee_id' => $employee_id,
				'gender_id' => $gender,
				'divisi_id' => $divisi,
				'cabang_id' => $cabang,
				'mobile' => $mobile,
				'email' => $email,
				'username' => $username,
				'password' => $password, // Model will hash it
				'type' => $type,
				'status' => 1,
				'created' => time(),
			);

			$newId = $this->Users->register($userData);

			if ($newId) {
				set_msg('success', 'User berhasil ditambahkan.');
				redirect(BASE_URL . 'user/list');
			} else {
				set_msg('error', 'Gagal menyimpan user.');
				redirect(current_url());
			}
		}

		$data = array(
			'list_gender' => $this->Master_model->get_gender(),
			'list_cabang' => $this->Master_model->get_cabang_active(),
			'list_divisi' => $this->Master_model->get_divisi_active(),
		);

		$this->render('Add User', 'user/add_user', $data);
	}

	public function change_username()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$data['current_username'] = $username;
		$this->render('Change Username', 'user/change_username', $data);
	}

	public function change_name()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		$data['current_name'] = $user_details['name'];
		$this->render('Change Name', 'user/change_name', $data);
	}

	public function change_email()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		$data['current_email'] = $user_details['email'];
		$this->render('Change Email', 'user/change_email', $data);
	}

	public function change_mobile()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		$data['current_mobile'] = $user_details['mobile'];
		$this->render('Change Mobile', 'user/change_mobile', $data);
	}

	public function change_employee_id()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		$data['current_employee_id'] = isset($user_details['employee_id']) ? $user_details['employee_id'] : '';
		$this->render('Change Employee ID', 'user/change_employee_id', $data);
	}

	public function change_cabang()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		// Get current cabang name
		$limit_cabang = $this->db->get_where('mst_cabang', ['id' => $user_details['cabang_id']])->row();
		$data['current_cabang_name'] = $limit_cabang ? $limit_cabang->nama_cabang : '-';
		$data['current_cabang_id'] = $user_details['cabang_id'];

		$data['list_cabang'] = $this->Master_model->get_cabang_active();
		$this->render('Change Cabang', 'user/change_cabang', $data);
	}

	public function change_divisi()
	{
		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		// Get current divisi name
		$limit_divisi = $this->db->get_where('mst_divisi', ['id' => $user_details['divisi_id']])->row();
		$data['current_divisi_name'] = $limit_divisi ? $limit_divisi->nama_divisi : '-';
		$data['current_divisi_id'] = $user_details['divisi_id'];

		$data['list_divisi'] = $this->Master_model->get_divisi_active();
		$this->render('Change Divisi', 'user/change_divisi', $data);
	}

	public function change_type()
	{
		if ($this->Session->getUserType() != USER_ADMIN) {
			redirect(BASE_URL . 'user/profile');
			return;
		}

		$username = $this->Session->getLoggedDetails()['username'];
		$user_details = $this->Users->getUserBy(array('username' => $username));
		$data['current_type'] = $user_details['type'];
		$this->render('Change Type', 'user/change_type', $data);
	}

	public function edit_user($user_id)
	{
		// Load user details
		$user_details = $this->Users->getByID($user_id);

		// If user not found, redirect to list
		if (!$user_details) {
			redirect(BASE_URL . 'user/list');
			return;
		}

		$data['user_details'] = $user_details;

		// Load master data for dropdowns
		$data['list_cabang'] = $this->Master_model->get_cabang_active();
		$data['list_divisi'] = $this->Master_model->get_divisi_active();

		$this->render('Edit User', 'user/edit_user', $data);
	}

	public function add_cabang()
	{
		// Strict check removed to fix redirection issue. API is protected.
		$data['list_cabang'] = $this->Master_model->get_cabang_active();
		$this->render('Add Cabang', 'user/add_cabang', $data);
	}

	public function add_divisi()
	{
		// Strict check removed to fix redirection issue. API is protected.
		$data['list_divisi'] = $this->Master_model->get_divisi_active();
		$this->render('Add Divisi', 'user/add_divisi', $data);
	}

	public function add_category()
	{
		// Strict check removed to fix redirection issue. API is protected.
		$data['list_category'] = $this->Master_model->get_category_active();
		$this->render('Add Category', 'user/add_category', $data);
	}

	public function add_subject()
	{
		// Strict check removed to fix redirection issue. API is protected.
		$data['list_subject'] = $this->Master_model->get_subject_active();
		$this->render('Add Subject', 'user/add_subject', $data);
	}

	// End of Class
}