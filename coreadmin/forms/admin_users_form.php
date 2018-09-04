<fieldset>
    <!-- Form Name -->
    <legend>Add new user</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">User name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input style="height:40px" type="text" name="user_name" placeholder="user name" class="form-control" value="<?php echo ($edit) ? $admin_account['user_name'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
     <div class="form-group">
        <label class="col-md-4 control-label">User name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  style="height:40px" type="text" name="email" placeholder="email" class="form-control" value="<?php echo ($edit) ? $admin_account['email'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >Password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input style="height:40px" type="password" name="passwd" placeholder="Password " class="form-control" required="" autocomplete="off">
            </div>
        </div>
    </div>

    <!-- radio checks -->
    <div class="form-group">
        <label class="col-md-4 control-label">User type</label>
        <div class="col-md-4">
            <div class="radio">
                <label>
                    <?php //echo $admin_account['admin_type'] ?>
                    <input  type="radio" name="user_type" value="super" required="" <?php echo ($edit && $admin_account['user_type'] =='super') ? "checked": "" ; ?>/> Super admin
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="user_type" value="admin" required="" <?php echo ($edit && $admin_account['user_type'] =='admin') ? "checked": "" ; ?>/> Admin
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php //echo $admin_account['admin_type'] ?>
                    <input type="radio" name="user_type" value="auditor" required="" <?php echo ($edit && $admin_account['user_type'] =='auditor') ? "checked": "" ; ?>/> Conference Auditor
                </label>
            </div>
             <div class="radio">
                <label>
                    <?php //echo $admin_account['admin_type'] ?>
                    <input type="radio" name="user_type" value="treasurer" required="" <?php echo ($edit && $admin_account['user_type'] =='treasurer') ? "checked": "" ; ?>/> Church Treasurer
                </label>
            </div>
        </div>
    </div>
     <div class="form-group">
        <label class="col-md-4 control-label">Account Status</label>
        <div class="col-md-4">
              <div class="radio">
                <label>
                    <input type="radio" name="status" value="Approved" required="" <?php echo ($edit && $admin_account['status'] =='Approved') ? "checked": "" ; ?>/> Approved
                </label>
            </div>
             <div class="radio">
                <label>
                    <?php //echo $admin_account['admin_type'] ?>
                    <input  type="radio" name="status" value="Pending" checked="true" required="" <?php echo ($edit && $admin_account['status'] =='Pending') ? "checked": "" ; ?>/> Pending
                </label>
            </div>

        </div>
    </div>
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>
