$(document).ready(function () {
    $("button").click(function () {
        var pizzaId = $(this).val();
        var amount = $("#" + pizzaId).val() * 1;
        if (!amount) {
            $(this).parent().addClass("has-error");
            //alert("Bitte Menge angeben!");
            return;
        }
        $(this).parent().removeClass("has-error");

        $.ajax({
            url: "addpizzaorder.php?pizzaid=" + pizzaId + "&amount=" + amount, success: function () {
                var counterElement = $("#counter");
                var counter = counterElement.data("numberOfPizzas");
                if (!counter) { //we don't have a counter, load it from the badge itself
                    counter = counterElement.html() * 1;
                }
                //console.log(counter);
                counter += amount;
                counterElement.data("numberOfPizzas", counter);
                counterElement.html(counter);
            }
        });
    })
});