<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require "../../vendor/autoload.php";

Propel::init(__DIR__ . "/../../propel/conf/pizzaservice-conf.php");

session_start();

use Pizzaservice\Lib\Web\LayoutHelper;
use Pizzaservice\Propel\Models\PizzaQuery;

$layoutHelper = new LayoutHelper();

echo $layoutHelper->renderHead("order");

echo $layoutHelper->renderHeader("order");

$bodyHTML[] = "    <table>";
$bodyHTML[] = "        <tr>";
$bodyHTML[] = "            <th>Pizza</th>";
$bodyHTML[] = "            <th>Zutaten</th>";
$bodyHTML[] = "            <th>Preis</th>";
$bodyHTML[] = "            <th>Anpassen</th>";
$bodyHTML[] = "        </tr>";

$amountPizzas = 0;
$price = 0;

if (isset($_SESSION["order"]) && !empty($_SESSION["order"]))
{
    foreach ($_SESSION["order"] as $order)
    {
        $pizzaIds[] = $order[0];
        $amount[] = $order[1];
    }

    $pizzas = PizzaQuery::create()->findPks($pizzaIds);

    foreach ($pizzas as $i => $pizza)
    {
        $bodyHTML[] = "        <tr>";
        $bodyHTML[] = "            <td>" . $pizza->getName() . "</td>";
        foreach ($pizza->getIngredients() as $ingredient)
        {
            $ingredients[] = $ingredient->getName();
        }
        $amountPizzas += $amount[$i];
        $price += $pizza->getPrice() * $amount[$i];
        $bodyHTML[] = "            <td>" . implode(", ", $ingredients) . "</td>";
        $bodyHTML[] = "            <td>" . number_format($pizza->getPrice(), 2) . "€</td>";
        $bodyHTML[] = "            <td>";
        $bodyHTML[] = "                <form class='form-inline'>";
        $bodyHTML[] = "                    <input type=\"number\" class='form-control' min='1' value=\"" . $amount[$i] . "\">";
        $bodyHTML[] = "                    <button class=\"btn btn-danger\" type=\"button\" id=\"" . $pizza->getId() . "\">Löschen</button>";
        $bodyHTML[] = "                </form>";
        $bodyHTML[] = "            </td>";
        $bodyHTML[] = "        </tr>";
        $ingredients = array();
    }
}
else
{
    $bodyHTML[] = "        <tr>";
    $bodyHTML[] = "            <td colspan='4'><div class='alert alert-info text-center'><strong>Keine Pizzen ausgewählt!</strong></div></td>";
    $bodyHTML[] = "        </tr>";
}

$bodyHTML[] = "    </table>";
$bodyHTML[] = "    <h4 class='well text-center' id='overview'><ins id='pizzen'>$amountPizzas</ins> Pizzen für <ins id='amount'>" . str_replace(",", "", number_format($price, 2)) . "</ins>€</h4>";
echo implode("\n", $bodyHTML);
?>
    <form class="container-fluid col-md-8 col-md-offset-2" id="address-field">
        <div class="row">
            <div class="col-md-5">
                <label for="first_name">Vorname</label>
                <input type="text" class="form-control" id="first_name" required>
            </div>
            <div class="col-md-5">
                <label for="last_name">Nachname</label>
                <input type="text" class="form-control" id="last_name" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <label for="street">Straße</label>
                <input type="text" class="form-control" id="street" required>
            </div>
            <div class="col-md-3">
                <label for="number">Nr.</label>
                <input type="number" class="form-control" id="number" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label for="zip">PLZ</label>
                <input type="number" class="form-control" id="zip" required>
            </div>
            <div class="col-md-7">
                <label for="city">Stadt</label>
                <input type="text" class="form-control" id="city" required>
            </div>
        </div>
        <button class="btn btn-primary pull-right" type="button" id="submit_btn">Bestellen</button>
    </form>
<?php
echo $layoutHelper->renderFooter();
?>