$(document).ready(function () {
    if ($("table tr td").length < 2) {
        $("#submit_btn").prop("disabled", true);
    }
    $("#submit_btn").click(function () {
        var exit = false;
        var data = "?";
        $("#address-field").find("input").each(function () {
            if (!$(this).val().trim()) {
                $(this).parent().removeClass("has-success");
                $(this).parent().addClass("has-error");
                exit = true;
            } else {
                $(this).parent().removeClass("has-error");
                $(this).parent().addClass("has-success");
                data += "&" + $(this).attr("id") + "=" + $(this).val().trim();
            }
        });

        if (exit) return;

        $.ajax({
            url: "process/index.php" + data, success: function () {
                $("#address-field").remove();
                $("table").remove();
                $("#counter").text("0");
                $("body").append("<div class=\"alert alert-success col-md-4 col-md-offset-4 text-center\">\n" +
                    "  <strong>Vielen Dank!</strong> Die Bestellung wurde entgegen genommen!" +
                    "</div>");
            }
        });
    });

    $("table").on("click", "button", function () {
        var button = $(this);
        var pizzaId = button.prop("id");

        $.ajax({
            url: "changeamount.php?pizzaId=" + pizzaId + "&amount=0", success: function () {
                button.parent().parent().parent().remove();
                var counterElement = $("#counter");
                var counter = counterElement.text() * 1;
                counterElement.text((counter - button.siblings("input").val() * 1));
                if ($("table tr td").length < 2) {
                    $("#submit_btn").prop("disabled", true);
                    $("table tbody").append("<tr><td colspan='3'><div class='alert alert-info text-center'><strong>Keine Pizzen ausgewählt!</strong></div></td></tr>");
                }
            }
        });
    });

    var input = $("table input");
    var amount;
    input.focusin(function () {
        amount = $(this).val();
    });

    input.focusout(function () {
        var newAmount = $(this).val();
        if (!newAmount.trim() || newAmount === "0") {
            $(this).val(amount);
            return;
        }
        if (amount !== newAmount) {
            var pizzaId = $(this).siblings("button").prop("id");
            $.ajax({
                url: "changeamount.php?pizzaId=" + pizzaId + "&amount=" + newAmount, success: function () {
                    var counterElement = $("#counter");
                    var counter = counterElement.text() * 1;
                    counterElement.text((counter - amount + newAmount * 1));
                }
            });
        }
    })
});