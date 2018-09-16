// Add Record
function addActualIncome() {
// get values
var source = $("#source").val();
        var amount = $("#amount").val();
        var year = $("#financial_year_id").val();
        $.ajax({
        url: "ajax/income/addActualIncome.php",
                method: "POST",
                data: {source_name: source, amount:amount, financial_year_id:year},
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

