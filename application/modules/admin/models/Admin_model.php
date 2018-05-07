<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin model
 *
 */
class Admin_model extends CI_Model {

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
     * get_profile_image method
     * 
     * select the existing image file from database
     * @access public
     * @param int $user_id
     * @param string $key - value of the meta_key
     */
    public function get_profile_image($user_id) {
        $this->db->select('value');
        $this->db->from('user_meta');
        $this->db->where('key', 'profile_image');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get()->row();
        //var_dump($query);die();
        if ($query == NULL) {
            return false;
        }
        return $query->value;
    }

    /*
     * insert_job_category method
     * 
     * @access public
     * @param string $cat_name
     * @return void  
     */

    public function get_all_base_chart() {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('parent_id = 0');
//        $this->db->or_where('parent_id = 20');
//        $this->db->or_where('parent_id = 30');
//        $this->db->or_where('parent_id = 40');
        return $this->db->get()->result();
    }

    /**
     * get_profile function
     *
     * Display all the user information from user_meta table
     * @access public
     * @param int $user_id
     * @return associative array
     */
    public function get_profile_meta($user_id) {
        $this->db->select('*');
        $this->db->from('user_meta');
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result_array();
    }

    /**
     * Get user mail
     *
     * @access public
     * @param int $user_id
     * @return string 
     */
    public function get_user_mail($user_id) {
        // get user mail
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $result = $this->db->get()->row();
        return $result->email;
    }

    /**
     * update_profile data function
     * 
     * update user profile data if the key already exist in the user_meta table
     * @access public
     * @param associative array $values
     * @param int $user_id
     * @return bool
     */
    public function update_profile($data, $user_id) {
        // update the user data 
        foreach ($data as $key => $value) {
            if ($this->get_user_meta_value($user_id, $key) == null) {
                // if key is email then update it inside user table 
                if ($key == 'email') {
                    if ($this->check_existing_email($value) !== NULL) {
                        continue;
                    } else {
                        $update_result = array('email' => $value);
                        $this->db->where('id', $user_id);
                        $this->db->update('users', $update_result);
                    }
                    continue;
                }

                /* insert query */
                $data = ['user_id' => $user_id, 'key' => $key, 'value' => $value];
                $this->db->insert('user_meta', $data);
            } else {
                /* update query */
                $condition = array('user_id' => $user_id, 'key' => $key);
                $update_result = array('value' => $value);
                $this->db->where($condition);
                $this->db->update('user_meta', $update_result);
            }
        }
        return true;
    }

    /**
     * insert_profile_image method
     * @access public
     * @param int $user_id
     * @param array $upload_data
     * @return bool
     */
    public function insert_profile_image($user_id, $upload_data) {
        // profile picture meta key is profile_image
        $key = 'profile_image';
        if ($this->get_user_meta_value($user_id, $key) == null) {
            // insert query
            $data = ['user_id' => $user_id, 'key' => $key, 'value' => $upload_data];
            $this->db->insert('user_meta', $data);
        } else {
            // update query
            // delete existing file after update
            $previous_img_file = './assets/uploads/' . $user_id . '/' . $this->get_profile_image($user_id);

            $condition = array('user_id' => $user_id, 'key' => $key);
            $update_result = array('value' => $upload_data);
            $this->db->where($condition);
            $this->db->update('user_meta', $update_result);

            // delete the previous image file from storage
            unlink($previous_img_file);
        }
    }

    public function get_user_meta_value($user_id, $key) {
        $this->db->select('*');
        $this->db->from('user_meta');
        $this->db->where('key', $key);
        $this->db->where('user_id', $user_id);
        return $this->db->get()->row();
    }

    /**
     * check_existing_email method
     *
     * Check email from user table
     * @access public
     * @param int $email
     * @return object
     */
    public function check_existing_email($email) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        return $this->db->get()->row();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllAssetsParents() {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 10));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Assets Sub Child
     * @return object
     * */
    public function getAllAssetsSubChild() {
        $parent = $this->db->get_where('groups', array('parent_id' => 1));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Assets Sub Child under sub
     * @return object
     * */
    public function getAllAssetsSubChildUnderSub($sub_child_id_value) {
        $parent = $this->db->get_where('groups', array('parent_id' => $sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllExpensesParents() {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 20));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Expense Sub Child
     * @return object
     * */
    public function getAllExpenseSubChild() {
        $parent = $this->db->get_where('groups', array('parent_id' => 2));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Expense Sub Child under sub
     * @return object
     * */
    public function getAllexpenseSubChildUnderSub($expense_sub_child_id_value) {
        $parent = $this->db->get_where('groups', array('parent_id' => $expense_sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllIncomeParents() {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 30));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Income Sub Child
     * @return object
     * */
    public function getAllIncomesSubChild() {
        $parent = $this->db->get_where('groups', array('parent_id' => 3));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Income Sub Child under sub
     * @return object
     * */
    public function getAllIncomesSubChildUnderSub($incomes_sub_child_id_value) {
        $parent = $this->db->get_where('groups', array('parent_id' => $incomes_sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllLiabilitiesParents() {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 40));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Liabilities Sub Child
     * @return object
     * */
    public function getAllLiabilitiesSubChild() {
        $parent = $this->db->get_where('groups', array('parent_id' => 4));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Liabilities Sub Child under sub
     * @return object
     * */
    public function getAllLiabilitiesSubChildUnderSub($liabilities_sub_child_id_value) {
        $parent = $this->db->get_where('groups', array('parent_id' => $liabilities_sub_child_id_value));
        return $parent->result();
    }

    /*
     * @Insert group name
     * @access public
     * @return bool
     */

    public function insertGroupName($group_name, $parent_id, $root_parent_id, $created_by) {
        $this->db->trans_begin();
        $insert_data = array(
            'group_name' => $group_name,
            'parent_id' => $parent_id,
            'root_parent_id' => $root_parent_id,
            'create_by' => $created_by
        );
        $result = $this->db->insert('groups', $insert_data);
        $last_insert_id = $this->db->insert_id();
        if ($result) {
            $check = $this->db->get_where('groups', array('id' => $parent_id));
            if ($check->num_rows() > 0) {
                $data = $check->result_array();
                $custom_id_row = $data[0]['custom_id'];
                $parent_row_check = $this->db->get_where('groups', array('parent_id' => $parent_id));
                if ($parent_row_check->num_rows() > 0) {
                    $row_count = $parent_row_check->num_rows();
                    $custom_id = $custom_id_row . $row_count;
                    $this->db->update('groups', array('custom_id' => $custom_id), array('id' => $last_insert_id));
                }
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @get Edit group data
     * @access public
     * @return array
     */

    public function getEditGroupData($group_id) {
        $result = $this->db->get_where('groups', array('id' => $group_id));
        return $result->result();
    }

    /*
     * @update group data
     * @access public
     * @return array
     */

    public function updateGroupData($update_id, $group_name, $parent_id, $root_parent_id, $updated_by) {
        $this->db->trans_begin();
        $update_id = array(
            'id' => $update_id
        );
        $update_data = array(
            'group_name' => $group_name,
            'parent_id' => $parent_id,
            'root_parent_id' => $root_parent_id,
            'updated_by' => $updated_by,
            'status' => 'active'
        );
        $this->db->update('groups', $update_data, $update_id);

        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @Insert ledger name
     * @access public
     * @return bool
     */

    public function insertLedger($ledger_name, $ledger_parent, $balance_type, $opening_balance, $note, $created_by) {
        $this->db->trans_begin();
        $insert_data = array(
            'group_id' => $ledger_parent,
            'ledger_name' => $ledger_name,
            'op_balance' => $opening_balance,
            'balance' => $opening_balance,
            'balance_type' => $balance_type,
            'note ' => $note,
            'create_by ' => $created_by,
            'status' => 'active'
        );
        $result = $this->db->insert('ledgers', $insert_data);

        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @update ledger name
     * @access public
     * @return bool
     */

    public function updateLedger($ledger_id, $ledger_name, $ledger_parent, $balance_type, $opening_balance, $note, $updated_by) {
        $this->db->trans_begin();
        $insert_data = array(
            'group_id' => $ledger_parent,
            'ledger_name' => $ledger_name,
            'op_balance' => $opening_balance,
            'balance' => $opening_balance,
            'balance_type' => $balance_type,
            'note ' => $note,
            'create_by ' => $updated_by,
            'status' => 'active'
        );
        $result = $this->db->insert('ledgers', $insert_data);

        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * List of ledger
     * @ access public
     * @ return object
     */

    public function getAllLedgerAccount($ledger_id) {
        $result = $this->db->get_where('ledgers', array('group_id' => $ledger_id));
        return $result->result();
    }

    /*
     * get ledger update data
     * @ access public
     * @ return object
     */

    public function getLedgerUpdateData($ledger_id) {
        $result = $this->db->get_where('ledgers', array('id' => $ledger_id));
        return $result->result();
    }

    /*
     * get debit ledger for balance
     * @ access public
     * @ return object
     */

    public function getDebitLedgerBalance($ledger_balnce_id) {
        $this->db->select('balance, ledger_name');
        $this->db->from('ledgers');
        $this->db->where('ledgers.id', $ledger_balnce_id);
        $this->db->order_by('lower(ledgers.ledger_name)', 'asc');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * get all ledger
     * @ access public
     * @ return object
     */

    public function getAllLedger() {
        $this->db->select('*');
        $this->db->from('ledgers');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @get All Sub Groups
     * @access public
     * @return object
     */

    public function getAllSubGroups($id) {
        $this->db->select("groups.*,(SELECT group_name FROM `groups` WHERE id = '$id') as parent_name");
        $this->db->from('groups');
        $this->db->where('groups.parent_id', $id);
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ Insert Paymode Name
     * @ asscess public
     * return bool
     */

    public function insertPaymode($insert_data) {
        $result = $this->db->insert('pay_mode', $insert_data);
        if ($result) {
            return TRUE;
        }
    }

    /*
     * @ get All Paymode Name
     * @ asscess public
     * return bool
     */

    public function getAllPayModeName() {
        $this->db->select('*');
        $this->db->from('pay_mode');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ Insert Bank Name
     * @ asscess public
     * return bool
     */

    public function insertBank($insert_data) {
        $result = $this->db->insert('cheque_register', $insert_data);
        if ($result) {
            return TRUE;
        }
    }

    /*
     * @ get All Paymode Name
     * @ asscess public
     * return array
     */

    public function getAllBankName() {
        $this->db->select('ledgers.ledger_name,ledgers.id');
        $this->db->from('ledgers');
        $this->db->where('ledgers.group_id', 7);
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ get All Cheque Number
     * @ asscess public
     * return array
     */

    public function getAllChequeBookNumber() {
        $this->db->select('*');
        $this->db->from('cheque_register');
        $this->db->where('status', 'active');
        $this->db->group_by('cheque_book_number');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ get All Cheque Number
     * @ asscess public
     * return array
     */

    public function getAllChequeNumberAgnBook($cheque_book_number) {
        $this->db->select('cheque_number, id');
        $this->db->from('cheque_register');
        $this->db->where('status', 'active');
        $this->db->where('cheque_book_number', $cheque_book_number);
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ get All Cheque Number
     * @ asscess public
     * return array
     */

    public function getAllChequeNumber() {
        $this->db->select('cheque_register.*, ledgers.ledger_name');
        $this->db->from('cheque_register');
        $this->db->join('ledgers', 'ledgers.id = cheque_register.bank_id');
        $this->db->where('cheque_register.status', 'active');
        $this->db->group_by('cheque_book_number');
        $this->db->order_by('cheque_book_number', 'DESC');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ get Bank Name ON ChequeNumber
     * @ asscess public
     * return array
     */

    public function getBankNameONChequeNumber($bank_name_on_chequeNumber_row) {
        $this->db->select('cheque_register.*, ledgers.ledger_name, ledgers.id as ledger_id');
        $this->db->from('cheque_register');
        $this->db->join('ledgers', 'ledgers.id = cheque_register.bank_id');
        $this->db->where('cheque_register.status', 'active');
        $this->db->where('cheque_register.cheque_book_number', $bank_name_on_chequeNumber_row);
        $this->db->group_by('cheque_book_number');
        $result = $this->db->get();
        return $result->result();
    }

    /*
     * @ get Last voucher id of payment voucher
     * @ asscess public
     * return object
     */

    public function getPaymentVoucherId() {
        $this->db->select('*');
        $this->db->from('payment_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ get Last voucher id receive voucher
     * @ asscess public
     * return object
     */

    public function getReceiveVoucherId() {
        $this->db->select('*');
        $this->db->from('receive_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ get Last voucher id journal voucher
     * @ asscess public
     * return object
     */

    public function getJournalVoucherId() {
        $this->db->select('*');
        $this->db->from('journal_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ get Last voucher id contra voucher
     * @ asscess public
     * return object
     */

    public function getContraVoucherId() {
        $this->db->select('*');
        $this->db->from('contra_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ insert payment voucher
     * @ asscess public
     * return bool
     */

    public function insertPaymentVoucher($voucher_master_data, $cheque_book_number, $cheque_number) {
        $result = $this->db->insert('payment_voucher_entries', $voucher_master_data);
        $insert_id = $this->db->insert_id();
        if ($result) {
            if (!empty($cheque_book_number) and ! empty($cheque_number)) {
                $update_cheque_number = array(
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number
                );
                $update_data = array(
                    'status' => 'taken'
                );
                $this->db->update('cheque_register', $update_data, $update_cheque_number);
            }
        }
        return $insert_id;
    }

    /*
     * @ insert payment voucher details
     * @ asscess public
     * return bool
     */

    public function insertPaymentVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length) {
        $this->db->trans_begin();
        for ($i = 0; $i < $length; $i++) {
            $details_data = array(
                'voucher_entries_id' => $voucher_id,
                'ledger_id' => $account_head[$i],
                'description' => $description[$i],
                'tax_id' => $tax_id[$i],
                'debit_amount' => $debit_amount[$i],
                'credit_amount' => $credit_amount[$i]
            );
            $d_amount = $debit_amount[$i];
//            if ($d_amount == NULL) {
//                $d_amount = 0;
//            }
            $c_amount = $credit_amount[$i];
//            if ($c_amount == NULL) {
//                $c_amount = 0;
//            }
            $result = $this->db->insert('payment_voucher_entries_details', $details_data);
            if ($result) {
                $get_exit_ledger_balance_data = array(
                    'id' => $account_head[$i]
                );

                $get_exitledger_balance = $this->db->get_where('ledgers', $get_exit_ledger_balance_data);
                if ($get_exitledger_balance->num_rows() > 0) {
                    if ($d_amount == NULL) {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row - $c_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    } else {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row + $d_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    }
                }
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @ insert receive voucher
     * @ asscess public
     * return bool
     */

    public function insertReceiveVoucher($voucher_master_data, $cheque_book_number, $cheque_number) {
        $result = $this->db->insert('receive_voucher_entries', $voucher_master_data);
        $insert_id = $this->db->insert_id();
        if ($result) {
            if (!empty($cheque_book_number) and ! empty($cheque_number)) {
                $update_cheque_number = array(
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number
                );
                $update_data = array(
                    'status' => 'taken'
                );
                $this->db->update('cheque_register', $update_data, $update_cheque_number);
            }
        }
        return $insert_id;
    }

    /*
     * @ insert receive voucher details
     * @ asscess public
     * return bool
     */

    public function insertReceiveVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length) {
        $this->db->trans_begin();
        for ($i = 0; $i < $length; $i++) {
            $details_data = array(
                'voucher_entries_id' => $voucher_id,
                'ledger_id' => $account_head[$i],
                'description' => $description[$i],
                'tax_id' => $tax_id[$i],
                'debit_amount' => $debit_amount[$i],
                'credit_amount' => $credit_amount[$i]
            );
            $d_amount = $debit_amount[$i];
            $c_amount = $credit_amount[$i];
            $result = $this->db->insert('receive_voucher_entries_details', $details_data);
            if ($result) {
                $get_exit_ledger_balance_data = array(
                    'id' => $account_head[$i]
                );

                $get_exitledger_balance = $this->db->get_where('ledgers', $get_exit_ledger_balance_data);
                if ($get_exitledger_balance->num_rows() > 0) {
                    if ($d_amount == NULL) {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row - $c_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    } else {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row + $d_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    }
                }
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @ insert journal voucher
     * @ asscess public
     * return bool
     */

    public function insertJournalVoucher($voucher_master_data, $cheque_book_number, $cheque_number) {
        $result = $this->db->insert('journal_voucher_entries', $voucher_master_data);
        $insert_id = $this->db->insert_id();
        if ($result) {
            if (!empty($cheque_book_number) and ! empty($cheque_number)) {
                $update_cheque_number = array(
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number
                );
                $update_data = array(
                    'status' => 'taken'
                );
                $this->db->update('cheque_register', $update_data, $update_cheque_number);
            }
        }
        return $insert_id;
    }

    /*
     * @ insert journal voucher details
     * @ asscess public
     * return bool
     */

    public function insertJournalVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length) {
        $this->db->trans_begin();
        for ($i = 0; $i < $length; $i++) {
            $details_data = array(
                'voucher_entries_id' => $voucher_id,
                'ledger_id' => $account_head[$i],
                'description' => $description[$i],
                'tax_id' => $tax_id[$i],
                'debit_amount' => $debit_amount[$i],
                'credit_amount' => $credit_amount[$i]
            );
            $d_amount = $debit_amount[$i];
            $c_amount = $credit_amount[$i];
            $result = $this->db->insert('journal_voucher_entries_details', $details_data);
            if ($result) {
                $get_exit_ledger_balance_data = array(
                    'id' => $account_head[$i]
                );

                $get_exitledger_balance = $this->db->get_where('ledgers', $get_exit_ledger_balance_data);
                if ($get_exitledger_balance->num_rows() > 0) {
                    if ($d_amount == NULL) {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row - $c_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    } else {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row + $d_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    }
                }
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /*
     * @ insert contra voucher
     * @ asscess public
     * return bool
     */

    public function insertContraVoucher($voucher_master_data, $cheque_book_number, $cheque_number) {
        $result = $this->db->insert('contra_voucher_entries', $voucher_master_data);
        $insert_id = $this->db->insert_id();
        if ($result) {
            if (!empty($cheque_book_number) and ! empty($cheque_number)) {
                $update_cheque_number = array(
                    'cheque_book_number' => $cheque_book_number,
                    'cheque_number' => $cheque_number
                );
                $update_data = array(
                    'status' => 'taken'
                );
                $this->db->update('cheque_register', $update_data, $update_cheque_number);
            }
        }
        return $insert_id;
    }

    /*
     * @ insert contra voucher details
     * @ asscess public
     * return bool
     */

    public function insertContraVoucherDetails($voucher_id, $account_head, $description, $tax_id, $debit_amount, $credit_amount, $length) {
        $this->db->trans_begin();
        for ($i = 0; $i < $length; $i++) {
            $details_data = array(
                'voucher_entries_id' => $voucher_id,
                'ledger_id' => $account_head[$i],
                'description' => $description[$i],
                'tax_id' => $tax_id[$i],
                'debit_amount' => $debit_amount[$i],
                'credit_amount' => $credit_amount[$i]
            );
            $d_amount = $debit_amount[$i];
            $c_amount = $credit_amount[$i];
            $result = $this->db->insert('contra_voucher_entries_details', $details_data);
            if ($result) {
                $get_exit_ledger_balance_data = array(
                    'id' => $account_head[$i]
                );

                $get_exitledger_balance = $this->db->get_where('ledgers', $get_exit_ledger_balance_data);
                if ($get_exitledger_balance->num_rows() > 0) {
                    if ($d_amount == NULL) {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row - $c_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    } else {
                        $balance_row = $get_exitledger_balance->result()[0]->balance;
                        $balance = $balance_row + $d_amount;
                        $update_balance = array(
                            'balance' => $balance
                        );
                        $this->db->update('ledgers', $update_balance, $get_exit_ledger_balance_data);
                    }
                }
            }
        }
        if ($this->db->trans_status() == TRUE) {
            $this->db->trans_commit();
            return TRUE;
        } else {
            $this->db->trans_rollback();
        }
    }

    /**
     * Add Truck
     * return boolean
     * */
    public function addTruck($insert_data) {
        $result = $this->db->insert('truck', $insert_data);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * List of Truck
     * return object
     */
    public function truckList() {
        $truck_list = $this->db->select('*')
                        ->from('truck')
                        ->where('truck.status', 'Active')
                        ->get()->result_array();
        return $truck_list;
    }
    
    /**
     * @ get all member account
     * @ return object
     * @ access public
     */
    public function getAllMemberAccount(){
         $result = $this->db->select('id,group_id,ledger_name')
                        ->from('ledgers')
                        ->where('ledgers.status', 'Active')
                        ->where('ledgers.group_id', 25)
                        ->get()->result_array();
        return $result;
    }

    /**
     * List of Member
     * return object
     */
    public function memberList() {
        $truck_list = $this->db->select('member.*, ledgers.ledger_name')
                        ->from('member')
                        ->join('ledgers', 'ledgers.id = member.account_id')
                        ->where('member.status', 'Active')
                        ->get()->result_array();
        return $truck_list;
    }

}
