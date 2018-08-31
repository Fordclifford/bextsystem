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
$pagelimit = 20;

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
$select = array('id', 'name', 'email', 'union_mission', 'conference', 'mobile', 'date','status');

//Start building query according to input parameters.
// If search string
if ($search_string)
{
    $db->where('name', '%' . $search_string . '%', 'like');
    $db->orwhere('conference', '%' . $search_string . '%', 'like');
	 $db->orwhere('union_mission', '%' . $search_string . '%', 'like');
 $db->orwhere('email', '%' . $search_string . '%', 'like');

}

//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$church = $db->arraybuilder()->paginate("church", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($church as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
include_once 'includes/header.php';
?>

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
<!--   Filter section end-->

    <hr>


    <table hidden class="table table-striped table-bordered table-condensed ">
        <thead>
            <tr>
              <th>Test</th>
                <th class="header">#</th>
                <th>Name</th>
                <th>Union</th>
                <th>Conference</th>
				 <th>Email</th>
                <th>Phone</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($church as $row) : ?>
                <tr>
                  <td><a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username">superuser</a></td>
                <td><?php echo $row['id'] ?></td>
	                <td><?php echo htmlspecialchars($row['name']); ?></td>
	                <td><?php echo htmlspecialchars($row['union_mission']) ?></td>
					 <td><?php echo $row['conference'] ?></td>
	                <td><?php echo htmlspecialchars($row['email']); ?></td>
	                <td><?php echo htmlspecialchars($row['mobile']) ?></td>
	               <td><?php echo htmlspecialchars($row['status']) ?> </td>
	                <td>
					<a href="edit_church.php?church_id=<?php echo $row['id'] ?>&operation=edit" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-edit"></span>

					<a href=""  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
				</tr>

						<!-- Delete Confirmation Modal-->
					 <div  class="modal fade" id="confirm-delete-<?php echo $row['id'] ?>" role="dialog">
					    <div class="modal-dialog">
					      <form action="delete_church.php" method="POST">
					      <!-- Modal content-->
						      <div  class="modal-content">
						        <div class="modal-header">
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						          <h4 class="modal-title">Confirm</h4>
						        </div>
						        <div class="modal-body">

						        		<input type="hidden" name="del_id" id = "del_id" value="<?php echo $row['id'] ?>">

						          <p>Are you sure you want to delete this church?</p>
						        </div>
						        <div class="modal-footer">
						        	<button type="submit" class="btn btn-default pull-left">Yes</button>
						         	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						        </div>
						      </div>
					      </form>

					    </div>
  					</div>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table class="table table-bordered table-striped table-condensed">
        <thead>
         <tr> <th class="header">#</th>
             <th>Name</th>
             <th>Union</th>
             <th>Conference</th>
             <th>Email</th>
             <th>Phone</th>
             <th>Status</th>
             <th>Actions</th>
         </tr>
        </thead>
        <tbody id="church_data">
        </tbody>
       </table>
    <script type="text/javascript" language="javascript" >
    $(document).ready(function(){

    function fetch_church_data()
    {
    $.ajax({
     url:"fetch.php",
     method:"POST",
     dataType:"json",
     success:function(data)
     {
      for(var count=0; count<data.length; count++)
      {
       var html_data = '<tr><td>'+data[count].id+'</td>';
       html_data += '<td data-name="name" class="name" data-type="text" data-pk="'+data[count].id+'">'+data[count].name+'</td>';
       html_data += '<td data-name="union_mission" class="union" id="union" data-type="select" data-pk="'+data[count].id+'">'+data[count].union_mission+'</td>';
       html_data += '<td data-name="conference" id="conference" class="conference" data-type="select" data-pk="'+data[count].id+'">'+data[count].conference+'</td>';
       html_data += '<td data-name="email" class="email" data-type="text" data-pk="'+data[count].id+'">'+data[count].email+'</td>';
       html_data += '<td data-name="mobile" class="mobile" data-type="text" data-pk="'+data[count].id+'">'+data[count].mobile+'</td>';
       html_data += '<td data-name="status" class="status" data-type="select" data-pk="'+data[count].id+'">'+data[count].status+'</td>';
       html_data += '<td <a href="" data-name="status" class="actions btn btn-danger delete_btn" data-toggle="modal" style="margin-left: 20px; " data-target="#confirm-delete-<?php echo $row['id'] ?>"><span class="fa fa-trash fa-2x" ></span></a></td></tr>';
       $('#church_data').append(html_data);
      }
     }
    })
    }

    fetch_church_data();

    $('#church_data').editable({
    container: 'body',
    selector: 'td.name',
    url: "update.php",
    title: 'Church Name',
    type: "POST",
    //dataType: 'json',
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });

    $('#church_data').editable({
    container: 'body',
    selector: 'td.union',
    url: "update.php",
    title: 'Union',
    type: "POST",
    dataType: 'json',
    source: [{value: union_arr[1], text: union_arr[1]}, {value:union_arr[0], text: union_arr[0]}],
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
       var regex = /^[a-zA-Z ]+$/;
       if(! regex.test(value))
       {
        return 'Enter Valid Name!';
       }
    }
    });

    $('#church_data').editable({
    container: 'body',
    selector: 'td.conference',
    url: "update.php",
    title: 'Conference',
    type: "POST",
    dataType: 'json',
    source: [{value: conference[0], text: conference[0]}, {value: conference[1], text: conference[1]},
    {value: conference[2], text: conference[2]},{value: conference[3], text: conference[3]},
    {value: conference[4], text: conference[4]},{value: conference[5], text: conference[5]},
    {value: conference[6], text: conference[6]},{value: conference[7], text: conference[7]},
    {value: conference[8], text: conference[8]},{value: conference[9], text: conference[9]}],
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });

    $('#church_data').editable({
   container: 'body',
   selector: 'td.mobile',
   url: "update.php",
   title: 'Mobile',
   type: "POST",
   dataType: 'json',
   validate: function(value){
    if($.trim(value) == '')
    {
     return 'This field is required';
    }
    var regex = /^[0-9]+$/;
    if(! regex.test(value))
    {
     return 'Numbers only!';
    }
   }
  });

    $('#church_data').editable({
    container: 'body',
    selector: 'td.email',
    url: "update.php",
    title: 'Email',
    type: "POST",
    dataType: 'json',
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
     var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     if(! regex.test(value))
     {
      return 'Enter Valid Email!';
     }
    }
    });

    $('#church_data').editable({
    container: 'body',
    selector: 'td.status',
    url: "update.php",
    title: 'Status',
    type: "POST",
    dataType: 'json',
    source: [{value: "Approved", text: "Approved"}, {value:"Pending", text:"Pending"}],
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });



    });
    </script>


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
<!--Main container end-->
<script type="text/javascript" src="../assets/js/conferences.js"></script>


<?php include_once './includes/footer.php'; ?>
