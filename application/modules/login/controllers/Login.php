<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        // loading site model
        $this->load->model('login_model');
    }

    public function index() {

        $this->load->library('form_validation');
        $data = new stdClass();
        $data->title = "Login";
        $data->company_info = $this->db->get_where('company_information', array('user_id'=>1))->result_array();
        /* logout */
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            $data->error = '<div class="alert alert-success">'
                    . '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Logout success.'
                    . '</div>';
        }


        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($this->login_model->resolve_user_login($username, $password)) {                
                $user_id = $this->login_model->get_user_id_from_username($username);
                $user = $this->login_model->get_user($user_id);                
                if ($user->status == 'deleted') {
                    redirect('/login/account_deleted');
                }
                // set session user datas
                $_SESSION['user_id'] = (int) $user->id;
                $_SESSION['username'] = (string) $user->username;
                $_SESSION['logged_in'] = (bool) true;
                $_SESSION['user_type'] = (string) $user->type;                

                // user login ok
                //Check user type then redirect to the desire panel
                switch ($_SESSION['user_type']) {
                    case 'admin':
                        redirect('/admin/');
                        break;
                    case 2:
                        redirect('/accounts/');
                        break;
                    default:
                        redirect('/login/');
                        break;
                }
            } else {

                // login failed
                $data->error = '<div class="alert alert-danger">'
                        . '<i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Wrong username or password.'
                        . '</div>';
            }
        }

        $this->template->load('login/template_dashboard', 'login/login', $data);
    }

    public function account_deleted() {
        $data = new stdClass();
        $data->title = "Deleted account";

        $this->template->load('home/template_home', 'home/account_deleted', $data);
    }

}

ob_end_clean();
?>