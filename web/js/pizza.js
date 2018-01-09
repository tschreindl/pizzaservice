$(document).ready(function () {
    $("button").click(function () {
        var pizzaId = $(this).val();
        var amount = $("#" + pizzaId).val() * 1;
        if (!amount) {
            $(this).parent().addClass("has-error");
            return;
        }
        $(this).parent().removeClass("has-error");

        $.ajax({
            url: "addpizzaorder.php?pizzaid=" + pizzaId + "&amount=" + amount, success: function () {
                var counterElement = $("#counter");
                counterElement.text(counterElement.text() * 1 + amount);
            }
        });
    })
});