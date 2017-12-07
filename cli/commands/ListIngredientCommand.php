<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

require_once __DIR__ . "/../../vendor/autoload.php";

use Pizzaservice\Propel\Models\Ingredient;
use Pizzaservice\Propel\Models\IngredientQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class to list all ingredients in the database.
 *
 * @package Pizzaservice\Cli\Commands
 */
class ListIngredientCommand extends Command
{
    /**
     * Configures the command list:ingredients.
     */
    protected function configure()
    {
        $this->setName("list:ingredients");
        $this->setDescription("Listet alle Zutaten");
        $this->setHelp("Dieser Befehl listet alle Zutaten die in der Datenbank gespeichert sind");
    }

    /**
     * Reads all ingredients from the database and prints it to the user.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ingredients = IngredientQuery::create()->find();
        echo "\nEs gibt aktuell " . count($ingredients) . " Zutaten\n";
        foreach ($ingredients as $ingredient)
        {
            /** @var Ingredient $ingredient */
            echo "\n-> " . $ingredient->getName();
        }
        echo "\n";
    }
}