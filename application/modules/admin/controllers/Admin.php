<?php

//

defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Admin extends MY_Controller
{

    /**
     * Constructor for this controller
     */
    public function __construct()
    {
        parent::__construct();
        // check if the user logged in
        if (isset($_SESSION['logged_in'])) {
            // check the user type
            if ($_SESSION['user_type'] != 'admin') {
                redirect('/login/');
            }
        } else {
            redirect('/login/');
        }

        $this->load->helper('url');
        $this->load->model('admin_model');
    }

    public function index()
    {
        $data = new stdClass();
        $data->title = 'Dashboard';
        $data->username = $_SESSION['username'];
        //$data->profile_image = $this->admin_model->get_profile_image($_SESSION['user_id']);

        $this->template->load('admin/template_dashboard', 'admin/dashboard', $data);
    }

    /**
     * profile function
     *
     * display the user information
     * @access public
     * @return void
     */
    public function profile()
    {
        // Load form validation library
        $this->load->library('form_validation');

        // load employer model
        $this->load->model('admin_model');

        // Data for the view
        $data = new stdClass();
        $data->title = "Site | Profile";
        $data->username = $_SESSION['username'];
        $data->profile_image = $this->admin_model->get_profile_image($_SESSION['user_id']);

        // get all the user data from employer_model to display in profile page
        $result = $this->admin_model->get_profile_meta($_SESSION['user_id']);
        foreach ($result as $value) {
            $key = $value['key'];
            $value = $value['value'];
            $data->$key = $value;
        }
        // get user email
        $data->email = $this->admin_model->get_user_mail($_SESSION['user_id']);
        // when a user click the update button of this information form
        if (isset($_POST['update_profile'])) {
            // Handle all kind of form data and validate it here for user profile update action
            $config = array(
                array(
                    'field' => 'fname',
                    'label' => 'First Name',
                    'rules' => 'required|alpha_numeric_spaces',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                        'alpha_numeric' => '%s field only except Alpha Nuemeric and spaces.',
                    ),
                ),
                array(
                    'field' => 'lname',
                    'label' => 'Last Name',
                    'rules' => 'required|alpha_numeric_spaces',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                        'alpha_numeric' => '%s field only except Alpha Nuemeric and spaces.',
                    ),
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|trim|valid_email',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                        'is_unique' => '%s already exist.',
                    ),
                ),
                array(
                    'field' => 'phone',
                    'label' => 'Phone',
                    'rules' => 'trim|numeric',
                    'errors' => array(
                        'numeric' => '%s field only accept numeric.',
                    ),
                ),
                array(
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),
                ),
                array(
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide a %s.',
                    ),
                ),
                array(
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim',
                ),
            );
            // setting the form validation rules here
            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == false) {
                $this->template->load('admin/template_dashboard', 'employer/profile', $data);
            } else {
                $user_profile_data = [];
                $input = $this->input->post();
                $user_profile_data['first_name'] = trim($input['fname']);
                $user_profile_data['last_name'] = trim($input['lname']);
                $user_profile_data['email'] = $input['email'];
                $user_profile_data['phone'] = $input['phone'];
                $user_profile_data['gender'] = $input['gender'];
                $user_profile_data['date_of_birth'] = $input['dob'];
                $user_profile_data['address'] = $input['address'];
                // calling the update method from employer_model
                $this->admin_model->update_profile($user_profile_data, $_SESSION['user_id']);
                redirect(site_url() . $_SESSION['user_type'] . '/profile/');
            }
        }
        // when a user want to upload or update profile image
        if (isset($_POST['profile_img_update'])) {
            if ($this->upload_profile_image($_SESSION['user_id'], 'profile_img')) {
                redirect(site_url() . $_SESSION['user_type'] . '/profile/');
            } else {
                $data->error = "Error with your file type.";
            }
        }
        // Load the setting view from common module
        $this->template->load('admin/template_dashboard', 'employer/profile', $data);
    }

    /**
     * profile image upload method
     *
     * @access protected
     * @param int $user_id
     * @param string $file_field_name
     * @return bool
     */
    protected function upload_profile_image($user_id, $file_field_name)
    {

        $config['upload_path'] = './assets/uploads/' . $user_id . '/';
        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size'] = '100';
        //$config['max_width']  = '1024';
        // $config['max_height']  = '768';
        $config['overwrite'] = true;
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;
        // if upload directory is not exist then create it
        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_field_name)) {
            return false;
        } else {
            // loading employer_model
            $this->load->model('admin_model');
            $this->admin_model->insert_profile_image($user_id, $this->upload->data('file_name'));
            return true;
        }
    }

    /*
     * create_chart_of_account method
     *
     * Insert new chart of account
     * @access public
     * @return void
     */

    public function groupListOfAccount()
    {
        $data = new stdClass();
        $data->title = 'Char Of Account';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $data->account_main_chart = $this->admin_model->get_all_base_chart();
        $this->template->load('admin/template_dashboard', 'admin/group_list_of_account', $data);
    }

    /*
     * Create Group method
     *
     * create new Group
     * @access public
     * @return void
     */

    public function createGroup()
    {
        $data = new stdClass();
        $data->title = 'create Group';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        if (isset($_POST['create_group'])) {
            $config = array(
                array(
                    'field' => 'group_name',
                    'label' => 'Group Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == true) {
                $group_name = $this->input->post('group_name');
                $parent_id = $this->input->post('group_parent');
                $root_parent_id = $this->input->post('root_parent');
                $created_by = $_SESSION['username'];
                $result = $this->admin_model->insertGroupName($group_name, $parent_id, $root_parent_id, $created_by);
                if ($result == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Group name added successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Failed.');
                }
            }
        }
        $data->assets_group = $this->admin_model->getAllAssetsParents();
        $data->assets_sub_childs = $this->admin_model->getAllAssetsSubChild();
        foreach ($data->assets_sub_childs as $value) {
            $sub_child_id_value = $value->id;
            $asset[] = $this->admin_model->getAllAssetsSubChildUnderSub($sub_child_id_value);
        }
        if (!empty($asset)) {
            $data->assets_sub_childs_under_sub = $asset;
        }
        $data->expenses_group = $this->admin_model->getAllExpensesParents();
        $data->expenses_sub_childs = $this->admin_model->getAllExpenseSubChild();
        foreach ($data->expenses_sub_childs as $expenses_value) {
            $expense_sub_child_id_value = $expenses_value->id;
            $expense[] = $this->admin_model->getAllexpenseSubChildUnderSub($expense_sub_child_id_value);
        }
        if (!empty($expense)) {
            $data->expenses_sub_childs_under_sub = $expense;
        }
        $data->incomes_group = $this->admin_model->getAllIncomeParents();
        $data->incomes_sub_childs = $this->admin_model->getAllIncomesSubChild();
        foreach ($data->incomes_sub_childs as $incomes_value) {
            $incomes_sub_child_id_value = $incomes_value->id;
            $incomes[] = $this->admin_model->getAllIncomesSubChildUnderSub($incomes_sub_child_id_value);
        }
        if (!empty($incomes)) {
            $data->incomes_sub_childs_under_sub = $incomes;
        }
        $data->liabilities_group = $this->admin_model->getAllLiabilitiesParents();
        $data->liabilities_sub_childs = $this->admin_model->getAllLiabilitiesSubChild();
        foreach ($data->liabilities_sub_childs as $liabilities_value) {
            $liabilities_sub_child_id_value = $liabilities_value->id;
            $liabilities[] = $this->admin_model->getAllLiabilitiesSubChildUnderSub($liabilities_sub_child_id_value);
        }
        if (!empty($liabilities)) {
            $data->liabilities_sub_childs_under_sub = $liabilities;
        }
        $this->template->load('admin/template_dashboard', 'admin/create_group', $data);
    }

    /*
     * Create Group method
     *
     * create new Group
     * @access public
     * @return void
     */

    public function editGroup($group_id)
    {
        $data = new stdClass();
        $data->title = 'Edit Group';
        $data->username = $_SESSION['username'];
        $data->get_editable_group = $this->admin_model->getEditGroupData($group_id);
        $data->assets_group = $this->admin_model->getAllAssetsParents();
        $data->assets_sub_childs = $this->admin_model->getAllAssetsSubChild();
        foreach ($data->assets_sub_childs as $value) {
            $sub_child_id_value = $value->id;
            $asset[] = $this->admin_model->getAllAssetsSubChildUnderSub($sub_child_id_value);
        }
        if (!empty($asset)) {
            $data->assets_sub_childs_under_sub = $asset;
        }
        $data->expenses_group = $this->admin_model->getAllExpensesParents();
        $data->expenses_sub_childs = $this->admin_model->getAllExpenseSubChild();
        foreach ($data->expenses_sub_childs as $expenses_value) {
            $expense_sub_child_id_value = $expenses_value->id;
            $expense[] = $this->admin_model->getAllexpenseSubChildUnderSub($expense_sub_child_id_value);
        }
        if (!empty($expense)) {
            $data->expenses_sub_childs_under_sub = $expense;
        }
        $data->incomes_group = $this->admin_model->getAllIncomeParents();
        $data->incomes_sub_childs = $this->admin_model->getAllIncomesSubChild();
        foreach ($data->incomes_sub_childs as $incomes_value) {
            $incomes_sub_child_id_value = $incomes_value->id;
            $incomes[] = $this->admin_model->getAllIncomesSubChildUnderSub($incomes_sub_child_id_value);
        }
        if (!empty($incomes)) {
            $data->incomes_sub_childs_under_sub = $incomes;
        }
        $data->liabilities_group = $this->admin_model->getAllLiabilitiesParents();
        $data->liabilities_sub_childs = $this->admin_model->getAllLiabilitiesSubChild();
        foreach ($data->liabilities_sub_childs as $liabilities_value) {
            $liabilities_sub_child_id_value = $liabilities_value->id;
            $liabilities[] = $this->admin_model->getAllLiabilitiesSubChildUnderSub($liabilities_sub_child_id_value);
        }
        if (!empty($liabilities)) {
            $data->liabilities_sub_childs_under_sub = $liabilities;
        }
        $this->template->load('admin/template_dashboard', 'admin/edit_group', $data);
    }

    /*
     * Update Group
     * @access public
     * @return void
     */

    public function updateGroup()
    {
        $data = new stdClass();
        $data->title = 'Update Group';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        if (isset($_POST['update_group'])) {
            $config = array(
                array(
                    'field' => 'group_name',
                    'label' => 'Group Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == true) {
                $update_id = $this->input->post('edit_id');
                $group_name = $this->input->post('group_name');
                $parent_id = $this->input->post('group_parent');
                $root_parent_id = $this->input->post('root_parent');
                $updated_by = $_SESSION['username'];
                $result = $this->admin_model->updateGroupData($update_id, $group_name, $parent_id, $root_parent_id, $updated_by);
                if ($result == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Group name Updated successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Updated Failed.');
                }
            }
            redirect('admin/editGroup/' . $update_id);
        }
    }

    /*
     * Create Ledger method
     *
     * create new Ledger
     * @access public
     * @return void
     */

    public function createLedger()
    {
        $data = new stdClass();
        $data->title = 'Create Ledger';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        if (isset($_POST['create_ledger'])) {
            $config = array(
                array(
                    'field' => 'ledger_name',
                    'label' => 'Ledger Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
                array(
                    'field' => 'ledger_parent',
                    'label' => 'Parent',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == true) {
                $ledger_name = $this->input->post('ledger_name');
                $ledger_parent = $this->input->post('ledger_parent');
                $balance_type = $this->input->post('balance_type');
                $opening_balance = $this->input->post('opening_balance');
                $note = $this->input->post('note');
                $created_by = $_SESSION['username'];
                $result = $this->admin_model->insertLedger($ledger_name, $ledger_parent, $balance_type, $opening_balance, $note, $created_by);
                if ($result == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Ledger added successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Failed');
                }
            }
        }
        $data->assets_group = $this->admin_model->getAllAssetsParents();
        $data->expenses_group = $this->admin_model->getAllExpensesParents();
        $data->incomes_group = $this->admin_model->getAllIncomeParents();
        $data->liabilities_group = $this->admin_model->getAllLiabilitiesParents();
        $this->template->load('admin/template_dashboard', 'admin/create_ledger', $data);
    }

    /*
     * Ledger List method
     * @access public
     * return object
     */

    public function ledgerList($ledger_id)
    {
        $data = new stdClass();
        $data->title = 'Ledger List';
        $data->username = $_SESSION['username'];
        $data->get_all_ledger = $this->admin_model->getAllLedgerAccount($ledger_id);
        $this->template->load('admin/template_dashboard', 'admin/ledger_list', $data);
    }

    /*
     * update ledger method
     *
     * update new ledger of account
     * @access public
     * @return void
     */

    public function updateLedger()
    {
        $data = new stdClass();
        $data->title = 'Update Ledger Account';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $data->all_accounts = $this->admin_model->getAllLedger();
        if (isset($_POST['update_ledger'])) {
            $config = array(
                array(
                    'field' => 'ledger_name',
                    'label' => 'Ledger Name',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
                array(
                    'field' => 'ledger_parent',
                    'label' => 'Parent',
                    'rules' => 'required',
                    'errors' => array(
                        'required' => 'You must provide %s',
                    ),
                ),
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == true) {
//                $inputs = $this->input->post();
                //                echo '<pre>';
                //                print_r($inputs);die();
                $ledger_id = $this->input->post('ledger_id');
                $ledger_name = $this->input->post('ledger_name');
                $ledger_parent = $this->input->post('ledger_parent');
                $balance_type = $this->input->post('balance_type');
                $opening_balance = $this->input->post('opening_balance');
                $note = $this->input->post('note');
                $updated_by = $_SESSION['username'];
                $result = $this->admin_model->updateLedger($ledger_id, $ledger_name, $ledger_parent, $balance_type, $opening_balance, $note, $updated_by);
                if ($result == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Ledger Updated successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Updated Failed');
                }
            }
        }

        $this->template->load('admin/template_dashboard', 'admin/update_ledger_account', $data);
    }

    /*
     * @ Get Ledger update Data
     * @access public
     * @return object
     */

    public function getLedgerUpdateData()
    {
        $data = new stdClass();
        $data->title = 'Get Ledger Update Data';
        $data->username = $_SESSION['username'];
        $data->assets_group = $this->admin_model->getAllAssetsParents();
        $assets_group_data = $data->assets_group;
        $data->expenses_group = $this->admin_model->getAllExpensesParents();
        $expenses_group_data = $data->expenses_group;
        $data->incomes_group = $this->admin_model->getAllIncomeParents();
        $incomes_group_data = $data->incomes_group;
        $data->liabilities_group = $this->admin_model->getAllLiabilitiesParents();
        $liabilities_group_data = $data->liabilities_group;
        if (isset($_POST['ledger'])) {
            $ledger_id = $this->input->post('ledger');
            $ledger_update_data = $this->admin_model->getLedgerUpdateData($ledger_id);
            //print_r($ledger_update_data);
            echo '<div class="updata_data">
                    <div class="form-group row">
                        <label for="ledger_name" class="col-md-2 col-sm-12 col-xs-12">Name</label>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <input type="text" name="ledger_name"  id="ledger_name" value="' . (isset($ledger_update_data) ? $ledger_update_data[0]->ledger_name : "") . '" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ledger_parent" class=" col-md-2 col-sm-12 col-xs-12">Parent</label>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <select class="form-control select2" name="ledger_parent" id="ledger_parent">
                                <optgroup label="Assets">
                                    <option></option>';
            if (isset($assets_group_data)) {
                if ($assets_group_data == !null) {
                    foreach ($assets_group_data as $asset_group_d) {
                        echo '<option ' . (isset($asset_group_d) ? (($asset_group_d->id == $ledger_id) ? "selected" : "") : "") . ' value="' . $asset_group_d->id . '">' . $asset_group_d->group_name . '</option>';
                    }
                }
            }
            echo '</optgroup><optgroup label="Expenses">';
            if (isset($expenses_group_data)) {
                if ($expenses_group_data == !null) {
                    foreach ($expenses_group_data as $expenses_group_d) {
                        echo '<option ' . (isset($expenses_group_d) ? (($expenses_group_d->id == $ledger_id) ? "selected" : "") : "") . ' value="' . $expenses_group_d->id . '">' . $expenses_group_d->group_name . '</option>';
                    }
                }
            }
            echo '</optgroup><optgroup label="Income">';
            if (isset($incomes_group_data)) {
                if ($incomes_group_data == !null) {
                    foreach ($incomes_group_data as $incomes_group_d) {
                        echo '<option ' . (isset($incomes_group_d) ? (($incomes_group_d->id == $ledger_id) ? "selected" : "") : "") . ' value="' . $incomes_group_d->id . '">' . $incomes_group_d->group_name . '</option>';
                    }
                }
            }
            echo '</optgroup><optgroup label="Liabilities and Owners Equity">';
            if (isset($liabilities_group_data)) {
                if ($liabilities_group_data == !null) {
                    foreach ($liabilities_group_data as $liabilities_group_d) {
                        echo '<option ' . (isset($liabilities_group_d) ? (($liabilities_group_d->id == $ledger_id) ? "selected" : "") : "") . ' value="' . $liabilities_group_d->id . '">' . $liabilities_group_d->group_name . '</option>';
                    }
                }
            }
            echo '</optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="balance_type" class=" col-md-2 col-sm-12 col-xs-12">Balance Type</label>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <select class="form-control select2" name="balance_type" id="balance_type">
                                <option ' . (isset($ledger_update_data) ? (($ledger_update_data[0]->balance_type == C) ? "selected" : "") : "") . ' value="C">Credit</option>
                                <option ' . (isset($ledger_update_data) ? (($ledger_update_data[0]->balance_type == D) ? "selected" : "") : "") . ' value="D">Debit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="opening_balance" class="col-md-2 col-sm-12 col-xs-12">Opening Balance<span class="required"> *</span></label>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <input type="text" name="opening_balance"  id="opening_balance" class="form-control prevent" value="' . (isset($ledger_update_data) ? $ledger_update_data[0]->op_balance : "") . '">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="note" class="col-md-2 col-sm-12 col-xs-12">note</label>
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <textarea class="form-control" name="note" id="note">' . (isset($ledger_update_data) ? $ledger_update_data[0]->note : "") . '</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_ledger" >Update</button>
                    <button type="button"  onclick="goBack()"  class="btn btn-info" >Back</button>
                </div>';
        }
    }

    /*
     * Delete Ledger method
     *
     * Delete Ledger
     * @access public
     * @return void
     */

    public function deleteLedger()
    {
        $data = new stdClass();
        $data->title = 'Delete Ledger';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');

// $data->all_category = $this->admin_model->get_all_category();
        $this->template->load('admin/template_dashboard', 'admin/delete_ledger', $data);
    }

    /*
     * @view sub chart of account
     * asscess public
     * return void
     */

    public function subChartOfAccount($id)
    {
        $data = new stdClass();
        $data->title = 'Sub Chart of Account';
        $data->username = $_SESSION['username'];
        $data->sub_groups = $this->admin_model->getAllSubGroups($id);
        $this->template->load('admin/template_dashboard', 'admin/sub_group_of_account', $data);
    }

    /*
     * @ Create pay mode
     * @ asscess public
     * @ return void
     */

    public function createPayMode()
    {
        $data = new stdClass();
        $data->title = 'Create pay mode';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'paymode_name',
                'label' => 'Pay Mode Name',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_paymode'])) {
                $paymode_name = $this->input->post('paymode_name');
                $insert_data = array(
                    'mode_name' => $paymode_name,
                    'create_by' => $_SESSION['username'],
                    'status' => 'active',
                );
                $result = $this->admin_model->insertPaymode($insert_data);
            }
        }
        $data->all_paymode_names = $this->admin_model->getAllPayModeName();
        $this->template->load('admin/template_dashboard', 'admin/create_pay_mode', $data);
    }

    /*
     * @ Create Bank
     * @ asscess public
     * @ return void
     */

    public function chequeRegister()
    {
        $data = new stdClass();
        $data->title = 'Create Bank';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $data->all_bank_names = $this->admin_model->getAllBankName();
        $config = array(
            array(
                'field' => 'bank_name',
                'label' => 'Bank Name',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'cheque_book_number',
                'label' => 'Cheque Book Number',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'start_cheque_number',
                'label' => 'Start Cheque Number',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'end_cheque_number',
                'label' => 'End Cheque Number',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_cheque_book'])) {
                $inputs = $this->input->post();
                $diff = $inputs['end_cheque_number'] - $inputs['start_cheque_number'];
                for ($i = 0; $i <= $diff; $i++) {
                    $cheque_number_row = $inputs['start_cheque_number'];
                    $cheque_number = $cheque_number_row + $i;
                    $insert_data = array(
                        'bank_id ' => $inputs['bank_name'],
                        'cheque_book_number ' => $inputs['cheque_book_number'],
                        'cheque_number  ' => $cheque_number,
                        'create_by' => $_SESSION['username'],
                        'start_number ' => $inputs['start_cheque_number'],
                        'end_number ' => $inputs['end_cheque_number'],
                        'status' => 'active',
                    );
                    $result = $this->admin_model->insertBank($insert_data);
                }
            }
        }
        $data->all_cheque_number = $this->admin_model->getAllChequeNumber();
        $this->template->load('admin/template_dashboard', 'admin/create_cheque_book', $data);
    }

    /*
     * @get all  cheque number
     * @access public
     * @return object
     */

    public function getAllChequeNumber()
    {
        if (isset($_POST['cheque_book_number'])) {
            $cheque_book_number = $this->input->post('cheque_book_number');
            $all_cheque_number = $this->admin_model->getAllChequeNumberAgnBook($cheque_book_number);
            foreach ($all_cheque_number as $cheque_number) {
                echo '<option></option>'
                . '<option value="' . $cheque_number->cheque_number . '">' . $cheque_number->cheque_number . '</option>';
            }
        }
    }

    /*
     * @get Bank Name ON ChequeNumber
     * @access public
     * @return object
     */

    public function getBankNameONChequeNumber()
    {
        if (isset($_POST['bank_name'])) {
            $bank_name_on_chequeNumber_row = $this->input->post('bank_name');
            $bank_name_on_chequeNumber = $this->admin_model->getBankNameONChequeNumber($bank_name_on_chequeNumber_row);
            print_r($bank_name_on_chequeNumber);
            foreach ($bank_name_on_chequeNumber as $bank_name) {
                echo '<option></option>'
                . '<option selected value="' . $bank_name->ledger_id . '">' . $bank_name->ledger_name . '</option>';
            }
        }
    }

    /*
     * @get ledger balance
     * @access public
     * @return void
     */

    public function getDebitLedgerBalance()
    {
        if (isset($_POST['ledger_id'])) {
            $ledger_balnce_id = $this->input->post('ledger_id');
            $balance_result = $this->admin_model->getDebitLedgerBalance($ledger_balnce_id);
            //print_r($debit_balance_result);
            foreach ($balance_result as $balance) {
                echo '<input type="text" style="text-align:right;" readonly id="balnce" name="balnce" value="= ' . $balance->balance . '"class="form-control">';
            }
        }
    }

    /*
     * @Add payment voucher
     * asscess public
     * return void
     */

    public function paymentVoucher()
    {
        $data = new stdClass();
        $data->title = 'Payment Voucher';
        $data->username = $_SESSION['username'];
        $data->all_paymode_names = $this->admin_model->getAllPayModeName();
        $data->all_ledgers = $this->admin_model->getAllLedger();
        $data->all_bank_names = $this->admin_model->getAllBankName();
        $data->all_cheque_number = $this->admin_model->getAllChequeBookNumber();
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'paymode',
                'label' => 'Payment Mode',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_payment'])) {
                $voucher_date_row = $this->input->post('paymode');
                $voucher_date = date('Y-m-d', strtotime($voucher_date_row));
                $paymode = $this->input->post('paymode');
                $reference_number = $this->input->post('reference');
                $mobile_number = $this->input->post('mobile_number');
                $cheque_book_number = $this->input->post('cheque_book_number');
                $cheque_number = $this->input->post('cheque_number');
                $cheque_date_row = $this->input->post('cheque_date');
                $cheque_date = date('Y-m-d', strtotime($cheque_date_row));
                $bank_name = $this->input->post('bank_name');
                $total = $this->input->post('debit_total');
                $credit_total = $this->input->post('credit_total');
                $debit_total = $this->input->post('debit_total');
                $narration = $this->input->post('narration');

                $account_head = $this->input->post('account_head');
                $description = $this->input->post('description');
                $tax_id = $this->input->post('tax');
                $debit_amount = $this->input->post('debit_amount');
                $credit_amount = $this->input->post('credit_amount');
                $length = count($this->input->post('account_head'));

                $voucher_master_data = array(
                    'paymode_id ' => $paymode,
                    'voucher_date' => $voucher_date,
                    'voucher_type' => 'PV',
                    'reference_no' => $reference_number,
                    'mobile_number' => $mobile_number,
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number,
                    'cheque_date' => $cheque_date,
                    'bank_id' => $bank_name,
                    'total' => $total,
                    'narration' => $narration,
                    'created_by' => $_SESSION['username'],
                    'status' => 'active',
                );
                if ($debit_total == $credit_total) {
                    $voucher_id = $this->admin_model->insertPaymentVoucher($voucher_master_data, $cheque_book_number, $cheque_number);
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Your Balance is not equal. Please check');
                }

                var_dump($voucher_id);
                if ($voucher_id) {
                    $result = $this->admin_model->insertPaymentVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length);
                    if ($result == true) {
                        $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Payment successfully');
                    } else {
                        $this->session->set_flashdata('error', '<strong>Failed!</strong> Payment Voucher Failed');
                    }
                }
            }
        }
        $data->payment_voucher_number = $this->admin_model->getPaymentVoucherId();
        $this->template->load('admin/template_dashboard', 'admin/add_payment_voucher', $data);
    }

    public function receiveVoucher()
    {
        $data = new stdClass();
        $data->title = 'Receive Voucher';
        $data->username = $_SESSION['username'];
        $data->all_paymode_names = $this->admin_model->getAllPayModeName();
        $data->all_ledgers = $this->admin_model->getAllLedger();
        $data->all_bank_names = $this->admin_model->getAllBankName();
        $data->all_cheque_number = $this->admin_model->getAllChequeBookNumber();
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'paymode',
                'label' => 'Payment Mode',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_receive'])) {
                $voucher_date_row = $this->input->post('paymode');
                $voucher_date = date('Y-m-d', strtotime($voucher_date_row));
                $paymode = $this->input->post('paymode');
                $reference_number = $this->input->post('reference');
                $mobile_number = $this->input->post('mobile_number');
                $cheque_book_number = $this->input->post('cheque_book_number');
                $cheque_number = $this->input->post('cheque_number');
                $cheque_date_row = $this->input->post('cheque_date');
                $cheque_date = date('Y-m-d', strtotime($cheque_date_row));
                $bank_name = $this->input->post('bank_name');
                $total = $this->input->post('debit_total');
                $credit_total = $this->input->post('credit_total');
                $debit_total = $this->input->post('debit_total');
                $narration = $this->input->post('narration');

                $account_head = $this->input->post('account_head');
                $description = $this->input->post('description');
                $tax_id = $this->input->post('tax');
                $debit_amount = $this->input->post('debit_amount');
                $credit_amount = $this->input->post('credit_amount');
                $length = count($this->input->post('account_head'));

                $voucher_master_data = array(
                    'paymode_id ' => $paymode,
                    'voucher_date' => $voucher_date,
                    'voucher_type' => 'RV',
                    'reference_no' => $reference_number,
                    'mobile_number' => $mobile_number,
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number,
                    'cheque_date' => $cheque_date,
                    'bank_id' => $bank_name,
                    'total' => $total,
                    'narration' => $narration,
                    'created_by' => $_SESSION['username'],
                    'status' => 'active',
                );
                if ($debit_total == $credit_total) {
                    $voucher_id = $this->admin_model->insertReceiveVoucher($voucher_master_data, $cheque_book_number, $cheque_number);
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Your Balance is not equal. Please check');
                }

                var_dump($voucher_id);
                if ($voucher_id) {
                    $result = $this->admin_model->insertReceiveVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length);
                    if ($result == true) {
                        $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Receive successfully');
                    } else {
                        $this->session->set_flashdata('error', '<strong>Failed!</strong> Receive Voucher Failed');
                    }
                }
            }
        }
        $data->receive_voucher_number = $this->admin_model->getReceiveVoucherId();
        $this->template->load('admin/template_dashboard', 'admin/add_receive_voucher', $data);
    }

    public function journalVoucher()
    {
        $data = new stdClass();
        $data->title = 'Journal Voucher';
        $data->username = $_SESSION['username'];
        $data->all_paymode_names = $this->admin_model->getAllPayModeName();
        $data->all_ledgers = $this->admin_model->getAllLedger();
        $data->all_bank_names = $this->admin_model->getAllBankName();
        $data->all_cheque_number = $this->admin_model->getAllChequeBookNumber();
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'paymode',
                'label' => 'Payment Mode',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_journal'])) {
                $voucher_date_row = $this->input->post('paymode');
                $voucher_date = date('Y-m-d', strtotime($voucher_date_row));
                $paymode = $this->input->post('paymode');
                $reference_number = $this->input->post('reference');
                $mobile_number = $this->input->post('mobile_number');
                $cheque_book_number = $this->input->post('cheque_book_number');
                $cheque_number = $this->input->post('cheque_number');
                $cheque_date_row = $this->input->post('cheque_date');
                $cheque_date = date('Y-m-d', strtotime($cheque_date_row));
                $bank_name = $this->input->post('bank_name');
                $total = $this->input->post('debit_total');
                $credit_total = $this->input->post('credit_total');
                $debit_total = $this->input->post('debit_total');
                $narration = $this->input->post('narration');

                $account_head = $this->input->post('account_head');
                $description = $this->input->post('description');
                $tax_id = $this->input->post('tax');
                $debit_amount = $this->input->post('debit_amount');
                $credit_amount = $this->input->post('credit_amount');
                $length = count($this->input->post('account_head'));

                $voucher_master_data = array(
                    'paymode_id ' => $paymode,
                    'voucher_date' => $voucher_date,
                    'voucher_type' => 'JV',
                    'reference_no' => $reference_number,
                    'mobile_number' => $mobile_number,
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number,
                    'cheque_date' => $cheque_date,
                    'bank_id' => $bank_name,
                    'total' => $total,
                    'narration' => $narration,
                    'created_by' => $_SESSION['username'],
                    'status' => 'active',
                );
                if ($debit_total == $credit_total) {
                    $voucher_id = $this->admin_model->insertJournalVoucher($voucher_master_data, $cheque_book_number, $cheque_number);
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Your Balance is not equal. Please check');
                }

                var_dump($voucher_id);
                if ($voucher_id) {
                    $result = $this->admin_model->insertJournalVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length);
                    if ($result == true) {
                        $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Journal Payment successfully');
                    } else {
                        $this->session->set_flashdata('error', '<strong>Failed!</strong> Journal Voucher Failed');
                    }
                }
            }
        }
        $data->journal_voucher_number = $this->admin_model->getJournalVoucherId();
        $this->template->load('admin/template_dashboard', 'admin/add_journal_voucher', $data);
    }

    public function contraVoucher()
    {
        $data = new stdClass();
        $data->title = 'Contra Voucher';
        $data->username = $_SESSION['username'];
        $data->all_paymode_names = $this->admin_model->getAllPayModeName();
        $data->all_ledgers = $this->admin_model->getAllLedger();
        $data->all_bank_names = $this->admin_model->getAllBankName();
        $data->all_cheque_number = $this->admin_model->getAllChequeBookNumber();
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'paymode',
                'label' => 'Payment Mode',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['save_contra'])) {
                $voucher_date_row = $this->input->post('paymode');
                $voucher_date = date('Y-m-d', strtotime($voucher_date_row));
                $paymode = $this->input->post('paymode');
                $reference_number = $this->input->post('reference');
                $mobile_number = $this->input->post('mobile_number');
                $cheque_book_number = $this->input->post('cheque_book_number');
                $cheque_number = $this->input->post('cheque_number');
                $cheque_date_row = $this->input->post('cheque_date');
                $cheque_date = date('Y-m-d', strtotime($cheque_date_row));
                $bank_name = $this->input->post('bank_name');
                $total = $this->input->post('debit_total');
                $credit_total = $this->input->post('credit_total');
                $debit_total = $this->input->post('debit_total');
                $narration = $this->input->post('narration');

                $account_head = $this->input->post('account_head');
                $description = $this->input->post('description');
                $tax_id = $this->input->post('tax');
                $debit_amount = $this->input->post('debit_amount');
                $credit_amount = $this->input->post('credit_amount');
                $length = count($this->input->post('account_head'));

                $voucher_master_data = array(
                    'paymode_id ' => $paymode,
                    'voucher_date' => $voucher_date,
                    'voucher_type' => 'JV',
                    'reference_no' => $reference_number,
                    'mobile_number' => $mobile_number,
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number,
                    'cheque_date' => $cheque_date,
                    'bank_id' => $bank_name,
                    'total' => $total,
                    'narration' => $narration,
                    'created_by' => $_SESSION['username'],
                    'status' => 'active',
                );
                if ($debit_total == $credit_total) {
                    $voucher_id = $this->admin_model->insertContraVoucher($voucher_master_data, $cheque_book_number, $cheque_number);
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Your Balance is not equal. Please check');
                }

                var_dump($voucher_id);
                if ($voucher_id) {
                    $result = $this->admin_model->insertContraVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length);
                    if ($result == true) {
                        $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Contra Payment successfully');
                    } else {
                        $this->session->set_flashdata('error', '<strong>Failed!</strong> Contra Voucher Failed');
                    }
                }
            }
        }
        $data->contra_voucher_number = $this->admin_model->getContraVoucherId();
        $this->template->load('admin/template_dashboard', 'admin/add_contra_voucher', $data);
    }

    /**
     * @ Add Truck
     * @ access public
     * @ return boolean for add
     * @ return object for list
     * @ return object for edit
     * @ return boolean for update
     */
    public function addTruck()
    {
        $data = new stdClass();
        $data->title = 'Truck';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'truck_no',
                'label' => 'Truck No',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'truck_type',
                'label' => 'Truck Type',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'inclusion_date',
                'label' => 'Inclusion Date',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['add_truck'])) {
                $post = $this->input->post();
                $inclusion_date_row = $post['inclusion_date'];
                $inclusion_date = date('Y-m-d', strtotime($inclusion_date_row));
                $insert_data = array(
                    'truck_number' => $post['truck_no'],
                    'truck_type' => $post['truck_type'],
                    'inclusion_date' => $inclusion_date,
                    'created_by' => $_SESSION['username'],
                );
                $insert = $this->admin_model->addTruck($insert_data);
                if ($insert == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Add Truck successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Truck Add Failed');
                }
            }
        }

        $data->truck_list = $this->admin_model->truckList();
        $this->template->load('admin/template_dashboard', 'admin/truck', $data);
    }

    /**
     * @ get truck data for edit
     * @ access public
     * @ return object
     */
    public function getTruckDataOnEdit()
    {
        if (isset($_POST['truck_edit_id'])) {
            $post = $this->input->post();
            // print_r($post);
            $result = $this->db->get_where('truck', array('truck_tbl_id' => $post['truck_edit_id']))->result_array();

            if (!empty($result)) {
                echo '<div class="col-md-4">
                <div class="form-group">
                    <label for="truck_no">Truck No: <span>*</span></label><br>
                    <input type="hidden" name="truck_update_id" value="' . $result[0]['truck_tbl_id'] . '">
                    <input type="text" id="truck_no" name="truck_no" class="form-control" required="required" value="' . $result[0]['truck_number'] . '">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="truck_type">Truck Type: <span>*</span></label><br>
                    <select class="form-control" name="truck_type" id="truck_type" required="required">
                        <option>Select Type</option>
                        <option ' . (($result[0]["truck_type"] == "A") ? "selected" : "") . ' value="A">A</option>
                        <option ' . (($result[0]["truck_type"] == "B") ? "selected" : "") . ' value="B">B</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="truck_no">Inclusion Date: <span>*</span></label><br>
                    <input type="text" id="inclusion_date" name="inclusion_date" class="form-control dateinput" required="required" value="' . $result[0]['inclusion_date'] . '">
                </div>
            </div>
            <button type="submit" name="edit_truck" class="btn btn-success pull-right" id="edit_truck" title="Add Truck">Update</button>';
            }
            // echo'<pre>';
            // print_r($result);

        }
    }

    /**
     * @ update truck
     * @ access public
     * @ return boolean
     */
    public function updateTruck()
    {
        $data = new stdClass();
        $data->title = 'Update Truck';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'truck_no',
                'label' => 'Truck No',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'truck_type',
                'label' => 'Truck Type',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
            array(
                'field' => 'inclusion_date',
                'label' => 'Inclusion Date',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['edit_truck'])) {
                $post = $this->input->post();
                //     echo'<pre>';
                // print_r($post);
                $inclusion_date_row = $post['inclusion_date'];
                $inclusion_date = date('Y-m-d', strtotime($inclusion_date_row));
                $update_data = array(
                    'truck_number' => $post['truck_no'],
                    'truck_type' => $post['truck_type'],
                    'inclusion_date' => $inclusion_date,
                    'created_by' => $_SESSION['username'],
                );
                $update = $this->db->update('truck', $update_data, array('truck_tbl_id' => $post['truck_update_id']));
                if ($update == true) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Update successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Update Failed');
                }
            }
        }

        $data->truck_list = $this->admin_model->truckList();
        $this->template->load('admin/template_dashboard', 'admin/truck', $data);
    }

    /**
     * @ Add Member
     * @ access public
     * @ return boolean
     * */
    public function member()
    {
        $data = new stdClass();
        $data->title = 'Member';
        $data->username = $_SESSION['username'];
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'member_no',
                'label' => 'Member No',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide %s',
                ),
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == true) {
            if (isset($_POST['add_member'])) {
                $inputs = $this->input->post();

                $configure['upload_path'] = './uploads/';
                $configure['allowed_types'] = 'gif|jpg|png|jpeg';
                $configure['encrypt_name'] = false;
                $this->load->library('upload', $configure);
                $this->upload->do_upload('picture');
                $pic_data = $this->upload->data();
                $member_data = array(
                    'account_id' => $inputs['account_name'],
                    'truck_no' => (!empty($inputs['truck_no'])) ? json_encode($inputs['truck_no']) : "0",
                    'member_no' => $inputs['member_no'],
                    'father_name' => $inputs['father_name'],
                    'mother_name' => $inputs['mother_name'],
                    'husband_name' => $inputs['husband_name'],
                    'nid' => $inputs['nid_no'],
                    'date_of_birth' => date('Y-m-d', strtotime($inputs['date_birth'])),
                    'mobile_no' => $inputs['mobile_no'],
                    'email' => $inputs['email'],
                    'nominee_name' => $inputs['nominee_name'],
                    'relation' => $inputs['relation'],
                    'admission_fees' => $inputs['admission_fees'],
                    'paid_up_balance' => $inputs['paid_up_balance'],
                    'dps' => $inputs['dps_group'],
                    'present_address' => $inputs['present_address'],
                    'permanent_address' => $inputs['permanent_address'],
                    'member_type' => $inputs['member_type'],
                    'picture' => $pic_data['file_name'],
                    'created_by' => $_SESSION['username'],
                );
                $result = $this->db->insert('member', $member_data);
                $this->db->update('ledgers', array('status' => 'Created'), array('id' => $inputs['account_name']));

                if ($result) {
                    $this->session->set_flashdata('successMsg', '<strong>Success!</strong> Add member successfully');
                } else {
                    $this->session->set_flashdata('error', '<strong>Failed!</strong> Member Add Failed');
                }
            }
        }

        $data->all_member_account = $this->admin_model->getAllMemberAccount();
        $data->all_truck = $this->admin_model->truckList();
        $data->member_list = $this->admin_model->memberList();
        $this->template->load('admin/template_dashboard', 'admin/member', $data);
    }
    /**
     * @ get member data for edit
     * @ access public
     * @ return object
     */
    public function getMemberDataOnEdit()
    {
        if (isset($_POST['member_edit_id'])) {
            $data->all_member_account = $this->admin_model->getAllMemberAccount();
            $data->all_truck = $this->admin_model->truckList();
            $data->member_list = $this->admin_model->memberList();
            $post = $this->input->post();
            $result = $this->db->get_where('member', array('member_id' => $post['member_edit_id']))->result_array();
            // print_r($result);
            if (!empty($result)) {
                echo '';
            }
        }
    }

}

ob_end_clean()
?>
