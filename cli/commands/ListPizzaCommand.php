<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

use Pizzaservice\Propel\Models\IngredientQuery;
use Pizzaservice\Propel\Models\PizzaIngredientsQuery;
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
        $pizzas = PizzaQuery::create()->find();
        echo "\nEs gibt aktuell " . count($pizzas) . " Pizzen\n";
        $pizzaIds = array();
        $pizzaNames = array();
        foreach ($pizzas as $pizza)
        {
            $explode = explode("\n", $pizza);
            $pizzaIds[] = substr($explode[0], 3);
            $pizzaNames[] = substr($explode[1], 6);
        }

        foreach ($pizzaIds as $i => $pizzaId)
        {
            echo "\nPizza: " . $pizzaNames[$i] . "\n";
            $pizzaIngredients = PizzaIngredientsQuery::create()->findByPizzaId($pizzaId);
            echo "Zutaten:\n";
            foreach ($pizzaIngredients as $pizzaIngredient)
            {
                $explode = explode("\n", $pizzaIngredient);
                $ingredients = IngredientQuery::create()->findById(substr($explode[1], 14));
                foreach ($ingredients as $ingredient)
                {
                    $explode = explode("\n", $ingredient);
                    echo "-> " . substr($explode[1], 6) . "\n";
                }
            }
        }
        echo "\n";
    }
}