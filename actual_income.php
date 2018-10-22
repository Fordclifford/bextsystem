<?php
session_start();
require_once 'includes/auth_validate.php';
include_once'includes/header.php';
require_once 'coreadmin/config/config.php';
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
    $filter_col = "date_added";
}
if (!$order_by) {
    $order_by = "Desc";
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
//$db->where('church_id',$_SESSION['church']);
$db->join("financial_year f", "i.financial_year_id=f.id", "LEFT");

$select = array('i.id', 'i.balance', 'i.source_name', 'i.amount', 'i.date_added', 'f.year', 'i.church_id');
//
// $church = $db->get ("church c", null, "u.user_name,c.id,c.name,c.union_mission,c.conference,c.mobile,c.date");
// print_r($church);
//Start building query according to input parameters.
// If search string
if ($search_string) {
    $db->where('source_name', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}

//Set pagination limit
$db->pageLimit = $pagelimit;

//Get result of the query.
$income = $db->arraybuilder()->paginate("actual_income i", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($income as $value) {
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
?>
<?php include_once './includes/header.php'; ?>

<?php
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
    include_once './sidenav.php';
    ?>

<?php endif; ?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Actual Income</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
                <a href="">
                    <button data-toggle="modal" data-target="#add_new_record_modal" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
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
                <th>Income Source</th>
                <th>Amount</th>
                <th>Date Added</th>
                <th>Financial Year</th>
                <th>Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="income_data">
<?php foreach ($income as $row) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td data-name="source_name" class="source_name" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo $row['source_name'] ?></td>
                    <td data-name="amount" class="amount" data-type="text" data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['amount']); ?></td>
                    <td data-name="date_added" id="date_added" class="date_added" data-original-title="Select option" data-value="0" data-type="date"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['date_added']) ?></td>
                    
                     <td data-name="financial_year_id" id="year" class="year" data-original-title="Select Year" data-value="0" data-type="select"  data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['year']) ?></td>

                    <td data-name="balance" id="balance" class="balance"   data-pk="<?php echo $row['id'] ?>"><?php echo htmlspecialchars($row['balance']) ?></td>

                   
                    <td>	<a href=""  class="btn btn-danger delete_income delete_btn" name="delete_income" id="<?php echo $row['id'] ?>" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <form id="income_form" method="post" class="well form-horizontal modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Income </h4>
                </div>
                <div class="modal-body"  >
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Income Source:</label>
                            <div class="col-md-7 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                                    <input type="text" list="incomes" name="source_name" style="background:url('assets/image/image_arrow.PNG')no-repeat right;height:40px" id="source" placeholder="Click for options or type a value " class="form-control w3-round-large"  autocomplete="off">
                                    <datalist id="incomes">
                                        <option value="Sabbath School Collections">Sabbath School Expense Collections</option>
                                        <option value="Church Fund For Needy">Church Fund For Needy</option>
                                        <option value="Combined(church) Budget">Combined Budget Giving</option>
                                        <option value="Welfare Fund">Welfare Fund</option>
                                    </datalist>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Financial Year</label>
                            <div class="col-md-7 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>

                                    <?php
                                    $db->where("church_id", $_SESSION['church']);
                                    echo "<select title=\" choose year\"   style=\" height: 40px\" class=\"form-control w3-round-large\" name=\"financial_year_id\" id=\"financial_year_id\" >";
                                    echo "<option value=''> -----Select Year------ </option>";
                                    foreach ($db->get('financial_year') as $row) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['year'] . "</option>";
                                    } echo "</select>";
                                    ?>

                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Amount</label>
                            <div class="col-md-7 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input style="height:40px" type="number" name="amount" id="amount" placeholder="Amount" class="form-control" required="true" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" data-toggle="tooltip"  title="dismiss modal" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit"  title="click to add record" data-toggle="tooltip"  class="btn btn-primary" onclick="addActualIncome()">Add Income</button>
                </div>
            </form>

        </div>
    </div>


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
            echo '<li' . $li_class . '><a href="actual_income.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul></div>';
    }
    ?>
</div>


<!--    Pagination links end-->

</div> 



<script type="text/javascript">
<?php echo "var years = $jsonYears; \n"; ?>
    $(document).ready(function () {
        $('#income_data').editable({
            container: 'body',
            selector: 'td.year',
            url: "ajax/income/update_actual_income.php",
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

        $('#income_data').editable({
            container: 'body',
            selector: 'td.source_name',
            url: "ajax/income/update_actual_income.php",
            title: 'Source Name',
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

        $('#income_data').editable({
            container: 'body',
            selector: 'td.amount',
            url: "ajax/income/update_actual_income.php",
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

        $(document).on('click', '.delete_income', function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?"))
            {
                $.ajax({
                    url: "ajax/income/delete_actual_income.php",
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
<script type="text/javascript">
    $(document).ready(function () {
        $("#income_form").validate({
            rules: {
                year: {
                    required: true,
                    minlength: 3
                },
                source_name: {
                    required: true,
                    minlength: 3
                },
                amount: {
                    required: true,
                    minlength: 1
                }
            }
        });
    });
</script>


<script src="assets/js/modal.js"></script>
<?php include_once('includes/footer.php'); ?>
<script src="includes/js/notif.js" type="text/javascript"></script>