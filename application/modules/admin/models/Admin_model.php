<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin model
 *
 */
class Admin_model extends CI_Model
{

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->database();
    }

    /***
     * get_profile_image method
     *
     * select the existing image file from database
     * @access public
     * @param int $user_id
     * @param string $key - value of the meta_key
     */
    public function get_profile_image($user_id)
    {
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

    public function get_all_base_chart()
    {
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
    public function get_profile_meta($user_id)
    {
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
    public function get_user_mail($user_id)
    {
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
    public function update_profile($data, $user_id)
    {
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
    public function insert_profile_image($user_id, $upload_data)
    {
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

    public function get_user_meta_value($user_id, $key)
    {
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
    public function check_existing_email($email)
    {
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
    public function getAllAssetsParents()
    {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 10));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Assets Sub Child
     * @return object
     * */
    public function getAllAssetsSubChild()
    {
        $parent = $this->db->get_where('groups', array('parent_id' => 1));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Assets Sub Child under sub
     * @return object
     * */
    public function getAllAssetsSubChildUnderSub($sub_child_id_value)
    {
        $parent = $this->db->get_where('groups', array('parent_id' => $sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllExpensesParents()
    {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 20));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Expense Sub Child
     * @return object
     * */
    public function getAllExpenseSubChild()
    {
        $parent = $this->db->get_where('groups', array('parent_id' => 2));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Expense Sub Child under sub
     * @return object
     * */
    public function getAllexpenseSubChildUnderSub($expense_sub_child_id_value)
    {
        $parent = $this->db->get_where('groups', array('parent_id' => $expense_sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllIncomeParents()
    {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 30));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Income Sub Child
     * @return object
     * */
    public function getAllIncomesSubChild()
    {
        $parent = $this->db->get_where('groups', array('parent_id' => 3));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Income Sub Child under sub
     * @return object
     * */
    public function getAllIncomesSubChildUnderSub($incomes_sub_child_id_value)
    {
        $parent = $this->db->get_where('groups', array('parent_id' => $incomes_sub_child_id_value));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all parents
     * @return object
     * */
    public function getAllLiabilitiesParents()
    {
        $parent = $this->db->get_where('groups', array('root_parent_id' => 40));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Liabilities Sub Child
     * @return object
     * */
    public function getAllLiabilitiesSubChild()
    {
        $parent = $this->db->get_where('groups', array('parent_id' => 4));
        return $parent->result();
    }

    /**
     * @access public
     * @Get all Liabilities Sub Child under sub
     * @return object
     * */
    public function getAllLiabilitiesSubChildUnderSub($liabilities_sub_child_id_value)
    {
        $parent = $this->db->get_where('groups', array('parent_id' => $liabilities_sub_child_id_value));
        return $parent->result();
    }

    /*
     * @Insert group name
     * @access public
     * @return bool
     */

    public function insertGroupName($group_name, $parent_id, $root_parent_id, $created_by)
    {
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

    public function getEditGroupData($group_id)
    {
        $result = $this->db->get_where('groups', array('id' => $group_id));
        return $result->result();
    }

    /*
     * @update group data
     * @access public
     * @return array
     */

    public function updateGroupData($update_id, $group_name, $parent_id, $root_parent_id, $updated_by)
    {
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

    public function insertLedger($data)
    {
		$check_exists = $this->db->get_where('ledgers',array('ledger_name'=>$data['ledger_name']));
		if($check_exists->num_rows() == 0){
			if($data['balance_type'] == 'C'){
				$insert_data = array(
					'group_id' => $data['ledger_parent'],
					'ledger_name' => $data['ledger_name'],
					'op_balance' => $data['opening_balance'],
//					'credit' => $data['opening_balance'],
					'balance' => $data['opening_balance'],
					'balance_type' => $data['balance_type'],
					'note ' => $data['note'],
					'create_by ' => $_SESSION['username'],
					'status' => 'active'
				);
			}elseif ($data['balance_type'] == 'D'){
				$insert_data = array(
					'group_id' => $data['ledger_parent'],
					'ledger_name' => $data['ledger_name'],
					'op_balance' => $data['opening_balance'],
//					'debit' => $data['opening_balance'],
					'balance' => $data['opening_balance'],
					'balance_type' => $data['balance_type'],
					'note ' => $data['note'],
					'create_by ' => $_SESSION['username'],
					'status' => 'active'
				);

			}
			$result = $this->db->insert('ledgers', $insert_data);
			if($result){
				return true;
			}else{
				return false;
			}

		}else{
			return false;
		}
        
    }

    /*
     * @update ledger name
     * @access public
     * @return bool
     */

		public function updateLedger($data)
    {
    	if(!empty($data['ledger_id'])){
			$check_exists = $this->db->get_where('ledgers',array('id'=>$data['ledger_id']))->row_array();
			if($data['balance_type'] == 'C'){
				$update_data = array(
					'group_id' => $data['ledger_parent'],
					'ledger_name' => $data['ledger_name'],
					'op_balance' => $data['opening_balance'],
//					'credit' => $data['opening_balance'],
//					'debit' => 0,
					'balance' => $data['opening_balance'],
					'balance_type' => $data['balance_type'],
					'note ' => $data['note'],
					'updated_by ' => $_SESSION['username'],
					'status' => 'active'
				);
			}elseif ($data['balance_type'] == 'D'){
				$update_data = array(
					'group_id' => $data['ledger_parent'],
					'ledger_name' => $data['ledger_name'],
					'op_balance' => $data['opening_balance'],
//					'debit' => $data['opening_balance'],
//					'credit' => 0,
					'balance' => $data['opening_balance'],
					'balance_type' => $data['balance_type'],
					'note ' => $data['note'],
					'updated_by ' => $_SESSION['username'],
					'status' => 'active'
				);

			}
			if(abs($check_exists['op_balance']) == abs($check_exists['balance'])){
				$result = $this->db->update('ledgers', $update_data,array('id'=>$data['ledger_id']));
				if($result){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
    		return false;
		}
    }

    /*
     * List of ledger
     * @ access public
     * @ return object
     */

    public function getAllLedgerAccount($ledger_id)
    {
        $result = $this->db->get_where('ledgers', array('group_id' => $ledger_id));
        return $result->result();
    }

    /*
     * get ledger update data
     * @ access public
     * @ return object
     */

    public function getLedgerUpdateData($ledger_id)
    {
        $result = $this->db->get_where('ledgers', array('id' => $ledger_id));
        return $result->result();
    }

    /*
     * get debit ledger for balance
     * @ access public
     * @ return object
     */

    public function getDebitLedgerBalance($ledger_balnce_id)
    {
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

    public function getAllLedger()
    {
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

    public function getAllSubGroups($id)
    {
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

    public function insertPaymode($insert_data)
    {
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

    public function getAllPayModeName()
    {
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

    public function insertBank($insert_data)
    {
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

    public function getAllBankName()
    {
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

    public function getAllChequeBookNumber()
    {
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

    public function getAllChequeNumberAgnBook($cheque_book_number)
    {
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

    public function getAllChequeNumber()
    {
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

    public function getBankNameONChequeNumber($bank_name_on_chequeNumber_row)
    {
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

    public function getPaymentVoucherId()
    {
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

    public function getReceiveVoucherId()
    {
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

    public function getJournalVoucherId()
    {
        $this->db->select('*');
        $this->db->from('journal_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ get Last voucher id contra voucher
     * @ asscess public
     * @ return object
     */

    public function getContraVoucherId()
    {
        $this->db->select('*');
        $this->db->from('contra_voucher_entries');
        $result = $this->db->get();
        return $result->num_rows();
    }

    /*
     * @ get member truck list
     * @ access public
     * @ return object
     */

    public function getMemberTruckList()
    {
        $this->db->select('truck_tbl_id, truck_number');
        $this->db->from('truck');
//        $this->db->where('truck.truck_type', 'A');
        $this->db->where('truck.status', 'Active');
        $result = $this->db->get();
        return $result->result_array();
    }

    /*
     * @ insert payment voucher
     * @ access public
     * return bool
     */
    public function insertPaymentVoucher($data)
    {
    	$flag = 0;
		if(!empty($data['debit_total']) && !empty($data['credit_total'])){
			if($data['debit_total'] == $data['credit_total']){
				$voucher_master_data = array(
					'paymode_id ' => $data['paymode'],
					'voucher_date' => date('Y-m-d', strtotime($data['voucher_date'])),
					'voucher_type' => 'PV',
					'reference_no' => $data['reference'],
					'mobile_number' => $data['mobile_number'],
					'cheque_book_number' => $data['cheque_book_number'],
					'cheque_number' => ((!empty($data['cheque_number']))? $data['cheque_number']:''),
					'cheque_date' => date('Y-m-d', strtotime($data['cheque_date'])),
					'bank_id' => ((!empty($data['bank_name']))? $data['bank_name']:''),
					'total' => $data['debit_total'],
					'narration' => $data['narration'],
					'created_by' => $_SESSION['username'],
					'status' => 'active',
				);
				$result= $this->db->insert('payment_voucher_entries', $voucher_master_data);
				$insert_id = $this->db->insert_id();
				if($result){
					foreach ($data['account_head'] as $key=>$val){
						$details_data = array(
							'voucher_entries_id' => $insert_id,
							'ledger_id' => $val,
							'description' => $data['description'][$key],
							'tax_id' => $data['tax'][$key],
							'debit_amount' => $data['debit_amount'][$key],
							'credit_amount' => $data['credit_amount'][$key]
						);
						$details_result = $this->db->insert('payment_voucher_entries_details', $details_data);
						if($details_result){
							$flag = 1;
							$ledger_exists_data = $this->db->get_where('ledgers',array('id'=>$val))->row();
							if(!empty($ledger_exists_data)){
								$debit_amount = ($ledger_exists_data->debit) + ($data['debit_amount'][$key]);
								$credit_amount = ($ledger_exists_data->credit) + ($data['credit_amount'][$key]);
								if($debit_amount>$credit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($debit_amount-$credit_amount),
										'balance_type'=>'D'
									);
								}elseif ($credit_amount>$debit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($credit_amount-$debit_amount),
										'balance_type'=>'C'
									);
								}
								$this->db->update('ledgers',$update_ledger_array,array('id'=>$val));
							}
						}
					}
				}
			}
		}

		if($flag == 1){
			return true;
		}
    }

    /*
     * @ insert receive voucher
     * @ access public
     * return bool
     */

    public function insertReceiveVoucher($data)
    {
		$flag = 0;
		if(!empty($data['debit_total']) && !empty($data['credit_total'])){
			if($data['debit_total'] == $data['credit_total']){
				$voucher_master_data = array(
					'paymode_id ' => $data['paymode'],
					'voucher_date' => date('Y-m-d', strtotime($data['voucher_date'])),
					'voucher_type' => 'RV',
					'reference_no' => $data['reference'],
					'mobile_number' => $data['mobile_number'],
					'cheque_book_number' => $data['cheque_book_number'],
					'cheque_number' => ((!empty($data['cheque_number']))? $data['cheque_number']:''),
					'cheque_date' => date('Y-m-d', strtotime($data['cheque_date'])),
					'bank_id' => ((!empty($data['bank_name']))? $data['bank_name']:''),
					'total' => $data['debit_total'],
					'narration' => $data['narration'],
					'created_by' => $_SESSION['username'],
					'status' => 'active',
				);
				$result= $this->db->insert('receive_voucher_entries', $voucher_master_data);
				$insert_id = $this->db->insert_id();
				if($result){
					foreach ($data['account_head'] as $key=>$val){
						$details_data = array(
							'voucher_entries_id' => $insert_id,
							'ledger_id' => $val,
							'description' => $data['description'][$key],
							'tax_id' => $data['tax'][$key],
							'debit_amount' => $data['debit_amount'][$key],
							'credit_amount' => $data['credit_amount'][$key]
						);
						$details_result = $this->db->insert('receive_voucher_entries_details', $details_data);

						if($details_result){
							$flag = 1;
							$ledger_exists_data = $this->db->get_where('ledgers',array('id'=>$val))->row();
							if(!empty($ledger_exists_data)){
								$debit_amount = ($ledger_exists_data->debit) + ($data['debit_amount'][$key]);
								$credit_amount = ($ledger_exists_data->credit) + ($data['credit_amount'][$key]);
								if($debit_amount>$credit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($debit_amount-$credit_amount),
										'balance_type'=>'D'
									);
								}elseif ($credit_amount>$debit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($credit_amount-$debit_amount),
										'balance_type'=>'C'
									);
								}
								$this->db->update('ledgers',$update_ledger_array,array('id'=>$val));
							}
						}
					}
				}
			}
		}

		if($flag == 1){
			return true;
		}
    }

    /*
     * @ insert journal voucher
     * @ asscess public
     * return bool
     */

    public function insertJournalVoucher($data)
    {
		$flag = 0;
		if(!empty($data['debit_total']) && !empty($data['credit_total'])){
			if($data['debit_total'] == $data['credit_total']){
				$voucher_master_data = array(
					'paymode_id ' => $data['paymode'],
					'voucher_date' => date('Y-m-d', strtotime($data['voucher_date'])),
					'voucher_type' => 'JV',
					'reference_no' => $data['reference'],
					'mobile_number' => $data['mobile_number'],
					'cheque_book_number' => $data['cheque_book_number'],
					'cheque_number' => ((!empty($data['cheque_number']))? $data['cheque_number']:''),
					'cheque_date' => date('Y-m-d', strtotime($data['cheque_date'])),
					'bank_id' => ((!empty($data['bank_name']))? $data['bank_name']:''),
					'total' => $data['debit_total'],
					'narration' => $data['narration'],
					'created_by' => $_SESSION['username'],
					'status' => 'active',
				);
				$result= $this->db->insert('journal_voucher_entries', $voucher_master_data);
				$insert_id = $this->db->insert_id();
				if($result){
					foreach ($data['account_head'] as $key=>$val){
						$details_data = array(
							'voucher_entries_id' => $insert_id,
							'ledger_id' => $val,
							'description' => $data['description'][$key],
							'tax_id' => $data['tax'][$key],
							'debit_amount' => $data['debit_amount'][$key],
							'credit_amount' => $data['credit_amount'][$key]
						);
						$details_result = $this->db->insert('journal_voucher_entries_details', $details_data);
						if($details_result){
							$flag = 1;
							$ledger_exists_data = $this->db->get_where('ledgers',array('id'=>$val))->row();
							if(!empty($ledger_exists_data)){
								$debit_amount = ($ledger_exists_data->debit) + ($data['debit_amount'][$key]);
								$credit_amount = ($ledger_exists_data->credit) + ($data['credit_amount'][$key]);
								if($debit_amount>$credit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($debit_amount-$credit_amount),
										'balance_type'=>'D'
									);
								}elseif ($credit_amount>$debit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($credit_amount-$debit_amount),
										'balance_type'=>'C'
									);
								}
								$this->db->update('ledgers',$update_ledger_array,array('id'=>$val));
							}
						}
					}
				}
			}
		}

		if($flag == 1){
			return true;
		}
    }

    /*
     * @ insert contra voucher
     * @ asscess public
     * return bool
     */

    public function insertContraVoucher($data)
    {
		$flag = 0;
		if(!empty($data['debit_total']) && !empty($data['credit_total'])){
			if($data['debit_total'] == $data['credit_total']){
				$voucher_master_data = array(
					'paymode_id ' => $data['paymode'],
					'voucher_date' => date('Y-m-d', strtotime($data['voucher_date'])),
					'voucher_type' => 'JV',
					'reference_no' => $data['reference'],
					'mobile_number' => $data['mobile_number'],
					'cheque_book_number' => $data['cheque_book_number'],
					'cheque_number' => ((!empty($data['cheque_number']))? $data['cheque_number']:''),
					'cheque_date' => date('Y-m-d', strtotime($data['cheque_date'])),
					'bank_id' => ((!empty($data['bank_name']))? $data['bank_name']:''),
					'total' => $data['debit_total'],
					'narration' => $data['narration'],
					'created_by' => $_SESSION['username'],
					'status' => 'active',
				);
				$result= $this->db->insert('contra_voucher_entries', $voucher_master_data);
				$insert_id = $this->db->insert_id();
				if($result){
					foreach ($data['account_head'] as $key=>$val){
						$details_data = array(
							'voucher_entries_id' => $insert_id,
							'ledger_id' => $val,
							'description' => $data['description'][$key],
							'tax_id' => $data['tax'][$key],
							'debit_amount' => $data['debit_amount'][$key],
							'credit_amount' => $data['credit_amount'][$key]
						);
						$details_result = $this->db->insert('contra_voucher_entries_details', $details_data);

						if($details_result){
							$flag = 1;
							$ledger_exists_data = $this->db->get_where('ledgers',array('id'=>$val))->row();
							if(!empty($ledger_exists_data)){
								$debit_amount = ($ledger_exists_data->debit) + ($data['debit_amount'][$key]);
								$credit_amount = ($ledger_exists_data->credit) + ($data['credit_amount'][$key]);
								if($debit_amount>$credit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($debit_amount-$credit_amount),
										'balance_type'=>'D'
									);
								}elseif ($credit_amount>$debit_amount){
									$update_ledger_array = array(
										'debit'=>$debit_amount,
										'credit'=>$credit_amount,
										'balance'=>($credit_amount-$debit_amount),
										'balance_type'=>'C'
									);
								}
								$this->db->update('ledgers',$update_ledger_array,array('id'=>$val));
							}
						}
					}
				}
			}
		}

		if($flag == 1){
			return true;
		}
    }

    /**
     * @ insert member truck voucher
     * @ access public
     * return bool
     */
    public function insert_member_truck_voucher($post)
    {
        $master_data = array(
            'total_amount' => $post['total_amount'],
            'created_by' => $_SESSION['username'],
            'note' => $post['note'],
        );
        $receive_voucher_data = array(
            'voucher_date'=> date('Y-m-d'),
            'voucher_type'=>'RV',
            'total' =>$post['total_amount'],
            'narration'=>$post['note'],
            'created_by' => $_SESSION['username']
        );
        //update member truck fee
        $truck_member_exits_balance_data = $this->db->select('po_balance,debit,credit,balance')->from('ledgers')->where('id', 19)->get()->result_array();
        $updated_balance = $truck_member_exits_balance_data[0]['balance'] + $post['total_amount'];
        $updated_credit = $truck_member_exits_balance_data[0]['credit'] + $post['total_amount'];
        $this->db->update('ledgers', array('balance' => $updated_balance, 'credit' => $updated_credit), array('id' => 19));

        //update cash in hand fee
        $cash_in_hand_exits_balance_data = $this->db->select('balance, debit')->from('ledgers')->where('id', 1)->get()->result_array();
        $updated_cash_in_hand_balance = $cash_in_hand_exits_balance_data[0]['balance'] + $post['total_amount'];
        $updated_debit = $cash_in_hand_exits_balance_data[0]['debit'] + $post['total_amount'];
        $this->db->update('ledgers', array('balance' => $updated_cash_in_hand_balance, 'debit' => $updated_debit), array('id' => 1));
        $result = 0;
        $ins_result = $this->db->insert('member_truck_voucher_master', $master_data);
        $insert_id = $this->db->insert_id();
        $receive_vouchure = $this->db->insert('receive_voucher_entries', $receive_voucher_data);
        $receive_vouchure_insert_id = $this->db->insert_id();

        if ($ins_result) {
            $length = count($post['truck_id']);
            for ($i = 0; $i < $length; $i++) {
                $details_data = array(
                    'member_truck_voucher_master_id' => $insert_id,
                    'truck_id' => $post['truck_id'][$i],
                    'truck_member_id' => $post['truck_member_id'][$i],
                    'amount' => $post['amount'][$i],
                    'entry_date' => date('Y-m-d', strtotime($post['e_date'][$i])),
                    'created_by' => $_SESSION['username']
                );
                $de_insert = $this->db->insert('member_truck_voucher_details', $details_data);

                $receive_vouchure_details = array(
                    'voucher_entries_id' =>$receive_vouchure_insert_id,
                    'ledger_id' => '19',
                    'tax_id' => '1',
                    'debit_amount' =>$post['amount'][$i],
                );
                $receive_vouchure_details_insert = $this->db->insert('receive_voucher_entries_details', $receive_vouchure_details);
                if ($de_insert) {
                    $result = 1;
                }
            }
        }
        if ($result == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @ insert non member truck voucher
     * @ access public
     * return bool
     */
    public function insert_non_member_truck_voucher($post)
    {
        $non_member_truck_voucher_data = array(
            'entry_date' => date('Y-m-d', strtotime($post['entry_date'])),
            'truck_count' => $post['truck_count'],
            'total_amount' => $post['total_amount'],
            'note' => $post['narration'],
            'created_by' => $_SESSION['username']
        );
        //update non truck free
        $truck_member_exits_balance_data = $this->db->select('balance,credit')->from('ledgers')->where('id', 20)->get()->result_array();
        $updated_balance = $truck_member_exits_balance_data[0]['balance'] + $post['total_amount'];
        $credit_balance = $truck_member_exits_balance_data[0]['balance'] + $post['total_amount'];
        $ledger_update = $this->db->update('ledgers', array('balance' => $updated_balance, 'credit' => $credit_balance), array('id' => 20));

        //insert receive voucher
        $receive_voucher_data = array(
            'voucher_date'=>date('Y-m-d', strtotime($post['entry_date'])),
            'voucher_type'=>'RV',
            'total'=>$post['total_amount'],
            'narration'=>$post['narration'],
            'created_by'=>$_SESSION['username']
        );
        $receive_vouchure = $this->db->insert('receive_voucher_entries', $receive_voucher_data);
        $receive_vouchure_insert_id = $this->db->insert_id();
        if($receive_vouchure){
            $receive_vouchure_details = array(
                'voucher_entries_id' =>$receive_vouchure_insert_id,
                'ledger_id' => '20',
                'tax_id' => '1',
                'debit_amount' =>$post['total_amount']
            );
            $receive_vouchure_details_insert = $this->db->insert('receive_voucher_entries_details', $receive_vouchure_details);
        }
        //update cash in hand fee
        $cash_in_hand_exits_balance_data = $this->db->select('balance, debit')->from('ledgers')->where('id', 1)->get()->result_array();
        $updated_cash_in_hand_balance = $cash_in_hand_exits_balance_data[0]['balance'] + $post['total_amount'];
        $updated_debit = $cash_in_hand_exits_balance_data[0]['debit'] + $post['total_amount'];
        $this->db->update('ledgers', array('balance' => $updated_cash_in_hand_balance, 'debit' => $updated_debit), array('id' => 1));

        if ($ledger_update) {
            $result = $this->db->insert('non_member_truck_voucher', $non_member_truck_voucher_data);
            if ($result) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }


    /**
     * Add Truck
     * return boolean
     * */
    public function addTruck($insert_data)
    {
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
    public function truckList()
    {
        $truck_list = $this->db->select('truck.*, ledgers.ledger_name, member.member_no')
            ->from('truck')
            ->join('member', 'member.member_id = truck.member_id')
            ->join('ledgers', 'member.account_id = ledgers.id')
            ->where('truck.status', 'Active')
            ->order_by('truck.member_id')
            ->get()->result_array();
        return $truck_list;
    }

    /**
     * @ get all member account
     * @ return object
     * @ access public
     */
    public function getAllMemberAccount()
    {
        $result = $this->db->select('id,group_id,ledger_name,status')
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
    public function memberList()
    {
        $member_list = $this->db->select('member.*, ledgers.ledger_name,ledgers.status,ledgers.id')
            ->from('member')
            ->join('ledgers', 'ledgers.id = member.account_id')
//            ->join('truck', 'truck.member_id = member.member_id')
            ->where('member.status', 'Active')
            ->get()->result_array();
        return $member_list;
    }

    /*=======================Truck report==================================*/
    /**
     * Truck Member report
     * access public
     * return object
     * parameter date range
     */

    public function truckMemberReport()
    {
        $truck_member_report = $this->db->select('member.member_no, ledgers.ledger_name, truck.truck_number, truck.truck_type')
            ->from('member')
            ->join('ledgers', 'ledgers.id = member.account_id')
            ->join('truck', 'truck.member_id = member.member_id')
            ->where('member.status', 'Active')
            ->order_by('member.member_no')
            ->get()->result_array();
        return $truck_member_report;
    }
    /**
    * Truck Member report
    * access public
    * return object
    * parameter date range
    */

    public function truckStatementMemberwise($start_date,$end_date, $member_id)
    {
         $this->db->select('
                            member.member_no,
                            ledgers.ledger_name,
                            member_truck_voucher_details.truck_id,
                            member_truck_voucher_details.truck_member_id,
                            truck.truck_number,
                            truck.remark,
                            (select count(member_truck_voucher_details.truck_id) from truck where truck.truck_type = "A" AND member_truck_voucher_details.truck_id = truck.truck_tbl_id) as big,                                      
                            (select count(member_truck_voucher_details.truck_id) from truck where truck.truck_type = "B" AND member_truck_voucher_details.truck_id = truck.truck_tbl_id) as mini                                       
                            ');
        $this->db->from('member_truck_voucher_details');
        $this->db->join('truck', 'member_truck_voucher_details.truck_id = truck.truck_tbl_id');
        $this->db->join('member', 'member.account_id = member_truck_voucher_details.truck_member_id');
        $this->db->join('ledgers', 'ledgers.id = member.account_id');
        $this->db->where("DATE_FORMAT(member_truck_voucher_details.entry_date,'%Y-%m-%d') >=", $start_date);
        $this->db->where("DATE_FORMAT(member_truck_voucher_details.entry_date,'%Y-%m-%d') <=", $end_date);
        $this->db->where('member_truck_voucher_details.status', 'Active');
        if($member_id != 'All'){
            $this->db->where('member_truck_voucher_details.truck_member_id', $member_id);
        }
        $this->db->group_by('member_truck_voucher_details.truck_member_id');
        $truck_member_report = $this->db->get()->result_array();
        return $truck_member_report;
    }
    /**
     * Truck income statement report
     * access public
     * return object
     * parameter date range
     */
    public function getTruckIncomeStatement($start_date,$end_date)
    {
        $truck_income_statement_report = $this->db->select('id, voucher_date,narration,total')
                                                ->from('receive_voucher_entries')
                                                ->where("DATE_FORMAT(voucher_date,'%Y-%m-%d') >=", $start_date)
                                                ->where("DATE_FORMAT(voucher_date,'%Y-%m-%d') <=", $end_date)
                                                ->order_by('voucher_date')
                                                ->get()->result_array();
        return $truck_income_statement_report;
    }

    /**
     * Truck statement report Non memberwise
     * access public
     * return object
     * parameter date range
     */
    public function getTruckStatementNonMemberwise($start_date,$end_date){
        $truck_statement_report_nonmemberwise = $this->db->select('*')
                                                        ->from('non_member_truck_voucher')
                                                        ->where("DATE_FORMAT(entry_date,'%Y-%m-%d') >=", $start_date)
                                                        ->where("DATE_FORMAT(entry_date,'%Y-%m-%d') <=", $end_date)
                                                        ->order_by('entry_date')
                                                        ->get()->result_array();
        return $truck_statement_report_nonmemberwise;
    }
    /**
     * get account ledger wise statement
     * access public
     * return object
	 * parameter ledger id
     * parameter date range
     */
    public function getLedgerWiseAccountStatement($start_date,$end_date,$ledger_id){
        $ledger_wise_statement = array();
        $ledger_wise_before_date_statement = array();
        $receive_statement = $this->db->select('receive_voucher_entries.id,
                                                   receive_voucher_entries.voucher_date,
                                                   receive_voucher_entries.narration,
                                                   receive_voucher_entries.voucher_type,
                                                   ledgers.op_balance,
                                                   ledgers.balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   rv.ledger_id,
                                                   SUM(rv.debit_amount) as debit_amount,
                                                   SUM(rv.credit_amount) as credit_amount')
                                        ->from('receive_voucher_entries_details as rv')
                                        ->join('ledgers','ledgers.id = rv.ledger_id')
                                        ->join('receive_voucher_entries','receive_voucher_entries.id = rv.voucher_entries_id')
                                        ->where("rv.ledger_id", $ledger_id)
                                        ->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
                                        ->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
                                        ->group_by('receive_voucher_entries.voucher_date')
                                        ->group_by('receive_voucher_entries.id')
                                        ->get()->result_array();

        array_push($ledger_wise_statement,$receive_statement);

		$before_receive_statement = $this->db->select('receive_voucher_entries.id,
                                                   receive_voucher_entries.voucher_date,
                                                   receive_voucher_entries.narration,
                                                   receive_voucher_entries.voucher_type,
                                                   ledgers.op_balance,
                                                   ledgers.balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   rv.ledger_id,
                                                   SUM(rv.debit_amount) as debit_amount,
                                                   SUM(rv.credit_amount) as credit_amount')
			->from('receive_voucher_entries_details as rv')
			->join('ledgers','ledgers.id = rv.ledger_id')
			->join('receive_voucher_entries','receive_voucher_entries.id = rv.voucher_entries_id')
			->where("rv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('receive_voucher_entries.voucher_date')
			->group_by('receive_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_receive_statement);
        $payment_statement = $this->db->select('payment_voucher_entries.id,
                                                   payment_voucher_entries.voucher_date,
                                                   payment_voucher_entries.narration,
                                                   payment_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   pv.ledger_id,
                                                   SUM(pv.debit_amount)as debit_amount,
                                                   SUM(pv.credit_amount)as credit_amount ')
            ->from('payment_voucher_entries_details as pv')
			->join('ledgers','ledgers.id = pv.ledger_id')
            ->join('payment_voucher_entries','payment_voucher_entries.id = pv.voucher_entries_id')
            ->where("pv.ledger_id", $ledger_id)
            ->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
            ->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
            ->group_by('payment_voucher_entries.voucher_date')
            ->group_by('payment_voucher_entries.id')
            ->get()->result_array();
        array_push($ledger_wise_statement,$payment_statement);
		$before_payment_statement = $this->db->select('payment_voucher_entries.id,
                                                   payment_voucher_entries.voucher_date,
                                                   payment_voucher_entries.narration,
                                                   payment_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   pv.ledger_id,
                                                   SUM(pv.debit_amount)as debit_amount,
                                                   SUM(pv.credit_amount)as credit_amount ')
			->from('payment_voucher_entries_details as pv')
			->join('ledgers','ledgers.id = pv.ledger_id')
			->join('payment_voucher_entries','payment_voucher_entries.id = pv.voucher_entries_id')
			->where("pv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('payment_voucher_entries.voucher_date')
			->group_by('payment_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_payment_statement);

        $journal_statement = $this->db->select('journal_voucher_entries.id,
                                                   journal_voucher_entries.voucher_date,
                                                   journal_voucher_entries.narration,
                                                   journal_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   jv.ledger_id,
                                                   SUM(jv.debit_amount) as debit_amount,
                                                   SUM(jv.credit_amount) as credit_amount')
            ->from('journal_voucher_entries_details as jv')
			->join('ledgers','ledgers.id = jv.ledger_id')
            ->join('journal_voucher_entries','journal_voucher_entries.id = jv.voucher_entries_id')
            ->where("jv.ledger_id", $ledger_id)
            ->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
            ->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
            ->group_by('journal_voucher_entries.voucher_date')
            ->group_by('journal_voucher_entries.id')
            ->get()->result_array();
        array_push($ledger_wise_statement,$journal_statement);

		$jbefore_ournal_statement = $this->db->select('journal_voucher_entries.id,
                                                   journal_voucher_entries.voucher_date,
                                                   journal_voucher_entries.narration,
                                                   journal_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   jv.ledger_id,
                                                   SUM(jv.debit_amount) as debit_amount,
                                                   SUM(jv.credit_amount) as credit_amount')
			->from('journal_voucher_entries_details as jv')
			->join('ledgers','ledgers.id = jv.ledger_id')
			->join('journal_voucher_entries','journal_voucher_entries.id = jv.voucher_entries_id')
			->where("jv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('journal_voucher_entries.voucher_date')
			->group_by('journal_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$jbefore_ournal_statement);

        $contra_statement = $this->db->select('contra_voucher_entries.id,
                                                   contra_voucher_entries.voucher_date,
                                                   contra_voucher_entries.narration,
                                                   contra_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   cv.ledger_id,
                                                   SUM(cv.debit_amount) as debit_amount,
                                                   SUM(cv.credit_amount) as credit_amount')
            ->from('contra_voucher_entries_details as cv')
			->join('ledgers','ledgers.id = cv.ledger_id')
            ->join('contra_voucher_entries','contra_voucher_entries.id = cv.voucher_entries_id')
            ->where("cv.ledger_id", $ledger_id)
            ->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
            ->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
            ->group_by('contra_voucher_entries.voucher_date')
            ->group_by('contra_voucher_entries.id')
            ->get()->result_array();
        array_push($ledger_wise_statement,$contra_statement);

		$before_contra_statement = $this->db->select('contra_voucher_entries.id,
                                                   contra_voucher_entries.voucher_date,
                                                   contra_voucher_entries.narration,
                                                   contra_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   cv.ledger_id,
                                                   SUM(cv.debit_amount) as debit_amount,
                                                   SUM(cv.credit_amount) as credit_amount')
			->from('contra_voucher_entries_details as cv')
			->join('ledgers','ledgers.id = cv.ledger_id')
			->join('contra_voucher_entries','contra_voucher_entries.id = cv.voucher_entries_id')
			->where("cv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('contra_voucher_entries.voucher_date')
			->group_by('contra_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_contra_statement);

		$statement['ledger_wise_statement'] = $ledger_wise_statement;
		$statement['ledger_wise_before_date_statement'] = $ledger_wise_before_date_statement;
        return $statement;
    }

    /*
     * get account report group wise statement
     * access public
     * parameter group id
     * made by yusuf
     * ***/

	public function getGroupWiseAccountStatement($start_date,$end_date,$group_id){
		$ledger_wise_statement = array();
		$ledger_wise_before_date_statement = array();

		// get ledger ids
		$this->db->select('id');
		$this->db->from('ledgers');
		$this->db->where('group_id',$group_id);
		$ids = $this->db->get()->result_array();
		if(!empty($ids)){
			$ledger_id = array_column($ids,'id');
		}else{
			$ledger_id = '';
		}

		$receive_statement = $this->db->select('receive_voucher_entries.id,
                                                   receive_voucher_entries.voucher_date,
                                                   receive_voucher_entries.narration,
                                                   receive_voucher_entries.voucher_type,
                                                   ledgers.op_balance,
                                                   ledgers.balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   rv.ledger_id,
                                                   SUM(rv.debit_amount) as debit_amount,
                                                   SUM(rv.credit_amount) as credit_amount')
			->from('receive_voucher_entries_details as rv')
			->join('ledgers','ledgers.id = rv.ledger_id')
			->join('receive_voucher_entries','receive_voucher_entries.id = rv.voucher_entries_id')
			->where_in("rv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
			->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
			->group_by('receive_voucher_entries.voucher_date')
			->group_by('receive_voucher_entries.id')
			->get()->result_array();

		array_push($ledger_wise_statement,$receive_statement);

		$before_receive_statement = $this->db->select('receive_voucher_entries.id,
                                                   receive_voucher_entries.voucher_date,
                                                   receive_voucher_entries.narration,
                                                   receive_voucher_entries.voucher_type,
                                                   ledgers.op_balance,
                                                   ledgers.balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   rv.ledger_id,
                                                   SUM(rv.debit_amount) as debit_amount,
                                                   SUM(rv.credit_amount) as credit_amount')
			->from('receive_voucher_entries_details as rv')
			->join('ledgers','ledgers.id = rv.ledger_id')
			->join('receive_voucher_entries','receive_voucher_entries.id = rv.voucher_entries_id')
			->where_in("rv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('receive_voucher_entries.voucher_date')
			->group_by('receive_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_receive_statement);
		$payment_statement = $this->db->select('payment_voucher_entries.id,
                                                   payment_voucher_entries.voucher_date,
                                                   payment_voucher_entries.narration,
                                                   payment_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   pv.ledger_id,
                                                   SUM(pv.debit_amount)as debit_amount,
                                                   SUM(pv.credit_amount)as credit_amount ')
			->from('payment_voucher_entries_details as pv')
			->join('ledgers','ledgers.id = pv.ledger_id')
			->join('payment_voucher_entries','payment_voucher_entries.id = pv.voucher_entries_id')
			->where_in("pv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
			->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
			->group_by('payment_voucher_entries.voucher_date')
			->group_by('payment_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_statement,$payment_statement);
		$before_payment_statement = $this->db->select('payment_voucher_entries.id,
                                                   payment_voucher_entries.voucher_date,
                                                   payment_voucher_entries.narration,
                                                   payment_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   pv.ledger_id,
                                                   SUM(pv.debit_amount)as debit_amount,
                                                   SUM(pv.credit_amount)as credit_amount ')
			->from('payment_voucher_entries_details as pv')
			->join('ledgers','ledgers.id = pv.ledger_id')
			->join('payment_voucher_entries','payment_voucher_entries.id = pv.voucher_entries_id')
			->where_in("pv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('payment_voucher_entries.voucher_date')
			->group_by('payment_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_payment_statement);

		$journal_statement = $this->db->select('journal_voucher_entries.id,
                                                   journal_voucher_entries.voucher_date,
                                                   journal_voucher_entries.narration,
                                                   journal_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   jv.ledger_id,
                                                   SUM(jv.debit_amount) as debit_amount,
                                                   SUM(jv.credit_amount) as credit_amount')
			->from('journal_voucher_entries_details as jv')
			->join('ledgers','ledgers.id = jv.ledger_id')
			->join('journal_voucher_entries','journal_voucher_entries.id = jv.voucher_entries_id')
			->where_in("jv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
			->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
			->group_by('journal_voucher_entries.voucher_date')
			->group_by('journal_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_statement,$journal_statement);

		$jbefore_ournal_statement = $this->db->select('journal_voucher_entries.id,
                                                   journal_voucher_entries.voucher_date,
                                                   journal_voucher_entries.narration,
                                                   journal_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   jv.ledger_id,
                                                   SUM(jv.debit_amount) as debit_amount,
                                                   SUM(jv.credit_amount) as credit_amount')
			->from('journal_voucher_entries_details as jv')
			->join('ledgers','ledgers.id = jv.ledger_id')
			->join('journal_voucher_entries','journal_voucher_entries.id = jv.voucher_entries_id')
			->where_in("jv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('journal_voucher_entries.voucher_date')
			->group_by('journal_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$jbefore_ournal_statement);

		$contra_statement = $this->db->select('contra_voucher_entries.id,
                                                   contra_voucher_entries.voucher_date,
                                                   contra_voucher_entries.narration,
                                                   contra_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   cv.ledger_id,
                                                   SUM(cv.debit_amount) as debit_amount,
                                                   SUM(cv.credit_amount) as credit_amount')
			->from('contra_voucher_entries_details as cv')
			->join('ledgers','ledgers.id = cv.ledger_id')
			->join('contra_voucher_entries','contra_voucher_entries.id = cv.voucher_entries_id')
			->where_in("cv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date)
			->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date)
			->group_by('contra_voucher_entries.voucher_date')
			->group_by('contra_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_statement,$contra_statement);

		$before_contra_statement = $this->db->select('contra_voucher_entries.id,
                                                   contra_voucher_entries.voucher_date,
                                                   contra_voucher_entries.narration,
                                                   contra_voucher_entries.voucher_type,
                                                   ledgers.balance,
                                                   ledgers.op_balance,
                                                   ledgers.balance_type,
                                                   ledgers.ledger_name,
                                                   cv.ledger_id,
                                                   SUM(cv.debit_amount) as debit_amount,
                                                   SUM(cv.credit_amount) as credit_amount')
			->from('contra_voucher_entries_details as cv')
			->join('ledgers','ledgers.id = cv.ledger_id')
			->join('contra_voucher_entries','contra_voucher_entries.id = cv.voucher_entries_id')
			->where_in("cv.ledger_id", $ledger_id)
			->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') <", $start_date)
			->group_by('contra_voucher_entries.voucher_date')
			->group_by('contra_voucher_entries.id')
			->get()->result_array();
		array_push($ledger_wise_before_date_statement,$before_contra_statement);

		$statement['ledger_wise_statement'] = $ledger_wise_statement;
		$statement['ledger_wise_before_date_statement'] = $ledger_wise_before_date_statement;
		return $statement;
	}
	/**
	 * Trial Balance Statement
	 * access public
	 * return object
	 * ***/

	public function trialBalanceStatement($post){

		$ledger_wise_statement = array();

		if(!empty($post['start_date']) && !empty($post['end_date'])) {
//			echo '<pre>';
			$start_date = date('Y-m-d', strtotime($post['start_date']));
			$end_date = date('Y-m-d', strtotime($post['end_date']));
			$this->db->select('ledgers.op_balance,
							   ledgers.balance_type,
							   ledgers.ledger_name,
							   groups.group_name,
							   rv.ledger_id,
							   SUM(rv.debit_amount) as debit_amount,
							   SUM(rv.credit_amount) as credit_amount');
			$this->db->from('receive_voucher_entries_details as rv');
			$this->db->join('ledgers', 'ledgers.id = rv.ledger_id');
			$this->db->join('receive_voucher_entries', 'receive_voucher_entries.id = rv.voucher_entries_id');
			$this->db->join('groups', 'groups.id = ledgers.group_id');
			if (!empty($start_date) && !empty($end_date)) {
				$this->db->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date);
				$this->db->where("DATE_FORMAT(receive_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date);
			}
			$this->db->group_by('rv.ledger_id');
			$receive_statement = $this->db->get()->result_array();
			array_push($ledger_wise_statement, $receive_statement);


			$this->db->select('ledgers.op_balance,
							   ledgers.balance_type,
							   ledgers.ledger_name,
							   groups.group_name,
							   SUM(pv.debit_amount)as debit_amount,
							   SUM(pv.credit_amount)as credit_amount');
			$this->db->from('payment_voucher_entries_details as pv');
			$this->db->join('ledgers', 'ledgers.id = pv.ledger_id');
			$this->db->join('payment_voucher_entries', 'payment_voucher_entries.id = pv.voucher_entries_id');
			$this->db->join('groups', 'groups.id = ledgers.group_id');
			if (!empty($start_date) && !empty($end_date)) {
				$this->db->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date);
				$this->db->where("DATE_FORMAT(payment_voucher_entries.voucher_date,'%Y-%;m-%d') <=", $end_date);
			}
			$this->db->group_by('pv.ledger_id');
			$payment_statement = $this->db->get()->result_array();
			array_push($ledger_wise_statement, $payment_statement);

			$this->db->select('ledgers.op_balance,
							   ledgers.balance_type,
							   ledgers.ledger_name,
							   groups.group_name,
							   jv.ledger_id,
							   SUM(jv.debit_amount) as debit_amount,
							   SUM(jv.credit_amount) as credit_amount');
			$this->db->from('journal_voucher_entries_details as jv');
			$this->db->join('ledgers', 'ledgers.id = jv.ledger_id');
			$this->db->join('journal_voucher_entries', 'journal_voucher_entries.id = jv.voucher_entries_id');
			$this->db->join('groups', 'groups.id = ledgers.group_id');
			if (!empty($start_date) && !empty($end_date)) {
				$this->db->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date);
				$this->db->where("DATE_FORMAT(journal_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date);
			}
			$this->db->group_by('jv.ledger_id');
			$journal_statement = $this->db->get()->result_array();
			array_push($ledger_wise_statement, $journal_statement);

			$this->db->select('ledgers.op_balance,
							   ledgers.balance_type,
							   ledgers.ledger_name,
							   groups.group_name,
							   cv.ledger_id,
							   SUM(cv.debit_amount) as debit_amount,
							   SUM(cv.credit_amount) as credit_amount');
			$this->db->from('contra_voucher_entries_details as cv');
			$this->db->join('ledgers', 'ledgers.id = cv.ledger_id');
			$this->db->join('contra_voucher_entries', 'contra_voucher_entries.id = cv.voucher_entries_id');
			$this->db->join('groups', 'groups.id = ledgers.group_id');
			if (!empty($start_date) && !empty($end_date)) {
				$this->db->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') >=", $start_date);
				$this->db->where("DATE_FORMAT(contra_voucher_entries.voucher_date,'%Y-%m-%d') <=", $end_date);
			}
			$this->db->group_by('cv.ledger_id');
			$contra_statement = $this->db->get()->result_array();
			array_push($ledger_wise_statement, $contra_statement);

			$final_array = call_user_func_array('array_merge', $ledger_wise_statement);
			$all_ledgers = array_column($final_array,'ledger_id');
			$ledger_info = array();

			foreach ($all_ledgers as $key=>$val){
				$debit = 0;
				$credit = 0;
				foreach ($final_array as $v){
					if($val == $v['ledger_id']){
						$debit += (int) $v['debit_amount'];
						$credit += (int) $v['credit_amount'];
					}
				}
				$v['debit'] = $debit;
				$v['credit'] = $credit;

				array_push($ledger_info,$v);

			}
//			print_r($all_ledgers);
//			print_r($ledger_info);
//			print_r(call_user_func_array('array_merge', $ledger_wise_statement));

			$data['trial_balance_statement'] = $ledger_info;
		}else{
			$this->db->select('groups.group_name,
								ledgers.ledger_name,
								ledgers.op_balance,
								ledgers.balance_type,
								ledgers.debit,
								ledgers.credit');
			$this->db->from('ledgers');
			$this->db->join('groups','groups.id = ledgers.group_id');
			$result = $this->db->get()->result_array();

			$data['trial_balance_statement'] = $result;
		}
		return $data;
	}
	/**
	 * Trial Balance Statement
	 * access public
	 * return object
	 * ***/

	public function balanceStatement(){
		$this->db->select('ledger_name,
							op_balance,
							debit,
							credit');
		$this->db->from('ledgers');
		return $this->db->get()->result_array();
	}
}
