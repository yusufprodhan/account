<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile {
	public function __construct(){
		
	}
    public function get_profile_image(){
    	$this->CI =& get_instance();
    	$this->CI->load->model('common/common_model');
    	return $this->CI->common_model->get_existing_image_from_user_meta($_SESSION['user_id'], 'profile_image');
    }
}