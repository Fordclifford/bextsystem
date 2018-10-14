<?php

session_start();
require_once 'includes/auth_validate.php';
require_once 'coreadmin/config/config.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
  $church_id = $_SESSION['church'];


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
$db->join("financial_year f", "b.financial_year=f.id", "LEFT");
$db->join("actual_income a", "b.source=a.id", "LEFT");
$select = array('b.id', 'a.source_name','b.image','f.year', 'b.amount', 'b.date','b.description','b.mode_of_payment');

// $church = $db->get ("church c", null, "u.user_name,c.id,c.name,c.union_mission,c.conference,c.mobile,c.date");
// print_r($church);
//Start building query according to input parameters.
// If search string
if ($search_string) {
    
    $db->where('description', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$bill = $db->arraybuilder()->paginate("bill b", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($bill as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}


$d = getDbInstance();
$d->where('church_id', $_SESSION['church']);
foreach ($d->get('financial_year') as $row) {
    $years[] = array("value" => $row['id'], "text" => $row['year']);
}
$jsonYears = json_encode($years);

$sdb = getDbInstance();
$d->where('church_id', $_SESSION['church']);
foreach ($d->get('actual_income') as $row) {
    $income[] = array("value" => $row['id'], "text" => $row['source_name']);
}
$jsonIncome = json_encode($income);
?>
<?php include_once './includes/header.php'; ?>

<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) : ?>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Income & Expense Tracker</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->

            <!-- /.dropdown -->
            <li>  <a name="button" id="notification-icon" name="button" onclick="myFunction()" class="notification">
                    <i class="fa fa-envelope fa-fw"></i><?php if ($count > 0) { ?>
                        <span class="badge" id="notification-count" ><?php
                            echo $count;
                        }
                        ?></span>
                </a> <div id="notification-latest"></div>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>

                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="actual_income.php"> <i class="glyphicon glyphicon-usd"></i>Actual Income</a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="actual_income.php"><i class="fa fa-list fa-fw"></i>List all</a>
                            </li>
                            <li>
                                <a href="actualIncomePdf.php" ><i class="fa fa-file-pdf-o fa-fw"></i>Export pdf</a>
                            </li>
                            <li>
                                <a href="actualIncomeExcel.php" ><i class="fa fa-file-excel-o fa-fw"></i>Export Excel</a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="bills.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Bills<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="bills.php"><i class="fa fa-list fa-fw"></i>List all</a>
                            </li>
                            <li>
                                <a href="addbill.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                            </li>
                            <li>
                                <a href="exportBillsPdf.php" ><i class="fa fa-file-pdf-o fa-fw"></i>Export pdf</a>
                            </li>
                            <li>
                                <a href="exportBillsExcel.php" ><i class="fa fa-file-excel-o fa-fw"></i>Export Excel</a>
                            </li>
                        </ul>
                    </li>

                    <li >
                        <a href="budget.php"><i class="glyphicon glyphicon-briefcase fa-fw"></i> Budget<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="estimated_income.php"><i class="fa fa-list fa-fw"></i>Estimated Income</a>
                            </li>
                            <li>
                                <a href="estimated_expenses.php"><i class="fa fa-list fa-fw"></i>Estimated Expenses</a>

                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="balance.php"> <i class="glyphicon glyphicon-btc"></i> Balance</a>

                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
<?php endif; ?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Bills</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
                <a href="addbill.php">
                    <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
                </a>
            </div>
        </div>
    </div>
    <?php require_once 'includes/flash_messages.php'; ?>
    <div id="alert_message"></div>
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" style="height:30px" class="form-control" title="search by name" data-toggle="tooltip" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col"  class="form-control">

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
                <th>Source</th>
                <th>Amount</th>
                <th>Date Added</th>
                <th>Bill Attachment</th>
                 <th>Description</th>
                <th>Financial Year</th>
                 <th>Mode of Payment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="bill_data">
            <?php foreach ($bill as $row) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td data-name="source" class="source" data-type="select" data-pk="<?php echo $row['id'] ?>"><?php echo $row['source_name'] ?></td>
                    <td data-name="amount" class="amount" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['amount']); ?></td>
                    <td data-name="date" id="date" class="date" data-original-title="Select option" data-value="0" data-type="date"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['date']) ?></td>
                      <td data-name="image" id="image" class="image" data-type="text"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['image']) ?></td>
                   
                    <td data-name="description" id="description" class="description" data-type="text"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['description']) ?></td>
                     <td data-name="financial_year_id" id="year" class="year" data-original-title="Select Year" data-value="0" data-type="select"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['year']) ?></td>

                    <td data-name="mode_of_payment" id="mode_of_payment" class="mode_of_payment" data-type="text"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['mode_of_payment']) ?></td>
                    <td><a href=""  class="btn btn-danger delete_bill delete_btn" name="delete_bill" id="<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

 


</div>



<!-- // Modal -->

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
            echo '<li' . $li_class . '><a href="bills.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul></div>';
    }
    ?>
</div>


<!--    Pagination links end-->

</div> 



<script type="text/javascript">
<?php echo "var years = $jsonYears; \n"; 
echo "var income = $jsonIncome; \n";?>
    $(document).ready(function () {
        $('#bill_data').editable({
            container: 'body',
            selector: 'td.year',
            url: "ajax/bill/update_bill.php",
            title: 'Year',
            type: "POST",
            dataType: 'json',
            source: function () {
                return years;
            },
            success: function ()
            {
                window.location.reload();
            }
        });
        
           $('#bill_data').editable({
            container: 'body',
            selector: 'td.source',
            url: "ajax/bill/update_bill.php",
            title: 'Source',
            type: "POST",
            dataType: 'json',
            source: function () {
                return income;
            },
            success: function ()
            {
                window.location.reload();
            }
        });

        $('#bill_data').editable({
            container: 'body',
            selector: 'td.description',
            url: "ajax/bill/update_bill.php",
            title: 'Description',
            type: "POST",
//dataType: 'json',
            validate: function (value) {
                if ($.trim(value) == '')
                {
                    return 'This field is required';
                }
            },
            success: function ()
            {
                window.location.reload();
            }
        });

        $('#bill_data').editable({
            container: 'body',
            selector: 'td.amount',
           url: "ajax/bill/update_bill.php",
           title: 'Amount',
            type: "POST",
//dataType: 'json',
            validate: function (value) {
                if ($.trim(value) == '')
                {
                    return 'This field is required';
                }
            },
            success: function ()
            {
                window.location.reload();
            }
        });
        $('#bill_data').editable({
            container: 'body',
            selector: 'td.mode_of_payment',
           url: "ajax/bill/update_bill.php",
           title: 'Payment Mode',
            type: "POST",
//dataType: 'json',
            validate: function (value) {
                if ($.trim(value) == '')
                {
                    return 'This field is required';
                }
            },
            success: function ()
            {
                window.location.reload();
            }
        });

        $(document).on('click', '.delete_bill', function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?"))
            {
                $.ajax({
                    url: "ajax/bill/delete_bill.php",
                    method: "POST",
                    data: {id: id},
                    success: function () {
//                        window.location.reload();
                    }
                });
                setInterval(function () {
                    $('#alert_message').html('');
                }, 500);
            }
        });

    });
</script>


<?php include_once('includes/footer.php'); ?>