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
                <form class="form-horizontal" action="<?php echo site_url() ?>admin/memberTruckVoucher" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
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
                                            <label for="truck_no" class="col-sm-3 col-form-label">Truck No</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="truck_no" class="form-control" name="truck_no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="amount" class="form-control" name="amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="add_member_truck" class="btn btn-success pull-right">Add</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <table class="table table-striped table-bordered" id="member_trucl_tbl">
                                <thead>
                                <tr>
                                    <th>Truck No</th>
                                    <th>Member</th>
                                    <th>Amount</th>
                                    <th>Entry Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="form-group">
                                <div class="row">
                                    <label for="narration" class="col-sm-3 col-form-label">Total Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly id="total_amount" name="total_amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label for="narration" class="col-sm-3 col-form-label">Narration</label>
                                    <div class="col-sm-9">
                                        <textarea id="note" name="note" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <button type="submit" name="save_member_voucher" class="form-control btn btn-primary save_member_voucher">Save Non Member Voucher</button>
                        </div>
                    </div>
                </form>
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

//        $('#true_no').select2({
//            placeholder: "Select Truck",
//        });

        //for delete row
        var final_amount = 0;
        $("#member_trucl_tbl tbody").on("click", ".debitbtnDel", function (event) {
            var total_sum = $(document).find('#total_amount').val();
            var delete_amount = $(this).parent().parent().find('.amount').val();
            final_amount = total_sum - delete_amount;
            $(this).closest("tr").remove();
            $(document).find('#total_amount').val(final_amount);
        });

        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

    });

    $(document).find('.save_member_voucher').hide();
    // add truck
    $(document).on("click", "#add_member_truck", function () {
        $(document).find('.save_member_voucher').show();
        var e_date = $(document).find('#entry_date').val();
        var truck_number = $(document).find('#truck_no').val();
        var amount = $(document).find('#amount').val();
        var html = '<tr>' +
            '<td><input type="text" class="form-control" readonly name="truck_no[]" value="' + truck_number + '" ></td>' +
            '<td><input type="text" class="form-control amount" readonly name="amount[]" value="' + amount + '" ></td>' +
            '<td><input type="text" class="form-control" readonly name="e_date[]" value="' + e_date + '" ></td>' +
            '<td><a class=" debitbtnDel btn btn-danger glyphicon glyphicon-remove" title="Delete"></a></td>' +
            '</tr>';
        $(document).find('#member_trucl_tbl tbody').append(html);
        Sum();
    });

    //for total calculation function
    function Sum() {
        var total = 0, total_amount;
        $("#member_trucl_tbl tbody .amount").each(function () {
            total_amount = $(this).val();
            total_amount = isNaN(total_amount) || $.trim(total_amount) === "" ? 0 : parseFloat(total_amount);
            total += total_amount;
        });
        $("#total_amount").val(Math.round(total));
    }


</script>