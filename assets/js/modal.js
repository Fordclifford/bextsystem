// Add Record
function addActualIncome() {
// get values
    var source = $("#source").val();
    var amount = $("#amount").val();
    var year = $("#financial_year_id").val();
    $.ajax({
        url: "ajax/income/addActualIncome.php",
        method: "POST",
        data: {source_name: source, amount: amount, financial_year_id: year},
        success: function (data) {
            $('#alert_message').html('<div class="alert alert-dismissible alert-success">' + data + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            $("#add_new_record_modal").modal("hide");
            $("#source").val("");
            $("#amount").val("");
            $("#financial_year_id").val("");

        }
    });
    setInterval(function () {
        $('#alert_message').html('');
    }, 500);
}

// Add Record
function exportDatePdf() {

// get values
    var from = $("#from_date").val();
    var to = $("#to_date").val();
    if (from < to) {
       
   

$.ajax({
    url: "ajax/income/actualIncomePdf.php",
    method: "POST",
    data: {from_date: from, to_date: to},
    success: function (data) {
         $("#export_pdf_modal").modal("hide");
        $("#from_date").val("");
        $("#to_date").val("");
        
        

    }
});
    }
if(from > to) {
    alert("from date should smaller than to date!");
}

}

function exportDateExcel() {

// get values
    var from = $("#efrom_date").val();
    var to = $("#eto_date").val();
 
    if (from < to) {
      
       
   

$.ajax({
    url: "ajax/income/actualIncomeExcel.php",
    method: "POST",
    data: {from_date: from, to_date: to},
    success: function (data) {
        alert(data);
         $("#export_excel_modal").modal("hide");
        $("#from_date").val("");
        $("#to_date").val("");
        
        

    }
});
    }
if(from > to) {
    alert("from date should smaller than to date!");
}

}