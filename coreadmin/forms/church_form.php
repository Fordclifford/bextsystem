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
        <label class="col-md-4 control-label">Union/Mission</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                <select  style="height:40px" id="union_mission" name="union_id" placeholder="union" class="form-control"  autocomplete="off"></select>
            </div>
        </div>
    </div>
  <div class="form-group">
        <label class="col-md-4 control-label">Conference</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                <select  style="height:40px" id="conference" name="conference_id" placeholder="Conference" class="form-control"  autocomplete="off"></select>
            </div>
        </div>
    </div>

   <div class="form-group">
        <label class="col-md-4 control-label">Church name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                <input style="height:40px" type="text" name="name" placeholder="church name" class="form-control"  autocomplete="off">
            </div>
        </div>
    </div>

   <div class="form-group">
        <label class="col-md-4 control-label">User</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
   
            <?php
            $db->where ("user_type", 'treasurer');
            echo "<select title=\" Choose User\"   style=\" height: 40px\" class=\"form-control w3-round-large\" name=\"user_id\" id=\"user_id\" >";
  echo "<option value=''> -----Select User------ </option>";
            foreach ($db->get('users') as $row) {
                echo "<option value='" . $row['id'] . "'>" . $row['user_name'] . "</option>";
            } echo "</select>";
            ?>

        </div>

    </div>
   </div>


   <div class="form-group">
        <label class="col-md-4 control-label">Church name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                <input style="height:40px" type="text" name="mobile" placeholder="Mobile Number" class="form-control"  autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>
