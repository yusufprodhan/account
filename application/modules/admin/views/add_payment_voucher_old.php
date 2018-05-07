<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php
                $error = $this->session->flashdata('error');
                $success = $this->session->flashdata('successMsg');
                if ($error) {
                    ?>
                    <div class = "alert alert-danger alert-dismissable" >
                        <button type="button" class= "close" data-dismiss="alert" aria-hidden ="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <?php echo $error; ?>
                    </div>
                <?php }if ($success) { ?>

                    <div class="alert alert-success alert-dismissable" >
                        <button type = "button" class= "close" data-dismiss= "alert" aria-hidden= "true"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <?php echo $success; ?>
                    </div>
                <?php } ?>
                <h2><?php if(isset($title)){echo $title;}?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" action="<?php echo site_url() ?>admin/paymentVoucher" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="voucher_number" class="col-sm-3 col-form-label">Voucher Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="voucher_number" name="voucher_number" class="form-control" value="<?php echo $payment_voucher_number + 1; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="paymode" class="col-sm-3 col-form-label">Payment Mode</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="paymode" id="paymode" required="required">
                                                    <option></option>
                                                    <?php if (isset($all_paymode_names)): ?>
                                                        <?php if ($all_paymode_names == !NULL): ?>
                                                            <?php foreach ($all_paymode_names as $paymode_name): ?>
                                                                <option value="<?php echo $paymode_name->id ?>"><?php echo $paymode_name->mode_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <?php if (form_error('paymode')) { ?>
                                                    <span class="help-block">
                                                        <strong><?= form_error('paymode') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="mobile_number" class="col-sm-3 col-form-label">Mobile Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="mobile_number" name="mobile_number" class="form-control prevent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="cheque_area" style="display: none;">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="cheque_number" class="col-sm-3 col-form-label">Cheque Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cheque_number" name="cheque_number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="cheque_date" class="col-sm-3 col-form-label">Cheque Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cheque_date" name="cheque_date" class="form-control dateinput">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="bank_name" class="col-md-3 col-form-label">Bank Name</label>
                                            <div class="col-md-9">
                                                <select id="bank_name"  name="bank_name" class="form-control select2">
                                                    <option></option>
                                                    <?php if (isset($all_bank_names)): ?>
                                                        <?php if ($all_bank_names == !NULL): ?>
                                                            <?php foreach ($all_bank_names as $bank): ?>
                                                                <option value="<?php echo $bank->id ?>"><?php echo $bank->bank_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Payment To</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="debit_to_head" class="col-sm-3 col-form-label">Head</label>
                                                    <div class="col-sm-9">
                                                        <select id="debit_to_head" class="form-control select2">
                                                            <option></option>
                                                            <?php if (isset($all_ledgers)): ?>
                                                                <?php if ($all_ledgers == !NULL): ?>
                                                                    <?php foreach ($all_ledgers as $ledger): ?>
                                                                        <option value="<?php echo $ledger->ledger_name ?>"><?php echo $ledger->ledger_name ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="debit_balnce">
                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="debit_to_description" class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" id="debit_to_description" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="debit_to_amount" class="col-sm-3 col-form-label">Debit Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="debit_to_amount" class="form-control prevent">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" name="add_debit" id="add_debit" class="btn btn-primary pull-right">Add Debit</button>
                                        </div>                                
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Debit</div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table debit_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">Debit A/C Head</th>
                                                            <th class="center">Description</th>
                                                            <th class="center">Debit Amount</th>                                                            
                                                            <th class="center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="left" colspan="4">&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">Total </th>
                                                            <th colspan="2" class="right"><input id="debit_total" name="debit_total" class="form-control" readonly="" value=""></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">From whom payment is taken place</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="credit_to_head" class="col-sm-3 col-form-label">Head</label>
                                                    <div class="col-sm-9">
                                                        <select id="credit_to_head" class="form-control select2">
                                                            <option></option>
                                                            <?php if (isset($all_ledgers)): ?>
                                                                <?php if ($all_ledgers == !NULL): ?>
                                                                    <?php foreach ($all_ledgers as $ledger): ?>
                                                                        <option value="<?php echo $ledger->ledger_name ?>"><?php echo $ledger->ledger_name ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="credit_balnce">
                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="credit_to_description" class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" id="credit_to_description" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="credit_to_amount" class="col-sm-3 col-form-label">Credit Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="credit_to_amount" class="form-control prevent">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" name="add_credit" id="add_credit" class="btn btn-success pull-right">Add Credit</button>
                                        </div>                                
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">Credit</div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table crebit_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">Credit A/C Head</th>
                                                            <th class="center">Description</th>
                                                            <th class="center">Credit Amount</th>                                                            
                                                            <th class="center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="left" colspan="4">&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="2">Total </th>
                                                            <th colspan="2" class="right"><input id="credit_total" name="credit_total" class="form-control" readonly="" value=""></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>                       
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <label for="narration" class="col-sm-2 col-form-label">Narration</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" id="narration" name="narration" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>                        
                            <button type="submit" name="save_payment" class="btn btn-lg btn-success pull-right" id="save_payment" value="Complete Payment Voucher">Save Payment Voucher</button>
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
        var debit_counter = 1;
        var credit_counter = 1;
        var debit_total = 0;
        var credit_total = 0;

        $("#paymode").select2({
            placeholder: "Select Payment Mode"
        });

        $("#bank_name").select2({
            placeholder: "Select Bank Name"
        });

        $("#debit_to_head").select2({
            placeholder: "Select Account"
        });
        $("#credit_to_head").select2({
            placeholder: "Select Account"
        });

        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });

//        $('#paymode_date').datepicker('setDate', 'today').on('change', function () {
//            $('.datepicker').hide();
//        });

        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

        //for cheque
        $('#cheque_area').hide();
        $('#paymode').change("select2:select", function (e) {
            var paymode = $(this).val();
            if (paymode === '2') {
                //alert('ok');
                $('#cheque_area').css('display', 'inline-block');
            } else {
                $('#cheque_area').css('display', 'none');
            }
        });


        //===================for debit=============================
        $('#debit_to_head').change("select2:select", function (e) {
            var debitbal = $(this).val();
            $.ajax({
                url: "<?= site_url('/admin/getDebitLedgerBalance/'); ?>",
                type: 'post',
                data: {debitbal: debitbal},
                success: function (data) {
                    $('#debit_balnce').html(data);
                }
            });

        });       

        $('#add_debit').on("click", function (e) {
            var debit_head = $('#debit_to_head').val();
            var debit_descrip = $('#debit_to_description').val();
            var debit_balance = $("#debit_balnce input").attr('value');            
            var debit_amount = $('#debit_to_amount').val();
            var cols = "";
            var newRow = $("<tr>");
            cols += '<td><input class="form-control" readonly type="text" name="debit_head[]" id="debit_head_' + debit_counter + '"value="' + debit_head +'"></td>';
            cols += '<td><input class="form-control" readonly type="text" name="debit_descrip[]" id="debit_descrip_' + debit_counter + '"value="' + debit_descrip + '"></td>';
            cols += '<td> <input class="form-control" type="text" readonly name="debit_amount[]" id="debit_amount_' + debit_counter + '" value="' + debit_amount + '"/></td>';
            cols += '<td><a class=" debitbtnDel btn btn-danger glyphicon glyphicon-remove" id="' + debit_counter + '" title="Delete User"></a></td>';
            newRow.append(cols);
            $(".debit_table tbody").append(newRow);
            $("#debit_to_amount").each(function () {
                debit_total = debit_total + parseFloat($(this).val());
                $("#debit_total").val(debit_total);
            });
            debit_counter++;
        });

        $(".debit_table tbody").on("click", ".debitbtnDel", function (event) {
            var get_this_total = $('#debit_amount_' + $(this).attr('id')).val();
            debit_total = debit_total - get_this_total;
            $(this).closest("tr").remove();
            debit_counter--;
            $("#debit_total").val(debit_total);
        });


        //===============for crebit================================
        
        $('#credit_to_head').change("select2:select", function (e) {
            var creditbal = $(this).val();
            $.ajax({
                url: "<?= site_url('/admin/getcreditLedgerBalance/'); ?>",
                type: 'post',
                data: {creditbal: creditbal},
                success: function (data) {
                    $('#credit_balnce').html(data);
                }
            });

        });
        $('#add_credit').on("click", function (e) {
            var credit_head = $('#credit_to_head').val();
            var credit_descrip = $('#credit_to_description').val();
            var credit_amount = $('#credit_to_amount').val();
            var credit_cols = "";
            var credit_newRow = $("<tr>");
            credit_cols += '<td><input class="form-control" type="text" name="credit_head[]" readonly id="credit_head_' + credit_counter + '" value="' + credit_head + '"></td>';
            credit_cols += '<td><input class="form-control" type="text" name="credit_descrip[]" readonly id="credit_descrip_' + credit_counter + '" value="' + credit_descrip + '"></td>';
            credit_cols += '<td><input class="form-control" type="text" name="credit_amount[]" readonly id="credit_amount_' + credit_counter + '" value="' + credit_amount + '"/></td>';
            credit_cols += '<td><a  class=" creditbtnDel btn btn-danger glyphicon glyphicon-remove" id="' + credit_counter + '" title="Delete User"></a></td>';
            credit_newRow.append(credit_cols);
            $(".crebit_table tbody").append(credit_newRow);

            $("#credit_to_amount").each(function () {
                credit_total = credit_total + parseFloat($(this).val());
                $("#credit_total").val(credit_total);
            });
            credit_counter++;
        });

        $(".crebit_table tbody").on("click", ".creditbtnDel", function (e) {
            var total = $('#credit_amount_' + $(this).attr('id')).val();
            credit_total = credit_total - total;
            $(this).closest("tr").remove();
            credit_counter--;
            $("#credit_total").val(credit_total);
        });

    });
</script>