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
                <h2><?php
                    if (isset($title)) {
                        echo $title;
                    }
                    ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal" action="<?php echo site_url() ?>admin/receiveVoucher" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="voucher_number" class="col-sm-3 col-form-label">Voucher Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="voucher_number" name="voucher_number" class="form-control" value="<?php echo $receive_voucher_number + 1; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="voucher_date" class="col-sm-3 col-form-label">Voucher Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="voucher_date" name="voucher_date" class="form-control dateinput">
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
                                            <label for="reference" class="col-sm-3 col-form-label">Reference#</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="reference" name="reference" class="form-control">
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
                                <div class="col-md-6" id="cheque_area">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="cheque_book_number" class="col-sm-3 col-form-label">Cheque Book Number</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="cheque_book_number" id="cheque_book_number">
                                                    <option></option>
                                                    <?php if (isset($all_cheque_number)): ?>
                                                        <?php if ($all_cheque_number == !NULL): ?>
                                                            <?php foreach ($all_cheque_number as $cheque_number): ?>
                                                                <option value="<?php echo $cheque_number->cheque_book_number ?>"><?php echo $cheque_number->cheque_book_number ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="bank_name" class="col-md-3 col-form-label">Bank Name</label>
                                            <div class="col-md-9">
                                                <select id="bank_name"  name="bank_name" class="form-control select2">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="cheque_number" class="col-sm-3 col-form-label">Cheque Number</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="cheque_number" id="cheque_number">
                                                </select>
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
                                </div>
                            </div>                            
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered dc_table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Account</th>
                                            <th>Current Balance</th>
                                            <th>Description</th>
                                            <th>Tax</th>
                                            <th>Debit <br>(To Whom Receipt)</th>
                                            <th>Credit <br>(Receive From)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr>
                                            <td width="20%">
                                                <select id="account_head_" class="form-control select2 account_head" name="account_head[]">
                                                    <option></option> 
                                                    <?php if (isset($all_ledgers)): ?>
                                                        <?php if ($all_ledgers == !NULL): ?>
                                                            <?php foreach ($all_ledgers as $ledger): ?>
                                                                <option value="<?php echo $ledger->id ?>"><?php echo $ledger->ledger_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </td>
                                            <td width="12%" class="current_balance"></td>
                                            <td width="20%"><input type="text" name="description[]" class="form-control" id="description_"></td>
                                            <td><select id="tax_" class="form-control select2 text" name="tax[]">
                                                    <option></option>
                                                    <option value="1">Demo Tax</option>
                                                </select>
                                            </td>
                                            <td><input style="text-align:right;" type="text"  name="debit_amount[]" id="debit_amount_" class="form-control debit_amount"></td>
                                            <td><input style="text-align:right;" type="text"  name="credit_amount[]" id="credit_amount_" class="form-control credit_amount"></td>
                                            <td width="12%"><button class="btn btn-success add_row" test="test" type="button" id="add_row"><i class="fa fa-plus"></i></button><a class=" debitbtnDel btn btn-danger glyphicon glyphicon-remove" title="Delete User"></a></td>
                                        </tr>
                                        <tr class="tr_prepend">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td><input class="form-control" id="debit_total" name="debit_total" type="text" readonly="readonly"></td>
                                            <td><input class="form-control" id="cerdit_total" name="credit_total" type="text" readonly="readonly"></td>
                                        </tr>
                                    </tbody>

                                </table>
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
                            <button type="reset" class="btn btn-danger" onClick="location.reload()">Cancel</button>
                            <button type="submit" name="save_receive" class="btn btn-success pull-right" id="save_receive" value="Complete Receive Voucher">Save Receive Voucher</button>
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
        var counter = 1
        var debit_sum = 0;
        var credit_sum = 0;
        var debit_each_value = 0;
        var credit_each_value = 0;

        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });

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


        //===================for debit and credit=============================        

        $(document).on("click",'.add_row', function (e) {
            var cols = "";
            var newRow = $('<tr>');
            cols += '<td width="20%"><select id="account_head_' + counter + '" class="form-control select2 account_head" name="account_head[]"><option></option> <?php if (isset($all_ledgers)): ?><?php if ($all_ledgers == !NULL): ?><?php foreach ($all_ledgers as $ledger): ?><option value="<?php echo $ledger->id ?>"><?php echo $ledger->ledger_name ?></option><?php endforeach; ?><?php endif; ?><?php endif; ?></select></td>';
            cols += '<td width="12%" class="current_balance" id="current_balance_' + counter + '"></td>';
            cols += '<td width="20%"><input type="text" name="description[]" class="form-control" id="description_' + counter + '"></td>';
            cols += '<td><select id="tax_' + counter + '" class="form-control select2 text" name="tax[]"><option></option><option value="1">Demo Tax</option></select></td>';
            cols += '<td><input style="text-align:right;" type="text"  name="debit_amount[]" id="debit_amount_' + counter + '" class="form-control debit_amount"></td>';
            cols += '<td><input style="text-align:right;" type="text"  name="credit_amount[]" id="credit_amount_' + counter + '" class="form-control credit_amount"></td>';
            cols += '<td width="12%"><button class="btn btn-success add_row" test="test" type="button" id="add_row"><i class="fa fa-plus"></i></button><a class=" debitbtnDel btn btn-danger glyphicon glyphicon-remove" id="' + counter + '" title="Delete User"></a></td>';
            newRow.append(cols);
            $(this).parent().parent().after(newRow);
            
            $(document).find("[test='test']").each(function(){$(this).addClass('add_row')});
            counter++;

            //for balance
            $(".account_head").change("select2:select", function (e) {
                var ledger_id = $(this).val();
                var current = $(this);
                $.ajax({
                    url: "<?= site_url('/admin/getDebitLedgerBalance/'); ?>",
                    type: 'post',
                    data: {ledger_id: ledger_id},
                    success: function (data) {
                        $(current).parent().parent().find('.current_balance').html(data);
                    }
                });
            });
        });

        //for balance
        $(".account_head").change("select2:select", function (e) {
            var ledger_id = $(this).val();
            var current = $(this);
            $.ajax({
                url: "<?= site_url('/admin/getDebitLedgerBalance/'); ?>",
                type: 'post',
                data: {ledger_id: ledger_id},
                success: function (data) {
                    $(current).parent().parent().find('.current_balance').html(data);
                }
            });
        });

        //for cheque number
        $("#cheque_book_number").change("select2:select", function (e) {
            var cheque_book_number = $(this).val();
            $.ajax({
                url: "<?= site_url('/admin/getAllChequeNumber/'); ?>",
                type: 'post',
                data: {cheque_book_number: cheque_book_number},
                success: function (data) {
                    $('#cheque_number').html(data);
                }
            });
        });
        
        //for cheque number
        $("#cheque_book_number").change("select2:select", function (e) {
            var bank_name = $(this).val();
            $.ajax({
                url: "<?= site_url('/admin/getBankNameONChequeNumber/'); ?>",
                type: 'post',
                data: {bank_name: bank_name},
                success: function (data) {
                    $('#bank_name').html(data);
                }
            });
        });

        //for delete row
        $(".dc_table tbody").on("click", ".debitbtnDel", function (event) {
            debit_sum = $("#debit_total").val();
            credit_sum = $("#cerdit_total").val();
            debit_each_value = $('#debit_amount_' + $(this).attr('id')).val();
            credit_each_value = $('#credit_amount_' + $(this).attr('id')).val();
            debit_sum = debit_sum - debit_each_value;
            credit_sum = credit_sum - credit_each_value;
            $(this).closest("tr").remove();
            counter--;
            $("#debit_total").val(debit_sum);
            $("#cerdit_total").val(credit_sum);
        });



        //for debit total calculation
        $(document).on('input', '.debit_amount', debitSum);
        debitSum();

        //for credit total calculation
        $(document).on('input', '.credit_amount', creditSum);
        creditSum();

        $("#save_receive").hide();
        var debit_total_val;
        var credit_total_val;

        $(document).on("change", '.debit_amount', function () {
            debit_total_val = $("#debit_total").val();
            credit_total_val = $("#cerdit_total").val();
            if (debit_total_val == credit_total_val) {
                $("#save_receive").show();
            } else {
                $("#save_receive").hide();
            }
        });

        $(document).on("change", '.credit_amount', function () {
            credit_total_val = $("#cerdit_total").val();
            debit_total_val = $("#debit_total").val();
            if (debit_total_val == credit_total_val) {
                $("#save_receive").show();
            } else {
                $("#save_receive").hide();
            }
        });

    });

    //for debit total calculation function
    function debitSum() {
        var total = 0, debit_total;
        $(".dc_table tbody .debit_amount").each(function () {
            debit_total = $(this).val();
            debit_total = isNaN(debit_total) || $.trim(debit_total) === "" ? 0 : parseFloat(debit_total);
            total += debit_total;
        });
        $("#debit_total").val(Math.round(total));
    }

    //for credit total calculation function
    function creditSum() {
        var ctotal = 0, credit_total;
        $(".dc_table tbody .credit_amount").each(function () {
            credit_total = $(this).val();
            credit_total = isNaN(credit_total) || $.trim(credit_total) === "" ? 0 : parseFloat(credit_total);
            ctotal += credit_total;
        });
        $("#cerdit_total").val(Math.round(ctotal));
    }
</script>