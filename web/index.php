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

echo $layoutHelper->renderHead();

echo $layoutHelper->renderHeader("pizza");

/** @var Pizza[] $pizzas */
$pizzas = PizzaQuery::create()->find();
$ingredients = array();

$bodyHTML = "<table>\n";
$bodyHTML .= "<tr>\n";
$bodyHTML .= "<th>Pizza</th>\n";
$bodyHTML .= "<th>Zutaten</th>\n";
$bodyHTML .= "<th>Bestellung</th>\n";
$bodyHTML .= "</tr>\n";
foreach ($pizzas as $pizza)
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
    $bodyHTML .= "<input type=\"number\" class='form-control' id=\"" . $pizza->getId() . "\" min='0'>\n";
    $bodyHTML .= "<button class=\"btn btn-primary\" type=\"button\" value=\"" . $pizza->getId() . "\">Bestellen</button>\n";
    $bodyHTML .= "</form>\n";


    $bodyHTML .= "</td>\n";


    $bodyHTML .= "</tr>\n";
    $ingredients = array();
}


$bodyHTML .= "</table>\n";


$bodyHTML .= "</div>\n";


$bodyHTML .= "</body>\n";

echo $bodyHTML;

