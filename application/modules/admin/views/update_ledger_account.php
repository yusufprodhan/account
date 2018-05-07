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
                        <h2>Update Ledger</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form action="<?php echo site_url() ?>admin/updateLedger" method="post" accept-charset="utf-8">
                                    <?php
                                    $csrf = array(
                                        'name' => $this->security->get_csrf_token_name(),
                                        'hash' => $this->security->get_csrf_hash()
                                    );
                                    ?>
                                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label for="select_ledger" class=" col-md-2 col-sm-12 col-xs-12">Select Ledger</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <select class="form-control select2" name="ledger_id" id="select_ledger">
                                                    <option></option>
                                                    <?php if (isset($all_accounts)): ?>
                                                        <?php if ($all_accounts == !NULL): ?>
                                                            <?php foreach ($all_accounts as $account): ?>
                                                                <option value="<?php echo $account->id ?>"><?php echo $account->ledger_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>                                                                    
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" id="ledger_section">

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
        $("#select_ledger").select2({
            placeholder: "Select Ledger"
        });

        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });
        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

        $('#ledger_section').hide();
        $('#select_ledger').change("select2:select", function (e) {
            $('#ledger_section').show();
            var ledger = $(this).val();
            $.ajax({
                url: "<?= site_url('/admin/getLedgerUpdateData/'); ?>",
                type: 'post',
                data: {ledger: ledger},
                success: function (data) {
                    $('#ledger_section').html(data);

                    $("#ledger_parent").select2({
                        placeholder: "Select Parent"
                    });

                    $("#balance_type").select2({
                        placeholder: "Select Parent"
                    });
                }
            });

        });

    })
    function goBack() {
        window.history.back();
    }
</script>