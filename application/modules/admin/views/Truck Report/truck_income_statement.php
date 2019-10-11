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
                                    <button class="btn btn-success" id="search" name="search" type="submit" style="margin-top: 22px;">Search </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <style>
                            table tfoot{display:table-row-group;}
                        </style>
                        <table class="table table-striped table-bordered dt-responsive nowrap datatable" cellspacing="0" width="100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        $.ajax({
            url: "<?= site_url('/admin/getTruckIncomeStatement'); ?>",
            type: 'post',
            data: {start_date: start_date,end_date:end_date},
            success: function (data) {
                $(document).find('.datatable').html(data);
                $(document).find('.datatable').DataTable({
                    dom: 'Bfrtip',
//                    "pageLength":50,
                    //"bRetrieve": true,
                    "bDestroy": true,
                    "bPaginate":true,
//                    "iDisplayLength": 25,
                    "lengthMenu": [[10,25, 50, 100, 500, -1], [10,25, 50, 100, 500, "All"]],
                    buttons: [
                        {
                            extend: 'csv',
                            footer: true,
                            filename: 'Truck Statement Report Memberwise'
                        },
                        {
                            extend: 'excel',
                            footer: true,
                            filename: 'Truck Statement Report Memberwise'
                        },
                        {
                            extend: 'print',
                            footer: true,
                            filename: 'Truck Statement Report Memberwise'
                        },
                        {
                            extend: 'pageLength',
                            footer: true
                        }
                    ],
                });
            }
        });
    });

</script>
