<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php
                $error = $this->session->flashdata('error');
                $success = $this->session->flashdata('successMsg');
                if ($error) {
                    ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <?php echo $error; ?>
                </div>
                <?php }if ($success) { ?>

                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <h2>
                    <?php
                    if (isset($title)) {
                        echo $title;
                    }
                    ?>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" action="<?php echo site_url() ?>admin/nonMemberTruckEntry" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="entry_number" class="col-sm-3 col-form-label">Entry Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="entry_number" name="entry_number" class="form-control" value="<?php echo $non_member_truck_entry_number + 1; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="entry_date" class="col-sm-3 col-form-label">Entry Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="entry_date" name="entry_date" class="form-control dateinput">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="true_no" class="col-sm-3 col-form-label">Truck No</label>
                                            <div class="col-sm-9">
                                            <input type="text" id="true_no" name="true_no" class="form-control">
                                                <?php if (form_error('true_no')) { ?>
                                                    <span class="help-block">
                                                        <strong><?= form_error('true_no') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <div class="row">
                                                <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="amount" name="amount" class="form-control" value="100">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="narration" class="col-sm-3 col-form-label">Note</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" id="note" name="note" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>                        
                        <div class="col-md-6">                            
                            <button type="submit" name="save_non_member_truck" class="btn btn-success pull-right">Save</button>
                            <button type="reset" class="btn btn-danger pull-right" onClick="location.reload()">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12"> 
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Truck No</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th>Entry Date</th>
                                    <th>Create By</th>
                                    <th>Status</th>                        
                                    <th>Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($non_mem_entry_truck_list)):?>
                                    <?php if (!empty($non_mem_entry_truck_list)): $i = 1; ?>
                                        <?php foreach ($non_mem_entry_truck_list as $non_entry_truck): ?>
                                            <tr>
                                                <td><?php echo $i; $i++ ?></td>
                                                <td><?php echo $non_entry_truck['truck_no'] ?> </td>
                                                <td><?php echo $non_entry_truck['amount'] ?></td>
                                                <td><?php echo $non_entry_truck['note'] ?></td>
                                                <td><?php echo $non_entry_truck['entry_date'] ?></td>
                                                <td><?php echo $non_entry_truck['created_by'] ?></td>
                                                <td><?php echo $non_entry_truck['status'] ?></td>
                                                <td>
                                                    <button type="button" data-toggle="modal" data-target="#editMember" id="edit_member" edit_member="<?= $non_entry_truck['non_member_truck_entry_id'] ?>" class="btn btn-sm btn-info pull-left"> <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</button>                                                     
                                                    <button type="button" onclick="delMemnon_entry_truck(this, <?= $non_entry_truck['non_member_truck_entry_id'] ?>)" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="fa fa-trash-o" aria-hidden="true" title="Delete Supplier "> Delete</i></button>
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
</div>

<script>
    $(document).ready(function () {
        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });
        $('.alert-success').delay(2000).hide(300).css({ 'color': 'green' });
        $('.alert-danger').delay(2000).hide(300).css({ 'color': 'red' });
    });
</script>