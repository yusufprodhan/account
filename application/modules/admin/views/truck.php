<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->session->flashdata('successMsg')): ?>
                    <div class="alert alert-success alert-dismissible fadeIn show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('successMsg');?>
                    </div>
                <?php endif;?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fadeIn show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('error');?>
                    </div>
                <?php endif;?>
                <h2>Truck</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <style> .cheque_form span{color: red;}</style>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#add_truck"><i class="fa fa-plus"></i> Add Truck</button>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <br>
                        <br>
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Truck Number</th>
                                    <th>Truck Type</th>
                                    <th>Inclusion Date</th>
                                    <th>Create By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($truck_list)): ?>
                                    <?php if ($truck_list == !null): $i = 1;?>
	                                        <?php foreach ($truck_list as $truck): ?>
	                                            <tr>
	                                                <td><?php echo $i;$i++ ?></td>
	                                                <td><?php echo $truck['truck_number'] ?> </td>
	                                                <td><?php echo $truck['truck_type'] ?></td>
	                                                <td><?php echo $truck['inclusion_date'] ?></td>
	                                                <td><?php echo $truck['created_by'] ?></td>
	                                                <td><?php echo $truck['status'] ?></td>
	                                                <td>
	                                                    <button type="button"  data-toggle="modal" data-target="#editTruck" id="edit_Truck" edit_id="<?=$truck['truck_tbl_id']?>" class="btn btn-sm btn-info"> <i class="fa fa-pencil-square" aria-hidden="true"></i> Edit</button>
	                                                    <button type="button" onclick="viewSupplier(<?=$truck['truck_tbl_id']?>);" class="btn btn-sm btn-primary"> <i class="fa fa-eye" aria-hidden="true"></i> View</button>
	                                                    <button type="button" onclick="delSupplier(this, <?=$truck['truck_tbl_id']?>)" class="btn btn-sm btn-danger" style="margin-left: 5px;"><i class="fa fa-trash-o" aria-hidden="true" title="Delete Supplier "> Delete</i></button>
	                                                </td>
	                                            </tr>
	                                        <?php endforeach;?>
                                    <?php endif;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add truck modal -->
<div class="modal fade" id="add_truck" role="dialog" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Truck</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/addTruck" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="truck_no">Truck No: <span>*</span></label><br>
                                        <input type="text" id="truck_no" name="truck_no" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="truck_type">Truck Type: <span>*</span></label><br>
                                        <select class="form-control" name="truck_type" id="truck_type" required="required">
                                            <option>Select Type</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="truck_no">Inclusion Date: <span>*</span></label><br>
                                        <input type="text" id="inclusion_date" name="inclusion_date" class="form-control dateinput" required="required">
                                    </div>
                                </div>
                                <button type="submit" name="add_truck" class="btn btn-success pull-right" id="add_truck" title="Add Truck">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Edit truck modal -->
<div class="modal fade" id="editTruck" role="dialog" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Truck</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/updateTruck" method="post">
                            <div class="row" id="truck_edit_data">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        // $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

    });

    $(document).on("click", "#edit_Truck", function(){
        var truck_edit_id = $(this).attr('edit_id');
        // console.log(edit_id);
        $.ajax({
            url: "<?= site_url('/admin/getTruckDataOnEdit/'); ?>",
            type: 'post',
            data: { truck_edit_id: truck_edit_id },
            success: function (data) {
                $(document).find('#truck_edit_data').html(data);

                $('.dateinput').datetimepicker({
                    format: 'YYYY-MM-DD',                    
                });
            }
        });

    });

</script>