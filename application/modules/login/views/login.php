<div class="container" style="margin-top: 113px;">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="text-center mb-5" style="margin-bottom: 5px !important;">
                <img src="<?php echo base_url('assets/images/employees.png'); ?>" alt="Logo">
                <h2><?php if(!empty($company_info)){echo $company_info[0]['company_name'];}?></h2>
            </div>
            <div style=" background-color: #f0f0f0;padding: 6% 4%; margin-top: 10px;">
                <?php if(isset($error)): ?>
                    <?= $error; ?>
                <?php endif; ?>
                <?php echo form_open(''); ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic addon1"><i class="fa fa-user" ></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username" required="required">                        
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic addon1"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="password" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> <!-- /container -->
