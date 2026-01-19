<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.3/PasswordHash.php');

define('PHPASS_HASH_STRENGTH', 8);
define('PHPASS_HASH_PORTABLE', false);

/**
 * SimpleLoginSecure Class
 *
 * Makes authentication simple and secure.
 *
 * Simplelogin expects the following database setup. If you are not using 
 * this setup you may need to do some tweaking.
 *   
 * 
 *   CREATE TABLE `users` (
 *     `id` int(10) unsigned NOT NULL auto_increment,
 *     `email` varchar(255) NOT NULL default '',
 *     `password` varchar(60) NOT NULL default '',
 *     `user_date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'Creation date',
 *     `user_modified` datetime NOT NULL default '0000-00-00 00:00:00',
 *     `user_last_login` datetime NULL default NULL,
 *     PRIMARY KEY  (`id`),
 *     UNIQUE KEY `email` (`email`),
 *   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * 
 * @package   SimpleLoginSecure
 * @version   2.1.1
 * @author    Stéphane Bourzeix, Pixelmio <stephane[at]bourzeix.com>
 * @copyright Copyright (c) 2012-2013, Stéphane Bourzeix
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt
 * @link      https://github.com/DaBourz/SimpleLoginSecure
 */
class SimpleLoginSecure
{
	var $CI;
	var $user_table = 'users';

	/**
	 * Create a user account
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function create($name='',$email = '', $password = '', $phone_number='',$type=1 ,$auto_login = true) 
	{
		$this->CI =& get_instance();
		


		//Make sure account info was sent
		if($email == '' OR $password == '') {
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('email', $email); 
		$query = $this->CI->db->get_where($this->user_table);
		
		if ($query->num_rows() > 0) //email already exists
			return false;

		//Hash password using phpass
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$password_hashed = $hasher->HashPassword($password);

		//Insert account into the database
		$data = array(
					'name' =>$name,
					'email' => $email,
					'password' => $password_hashed,
					'phone_number' => $phone_number,
					'type'	=> $type,
					'user_date' => date('c'),
					'user_modified' => date('c'),
				);		
		$this->CI->db->set($data); 

		if(!$this->CI->db->insert($this->user_table)) //There was a problem! 
			return false;						
				
		if($auto_login)
			$this->login($email, $password);
		
		return true;
	}

	/**
	 * Update a user account
	 *
	
	 * @access	public
	 * @param integer
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function update($id = null, $password='',$profile_pic='', $auto_login = true) 
	{
		$this->CI =& get_instance();

		//Make sure account info was sent
		if($id == null) {
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('id', $id);
		$query = $this->CI->db->get_where($this->user_table);
		
		if ($query->num_rows() == 0){ // user don't exists
			return false;
		}

		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$password_hashed = $hasher->HashPassword($password);
		//Update account into the database
		$data = array(
					'password' => $password_hashed,
					'profile_pic' => $profile_pic,
					'user_modified' => date('c'),
				);
		$this->CI->db->where('id', $id);

		if(!$this->CI->db->update($this->user_table, $data)) //There was a problem! 
			return false;						
				
		if($auto_login){
			$this->CI->db->where('id', $id);
			$query = $this->CI->db->get_where($this->user_table);
			if ($query->num_rows() == 0){ // user don't exists
				$user_data['user'] = $query->first_rows(); 
				$this->CI->session->set_userdata($user_data);
			}		
		}
		return true;
	}

	
	
	/**
	 * Update a user account
	 *
	
	 * @access	public
	 * @param integer
	 * @param	string
	 * @param	bool
	 * @return	bool
	 */
	function updateProfilePic($id = null,$profile_pic='', $auto_login = true) 
	{
		$this->CI =& get_instance();

		//Make sure account info was sent
		if($id == null) {
			return false;
		}
		
		//Check against user table
		$this->CI->db->where('id', $id);
		$query = $this->CI->db->get_where($this->user_table);
		
		if ($query->num_rows() == 0){ // user don't exists
			return false;
		}
	
		//Update account into the database
		$data = array(
					'profile_pic' => $profile_pic,
					'user_modified' => date('c'),
				);
 
		$this->CI->db->where('id', $id);

		if(!$this->CI->db->update($this->user_table, $data)) //There was a problem! 
			return false;						
				
		if($auto_login){
			$user_data['email'] = $email;
			$user_data['user'] = $user_data['email']; // for compatibility with Simplelogin
			
			$this->CI->session->set_userdata($user_data);
			}
		return true;
	}
	/**
	 * Login and sets session variables
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($email = '', $password = '') 
	{
		$this->CI =& get_instance();

		if($email == '' OR $password == '')
			return false;


		//Check if already logged in
		
		if($this->CI->session->userdata('email') == $email)
			return true;
		
		
		//Check against user table
		$this->CI->db->where('email', $email); 
		$query = $this->CI->db->get_where($this->user_table);

		
		if ($query->num_rows() > 0) 
		{
			$user_data = $query->row_array(); 
		//	print_r($user_data);
			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

			if(!$hasher->CheckPassword($password, $user_data['password']))
            
				return false;

			//Destroy old session
			$this->CI->session->sess_destroy();
			
			//Create a fresh, brand new session
			$this->CI->session->sess_create();
			$this->CI->db->simple_query('UPDATE ' . $this->user_table  . ' SET user_last_login = "' . date('c') . '" WHERE id = ' . $user_data['id']);
			//Set session data
			unset($user_data['password']);
			$user_data['user'] = $user_data; // for compatibility with Simplelogin
			$user_data['logged_in'] = true;
			$this->CI->session->set_userdata($user_data);
			
			return true;
		} 
		else 
		{
			return false;
		}	

	}

	/**
	 * Logout user
	 *
	 * @access	public
	 * @return	void
	 */
	function logout() {
		$this->CI =& get_instance();		

		$this->CI->session->sess_destroy();
	}

	/**
	 * Delete user
	 *
	 * @access	public
	 * @param integer
	 * @return	bool
	 */
	function delete($id) 
	{
		$this->CI =& get_instance();
		
		if(!is_numeric($id))
			return false;			

		return $this->CI->db->delete($this->user_table, array('id' => $id));
	}
	
	
	/**
	* Edit a user password
	* @author    Stéphane Bourzeix, Pixelmio <stephane[at]bourzeix.com>
	* @author    Diego Castro <castroc.diego[at]gmail.com>
	*
	* @access  public
	* @param  string
	* @param  string
	* @param  string
	* @return  bool
	*/
	function edit_password($email = '', $old_pass = '', $new_pass = '')
	{
		$this->CI =& get_instance();
		// Check if the password is the same as the old one
		$this->CI->db->select('password');
		$query = $this->CI->db->get_where($this->user_table, array('email' => $email));
		$user_data = $query->row_array();

		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);	
		/*if (!$hasher->CheckPassword($old_pass, $user_data['password'])){ //old_pass is the same
			return FALSE;
		}*/
		
		// Hash new_pass using phpass
		$password_hashed = $hasher->HashPassword($new_pass);
		// Insert new password into the database
		$data = array(
			'password' => $password_hashed,
			'user_modified' => date('c')
		);
		
		$this->CI->db->set($data);
		$this->CI->db->where('email', $email);
		if(!$this->CI->db->update($this->user_table, $data)){ // There was a problem!
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}
?>
