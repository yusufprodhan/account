<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
        $this->load->database();
        
    }
    
    /**
     * create_user function.
     * 
     * @access public
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @return bool true on success, false on failure
     */
    public function create_user($username, $email, $password) {
        
        $data = array(
            'username'   => $username,
            'email'      => $email,
            'password'   => $this->hash_password($password),
            'created_at' => date('Y-m-j H:i:s'),
        );
        
        return $this->db->insert('users', $data);
        
    }
    
    /**
     * resolve_user_login function.
     * 
     * @access public
     * @param mixed $username
     * @param mixed $password
     * @return bool true on success, false on failure
     */
    public function resolve_user_login($username, $password) {
        
        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $hash = $this->db->get()->row('password');
        return $this->verify_password($password, $hash);
    }


    /**
     * get_user_id_from_username function.
     * 
     * @access public
     * @param mixed $username
     * @return int the user id
     */
    public function get_user_id_from_username($username) {
        
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('username', $username);

        return $this->db->get()->row('id');
        
    }
    
    /**
     * get_user function.
     * 
     * @access public
     * @param mixed $user_id
     * @return object the user object
     */
    public function get_user($user_id) {
        $this->db->select('users.*,user_type.type');
        $this->db->from('users');
        $this->db->join('user_type','user_type.id = users.user_type_id');        
        $this->db->where('users.id', $user_id);
        return $this->db->get()->row();
        
    }

    /**
    * get_user_type function
    * 
    * @access public
    * @param int $user_id
    * @return string the user type name
    */
    public function get_user_type($user_id){
        $query = $this->db->query("SELECT `name` FROM `user_type` WHERE `id` = (SELECT `user_type_id` FROM `users` WHERE `id` = '$user_id') ");
        $row = $query->row();
        if (isset($row)) {
            return strtolower($row->name);
        }
    }
    
    /**
     * hash_password function.
     * 
     * @access private
     * @param mixed $password
     * @return string|bool could be a string on success, or bool false on failure
     */
    private function hash_password($password) {
        
        //return password_hash($password, PASSWORD_BCRYPT);
        return md5($password);
        
    }
    
    /**
     * verify_password_hash function.
     * 
     * @access private
     * @param mixed $password
     * @param mixed $hash
     * @return bool
     */
    private function verify_password($password, $hash) {
        
        if(md5($password) == $hash){
            return true;
        }

        return false;
        
    }

}