
<!-- login-form start here -->
  <div id="login-form">
    <div class="container">
      <div class="row">
        <div class="col-sm-offset-2 col-md-8 col-sm-8  col-xs-12">
          <div class="form">
            <div class="border"></div>
            <div class="border1"></div>
            <?= form_open('login/check_user/','class="form-horizontal"') ?>
              <fieldset>
                <div class="form-group">
                  <div class="col-sm-12">
                    <h3>Password reset link will be sent to your email.</h3>
                    <input class="form-control" placeholder="Enter email here" name="email" required="" type="email">
                  </div>
                </div>
                
                <div class="button">
                  <input type="submit" value="Send" class="btn btn-primary btnus" name="reset_pass">
                </div>
                
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- login-form  end here -->