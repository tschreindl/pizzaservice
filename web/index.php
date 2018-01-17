<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require "../vendor/autoload.php";

Propel::init(__DIR__ . "/../propel/conf/pizzaservice-conf.php");

session_start();

use Pizzaservice\Lib\Web\LayoutHelper;
use Pizzaservice\Propel\Models\Pizza;
use Pizzaservice\Propel\Models\PizzaQuery;

$layoutHelper = new LayoutHelper();

echo $layoutHelper->renderHead("pizza");

echo $layoutHelper->renderHeader("pizza");

/** @var Pizza[] $pizzas */
$pizzas = PizzaQuery::create()->find();
$ingredients = array();

$bodyHTML[] = "    <table>";
$bodyHTML[] = "        <tr>";
$bodyHTML[] = "            <th>Pizza</th>";
$bodyHTML[] = "            <th>Zutaten</th>";
$bodyHTML[] = "            <th>Preis</th>";
$bodyHTML[] = "            <th>Bestellung</th>";
$bodyHTML[] = "        </tr>";
foreach ($pizzas as $pizza)
{
    $bodyHTML[] = "        <tr>";
    $bodyHTML[] = "            <td>" . $pizza->getName() . "</td>";
    foreach ($pizza->getIngredients() as $ingredient)
    {
        $ingredients[] = $ingredient->getName();
    }

    $bodyHTML[] = "            <td>" . implode(", ", $ingredients) . "</td>";
    $bodyHTML[] = "            <td>" . number_format($pizza->getPrice(), 2) . "€</td>";
    $bodyHTML[] = "            <td>";

    $bodyHTML[] = "                <form class='form-inline'>";
    $bodyHTML[] = "                    <input type=\"number\" class='form-control' id=\"" . $pizza->getId() . "\" min='0'>";
    $bodyHTML[] = "                    <button class=\"btn btn-primary\" type=\"button\" value=\"" . $pizza->getId() . "\">Bestellen</button>";
    $bodyHTML[] = "                </form>";


    $bodyHTML[] = "            </td>";


    $bodyHTML[] = "        </tr>";
    $ingredients = array();
}

$bodyHTML[] = "    </table>\n";

echo implode("\n", $bodyHTML);

echo $layoutHelper->renderFooter();

