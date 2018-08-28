function readRecords() {
    $.get("ajax/profile/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}
function GetNameDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/profile/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var name = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_name").val(name.name);            
                    }
    );
    // Open modal popup
    $("#update_name_modal").modal("show");
}
function GetUnionDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/profile/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var union = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#union").val(union.union_mission);  
             $("#conference").val(union.conference);
                    }
    );
    // Open modal popup
    $("#update_union_modal").modal("show");
}
function UpdateNameDetails() {
    // get values
    var name = $("#update_name").val();   
    
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/profile/updateUserDetails.php", {
            id: id,
            name: name         
        },
        function (data, status) {
            // hide modal popup
            $("#update_name_modal").modal("hide");
            // reload Income by using readRecords();
            readRecords();
        }
    );
}
function UpdateUnionDetails() {
    // get values
    var union = $("#union_mission").val();  
    var conf = $("#conference").val();  
    
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/profile/updateUserDetails.php", {
            id: id,
            union_mission:union,
            conference: conf         
        },
        function (data, status) {
            // hide modal popup
            $("#update_union_modal").modal("hide");
            // reload Income by using readRecords();
            readRecords();
        }
    );
}

function GetMobileDetails(id) {
    // Add Income ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/profile/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var mobile = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_mobile").val(mobile.mobile);            
                    }
    );
    // Open modal popup
    $("#update_mobile_modal").modal("show");
}

function UpdateMobileDetails() {
    // get values
    var mobile = $("#update_mobile").val();   
    
    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/profile/updateUserDetails.php", {
            id: id,
            mobile: mobile         
        },
        function (data, status) {
            // hide modal popup
            $("#update_mobile_modal").modal("hide");
            // reload Income by using readRecords();
            readRecords();
        }
    );
}
$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});


