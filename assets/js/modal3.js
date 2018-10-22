
// READ records
function readRecords() {
    $.get("ajax/budget/readIncomeRecords.php", {}, function (data, status) {
        $(".record_content").html(data);
    });
     $.get("ajax/budget/readExpenseRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
    
}

function DeleteIncome(id) {
    var conf = confirm("Are you sure, do you really want to delete Income?");
    if (conf == true) {
        $.post("ajax/budget/deleteIncome.php", {
                id: id
            },
            function (data, status) {
                // reload Income by using readRecords();
                readRecords();
            }
        );
    }
}

function DeleteExpense(id) {
    var conf = confirm("Are you sure, do you really want to delete Expense?");
    if (conf == true) {
        $.post("ajax/budget/deleteExpense.php", {
                id: id
            },
            function (data, status) {
                // reload Income by using readRecords();
                readRecords();
            }
        );
    }
}


$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});