<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page

if ($_SESSION['user_type'] != 'super') {
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
$pagelimit = 10;
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

$select = array('u.user_name','u.id','u.user_type','u.email','u.status',"date_created");


// If user searches
if ($search_string) {
    $db->where('user_name', '%' . $search_string . '%', 'like');
    $db->orwhere('user_type', '%' . $search_string . '%', 'like');
	 $db->orwhere('email', '%' . $search_string . '%', 'like');
   $db->orwhere('status', '%' . $search_string . '%', 'like');

}


if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}

$db->pageLimit = $pagelimit;

$user = $db->arraybuilder()->paginate("users u", $page, $select);
// print_r($user);
$total_pages = $db->totalPages;


// get columns for order filter
foreach ($user as $value) {
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

    <!--    Begin filter section-->
    <div id="alert_message"></div>
    
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
                <th>Date Added</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="user_data">
              <?php foreach ($user as $row) : ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td data-name="user_name" class="user_name" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo $row['user_name'] ?></td>
                    <td data-name="user_type" class="user_type" id="user_type" data-type="select" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['user_type']) ?></td>'
                    <td data-name="email" id="email" class="email" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['email']) ?></td>
                    <td data-name="date" class="date" data-type="date" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['date_created']); ?></td>
                 
                    <td data-name="status" id="status" class="status"  data-type="select" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['status']) ?></td>
                       <td>
          <a href=""  class="btn btn-danger delete delete_btn" name="delete" id="<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
          </tr>
             <?php endforeach; ?>
          </tbody>

    </table>


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
                echo '<li' . $li_class . '><a href="admin_users.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
</div>
<?php include_once './includes/footer.php'; ?>
