<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->session->flashdata('successMsg')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= $this->session->flashdata('successMsg'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <h2>Pay Mode</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/createPayMode" method="post">
                            <div class="form-group">
                                <div class="row">
                                    <label for="paymode_name" class="col-sm-3 col-form-label">Pay Mode Name <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="paymode_name" name="paymode_name" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="save_paymode" class="btn btn-primary pull-right">Create</button>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pay Mode Name</th>
                                    <th>Created By</th>
                                    <th>Status</th>                        
                                    <th>Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($all_paymode_names)): ?>
                                    <?php if ($all_paymode_names == !NULL): $i = 1; ?>
                                        <?php foreach ($all_paymode_names as $paymode_name): ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $paymode_name->mode_name ?></td>
                                                <td><?php echo $paymode_name->create_by ?></td>
                                                <td><?php echo $paymode_name->status ?></td>                                                
                                                <td>
                                                    <button type="button" onclick="editSupplier(<?= $paymode_name->id; ?>);" class="btn btn-sm btn-info pull-left"> <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</button> 
                                                    <button type="button" onclick="delSupplier(this,<?= $paymode_name->id; ?>)" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="fa fa-trash-o" aria-hidden="true" title="Delete Supplier "> Delete</i></button>
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
<script>
    $(document).ready(function () {
        $('.alert-success').delay(1000).hide(300);
        $('.alert-danger').delay(1000).hide(300);
    })
</script>