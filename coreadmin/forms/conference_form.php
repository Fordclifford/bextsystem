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
    <!-- Form Name -->
    <legend>Add new conference</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">Conference name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input style="height:40px" type="text" name="conf_name" placeholder="conference name" class="form-control"  autocomplete="off">
            </div>
        </div>
    </div>
     <div class="form-group">
        <label class="col-md-4 control-label">Union/Mission</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <select  style="height:40px" id="union_mission" name="union_id" placeholder="union" class="form-control"  autocomplete="off"></select>
            </div>
        </div>
    </div>
    <!-- Text input-->

    <!-- radio checks -->

    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
    </div>
</fieldset>
