<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require_once "vendor/autoload.php";

Propel::init(__DIR__ . "/propel/conf/pizzaservice-conf.php");

use Pizzaservice\Propel\Models\Ingredient;
use Pizzaservice\Propel\Models\Pizza;

/**
 * Script to test if the creation of a pizza and an ingredient works correctly.
 */

$ingredient = new Ingredient();
$ingredient->setName("Salami");

$pizza = new Pizza();
$pizza->setName("Salami");
$pizza->setPrice(5.90);
$pizza->addIngredient($ingredient);
$pizza->save();