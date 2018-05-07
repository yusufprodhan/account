<section class="chart_of_accounts">
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Chart of Sub Account</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="pull-left">                                    
                                    <a class="btn btn-primary" href="<?php echo site_url() ?>admin/createGroup"><i class="fa fa-edit"></i>CREATE GROUP</a>
                                    <a class="btn btn-success" href="<?php echo site_url() ?>admin/createLedger"><i class="fa fa-edit"></i>CREATE LEDGER</a>                    
                                    <a class="btn btn-info" href="<?php echo site_url() ?>admin/deleteLedger"><i class="fa fa-edit"></i>DELETE LEDGER</a>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-bordered" id="chartofaccount">
                                    <thead>
                                        <tr>
                                            <th>GID#</th>
                                            <th>Parent</th>
                                            <th>Account Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                            
                                        <?php if (isset($sub_groups)) {
                                            $i = 1; ?>
                                            <?php if ($sub_groups == !NULL) { ?>
                                                <?php foreach ($sub_groups as $group): ?>
                                                    <tr>
                                                        <td><?php if (isset($group->custom_id)) {echo $group->custom_id;} ?></td>
                                                        <td><?php if (isset($group->parent_name)) {echo $group->parent_name;} ?></td>
                                                        <td><?php if (isset($group->group_name)) {echo $group->group_name;} ?></td>
                                                        <td><a class="btn btn-primary" href="<?php echo site_url() ?>admin/editGroup/<?php echo $group->id ?>">Edit</a><button type="button"  onclick="goBack()"  class="btn btn-success" >Back</button><a class="btn btn-success" href="<?php echo site_url() ?>admin/subChartOfAccount/<?php echo $group->id ?>">View subgroup</a><a class="btn btn-success" href="<?php echo site_url() ?>admin/ledgerList/<?php echo $group->id ?>">View Ledgers</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="3" style="text-align: center;"><strong><?php echo 'No data found'; ?></strong></td>
                                                    <td><button type="button"  onclick="goBack()"  class="btn btn-info" >Back</button></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function goBack() {
        window.history.back();
    }
</script> 