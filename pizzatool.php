<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

//namespace Pizzaservice\Cli;

require __DIR__ . "/vendor/autoload.php";

Propel::init(__DIR__ . "/propel/conf/pizzaservice-conf.php");

use Pizzaservice\Cli\Commands\CreateCustomerCommand;
use Pizzaservice\Cli\Commands\CreateIngredientCommand;
use Pizzaservice\cli\commands\CreateOrderCommand;
use Pizzaservice\Cli\Commands\CreatePizzaCommand;
use Pizzaservice\Cli\Commands\ListIngredientCommand;
use Pizzaservice\Cli\Commands\ListPizzaCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CreateIngredientCommand());
$application->add(new CreatePizzaCommand());
$application->add(new CreateOrderCommand());
$application->add(new CreateCustomerCommand());
$application->add(new ListIngredientCommand());
$application->add(new ListPizzaCommand());

$application->run();