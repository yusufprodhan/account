<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
<!--                --><?php //if (isset($status)){echo $status;}?>
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
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo site_url() ?>admin/updateCompanyInfo" method="post">
                            <?php if(!empty($company_info)){?>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="name_of_company" class="col-sm-3 col-form-label">Name of Company</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name_of_company" name="name_of_company" class="form-control" value="<?php echo $company_info[0]['company_name']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="name_of_business" class="col-sm-3 col-form-label">Type of Business</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name_of_business" name="name_of_business" class="form-control" value="<?php echo $company_info[0]['business_type']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="registrated_address" class="col-sm-3 col-form-label">Registrated Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="registrated_address" name="registrated_address" class="form-control" value="<?php echo $company_info[0]['registrated_address']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="country_of_origin" class="col-sm-3 col-form-label">Country of Origin</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="country_of_origin" name="country_of_origin" class="form-control" value="<?php echo $company_info[0]['country_of_origin']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="telephone_no" class="col-sm-3 col-form-label">Telephone No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="telephone_no" name="telephone_no" class="form-control" value="<?php echo $company_info[0]['telephone_no']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="fax_no" class="col-sm-3 col-form-label">Fax No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="fax_no" name="fax_no" class="form-control" value="<?php echo $company_info[0]['fax_no']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="<?php echo $company_info[0]['mobile_no']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="web_address" class="col-sm-3 col-form-label">Web Address</label>
                                        <div class="col-sm-9">
                                            <input type="url" id="web_address" name="web_address" class="form-control" value="<?php echo $company_info[0]['web_address']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $company_info[0]['email']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="at_glance_brief_description" class="col-sm-3 col-form-label">At Glance Brief Description</label>
                                        <div class="col-sm-9">
                                            <textarea type="email" id="at_glance_brief_description" name="at_glance_brief_description" class="form-control"><?php echo $company_info[0]['glance_description']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="update_company_info" class="btn btn-primary pull-right">Update</button>
                            <?php } else {?>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="name_of_company" class="col-sm-3 col-form-label">Name of Company</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name_of_company" name="name_of_company" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="name_of_business" class="col-sm-3 col-form-label">Type of Business</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="name_of_business" name="name_of_business" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="registrated_address" class="col-sm-3 col-form-label">Registrated Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="registrated_address" name="registrated_address" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="country_of_origin" class="col-sm-3 col-form-label">Country of Origin</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="country_of_origin" name="country_of_origin" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="telephone_no" class="col-sm-3 col-form-label">Telephone No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="telephone_no" name="telephone_no" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="fax_no" class="col-sm-3 col-form-label">Fax No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="fax_no" name="fax_no" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="mobile_no" class="col-sm-3 col-form-label">Mobile No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="mobile_no" name="mobile_no" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="web_address" class="col-sm-3 col-form-label">Web Address</label>
                                        <div class="col-sm-9">
                                            <input type="url" id="web_address" name="web_address" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="at_glance_brief_description" class="col-sm-3 col-form-label">At Glance Brief Description</label>
                                        <div class="col-sm-9">
                                            <textarea type="email" id="at_glance_brief_description" name="at_glance_brief_description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="save_company_info" class="btn btn-primary pull-right">Update</button>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.alert-success').delay(2000).css({'color': 'green'});
        $('.alert-danger').delay(2000).css({'color': 'red'});
    })
</script>