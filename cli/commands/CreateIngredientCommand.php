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
use Symfony\Component\Console\Question\Question;

/**
 * Class to create an ingredient.
 */
class CreateIngredientCommand extends Command
{
    /**
     * Configures the command create:ingredient.
     */
    protected function configure()
    {
        $this->setName("create:ingredient");
        $this->setDescription("Erstellt eine Zutat");
        $this->setHelp("Dieser Befehl erstellt eine Zutat für eine Pizza und speichert sie in der Datenbank");
    }

    /**
     * Lists all existing ingredients and creates a new ingredient based on the user input.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     * @throws \PropelException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo "\nFolgende Zutaten gibt es bereits:\n";
        $ingredients = IngredientQuery::create()->find();
        foreach ($ingredients as $ingredient)
        {
            $explode = explode("\n", $ingredient);
            echo "-> " . substr($explode[1], 6) . "\n";
        }
        echo "\n";

        $helper = $this->getHelper("question");

        $question = new Question("Wie soll die Zutat heißen?\n");

        $ingredientName = $helper->ask($input, $output, $question);
        if (!$ingredientName) return;

        $ingredient = new Ingredient();
        $ingredient->setName($ingredientName);
        $ingredient->save();
        echo "$ingredientName erfolgreich hinzugefügt\n";

    }
}