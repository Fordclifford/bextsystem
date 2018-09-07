<?php
include_once 'register/config.php';
  $query = "SELECT id,name FROM union_mission";
  $stmt = $DB->prepare($query);
  $stmt->execute();

    foreach($stmt->fetchAll() as $row) {
    $unions[] = array("id" => $row['id'], "val" => $row['name']);
  }


  $query = "SELECT id, union_id,name FROM conference";
  $stmt = $DB->prepare($query);
  $stmt->execute();

  foreach($stmt->fetchAll() as $row) {
    $conferences[$row['union_id']][] = array("id" => $row['id'], "val" => $row['name']);
}

  $jsonUnions = json_encode($unions);
  $jsonConferences = json_encode($conferences);


?>

<!docytpe html>
<html>

  <head>
    <script type='text/javascript'>
      <?php
        echo "var unions = $jsonUnions; \n";
        echo "var conferences = $jsonConferences; \n";
      ?>
      function loadUnions(){
        var select = document.getElementById("union_mission");
        select.option = new Option('','Select');
        select.onchange = updateConferences;
          for(var i = 0; i < unions.length; i++){
          select.options[i] = new Option(unions[i].val,unions[i].id);
        }
      }
      function updateConferences(){
        var unionSelect = this;
        var unionid = this.value;
        var confSelect = document.getElementById("conference");
        confSelect.options[i] = new Option('','Select');
        confSelect.options.length = 0; //delete all options if any present
        for(var i = 0; i < conferences[unionid].length; i++){
          confSelect.options[i] = new Option(conferences[unionid][i].val,conferences[unionid][i].id);
        }
      }
    </script>

  </head>

  <body onload='loadUnions()'>
    <select id='union_mission'>
    </select>

    <select id='conference'>

    </select>
  </body>
</html>
