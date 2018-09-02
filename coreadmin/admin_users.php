<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page
if ($_SESSION['user_type'] !== 'super') {
    // show permission denied message
    header('HTTP/1.1 401 Unauthorized', true, 401);

    exit("401 Unauthorized");
}
//Get data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$del_id = filter_input(INPUT_GET, 'del_id');

$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$page = filter_input(INPUT_GET, 'page');
$pagelimit = 20;
if ($page == "") {
    $page = 1;
}
// If filter types are not selected we show latest added data first
if ($filter_col == "") {
    $filter_col = "id";
}
if ($order_by == "") {
    $order_by = "desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('id', 'user_name', 'user_type','email','status');

// If user searches
if ($search_string) {
    $db->where('user_name', '%' . $search_string . '%', 'like');
}


if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}

$db->pageLimit = $pagelimit;
$result = $db->arraybuilder()->paginate("users", $page, $select);
$total_pages = $db->totalPages;


// get columns for order filter
foreach ($result as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
?>
<?php include_once './includes/header.php'; ?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-6">
            <h1 class="page-header">Admin users</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
            <a href="add_admin.php"> <button class="btn btn-success">Add new</button></a>
            </div>
        </div>
</div>
 <?php include('./includes/flash_messages.php') ?>

    <?php
    if (isset($del_stat) && $del_stat == 1) {
        echo '<div class="alert alert-info">Successfully deleted</div>';
    }
    ?>

    <!--    Begin filter section-->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search" >Search</label>
            <input style="height:32px" type="text" class="form-control" id="input_search"  name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col" class="form-control">

                <?php
                foreach ($filter_options as $option) {
                    ($filter_col === $option) ? $selected = "selected" : $selected = "";
                    echo ' <option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                ?>

            </select>

            <select name="order_by" class="form-control" id="input_order">

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
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th class="header">#</th>
                <th>Name</th>
                <th>User type</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="user_data">
        </tbody>
    </table>

    <script type="text/javascript" language="javascript" >
    $(document).ready(function(){

    function fetch_user_data()
    {
    $.ajax({
     url:"fetch_user.php",
     method:"POST",
     dataType:"json",
     success:function(data)
     {

      for(var count=0; count<data.length; count++)

      {
       var html_data = '<tr><td>'+data[count].id+'</td>';
       html_data += '<td data-name="user_name" class="user_name" data-type="text" data-pk="'+data[count].id+'">'+data[count].user_name+'</td>';
       html_data += '<td data-name="user_type" class="user_type" id="user_type" data-type="select" data-pk="'+data[count].id+'">'+data[count].user_type+'</td>';
       html_data += '<td data-name="email" id="email" class="email" data-type="text" data-pk="'+data[count].id+'">'+data[count].email+'</td>';
      html_data += '<td data-name="status" class="status" data-type="select" data-pk="'+data[count].id+'">'+data[count].status+'</td>';
      html_data += '<td> <a href="" data-name="delete" class="actions btn btn-danger delete_btn" data-toggle="modal"><span class="fa fa-trash fa-2x" ></span></a></td></tr>';

       $('#user_data').append(html_data);
     }

}
    });
    }

    fetch_user_data();

    $('#user_data').editable({
    container: 'body',
    selector: 'td.user_name',
    url: "update_user.php",
    title: 'Username',
    type: "POST",
    //dataType: 'json',
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });

    $('#user_data').editable({
    container: 'body',
    selector: 'td.user_type',
    url: "update_user.php",
    title: 'User Type',
    type: "POST",
    dataType: 'json',
    source: [{value: '', text: '-Please Select-'},{value: 'super', text:'Super Admin'}, {value: 'admin', text:'Admin'},
    {value: 'auditor', text:'Conference Auditor'},{value: 'treasurer', text:'Church Treasurer'}],
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });

    $('#user_data').editable({
    container: 'body',
    selector: 'td.status',
    url: "update_user.php",
    title: 'Status',
    type: "POST",
    dataType: 'json',
    source: [{value: '', text: '-Please Select-'}, {value: 'Approved', text: 'Approved'},{value: 'Pending', text: 'Pending'}],

    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
    }
    });

    $('#user_data').editable({
   container: 'body',
   selector: 'td.email',
   url: "update_user.php",
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
     return 'Invalid Email!';
    }
   }
  });


  });
</script>
    <!--    Pagination links-->
    <div class="text-center">

        <?php
        if (!empty($_GET)) {
            //we must unset $_GET[page] if built by http_build_query function
            unset($_GET['page']);
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="index.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
</div>
<?php include_once './includes/footer.php'; ?>
