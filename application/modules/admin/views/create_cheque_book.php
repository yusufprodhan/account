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
                <h2>Cheque Book Issue </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <style> .cheque_form span{color: red;}</style>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12 cheque_form">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/chequeRegister" method="post">
                            <div class="form-group">
                                <div class="row">
                                    <label for="bank_name" class="col-sm-3 col-form-label">Bank Name <span>*</span></label>
                                    <div class="col-sm-9">
                                        <select type="text" id="bank_name" name="bank_name" class="form-control select2" required="required">
                                            <option></option>
                                            <?php if (isset($all_bank_names)): ?>
                                                <?php if ($all_bank_names == !NULL): ?>
                                                    <?php foreach ($all_bank_names as $bank): ?>
                                                        <option value="<?php echo $bank->id ?>"><?php echo $bank->ledger_name ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="cheque_book_number" class="col-sm-3 col-form-label">Cheque Book Number <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="cheque_book_number" name="cheque_book_number" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="start_cheque_number" class="col-sm-3 col-form-label">Start Cheque Number <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="start_cheque_number" name="start_cheque_number" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="end_cheque_number" class="col-sm-3 col-form-label">End Cheque Number <span>*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" id="end_cheque_number" name="end_cheque_number" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="save_cheque_book" class="btn btn-primary pull-right">Submit</button>
                        </form>                        
                    </div>
                    <div class="col-md-12">                        
                        <br>
                        <br>
                        <br>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bank Name</th>
                                    <th>Cheque Book Number</th>
                                    <th>Total Page</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Status</th>                        
                                    <th>Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($all_cheque_number)): ?>
                                    <?php if ($all_cheque_number == !NULL): $i = 1; ?>
                                        <?php foreach ($all_cheque_number as $c1heque_number): ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $c1heque_number->ledger_name ?></td>
                                                <td style="text-align: right;"><?php echo $c1heque_number->cheque_book_number ?></td>
                                                <td><?php echo $c1heque_number->start_number ?> - <?php echo $c1heque_number->end_number ?> = <?php echo ($c1heque_number->end_number) - ($c1heque_number->start_number) + 1 ?></td>
                                                <td><?php echo $c1heque_number->create_by ?></td>
                                                <td><?php echo $c1heque_number->create_at ?></td>
                                                <td><?php echo $c1heque_number->status ?></td>                                                
                                                <td>
                                                    <button type="button" onclick="editSupplier(<?= $c1heque_number->id; ?>);" class="btn btn-sm btn-info pull-left"> <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</button> 
                                                    <button type="button" onclick="delSupplier(this, <?= $c1heque_number->id; ?>)" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="fa fa-trash-o" aria-hidden="true" title="Delete Supplier "> Delete</i></button>
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
        $("#bank_name").select2({
            placeholder: "Select Bank Name"
        });
    })
</script>