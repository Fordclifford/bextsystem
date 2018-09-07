<?php  
$db = getDbInstance();
  foreach( $db->get('union_mission') as $row) {
  $unions[] = array("id" => $row['id'], "val" => $row['union_name']);
}

foreach($db->get('conference') as $row) {
  $conferences[$row['union_id']][] = array("id" => $row['id'], "val" => $row['conf_name']);
}
$jsonUnions = json_encode($unions);
$jsonConferences = json_encode($conferences);
 ?>
<fieldset>

    <div class="form-group">
        <label for="union" >Select Union/Mission</label>
        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-globe"></span></span>
            <select title="union" data-toggle="tooltip" style="height:40px;margin-top: 0px" required="required"  class="w3-round-large form-control"  value="<?php echo $edit ? $church['union_mission'] : ''; ?>" id="union_mission" name ="union_mission"></select>
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
            $db->where ("user_type", 'treasurer');
            echo "<select title=\" Choose User\" data-toggle=\"tooltip\"  style=\" height: 40px\" class=\"form-control w3-round-large\" name=\"user_id\" id=\"user_id\" >";
  echo "<option value=''> -----Select User------ </option>";
            foreach ($db->get('users') as $row) {
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
