// Add Record

function addRecord() {
 
    // get values
    var category = $("#category").val();
    var amount = $("#amount").val();
    var date = $("#date").val();   
    var desc = $("#desc").val();
    var userfile = $("#userfile").val();
   

    // Add record
    $.post("ajax/bill/addRecord.php", {
        category: category,
        amount: amount,
        date: date,       
        desc:desc,
        userfile: userfile
         
       
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        readRecords();

        // clear fields from the popup
        $("#category").val("");
        $("#amount").val("");
        $("#desc").val("");       
        $("#date").val("");
        $("#userfile").val("");
        
       
    });
}

// READ records
function readRecords() {
    $.get("ajax/bills/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}


function DeleteBill(id) {
    var conf = confirm("Are you sure, do you really want to delete Bill?");
    if (conf == true) {
        $.post("ajax/bills/deleteRecord.php", {
                id: id
            },
            function (data, status) {
                // reload Income by using readRecords();
                readRecords();
            }
        );
    }
}

function GetBillDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/bills/readBillDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var bills = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_category").val(bills.source);
            $("#update_amount").val(bills.amount);
            $("#update_date").val(bills.date);
            $("#update_image").val(bills.image);
            $("#update_desc").val(bills.description);
                    }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateBillDetails() {
    // get values
     var category = $("#update_category").val();
    var amount = $("#update_amount").val();
    var date = $("#update_date").val();
    var image = $("#update_image").val();
    var desc=$("#update_desc").val();
   

    
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/bills/updateBillDetails.php", {
            id: id,
            category: category,
            amount: amount,
              date: date,
            image: image,
            desc: desc
          
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Income by using readRecords();
            readRecords();
        }
    );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});