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
                        <h2>Create Group</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form action="<?php echo site_url() ?>admin/createGroup" method="post" accept-charset="utf-8">
                                    <?php
                                    $csrf = array(
                                        'name' => $this->security->get_csrf_token_name(),
                                        'hash' => $this->security->get_csrf_hash()
                                    );
                                    ?>
                                    <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" />
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group row">
                                            <label for="group_name" class="col-md-2 col-sm-12 col-xs-12">Group Name<span class="required"> *</span></label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="group_name"  id="group_name" class="form-control" required="requried" placeholder="Enter group name">
                                                <?php if (form_error('group_name')) { ?>
                                                    <span class="help-block required">
                                                        <strong><?= form_error('group_name') ?></strong>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>                                       
                                        <div class="form-group row">
                                            <label for="group_parent" class=" col-md-2 col-sm-12 col-xs-12">Parent</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <select class="form-control select2" name="group_parent" id="group_parent" required="required">
                                                    <optgroup label="Assets">
                                                        <option></option>
                                                    <?php if (isset($assets_group)): ?>
                                                        <?php if ($assets_group == !NULL): ?>
                                                            <?php foreach ($assets_group as $asset_group): ?>
                                                                <option value="<?php echo $asset_group->id ?>"><?php echo $asset_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Expenses">
                                                    <?php if (isset($expenses_group)): ?>
                                                        <?php if ($expenses_group == !NULL): ?>
                                                            <?php foreach ($expenses_group as $expense_group): ?>
                                                                <option value="<?php echo $expense_group->id ?>"><?php echo $expense_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Income">
                                                    <?php if (isset($incomes_group)): ?>
                                                        <?php if ($incomes_group == !NULL): ?>
                                                            <?php foreach ($incomes_group as $income_group): ?>
                                                                <option value="<?php echo $income_group->id ?>"><?php echo $income_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                    <optgroup label="Liabilities and Owners Equity">
                                                    <?php if (isset($liabilities_group)): ?>
                                                        <?php if ($liabilities_group == !NULL): ?>
                                                            <?php foreach ($liabilities_group as $liabilitie_group): ?>
                                                                <option value="<?php echo $liabilitie_group->id ?>"><?php echo $liabilitie_group->group_name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    </optgroup>
                                                </select>
                                            </div>                                                                    
                                        </div>
                                        <div class="form-group row">
                                            <label for="root_parent" class=" col-md-2 col-sm-12 col-xs-12">Root Parent</label>
                                            <div class="col-md-10 col-sm-12 col-xs-12">
                                                <select class="form-control select2" name="root_parent" id="root_parent" required="required">
                                                    <option></option>
                                                    <option value="10">Assets</option>
                                                    <option value="20">Expenses</option>
                                                    <option value="30">Income</option>
                                                    <option value="40">Liabilities and Owners Equity</option>
                                                </select>
                                            </div>                                                                    
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="create_group" >Create</button>
                                        <button type="button"  onclick="goBack()"  class="btn btn-info" >Back</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Group Information</div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table debit_table">
                                                <thead>
                                                    <tr>
                                                        <th class="center">GID#</th>
                                                        <th class="center">Parent Group</th>
                                                        <th class="center">Sub Group Under Parent Group</th>                                                            
                                                        <th class="center">Sub Sub Group Under Sub Group</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="success">
                                                        <td>10</td>
                                                        <td>Asset</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <?php if (isset($assets_sub_childs)):
                                                        ?>
                                                        <?php if ($assets_sub_childs == !NULL): ?>
                                                            <?php foreach ($assets_sub_childs as $assets_sub_child):                                                                 
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $assets_sub_child->custom_id ?></td>
                                                                    <td></td>
                                                                    <td><?php echo $assets_sub_child->group_name ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php if (isset($assets_sub_childs_under_sub)): ?>
                                                                    
                                                                    <?php if ($assets_sub_childs_under_sub == !NULL): ?>
                                                                        <?php foreach ($assets_sub_childs_under_sub as $assets_sub_child_under_sub):?>
                                                                            <?php foreach ($assets_sub_child_under_sub as $asset_sub_value):?>
                                                                                <?php if ($asset_sub_value->parent_id == $assets_sub_child->id): 
                                                                                    ?>
                                                                                    <tr>                                                                                
                                                                                        <td><?php echo $asset_sub_value->custom_id ?></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td><?php echo $asset_sub_value->group_name ?></td>                                                                    
                                                                                    </tr>                                                                                    
                                                                                <?php endif; ?>
                                                                                    <?php ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endif;?>                                                    
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> 
                                                    <tr class="success">
                                                        <td>20</td>
                                                        <td>Expenses</td>
                                                        <td></td>
                                                        <td></td>                                                        
                                                    </tr>
                                                    <?php if (isset($expenses_sub_childs)):?>
                                                        <?php if ($expenses_sub_childs == !NULL): ?>
                                                            <?php foreach ($expenses_sub_childs as $expenses_sub_child): ?>
                                                                <tr>
                                                                    <td><?php echo $expenses_sub_child->custom_id ?></td>
                                                                    <td></td>
                                                                    <td><?php echo $expenses_sub_child->group_name ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php if (isset($expenses_sub_childs_under_sub)): ?>
                                                                    <?php if ($expenses_sub_childs_under_sub == !NULL): ?>
                                                                        <?php foreach ($expenses_sub_childs_under_sub as $expenses_sub_child_under_sub): ?>
                                                                            <?php foreach ($expenses_sub_child_under_sub as $expenses_sub_value): ?>
                                                                                <?php if ($expenses_sub_value->parent_id == $expenses_sub_child->id): ?>
                                                                                    <tr>                                                                                
                                                                                        <td><?php echo $expenses_sub_value->custom_id?></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td><?php echo $expenses_sub_value->group_name ?></td>                                                                    
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endif;?>                                                    
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> 
                                                    <tr class="success">
                                                        <td>30</td>
                                                        <td>Income</td>
                                                        <td></td>
                                                        <td></td>                                                        
                                                    </tr>
                                                    <?php if (isset($incomes_sub_childs)):?>
                                                        <?php if ($incomes_sub_childs == !NULL): ?>
                                                            <?php foreach ($incomes_sub_childs as $incomes_sub_child): ?>
                                                                <tr>
                                                                    <td><?php echo $incomes_sub_child->custom_id ?></td>
                                                                    <td></td>
                                                                    <td><?php echo $incomes_sub_child->group_name ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php if (isset($incomes_sub_childs_under_sub)): ?>
                                                                    <?php if ($incomes_sub_childs_under_sub == !NULL): ?>
                                                                        <?php foreach ($incomes_sub_childs_under_sub as $incomes_sub_child_under_sub): ?>
                                                                            <?php foreach ($incomes_sub_child_under_sub as $incomes_sub_value): ?>
                                                                                <?php if ($incomes_sub_value->parent_id == $incomes_sub_child->id): ?>
                                                                                    <tr>                                                                                
                                                                                        <td><?php echo $incomes_sub_value->custom_id ?></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td><?php echo $incomes_sub_value->group_name ?></td>                                                                    
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endif;?>                                                    
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> 
                                                    <tr class="success">
                                                        <td>40</td>
                                                        <td>Liabilities and Owners Equity</td>
                                                        <td></td>
                                                        <td></td>                                                        
                                                    </tr>
                                                    <?php if (isset($liabilities_sub_childs)): ?>
                                                        <?php if ($liabilities_sub_childs == !NULL): ?>
                                                            <?php foreach ($liabilities_sub_childs as $liabilities_sub_child): ?>
                                                                <tr>
                                                                    <td><?php echo $liabilities_sub_child->custom_id ?></td>
                                                                    <td></td>
                                                                    <td><?php echo $liabilities_sub_child->group_name ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php if (isset($liabilities_sub_childs_under_sub)): ?>
                                                                    <?php if ($liabilities_sub_childs_under_sub == !NULL): ?>
                                                                        <?php foreach ($liabilities_sub_childs_under_sub as $liabilities_sub_child_under_sub): ?>
                                                                            <?php foreach ($liabilities_sub_child_under_sub as $liabilities_sub_value): ?>
                                                                                <?php if ($liabilities_sub_value->parent_id == $liabilities_sub_child->id): ?>
                                                                                    <tr>                                                                                
                                                                                        <td><?php echo $liabilities_sub_value->custom_id ?></td>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td><?php echo $liabilities_sub_value->group_name ?></td>                                                                    
                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endif;?>                                                    
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> 
                                                </tbody>                                                
                                            </table>
                                        </div>
                                    </div>                       
                                </div>
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
        $("#group_parent").select2({
            placeholder: "Select Parent"
        });

        $("#root_parent").select2({
            placeholder: "Select Root Parent"
        });

        $('.alert-success').delay(2000).hide(300).css({'color': 'green'});
        $('.alert-danger').delay(2000).hide(300).css({'color': 'red'});

        $(document).on('change keyup', '.prevent', function () {
            var numchange = $(this).val().replace(/[^0-9.]/g, '');
            numchange = numchange.replace(/\.(?=.*\.)/, '');
            $(this).val(numchange);
        });

    });
    function goBack() {
        window.history.back();
    }
</script>