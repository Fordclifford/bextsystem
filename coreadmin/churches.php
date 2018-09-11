<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

//Get current page.
$page = filter_input(INPUT_GET, 'page');

//Per page limit for pagination.
$pagelimit = 10;

if (!$page) {
    $page = 1;
}

// If filter types are not selected we show latest created data first
if (!$filter_col) {
    $filter_col = "date";
}
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$db->join("users u", "c.user_id=u.id", "LEFT");
$db->join("conference n", "c.conference_id=n.id", "LEFT");
$db->join("union_mission m", "c.union_id=m.id", "LEFT");
$select = array('u.user_name','c.id','c.name','m.union_name','n.conf_name','c.mobile','c.date');
//
// $church = $db->get ("church c", null, "u.user_name,c.id,c.name,c.union_mission,c.conference,c.mobile,c.date");
// print_r($church);

//Start building query according to input parameters.
// If search string
if ($search_string)
{
    $db->where('name', '%' . $search_string . '%', 'like');
    $db->orwhere('conference', '%' . $search_string . '%', 'like');
	 $db->orwhere('union_mission', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$church = $db->arraybuilder()->paginate("church c", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($church as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}

$dbs = getDbInstance();
  foreach( $dbs->get('union_mission') as $row) {
  $unions[] = array("value" => $row['id'], "text" => $row['union_name']);
}

foreach($dbs->get('conference') as $row) {
  $conferences[] = array("value" => $row['id'], "text" => $row['conf_name']);
}
$d = getDbInstance();
$d->where('user_type','treasurer');
foreach($d->get('users') as $row) {
  $users[] = array("value" => $row['id'], "text" => $row['user_name']);
}
 $jsonUsers = json_encode($users);
$jsonUnions = json_encode($unions);
 $jsonConferences = json_encode($conferences);
 ?>

<?php include_once './includes/header.php'; ?>

<!--Main container start-->
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Churches</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
	            <a href="add_church.php?operation=create">
	            	<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
	            </a>
            </div>
        </div>
    </div>
        <?php include('./includes/flash_messages.php') ?>
    <!--    Begin filter section-->
    <div id="alert_message"></div>
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" style="height:30px" class="form-control" title="search by name,email,conference,union" data-toggle="tooltip" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col"  title="order by name,email,conference,union,status" data-toggle="tooltip" class="form-control">

                <?php
                foreach ($filter_options as $option) {
                    ($filter_col === $option) ? $selected = "selected" : $selected = "";
                    echo ' <option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                ?>

            </select>

            <select name="order_by" title="order asc or desc" data-toggle="tooltip" class="form-control" id="input_order">

                <option value="Asc" <?php
                if ($order_by == 'Asc') {
                    echo "selected";
                }
                ?> >Asc</option>
                <option value="Desc" <?php
                if ($order_by == 'Desc') {
                    echo "selected";
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">

        </form>
    </div>


    <table class="table table-bordered table-striped table-condensed">
        <thead>
         <tr> <th class="header">#</th>
             <th>Name</th>
             <th>Phone</th>
             <th>Union</th>
             <th>Conference</th>
              
               <th>Date Added</th>
               <th>User</th>
              <th>Actions</th>
         </tr>
        </thead>
        <tbody id="church_data">
          <?php foreach ($church as $row) : ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
	                <td data-name="name" class="name" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></td>
                         <td data-name="mobile" class="phone" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['mobile']); ?></td>
                  <td data-name="union_id" class="union_id" data-original-title="Select Union/Mission" id="union" data-type="select" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['union_name']) ?></td>'
	                <td data-name="conference_id" data-original-title="Select Conference" id="conference" class="conference_id" data-type="select" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['conf_name']) ?></td>
                  <td data-name="date" class="date" data-type="date" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['date']); ?></td>
                  <td data-name="user_id" id="user" class="user_id" data-original-title="Select User" data-type="select"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['user_name']) ?></td>
	                   <td>
				<a href=""  class="btn btn-danger delete_church delete_btn" name="delete_church" id="<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
				</tr>
           <?php endforeach; ?>
        </tbody>
       </table>



<!--    Pagination links-->
    <div class="text-center">

        <?php
        if (!empty($_GET)) {
            //we must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            //to keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        //Show pagination links
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="churches.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
    <!--    Pagination links end-->

</div>
 <script type="text/javascript">
     $(document).ready(function(){
<?php echo "var unions = $jsonUnions; \n";
echo "var conferences = $jsonConferences; \n";
echo "var users = $jsonUsers; \n";?>
$('#church_data').editable({
container: 'body',
selector: 'td.conference_id',
url: "update_church.php",
title: 'Conference',
type: "POST",
dataType: 'json',
source: function(){
   return conferences;
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#church_data').editable({
container: 'body',
selector: 'td.user_id',
url: "update_church.php",
title: 'User',
type: "POST",
dataType: 'json',
source: function(){
   return users;
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});

$('#church_data').editable({
container: 'body',
selector: 'td.union_id',
url: "update_church.php",
title: 'Union',
type: "POST",
dataType: 'json',
source: function(){
   return unions;
},
success:function(data)
{
  $('#alert_message').html('<div class="alert alert-dismissible alert-success">'+data+'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

}
});
});
  </script>
  <script src="js/crud_church.js" type="text/javascript" >
	</script>
<?php include_once './includes/footer.php'; ?>
