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
    $filter_col = "date_created";
}
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$db->join("users u", "c.user_id=u.id", "INNER");
$select = array('u.user_name','c.id','c.union_name','c.date_created');
//
// $church = $db->get ("church c", null, "u.user_name,c.id,c.name,c.union_mission,c.conference,c.mobile,c.date");
// print_r($church);

//Start building query according to input parameters.
// If search string
if ($search_string)
{
    $db->where('union_name', '%' . $search_string . '%', 'like');
  	 }

//If order by option selected
if ($order_by)
{
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$union = $db->arraybuilder()->paginate("union_mission c", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($union as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}

?>
<?php include_once './includes/header.php'; ?>

<!--Main container start-->
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Unions</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
	            <a href="add_union.php?operation=create">
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
            <input type="text" style="height:30px" class="form-control" title="search by name" data-toggle="tooltip" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col"  title="order by name,user" data-toggle="tooltip" class="form-control">

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
             <th>Date</th>
               <th>User</th>
              <th>Actions</th>
         </tr>
        </thead>
        <tbody id="union_data">
          <?php foreach ($union as $row) : ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
	                <td data-name="name" class="name" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo $row['union_name'] ?></td>
                   <td data-name="date" class="date" data-type="date" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['date_created']); ?></td>
                  <td data-name="user" id="user" class="user" data-original-title="Select option" data-value="0" data-type="select" data-source="fetch_user_name.php" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['user_name']) ?></td>
	                   <td>
				<a href=""  class="btn btn-danger delete_union delete_btn" name="delete_union" id="<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
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
                echo '<li' . $li_class . '><a href="unions.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
    <!--    Pagination links end-->

</div>
<!--Main container end-->

<?php include_once './includes/footer.php'; ?>
