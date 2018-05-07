<section class="create_group">
    <div class="content">
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
                        <h2>Create Ledger</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form action="<?php echo site_url() ?>admin/createLedger" method="post" accept-charset="utf-8">
                                    <?php
                                    $csrf = array(
                                        'name' => $this->security->get_csrf_token_name(),
                                        'hash' => $this->security->get_csrf_hash()
                                    );
                                    ?>
                                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label for="ledger_name" class="col-md-2 col-sm-12 col-xs-12">Ledger Name<span class="required"> *</span></label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="ledger_name"  id="ledger_name" class="form-control" required="requried" placeholder="Enter ledger name">
                                                <?php if (form_error('ledger_name')) { ?>
                                                    <span class="help-block">
                                                        <strong><?= form_error('ledger_name') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label for="ledger_parent" class=" col-md-2 col-sm-12 col-xs-12">Parent <span class="required"> *</span></label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <select class="form-control select2" name="ledger_parent" id="ledger_parent" required="required">
                                                    <optgroup label="Assets">
                                                        <option></option>
                                                        <option value="1"><b>Assets</b></option>
                                                    <?php if (isset($assets_group)): ?>
                                                        <?php if ($assets_group == !NULL): ?>
                                                            <?php foreach ($assets_group as $asset_group): ?>
                                                                <option value="<?php echo $asset_group->id ?>"><?php echo $asset_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Expenses">
                                                        <option value="2"><b>Expenses</b></option>
                                                    <?php if (isset($expenses_group)): ?>
                                                        <?php if ($expenses_group == !NULL): ?>
                                                            <?php foreach ($expenses_group as $expense_group): ?>
                                                                <option value="<?php echo $expense_group->id ?>"><?php echo $expense_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Income">
                                                        <option value="3"><b>Income</b></option>
                                                    <?php if (isset($incomes_group)): ?>
                                                        <?php if ($incomes_group == !NULL): ?>
                                                            <?php foreach ($incomes_group as $income_group): ?>
                                                                <option value="<?php echo $income_group->id ?>"><?php echo $income_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Liabilities and Owners Equity">
                                                        <option value="4"><b>Liabilities and Owners Equity</b></option>
                                                    <?php if (isset($liabilities_group)): ?>
                                                        <?php if ($liabilities_group == !NULL): ?>
                                                            <?php foreach ($liabilities_group as $liabilitie_group): ?>
                                                                <option value="<?php echo $liabilitie_group->id ?>"><?php echo $liabilitie_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                </select>
                                                <?php if (form_error('ledger_parent')) { ?>
                                                    <span class="help-block">
                                                        <strong><?= form_error('ledger_parent') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>                                                                    
                                        </div>
                                        <div class="form-group row">
                                            <label for="balance_type" class=" col-md-2 col-sm-12 col-xs-12">Balance Type</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <select class="form-control select2" name="balance_type" id="balance_type">
                                                    <option></option>
                                                    <option value="C">Credit</option>
                                                    <option value="D">Debit</option>
                                                </select>
                                            </div>                                                                    
                                        </div>
                                        <div class="form-group row">
                                            <label for="opening_balance" class="col-md-2 col-sm-12 col-xs-12">Opening Balance</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="opening_balance"  id="opening_balance" class="form-control prevent">                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="note" class="col-md-2 col-sm-12 col-xs-12">Note</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="note" id="note"></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" name="create_ledger" class="btn btn-primary" >Create</button>
                                        <button type="button" onclick="window.location.href = '<?php echo site_url() ?>admin/groupListOfAccount';" class="btn btn-info" >Back</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $("#ledger_parent").select2({
            placeholder: "Select Parent"
        });

        $("#balance_type").select2({
            placeholder: "Select Balance Type"
        });

        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });


        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

    })
</script>