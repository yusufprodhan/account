<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
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
                <h2><?php if(!empty($title)){echo $title;}else{echo $title;}?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <br>
                                    <input type="text" id="start_date" name="start_date" class="form-control dateinput">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <br>
                                    <input type="text" id="end_date" name="end_date" class="form-control dateinput">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="ledger_name">Ledger</label>
                                    <br/>
                                    <select class="form-control" name="ledger_name" id="ledger_name">
                                        <option>Select Ledger</option>
                                        <?php if(!empty($all_ledger)){
                                            foreach ($all_ledger as $ledger){
                                                ?>
                                                <option value="<?php echo $ledger['id']?>"><?php echo $ledger['ledger_name']?></option>
                                            <?php }}?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-success" id="search" name="search" type="submit" style="margin-top: 22px;">Search </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <style>
                            table tfoot{display:table-row-group;}
                        </style>
                        <table class="table table-striped table-bordered dt-responsive nowrap data_table" cellspacing="0" width="100%" id="data_table">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function () {
//        $('input[name="daterange"]').daterangepicker();

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    });

    //for data
    $(document).on('click', '#search',  function () {
        var start_date = $('input[name="start_date"]').val();
        var end_date = $('input[name="end_date"]').val();
        var ledger_id = $(document).find('#ledger_name').val();
        if(ledger_id != undefined && start_date !='' && end_date !=''){
            $.ajax({
                url: "<?= site_url('/admin/getLedgerWiseAccountStatement'); ?>",
                type: 'post',
                data: { start_date: start_date,end_date:end_date,ledger_id:ledger_id},
                success: function (data) {
                    $(document).find('.data_table').html(data);
//                    $(document).find('.data_table').DataTable({
//                        dom: 'Bfrtip',
//                        "bRetrieve": true,
//                        "bDestroy": true,
//                        "bPaginate":true,
//                        "lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
//                        buttons: [
//                            {
//                                extend: 'csv',
//                                footer: true,
//                                filename: 'Truck Statement Report Memberwise'
//                            },
//                            {
//                                extend: 'excel',
//                                footer: true,
//                                filename: 'Truck Statement Report Memberwise'
//                            },
//                            {
//                                extend: 'print',
//                                footer: true,
//                                filename: 'Truck Statement Report Memberwise'
//                            },
//                            {
//                                extend: 'pageLength',
//                                footer: true
//                            }
//                        ],
//                    });
                }
            });
        }else{
            alert('no yo');
        }
    });
</script>
