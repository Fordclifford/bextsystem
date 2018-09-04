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
$select = array('id', 'name', 'union_mission', 'conference', 'mobile', 'date');

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




<div id="alert_message"></div>

    <table class="table table-bordered table-striped table-condensed">
        <thead>
         <tr> <th class="header">#</th>
             <th>Name</th>
             <th>Union</th>
             <th>Conference</th>
              <th>Phone</th>
               <th>User</th>
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
     url:"fetch_church.php",
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
      html_data += '<td data-name="mobile" class="mobile" data-type="text" data-pk="'+data[count].id+'">'+data[count].mobile+'</td>';
       html_data += '<td data-name="user" class="user" data-type="select" data-pk="'+data[count].id+'">'+data[count].user_id+'</td>';
          html_data += '<td> <a href="" data-name="delete" class="actions btn btn-danger delete_btn" data-toggle="modal"><span class="fa fa-trash fa-2x" ></span></a></td></tr>';
       $('#church_data').append(html_data);
      }
     }
    });
    }

    fetch_church_data();

    $('#church_data').editable({
    container: 'body',
    selector: 'td.name',
    url: "update_church.php",
    title: 'Church Name',
    type: "POST",
    //dataType: 'json',
    validate: function(value){
     if($.trim(value) == '')
     {
      return 'This field is required';
     }
   },
   success:function(data)
   {
    $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
  }

   });



    $('#church_data').editable({
    container: 'body',
    selector: 'td.union',
    url: "update_church.php",
    title: 'Union',
    type: "POST",
    dataType: 'json',
    source: [{value: '', text: '-Please Select-'},{value: union_arr[1], text: union_arr[1]}, {value:union_arr[0], text: union_arr[0]}],
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
    url: "update_church.php",
    title: 'Conference',
    type: "POST",
    dataType: 'json',
    source: [{value: '', text: '-Please Select-'},{value: conference[0], text: conference[0]}, {value: conference[1], text: conference[1]},
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
   url: "update_church.php",
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

<script>
    var conference = new Array("Central Kenya Conference","Central Rift Valley Conference","Kenya Coast Field","Nyamira Conference","South Kenya Conference","Central Nyanza Conference","Greater Rift Valley Conference","Kenya Lake Conference","North West Kenya Conference","Ranen Conference");
</script>

<?php include_once './includes/footer.php'; ?>
