<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

use Pizzaservice\Propel\Models\Pizza;
use Pizzaservice\Propel\Models\PizzaQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class to list all pizzas in the database.
 *
 * @package Pizzaservice\Cli\Commands
 */
class ListPizzaCommand extends Command
{
    /**
     * Configures the command list:pizza.
     */
    protected function configure()
    {
        $this->setName("list:pizza");
        $this->setDescription("Listet alle Pizzen mit Zutaten");
        $this->setHelp("Dieser Befehl listet alle Pizzen mit deren Zutaten die in der Datenbank gespeichert sind");
    }

    /**
     * Reads all pizzas and ingredients from the database and prints it to the user.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Pizza[] $pizzas */
        $pizzas = PizzaQuery::create()->find();
        echo "\nEs gibt aktuell " . count($pizzas) . " Pizzen\n";
        foreach ($pizzas as $pizza)
        {
            echo "\nPizza: " . $pizza->getName() . "\n";
            $ingredients = $pizza->getIngredients();
            echo "Zutaten:\n";
            foreach ($ingredients as $ingredient)
            {
                echo "-> " . $ingredient->getName() . "\n";
            }
        }
    }
}