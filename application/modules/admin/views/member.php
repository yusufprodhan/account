<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->session->flashdata('successMsg')): ?>
                    <div class="alert alert-success alert-dismissible fadeIn show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= $this->session->flashdata('successMsg'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fadeIn show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <h2>Member</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <style> .cheque_form span{color: red;}</style>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_member"><i class="fa fa-plus"></i> Add Member</button>
                    </div>
                    <div class="col-md-12">                        
                        <br>
                        <br>
                        <br>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Name</th>
                                    <th>Member No</th>
                                    <th>Date Of Birth</th>
                                    <th>Mobile No</th>
                                    <th>Create By</th>
                                    <th>Status</th>                        
                                    <th>Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($member_list)):?>
                                    <?php if ($member_list == !NULL): $i = 1; ?>
                                        <?php foreach ($member_list as $member): ?>
                                            <tr>
                                                <td><?php echo $i; $i++ ?></td>
                                                <td><?php echo $member['ledger_name'] ?> </td>
                                                <td><?php echo $member['member_no'] ?></td>
                                                <td><?php echo $member['date_of_birth'] ?></td>
                                                <td><?php echo $member['mobile_no'] ?></td>
                                                <td><?php echo $member['created_by'] ?></td>
                                                <td><?php echo $member['status'] ?></td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#editMember" id="edit_member" edit_member="<?= $member['member_id'] ?>" class="btn btn-sm btn-info pull-left"> <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</button> 
                                                    <button type="button" onclick="editSupplier(<?= $member['member_id'] ?>);" class="btn btn-sm btn-info pull-left"> <i class="fa fa-eye" aria-hidden="true"></i> View</button> 
                                                    <button type="button" onclick="delSupplier(this, <?= $member['member_id'] ?>)" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="fa fa-trash-o" aria-hidden="true" title="Delete Supplier "> Delete</i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add member modal -->
<div class="modal fade add_member" id="add_member" role="dialog" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Member</h4>
            </div> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/member" method="post" enctype="multipart/form-data">
                            <div class="row">                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_name">Account No: <span style="color:red;">*</span></label><br>
                                        <select class="form-control select2 account_name" name="account_name" id="account_name">
                                            <option></option>
                                            <?php if(isset($all_member_account)){?>
                                                <?php if(!empty($all_member_account)){?>
                                                    <?php foreach($all_member_account as $member_account){?>
                                                        <option value="<?php echo $member_account['id']?>"><?php echo $member_account['ledger_name']?></option>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="truck_no">Truck No:</label><br>
                                        <select class="form-control select2 truck_no" name="truck_no[]" id="truck_no" multiple="multiple">
                                            <option></option>
                                            <?php if(isset($all_truck)){?>
                                                <?php if(!empty($all_truck)){?>
                                                    <?php foreach($all_truck as $truck){?>
                                                        <option value="<?php echo $truck['truck_tbl_id']?>"><?php echo $truck['truck_number']?></option>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="member_no">Member No: <span style="color:red;">*</span></label><br>
                                        <input type="text" id="member_no" name="member_no" class="form-control" required="required">  
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_name">Father Name:</label><br>
                                        <input type="text" id="father_name" name="father_name" class="form-control">
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_name">Mother Name:</label><br>
                                        <input type="text" id="mother_name" name="mother_name" class="form-control">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="husband_name">Husband Name:</label><br>
                                        <input type="text" id="husband_name" name="husband_name" class="form-control">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nid_no">National Id No/Birth No:<span style="color:red;">*</span></label><br>
                                        <input type="text" id="nid_no" name="nid_no" class="form-control" required="required">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_birth">Date Of Birth:<span style="color:red;">*</span></label><br>
                                        <input type="text" id="date_birth" name="date_birth" class="form-control dateinput" required="required">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No:<span style="color:red;">*</span></label><br>
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control" required="required">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email:</label><br>
                                        <input type="email" id="email" name="email" class="form-control">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nominee_name">Nominee name:</label><br>
                                        <input type="text" id="nominee_name" name="nominee_name" class="form-control">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="relation">Relation:</label><br>
                                        <input type="text" id="relation" name="relation" class="form-control">  
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="admission_fees">Admission Frees:</label><br>
                                        <input type="number" id="admission_fees" name="admission_fees" class="form-control">  
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="paid_up_balance">Paid Up Balance:</label><br>
                                        <input type="number" id="paid_up_balance" name="paid_up_balance" class="form-control">  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dps_group">DPS Group:</label><br>
                                        <select class="form-control dps_group" id="dps_group" name="dps_group">                                            
                                            <option></option>
                                            <option value="DPS-1">DPS-1</option>
                                            <option value="DPS-2">DPS-2</option>                                            
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="present_address">Present Address/Mailing Address:</label><br>
                                        <textarea type="number" id="present_address" name="present_address" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="permanent_address">Permanent Address:</label><br>
                                        <textarea type="number" id="permanent_address" name="permanent_address" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="member_type">Member Type:</label><br>
                                        <select class="form-control member_type" id="member_type" name="member_type"> 
                                            <option></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="relation">Picture:</label><br>
                                        <input type="file" id="picture" name="picture" class="form-control">  
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_member" class="btn btn-success pull-right" id="add_member" title="Add Truck">Add Member</button>
                        </form>  
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<!--Edit Member modal -->
<div class="modal fade editMember" id="editMember" role="dialog" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Member</h4>
            </div> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/member" method="post" enctype="multipart/form-data">
                            <div class="row">                                
                                <div id="member_update_data">

                                </div>
                            </div>
                            <button type="submit" name="update_member" class="btn btn-success pull-right" id="update_member" title="Update Member">Update Member</button>
                        </form>  
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<script>
    $(document).ready(function(){
        
        $('select').css('width', '100%');
       
        $(".account_name").select2({
            placeholder: "Select Account",
        });
        
        $(".truck_no").select2({
            placeholder: "Select Account",
        });
        
        $(".dps_group").select2({
            placeholder: "Select GPS",
        });
        
        $(".member_type").select2({
            placeholder: "Select GPS",
        });
        
        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': '#fff'});
    });

    //edit member
    $(document).on("click", "#edit_member", function(){
        var member_edit_id = $(this).attr('edit_member');
        // console.log(member_edit_id);
        $.ajax({
            url: "<?= site_url('/admin/getMemberDataOnEdit/'); ?>",
            type: 'post',
            data: { member_edit_id: member_edit_id },
            success: function (data) {
                $(document).find('#member_update_data').html(data);
                $('select').css('width', '100%');
                $(".truck_no").select2({
                    placeholder: "Select Account",
                });              
                
                $('.dateinput').datetimepicker({
                    format: 'YYYY-MM-DD',                    
                });
            }
        });

    });
</script>