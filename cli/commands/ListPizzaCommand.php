<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

use Pizzaservice\Propel\Models\Ingredient;
use Pizzaservice\Propel\Models\IngredientQuery;
use Pizzaservice\Propel\Models\Pizza;
use Pizzaservice\Propel\Models\PizzaIngredient;
use Pizzaservice\Propel\Models\PizzaIngredientQuery;
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
            /** @var Pizza $pizza */
            $pizzaIds[] = $pizza->getId();
            $pizzaNames[] = $pizza->getName();
        }

        foreach ($pizzaIds as $i => $pizzaId)
        {
            echo "\nPizza: " . $pizzaNames[$i] . "\n";
            $pizzaIngredients = PizzaIngredientQuery::create()->findByPizzaId($pizzaId);
            echo "Zutaten:\n";
            foreach ($pizzaIngredients as $pizzaIngredient)
            {
                /** @var PizzaIngredient $pizzaIngredient */
                $ingredients = IngredientQuery::create()->findById($pizzaIngredient->getIngredientId());
                foreach ($ingredients as $ingredient)
                {
                    /** @var Ingredient $ingredient */
                    echo "-> " . $ingredient->getName() . "\n";
                }
            }
        }
        echo "\n";
    }
}