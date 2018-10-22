<fieldset>

    <h1 style="margin:20px" class="text-center">Reset Password?</h1>
        <?php if (!empty($success_message)) { ?>
            <div class="success_message alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>

        <div id="validation-message">
            <?php if (!empty($error_message)) { ?>
                <?php echo $error_message; ?>
            <?php } ?>
        </div>
            
       <div class="form-group">
        <label class="col-md-4 control-label">password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input  style="height:40px" type="password" name="member_password" id="member_password" placeholder="password" class="form-control"  autocomplete="off"/>
            </div>
        </div>
    </div>
  <div class="form-group">
        <label class="col-md-4 control-label">Confirm Password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input  style="height:40px" type="password" name="confirm_password" id="confirm_password" placeholder="confirm password" class="form-control"  autocomplete="off"/>
            </div>
        </div>
    </div>
        


        <div class="form-group">
            <div class="text-center"><Button type="submit" name="reset-password" id="reset-password" value="Submit" class="form-submit-button">Reset<span class="glyphicon glyphicon-send"></span></Button></div>
        </div>
            
</fieldset>