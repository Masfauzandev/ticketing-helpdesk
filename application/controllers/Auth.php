<?PHP

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setHeaderFooter('auth/header.php', 'auth/footer.php');
		$this->load->model('user/Auth_model', 'Auth');
		$this->load->model('notification/Sms_model', 'SMS');
		$this->load->model('core/Token_model', 'PIN');
		$this->load->model('Master_model');
		$this->load->model('User_model', 'User');
		$this->load->database();
	}

	private function redirectIfLogged()
	{
		if ($this->Session->isLoggedin()) {
			if ($this->Session->getUserType() == USER_ADMIN)
				redirect(URL_POST_LOGIN_ADMIN);
			else if ($this->Session->getUserType() == USER_MEMBER)
				redirect(URL_POST_LOGIN_USER);
			else if ($this->Session->getUserType() == USER_AGENT)
				redirect(URL_POST_LOGIN_AGENT);
			else if ($this->Session->getUserType() == USER_MANAGER)
				redirect(URL_POST_LOGIN_MANAGER);
			else if ($this->Session->getUserType() == USER_LIMITED)
				redirect(URL_POST_LOGIN_LIMITED);
			else if ($this->Session->getUserType() == USER_DEACTIVATED)
				redirect(URL_POST_LOGIN_DEACTIVATED);

			return true;
		}
		return false;
	}



	public function index()
	{
		$this->login();
	}


	/**
	 * unauthorized landing page
	 */
	public function unauthorized()
	{
		$this->render('Unauthorized', 'auth/unauthorized');
	}


	/**
	 * Registration landing page
	 */
	public function register()
	{
		$this->requirePermissions(PERMISSION_AUTH_REGISTER);

		if ($this->isPOST()) {
			// Ambil semua POST
			$post = $this->input->post();

			// ========== AMBIL FIELD DENGAN BACKUP NAMA LAMA ==========
			// full_name atau nama_lengkap
			$full_name = $post['full_name'] ?? $post['nama_lengkap'] ?? null;
			// call_name atau nama_panggilan
			$call_name = $post['call_name'] ?? $post['nama_panggilan'] ?? null;
			// office_email atau email_kantor
			$office_email = $post['office_email'] ?? $post['email_kantor'] ?? null;

			$employee_id = $post['employee_id'] ?? $post['id_karyawan'] ?? null;
			$gender = $post['gender'] ?? $post['jenis_kelamin'] ?? null;
			$divisi = $post['divisi'] ?? $post['jabatan'] ?? null;
			$cabang = $post['cabang'] ?? null;
			$no_hp = $post['no_hp'] ?? null;
			$username = $post['username'] ?? null;
			$password = $post['password'] ?? null;
			$password_confirm = $post['password_confirm'] ?? null;

			// ========== VALIDASI DASAR ==========

			// Password konfirmasi
			if ($password !== $password_confirm) {
				set_msg('error', 'Password dan konfirmasi password tidak sama.');
				redirect(current_url());
			}

			// Username wajib ada
			if (empty($username)) {
				set_msg('error', 'Username wajib diisi.');
				redirect(current_url());
			}

			// Username unik
			if ($this->User->existsByUsername($username)) {
				set_msg('error', 'Username sudah digunakan, silakan pilih username lain.');
				redirect(current_url());
			}

			// Email kantor unik (kalau diisi)
			if (!empty($office_email) && $this->User->existsByEmail($office_email)) {
				set_msg('error', 'Email kantor sudah terdaftar.');
				redirect(current_url());
			}

			// Full name wajib
			if (empty($full_name)) {
				set_msg('error', 'Full Name wajib diisi.');
				redirect(current_url());
			}

			// ========== SIAPKAN DATA UNTUK INSERT KE TABEL USERS ==========

			$userData = array(
				'name' => $full_name,      // kolom name
				'call_name' => $call_name,      // kolom call_name
				'employee_id' => $employee_id,    // kolom employee_id
				'gender_id' => $gender,         // kolom gender_id
				'divisi_id' => $divisi,         // kolom divisi_id
				'cabang_id' => $cabang,         // kolom cabang_id
				'mobile' => $no_hp,          // kolom mobile
				'email' => $office_email,   // kolom email
				'username' => $username,       // kolom username
				'password' => $password,       // plain → akan di-hash di User_model->register()
				'type' => 10,              // tipe user LKI
				'status' => 1,               // aktif
				'created' => time(),
			);

			// ========== SIMPAN KE DATABASE ==========

			$newId = $this->User->register($userData);

			if ($newId) {
				set_msg('success', 'Pendaftaran akun berhasil. Silakan login.');
				redirect(URL_LOGIN);
			} else {
				set_msg('error', 'Gagal menyimpan data. Silakan coba lagi.');
				redirect(current_url());
			}
		}

		// ========== DROPDOWN DATA ==========

		$viewData = array(
			'list_gender' => $this->Master_model->get_gender(),
			'list_cabang' => $this->Master_model->get_cabang_active(),
			'list_divisi' => $this->Master_model->get_divisi_active(),
		);

		$this->addLookupPaths(array(DEFAULT_VIEW_FOLDER));
		$this->render('Register', 'auth/register', array('data' => $viewData));
	}




	public function registerPayment()
	{
		//		$this->redirectIfLogged();
		if ($this->isPOST()) {
			$refer = $_POST['referer'] = getUserID($_POST['referer']);
			$aadhar_no = trim($_POST['aadhar_no']);
			//Validate refer presence
			if (!$this->User->getByID($refer))
				set_msg('error', "Refer ID is not found. Please use valid refer ID");
			else {
				if (count($this->User->getBy(null, array('aadhar_no' => $aadhar_no)))) {
					set_msg('error', "Given Aadhar ID is already registered with us.");
					// Save user info and transaction information.
				} else {
					$_SESSION['pending_registration'] = $_POST;
					$this->load->model('payment/Paytm_model', 'Paytm');
					$desc = 'Member Registration for ' . $_POST['name'] . ', Referrer - ' . $_POST['referer'] . ', Mobile number - ' . $_POST['mobile'];
					$payment = $this->Paytm->generateTX(USER_SYSTEM_USERID, CLIENT_REGISTRATION_FEE, 0, TX_TYPE_DEPOSIT, $desc);

					$payment['redirect'] = BASE_URL . "/auth/registration_payment";
					$_SESSION[PAYMENT_SESSION_KEY] = $payment;

					echo $payment['html'];
					return;
				}
			}
		}
		$this->render('Register', 'auth/register', array('data' => array('referer' => (isset($_GET['r']) ? $_GET['r'] : ''))));
	}

	/**
	 * To be called once payment of registration is done.
	 */
	public function registration_payment()
	{
		$this->load->model('payment/Payment_model', 'Payment');

		if (Payment_model::getPaymentStatus() == false)
			return redirect(URL_PAYMENT_DONE);
		else {
			// $_SESSION['pending_registration'] = $_POST;
			//if($payment['amount']!==data from confirm tx)
			$registration = $_SESSION['pending_registration'];

			//cleanup
			unset($_SESSION['pending_registration']);
			//register user
			$user_details = $this->User->register($registration);
			//if status is array and id is set.
			if (is_array($user_details) && isset($user_details['id'])) {
				$_SESSION['registration_pin'] = substr(str_shuffle('BCDFGHJKLMNPQRSTVWXYZ123456789'), 0, 8);
				$uid = $user_details['id'];
				$activation_status = $this->User->activateUser($uid);
				// Payment_model::setPaymentStatus(true, "Congratulations you have been successfully registered.  User ID " . $user_details['username'] . " password has been sent to your registered mobile.");
				Payment_model::setPaymentStatus(true, "Congratulations,<br>Your PIN generated <br> <br> <span style=' color: #008000; background-color: #b3ffb3; padding: 5px;'>" . $_SESSION['registration_pin'] . " </span><br><br>  You have been successfully registered with it.  User ID " . $user_details['username'] . " password has been sent to your registered mobile.");
				unset($_SESSION['registration_pin']);
			} else
				Payment_model::setPaymentStatus(false, BinaryUser_model::$REGISTRATION_STATUS[$user_details] . " Ref: " . $_SESSION[PAYMENT_SESSION_KEY]['id']);

			redirect(URL_PAYMENT_DONE);
		}

	}


	public function aadharCheck()
	{
		$aadhar_no = trim($_POST['aadhar_no']);
		if (count($this->User->getBy(null, array('aadhar_no' => $aadhar_no)))) {
			set_msg('error', "Given Aadhar ID is already registered with us.");
			// Save user info and transaction information.
		}
	}


	/**
	 * Login landing page.
	 */
	public function login()
	{
		$this->requirePermissions(PERMISSION_AUTH_LOGIN);
		$this->redirectIfLogged();
		if ($this->isPOST()) {
			if ($this->process_login())
				return;
		}
		$this->render('Login', 'auth/login');
	}


	/**
	 * Login processing logic
	 * @return bool
	 */
	private function process_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$authData = array(
			'username' => $username,
			'password' => $password,
		);
		$result = $this->Auth->login($authData);
		if (!$result) {
			set_msg('error', 'Invalid username or password!');
			return false;
		} else {
			// Update last_login timestamp
			$this->db->where('id', $result['id']);
			$this->db->update('users', array('last_login' => time()));

			/* $this->Session->login($result['id'], DEFAULT_USER_PERMISSIONS, $result);
			if ($this->Session->isAdmin()) */
			$this->Session->login($result['id'], $this->Session->getDefaultPermissions($result['type']), $result);
			if ($this->Session->getUserType() == USER_ADMIN)
				redirect(URL_POST_LOGIN_ADMIN);
			else if ($this->Session->getUserType() == USER_MEMBER)
				redirect(URL_POST_LOGIN_USER);
			else if ($this->Session->getUserType() == USER_AGENT)
				redirect(URL_POST_LOGIN_AGENT);
			else if ($this->Session->getUserType() == USER_MANAGER)
				redirect(URL_POST_LOGIN_MANAGER);
			else if ($this->Session->getUserType() == USER_LIMITED)
				redirect(URL_POST_LOGIN_LIMITED);
			else if ($this->Session->getUserType() == USER_DEACTIVATED)
				redirect(URL_POST_LOGIN_DEACTIVATED);
			return true;
		}
	}


	/**
	 * Forgot password page.
	 */
	public function forgot_password()
	{
		$this->redirectIfLogged();
		$this->render('Forgot Password', 'auth/forgot_password');
	}


	/**
	 * Process logic of forgot password
	 */
	public function process_forgot()
	{
		$username = trim($this->input->post('username'));
		$email = trim($this->input->post('email'));

		if (empty($username)) {
			set_msg('error', 'Username required');
			redirect(base_url('auth/forgot_password'));
		}

		if (empty($email)) {
			set_msg('error', 'Email required');
			redirect(base_url('auth/forgot_password'));
		}

		// Find user directly by username (avoid getUserID issues)
		$user = $this->db->where('username', $username)->get('users')->row_array();
		if (empty($user)) {
			set_msg('error', 'Username not found in our record');
			redirect(base_url('auth/forgot_password'));
		}

		// Email must match the registered email
		if (strcasecmp(trim($user['email']), trim($email)) !== 0) {
			set_msg('error', 'Email does not match our records.');
			redirect(base_url('auth/forgot_password'));
		}

		// Generate new password (6 digits)
		$newPasswordPlain = mt_rand(100000, 999999);
		$hashedPassword = $this->User->hashPassword($newPasswordPlain);

		// ---- Send email FIRST (safer), then update password ----
		$this->load->library('email');

		// Apply SMTP config from client.config.php
		$this->email->initialize(CLIENT_SMTP_CONFIG);

		$fromEmail = defined('CLIENT_FROM_EMAIL') ? CLIENT_FROM_EMAIL : 'no-reply@' . CLIENT_DOMAIN;
		$replyTo = defined('CLIENT_REPLYTO_EMAIL') ? CLIENT_REPLYTO_EMAIL : $fromEmail;

		$this->email->from($fromEmail, PRODUCT_NAME);
		$this->email->reply_to($replyTo);
		$this->email->to($user['email']);

		$this->email->subject('Password Reset - ' . PRODUCT_NAME);

		$body = ''
			. '<p>Dear ' . htmlspecialchars($user['name']) . ',</p>'
			. '<p>Your password has been reset successfully.</p>'
			. '<p><strong>Username:</strong> ' . htmlspecialchars($username) . '<br>'
			. '<strong>New Password:</strong> ' . htmlspecialchars($newPasswordPlain) . '</p>'
			. '<p>Please login and change your password immediately.</p>'
			. (defined('CLIENT_MAIL_FOOTER') ? CLIENT_MAIL_FOOTER : '');

		$this->email->message($body);

		if (!$this->email->send()) {
			// DO NOT update password if email fails
			set_msg('error', 'Failed to send reset password email. Please try again later.');
			redirect(base_url('auth/forgot_password'));
		}

		// Email sent -> now update password
		$res = $this->User->update($user['id'], array('password' => $hashedPassword));

		if ($res) {
			set_msg('success', 'A new password has been sent to your registered email address.');
			redirect(base_url('auth/forgot_password'));
		} else {
			set_msg('error', 'There was some error processing your request!');
			redirect(base_url('auth/forgot_password'));
		}
	}




	public function reset_password()
	{
		$username = $this->input->get('username');
		$token = $this->input - get('token');
		if (!$username || !$token) {
			set_msg('error', 'Invalid URL');
			redirect(URL_LOGIN);
		}

		$newPassword = $this->Auth->verifyPasswordResetLink($username, $password);
		if (!$newPassword) {
			set_msg('error', 'Invalid URL');
			redirect(URL_LOGIN);
		}

		set_msg('success', $newPassword);
		redirect(URL_LOGIN);
	}

	public function logout()
	{
		$this->Session->logout();
		redirect(URL_LOGIN);
	}


	public function register_single_leg($postData)
	{

		if ($postData['payment_mode'] == 'PIN') {
			if (isset($postData['pin_num']) && $postData['pin_num'] != '') {
				$pin_details = $this->PIN->getPINdetails($postData['pin_num']);
				if (empty($pin_details)) {
					set_msg('error', "Invalid PIN inserted..");
					redirect('auth/register');
				} else {
					$pinAmount = json_decode($pin_details['meta'], true)['amount'];
					$pinStatus = $pin_details['status'];
					if ($pinStatus == 1) {
						if ($pinAmount == CLIENT_USER_REGISTRATION_AMOUNT) {
							// set_msg('success', "This PIN is valid..");
							$user_details = $this->User->register($postData);

							//if status is array and id is set.
							if (is_array($user_details) && isset($user_details['id'])) {
								$uid = $user_details['id'];
								$this->PIN->deactivatePIN($postData['pin_num']);
								$this->SingleLedger->createTX(USER_SYSTEM_USERID, $pinAmount, 0, TX_TYPE_ADMIN_FEE, '[Fee] User registerastion ' . $user_details['username'], 0, TX_STATUS_DONE);
								$activation_status = $this->User->activateUser($uid);
								set_msg('success', "Successfully registered member.  User ID " . $user_details['username'] . " password has been sent to the registered mobile.");
								redirect('auth/register');

							} else
								set_msg('error', BinaryUser_model::$REGISTRATION_STATUS[$user_details]);
							redirect('auth/register');
						} else
							set_msg('error', "PIN amount is not enough fro registration");
						redirect('auth/register');
					} else {
						set_msg('error', "This PIN is no longer valid..");
						redirect('auth/register');
					}
				}
			}
		} else if ($postData['payment_mode'] == 'PYTM') {
			// paytm register page
			echo $this->Auth->do_payment($postData);
			return;
			$user_details = $this->User->register($postData);

			if (is_array($user_details) && isset($user_details['id'])) {
				$uid = $user_details['id'];
				set_msg('success', 'You have successfully registered. Your ID is ' . formatUserID($uid) . '. Please login.');
				redirect('auth/register');
			}
		} else if ($postData['payment_mode'] == 'NOPAY') {
			$user_type = USER_TYPE_LIMITED;

			$postData['type'] = $user_type;
			$reg = $postData;
			// print_r($reg);
			$reg['aadhar_no'] = (isset($postData['aadhar_no'])) ? trim($postData['aadhar_no']) : '';
			$user_details = $this->User->register($reg);

			if (is_array($user_details) && isset($user_details['id'])) {
				$uid = $user_details['id'];
				// $act_status = $this->User->activateUser($uid);
				set_msg('success', 'You have successfully registered. Your ID is ' . formatUserID($uid) . '. Please login.');
				redirect('auth/register');
			}
		}

	}

	public function register_donation($post_data)
	{
		$post_data['type'] = USER_TYPE_LIMITED;
		$_SESSION['pending_registration'] = $post_data;
		$this->load->model('payment/Paytm_model', 'Paytm');
		$desc = 'Member Registration for ' . $post_data['name'] . ', Referrer - ' . $post_data['referer'] . ', Mobile number - ' . $post_data['mobile'];
		if ($post_data['p_mode'] == 'paytm') {
			$payment = $this->Paytm->generateTX(USER_SYSTEM_USERID, CLIENT_REGISTRATION_FEE, 0, TX_TYPE_ADMIN_FEE, $desc);
			$payment['redirect'] = BASE_URL . "/auth/registration_payment";
			$_SESSION[PAYMENT_SESSION_KEY] = $payment;
			echo $payment['html'];
			return;
		} else if ($post_data['p_mode'] == 'pin') {
			$pin_details = $this->PIN->getPINdetails($post_data['pin_num']);
			if (empty($pin_details)) {
				set_msg('error', "Invalid PIN inserted..");
			} else {
				$pinAmount = json_decode($pin_details['meta'], true)['amount'];
				$pinStatus = $pin_details['status'];
				// print_r($pinAmount);
				if ($pinStatus == 1) {
					if ($pinAmount == AIOPIN) {
						// set_msg('success', "This PIN is valid..");
						$user_details = $this->User->register($post_data);

						//if status is array and id is set.
						if (is_array($user_details) && isset($user_details['id'])) {
							$uid = $user_details['id'];
							$this->PIN->deactivatePIN($post_data['pin_num']);
							$desc = 'Member Registration for ' . $post_data['name'] . ', Referrer - ' . $post_data['referer'] . ', Mobile number - ' . $post_data['mobile'];
							$this->SingleLedger->createTX(USER_SYSTEM_USERID, $pinAmount, 0, TX_TYPE_ADMIN_FEE, $desc, 0, TX_STATUS_DONE);
							$activation_status = $this->User->activateUser($uid);

							$upline = $this->User->getParent($uid)['parent'] ?? '';
							$upperline = $this->User->getParent($upline)['parent'] ?? '';

							$this->ledger->createTX($upline, CLIENT_UPLINE_DONATION_AMT, 0, TX_TYPE_DONATION, "Donate to upline", 1, TX_STATUS_APPROVE, "", $uid);

							$this->ledger->createTX($upperline, CLIENT_UPPERLINE_DONATION_AMT, 0, TX_TYPE_DONATION, "Donate to upperline", 1, TX_STATUS_APPROVE, "", $uid);


							$message = "Dear User....thank you";
							// $this->SMS->sendTemplated($post_data['mobile'], $message, array());
							set_msg('success', "Successfully registered member.  User ID " . $user_details['username'] . " password has been sent to the registered mobile.");

						} else
							set_msg('error', BinaryUser_model::$REGISTRATION_STATUS[$user_details]);
					} else if ($pinAmount == CLIENT_USER_REGISTRATION_AMOUNT) {
						set_msg('success', "This PIN is valid..");
						$user_details = $this->User->register($post_data);

						//if status is array and id is set.
						if (is_array($user_details) && isset($user_details['id'])) {
							$uid = $user_details['id'];
							$this->PIN->deactivatePIN($post_data['pin_num']);
							$desc = 'Member Registration for ' . $post_data['name'] . ', Referrer - ' . $post_data['referer'] . ', Mobile number - ' . $post_data['mobile'];
							$this->SingleLedger->createTX(USER_SYSTEM_USERID, $pinAmount, 0, TX_TYPE_ADMIN_FEE, $desc, 0, TX_STATUS_DONE);
							$activation_status = $this->User->activateUser($uid);
							$message = "Dear User....thank you";
							// $this->SMS->sendTemplated($post_data['mobile'], $message, array());
							set_msg('success', "Successfully registered member.  User ID " . $user_details['username'] . " password has been sent to the registered mobile.");

						} else
							set_msg('error', BinaryUser_model::$REGISTRATION_STATUS[$user_details]);
					} else
						set_msg('error', "PIN amount is not enough fro registration");
				} else {
					set_msg('error', "This PIN is no longer valid..");
				}
			}
		}
	}

	public function register_binary($post_data)
	{
		if ($post_data['reg_as'] == 0) {
			echo $this->Auth->do_payment($_POST);
			return;
		} else {
			$user_type = USER_TYPE_LIMITED;

			$post_data['type'] = $user_type;
			$reg = $post_data;
			// print_r($reg);
			$reg['aadhar_no'] = (isset($post_data['aadhar_no'])) ? trim($post_data['aadhar_no']) : '';
			$user_details = $this->User->register($reg);

			if (is_array($user_details) && isset($user_details['id'])) {
				$uid = $user_details['id'];
				// $act_status = $this->User->activateUser($uid);
				set_msg('success', 'You have successfully registered. Your ID is ' . formatUserID($uid) . '. Please login.');
				redirect('auth/register');
			}
		}
	}







}
