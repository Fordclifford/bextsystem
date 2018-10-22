<fieldset>

    <h1 style="margin:20px" class="text-center">Forgot Password?</h1>
        <?php if (!empty($success_message)) { ?>
            <div class="success_message alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>

        <div id="validation-message">
            <?php if (!empty($error_message)) { ?>
                <?php echo $error_message; ?>
            <?php } ?>
        </div>

            
        <div class="form-group">
        <label class="col-md-4 control-label">Email</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input  style="height:40px" type="text" type="text" name="user-email" id="user-email" placeholder="email" class="form-control"  autocomplete="off"/>
            </div>
        </div>
    </div> 

       
    <div class="form-group ">
        <div style="margin-left: 25%" class="row">
           <div class="col-md-2">
           <a title="Click to signin"  href="../login.php"   data-toggle="tooltip"   ><span class="glyphicon glyphicon-log-in"></span> Signin</a>
         </div>
        <div  class="col-md-2">
         <button title="Click to Clear Input" type="reset" value="reset" data-toggle="tooltip"  class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
</div>
          <div class="col-md-2">
        <label></label>
        <button type="submit" name="forgot-password" value="Submit" id="forgot-password" class="btn  btn-warning" >Submit <span class="glyphicon glyphicon-send"></span></button>
         </div>
         
        </div>
         
    </div>
            
</fieldset>