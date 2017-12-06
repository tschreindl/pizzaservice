<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli;

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4("Pizzaservice\\Cli\\Commands\\", __DIR__ . "/commands");

use Pizzaservice\Cli\Commands\CreateIngredientCommand;
use Pizzaservice\Cli\Commands\CreatePizzaCommand;
use Pizzaservice\Cli\Commands\ListIngredientCommand;
use Pizzaservice\Cli\Commands\ListPizzaCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CreateIngredientCommand());
$application->add(new CreatePizzaCommand());
$application->add(new ListIngredientCommand());
$application->add(new ListPizzaCommand());
$application->run();