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

echo $layoutHelper->renderHead();

echo $layoutHelper->renderHeader("order");

$bodyHTML = "<table>\n";
$bodyHTML .= "<tr>\n";
$bodyHTML .= "<th>Pizza</th>\n";
$bodyHTML .= "<th>Zutaten</th>\n";
$bodyHTML .= "<th>Anpassen</th>\n";
$bodyHTML .= "</tr>\n";

foreach ($_SESSION["order"] as $order)
{
    $pizzaIds[] = $order[0];
    $amount[] = $order[1];
}

$pizzas = PizzaQuery::create()->findPks($pizzaIds);

foreach ($pizzas as $i => $pizza)
{
    $bodyHTML .= "<tr>\n";
    $bodyHTML .= "<td>" . $pizza->getName() . "</td>\n";
    foreach ($pizza->getIngredients() as $ingredient)
    {
        $ingredients[] = $ingredient->getName();
    }

    $bodyHTML .= "<td>" . implode(", ", $ingredients) . "</td>\n";
    $bodyHTML .= "<td>\n";

    $bodyHTML .= "<form class='form-inline'>\n";
    $bodyHTML .= "<input type=\"number\" class='form-control' id=\"" . $pizza->getId() . "\" min='0' value=\"" . $amount[$i] . "\">\n";
    $bodyHTML .= "<button class=\"btn btn-danger\" type=\"button\" value=\"" . $pizza->getId() . "\">Löschen</button>\n";
    $bodyHTML .= "</form>\n";


    $bodyHTML .= "</td>\n";


    $bodyHTML .= "</tr>\n";
    $ingredients = array();
}


$bodyHTML .= "</table>\n";

$bodyHTML .= "</div>\n";


$bodyHTML .= "</body>\n";

echo $bodyHTML;
?>

<form class="container-fluid col-md-5 col-md-offset-3" id="address-field">
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
        <div class="col-md-5">
            <label for="street">Straße</label>
            <input type="text" class="form-control" id="street" required>
        </div>
        <div class="col-md-2">
            <label for="number">Hausnummer</label>
            <input type="text" class="form-control" id="number" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <label for="zip">PLZ</label>
            <input type="text" class="form-control" id="zip" required>
        </div>
        <div class="col-md-5">
            <label for="city">Stadt</label>
            <input type="text" class="form-control" id="city" required>
        </div>
    </div>
    <button class="btn btn-primary pull-right" type="submit" id="submit_btn">Bestellen</button>
</form>