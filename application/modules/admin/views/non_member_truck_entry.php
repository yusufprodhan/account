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
                <?php }
                if ($success) { ?>

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
                <form class="form-horizontal" action="<?php echo site_url() ?>admin/nonMemberTruckVoucher"
                      method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="non_member_truck_voucher_no" class="col-sm-3 col-form-label">Voucher
                                                No.</label>
                                            <div class="col-sm-9">
                                                <input type="text" readonly id="non_member_truck_voucher_no"
                                                       value="<?php if (isset($non_member_voucher_no)) {
                                                           echo $non_member_voucher_no + 1;
                                                       } ?>" name="non_member_truck_voucher_no" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="entry_date" class="col-sm-3 col-form-label">Entry Date</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="entry_date" name="entry_date"
                                                       class="form-control dateinput">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="truck_count" class="col-sm-3 col-form-label">Truck Count</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="truck_count" class="form-control prevent"
                                                       name="truck_count" required>
                                                <?php if (form_error('truck_count')) { ?>
                                                    <span class="help-block">
                                                        <strong><?= form_error('truck_count') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="total_amount" class="col-sm-3 col-form-label">Total
                                                Amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="total_amount" readonly
                                                       class="form-control prevent"
                                                       name="total_amount" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label for="narration" class="col-sm-3 col-form-label">Narration</label>
                                            <div class="col-sm-9">
                                                <textarea id="narration" name="narration"
                                                          class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="save_non_member_voucher"
                                                class=" form-control btn btn-primary save_member_voucher">Save Non
                                            Member Voucher
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.alert-success').delay(2500).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2500).hide(300).css({'color': 'white'});
    });
    $(document).on('change keyup', '.prevent', function () {
        var numchange = $(this).val().replace(/[^0-9.]/g, '');
        numchange = numchange.replace(/\.(?=.*\.)/, '');
        $(this).val(numchange);
    });

    $(document).on('input', '#truck_count', function () {
        var truck_count = $(this).val();
        var total_amount = truck_count * 100;
        $(document).find('#total_amount').val(total_amount);
    })


</script>