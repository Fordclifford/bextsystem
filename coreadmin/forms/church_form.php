<?php  include_once '../config.php';   ?>
<fieldset>

    <div class="form-group">
        <label for="union" >Select Union/Mission</label>
        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-globe"></span></span>
            <select title="union" data-toggle="tooltip" style="height:40px;margin-top: 0px" required="required"  class="w3-round-large form-control"  value="<?php echo $edit ? $church['union_mission'] : ''; ?>" onchange="print_conf('conference', this.selectedIndex);" id="union_mission" name ="union_mission"></select>
        </div>
    </div>

    <div class="form-group">
        <label for="conference" >Select Conference</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
            <select title="Conference" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control" required="required"   value="<?php echo $edit ? $church['conference'] : ''; ?>" id="conference" name ="conference"></select>
        </div>  </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></span>
            <input title="Enter Church Name" data-toggle="tooltip" style="height:40px;margin-top: 0px" type="text" name="name" required="required"  placeholder="Church Name e.g Nairobi Central SDA" class="form-control w3-round-large"  value="<?php echo $edit ? $church['name'] : ''; ?>" maxlength="40" />
        </div>
    </div>

    <div class="form-group">
        <label>Select User: </label>
        <div class="input-group">

            <span class="input-group-addon"><span class="glyphicon glyphicon-flag "></span></span>

            <?php
            $church_ids = $_SESSION['user'];
            $sqls = "Select * FROM users WHERE user_type='treasurer' ";
            $qs = mysql_query($sqls);
            echo "<select title=\" Choose User\" data-toggle=\"tooltip\"  style=\" height: 40px\" class=\"form-control w3-round-large\" name=\"user_id\" id=\"user_id\" >";
  echo "<option value=''> -----Select User------ </option>";
            while ($row = mysql_fetch_array($qs)) {

                echo "<option value='" . $row['id'] . "'>" . $row['user_name'] . "</option>";
            } echo "</select>";
            ?>

        </div>

    </div>


    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
            <input title="Enter Mobile Number" data-toggle="tooltip" required="required"  style="height:40px;margin-top: 0px" type="text" placeholder="Contact Number e.g. 0712345678" name="mobile" class="form-control w3-round-large"  value="<?php echo $edit ? $church['mobile'] : ''; ?>" maxlength="40" />
        </div> </div>



    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>
<script type="text/javascript">

    function validatePassword()
    {
        if (document.login.password.value !== document.login.confirm_password.value) {
            alert("Your passwords did not match!. Please check and register again");


            return false;
        } else {
            return true;
        }
    }

</script>
<script type= "text/javascript" src = "js/conferences.js"></script>
<script language="javascript">print_union("union_mission");</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
