<?PHP

require_once __DIR__ . "/constants.php";

class User_model extends BaseMySQL_model
{
	public static $CHANGE_PASSWORD_MSG = array(
		1 => 'Successfully changed password.',
		0 => 'There was some error creating your account! Please try again later.',
		-1 => 'Incorrect old password',

	);

	public function __construct()
	{
		parent::__construct(TABLE_USER);
	}

	//Test Function to test the class
	public function test()
	{
		//Might give error for Authentication since multiple users
		//might have been created with same info
		$data = array(
			"name" => "James Bond",
			"email" => "james@bond.com",
			"username" => "james",
			"password" => "test@123",
		);

		$regId = $this->create($data);
		$loginTest = $this->isAuthorized($data['username'], $data['password']);
		if (!$loginTest) {
			echo "User_model -> isAuthorized() -> ERROR";
		} else {
			echo "isAuthorized() --> Successful";
		}

		$updateData = array("email" => "david_c@gmail.com");

		$updateUser = $this->update($regId, $updateData);
		$users = $this->getUsersBy(null, array("id" => $regId));
		if (count($users) > 0) {
			echo "getUsersBy() --> Successfull!";
		} else {
			echo "getUsersBy() --> ERROR!";
		}

		if ($users[0]['email'] == $updateData['email']) {
			echo "updateUser() --> Successfull!";
		} else {
			echo "updateUser() --> Error!";
		}

		$allUsers = $this->getAllUsers();
		if (count($allUsers) > 0) {
			echo "getAllUsers() --> Successful!";
		} else {
			echo "getUsersBy() --> Error!";
		}

		return;
	}

	/**
	 * Get a user's details by different fields
	 * @param $fields
	 * @return mixed
	 */
	public function getUserBy($fields)
	{
		return self::getOneItem(self::getBy(null, $fields));
	}

	public function getUserCreatedDate($uid)
	{
		$return = $this->db->select('created')
			->where('id', $uid)
			->get(TABLE_USER)->result_array();
		return $return[0]['created'];
		// print_r($return);
	}

	/**
	 * Register a user by details.
	 * Dipakai juga untuk register LKI.
	 * @param $data
	 * @return mixed
	 */
	public function register($data)
	{
		// hash password sebelum simpan
		if (!empty($data['password'])) {
			$data['password'] = $this->hashPassword($data['password']);
		}
		$result = parent::add($data);
		return $result;
	}


	/**
	 * Check if user is authorized by the uid.
	 * @param $uid
	 * @param $password
	 * @return bool
	 */
	public function isAuthorized($uid, $password)
	{
		$user = parent::getOneItem(parent::getBy("*", array("id" => $uid)));
		if (!$user) return false;
		return $this->verifyPassword($password, $user['password']);
	}


	/**
	 * Hash password using bcrypt (modern, secure).
	 * @param string $password Plain text password
	 * @return string Bcrypt hash
	 */
	public function hashPassword($password)
	{
		return password_hash($password, PASSWORD_BCRYPT);
	}

	/**
	 * Verify plain password against hash.
	 * Supports both bcrypt and legacy MD5 hashes.
	 * @param string $plain_password
	 * @param string $hashed_password
	 * @return bool
	 */
	public function verifyPassword($plain_password, $hashed_password)
	{
		// Check bcrypt first
		if (password_verify($plain_password, $hashed_password)) {
			return true;
		}
		// Fallback: check legacy MD5 hash
		if ($this->isMD5($hashed_password) && md5($plain_password) === $hashed_password) {
			return true;
		}
		return false;
	}

	/**
	 * Check if a hash looks like MD5 (32 hex chars).
	 * @param string $hash
	 * @return bool
	 */
	public function isMD5($hash)
	{
		return (bool) preg_match('/^[a-f0-9]{32}$/i', $hash);
	}

	/**
	 * Check if password needs rehashing (e.g. still MD5).
	 * @param string $hashed_password
	 * @return bool
	 */
	public function needsRehash($hashed_password)
	{
		if ($this->isMD5($hashed_password)) return true;
		return password_needs_rehash($hashed_password, PASSWORD_BCRYPT);
	}

	public function update($uId, $update)
	{
		$result = parent::setByID($uId, $update);
		return $result;
	}

	public function findUserDetailsByPrimary($fields, $text)
	{
		return $this->db->select($fields)->or_where(array('username' => $text, 'mobile' => $text, 'email' => $text))->limit(1)->get(TABLE_USER)->result_array();
	}



	public function getUsersBy($field = null, $value = null)
	{
		throw new Error("GetUsersBy is not implemented.");
	}


	public function getUserDetails($uid, $fields = null)
	{
		return parent::getByID($uid, $fields);
	}

	public function getBankDetails($uid)
	{
		return $this->db->select(TABLE_BANK_DETAILS . '.account_number, ' . TABLE_BANK_DETAILS . '.account_holder, ' . TABLE_BANK_DETAILS . '.ifsc_code, ' . TABLE_BANK_DETAILS . '.bank_name, ' . TABLE_BANK_DETAILS . '.uid, ' . TABLE_BANK_DETAILS . '.bank_address, tb.name as bank_full_name')
			->join(TABLE_BANKS . ' as tb', 'tb.id = ' . TABLE_BANK_DETAILS . '.bank_name', 'right')->where(array('uid' => $uid))->get(TABLE_BANK_DETAILS)->result_array();
	}

	public function updateBankDetails($uid, $info)
	{
		$update_info = getValuesOfKeys($info, array('account_number', 'ifsc_code', 'account_holder', 'bank_name', 'bank_address'));

		$bank_details = $this->db->where(array('uid' => $uid))->get(TABLE_BANK_DETAILS)->result_array();
		print_r($update_info);
		print_r($bank_details);
		if (count($bank_details))
			return $this->db->where(array('uid' => $uid))->update(TABLE_BANK_DETAILS, $update_info);
		else {
			$update_info['uid'] = $uid;
			return $this->db->insert(TABLE_BANK_DETAILS, $update_info);
		}

	}

	public function uploadProfilePicture($uId, $file, $orig_name)
	{
		if ($orig_name) {
			$config['upload_path'] = SETTING_PROFILE_PATH;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = false;
			$config['overwrite'] = true;

			// new name with uid and extensions
			$config['file_name'] = $uId . '.png';

			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($file)) {
				$error = array('error' => $this->upload->display_errors());
				return $error;
			} else {
				$data = $this->upload->data();
				return $config['upload_path'] . $data['file_name'];
			}
		}

	}

	public function updateProfile($info, $files, $allow_specific_edits, $uid = null)
	{
		$fields = array('gender', 'city', 'state', 'dob', 'address', 'meta');
		$specific_edits = array('name', 'father', 'mobile', 'email');
		if ($allow_specific_edits)
			$fields = array_merge($fields, $specific_edits);

		$member = getValuesOfKeys($info, $fields);
		$member['meta'] = 'AltMob:' . $info['mobile2'];
		if ($files)
			$this->uploadProfilePicture($uid, 'profile', $files['profile']['name']);
		if (!$uid)
			$uid = $this->Session->getLoggedUsername();
		$result = parent::update($uid, $member);
		return $result;

	}

	public function changePassword($uid, $old_password, $new_password)
	{
		$user = parent::getByID($uid);
		if (!$user) return -1;
		if ($this->verifyPassword($old_password, $user['password'])) {
			return $this->update($uid, array('password' => $this->hashPassword($new_password)));
		} else
			return -1;
	}

	public function getUserByUsernameAndUid($username, $uid)
	{
		return $this->db->get_where('users', ['username' => $username, 'id' => $uid])->row();
	}

	public function getWhereFieldIn($select, $field, $where_in)
	{
		if ($select == null)
			$select = "*";
		$query = $this->db->select($select);
		if (!empty($where_in)) {
			$query = $query->or_where_in($field, $where_in);
		}
		return $query->get(TABLE_USER)->result_array();
	}

	/* ============================================================
	 *              FUNGSI TAMBAHAN UNTUK REGISTER LKI
	 * ============================================================
	 */

	/**
	 * Cek apakah username sudah dipakai.
	 * @param string $username
	 * @return bool
	 */
	public function existsByUsername($username)
	{
		return $this->db
			->where('username', $username)
			->count_all_results(TABLE_USER) > 0;
	}

	/**
	 * Cek apakah email sudah dipakai.
	 * @param string $email
	 * @return bool
	 */
	public function existsByEmail($email)
	{
		return $this->db
			->where('email', $email)
			->count_all_results(TABLE_USER) > 0;
	}

	public function makeDatatableQuery($table, $context, $db, $arguments = null)
	{
		return array(
			'columns' => array(
				'id' => TABLE_USER . ".id",
				'name' => TABLE_USER . ".name",
				'email' => TABLE_USER . ".email",
				'mobile' => TABLE_USER . ".mobile",
				'username' => TABLE_USER . ".username",
				'type' => TABLE_USER . ".type",
				'status' => TABLE_USER . ".status",
				'created' => TABLE_USER . ".created",
				'last_login' => TABLE_USER . ".last_login",
				'last_ip' => TABLE_USER . ".last_ip",
				'last_os' => TABLE_USER . ".last_os",
				'last_pc_name' => TABLE_USER . ".last_pc_name",
			),
		);
	}

}
