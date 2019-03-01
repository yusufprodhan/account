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
                        <br>
                        <br>
                        <br>
                        <table id="datatable_ex" class="table table-striped table-bordered dt-responsive nowrap datatable_ex" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Member Name</th>
                                <th>Truck No</th>
                                <th>Truck Type</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($truck_member_reports)){
                                $i = 1;
                                $ledger_name = '';
                                foreach ($truck_member_reports as $truck_member_report){?>
                                <tr>
                                    <td> <?php echo $i;$i++;?></td>
                                    <?php if($ledger_name == $truck_member_report['ledger_name']){?>
                                        <td></td>
                                    <?php }else{?>
                                        <td><?php echo '('.$truck_member_report['member_no'].') '.$truck_member_report['ledger_name']?> </td>
                                    <?php }?>
                                    <td><?php echo $truck_member_report['truck_number'] ?> </td>
                                    <td><?php echo $truck_member_report['truck_type'] ?></td>
                                </tr>
                            <?php $ledger_name = $truck_member_report['ledger_name'];}}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
//        $('#datatable_ex').DataTable( {
//            dom: 'Bfrtip',
//            "lengthChange": true,
//            "pageLength":50,
//            "ordering" : true,
//            buttons: [
//                'copy', 'csv', 'excel', 'pdf', 'print'
//            ]
//        });
        $(document).find('.datatable_ex').DataTable({
            dom: 'Bfrtip',
//          "pageLength":50,
            //"bRetrieve": true,
            "bDestroy": true,
            "bPaginate":true,
//            "iDisplayLength": 25,
            "lengthMenu": [[25, 50, 100, 500, -1], [25, 50, 100, 500, "All"]],
            buttons: [
                {
                    extend: 'csv',
                    filename: 'Truck Member Report'
                },
                {
                    extend: 'excel',
                    filename: 'Truck Member Report'
                },
                {
                    extend: 'print',
                    filename: 'Truck Member Report'
                },
                {
                    extend: 'pageLength',
                    footer: true
                }
            ],
        });
    });
</script>