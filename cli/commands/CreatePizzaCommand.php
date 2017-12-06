<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

require_once __DIR__ . "/../../vendor/autoload.php";

use Pizzaservice\Propel\Models\IngredientQuery;
use Pizzaservice\Propel\Models\Pizza;
use Pizzaservice\Propel\Models\PizzaQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class to create a pizza with its ingredients.
 *
 * @package Pizzaservice\Cli\Commands
 */
class CreatePizzaCommand extends Command
{
    /**
     * Configures the command create:pizza.
     */
    protected function configure()
    {
        $this->setName("create:pizza");
        $this->setDescription("Erstellt eine Pizza");
        $this->setHelp("Dieser Befehl erstellt eine Pizza und speichert sie in der Datenbank");
    }

    /**
     * Runs through a Question/Answer query to ask the user which name and ingredients the pizza should have.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     * @throws \PropelException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pizzas = PizzaQuery::create()->find();
        echo "\nFolgende Pizzen gibt es bereits:\n";

        foreach ($pizzas as $pizza)
        {
            $explode = explode("\n", $pizza);
            echo "-> " . substr($explode[1], 6) . "\n";
        }
        echo "\n";

        $helper = $this->getHelper("question");

        $question = new Question("Wie soll die Pizza heißen?\n");

        $pizzaName = $helper->ask($input, $output, $question);
        if (!$pizzaName) return;

        $question = new Question("Was soll die Pizza kosten (€)?\n");

        $price = $helper->ask($input, $output, $question);
        if (!$price) return;

        echo "Okay du hast dich für eine Pizza $pizzaName für $price € entschieden.\n\n";

        $ingredients = IngredientQuery::create()->find();
        $ingredientsArray = array();

        foreach ($ingredients as $ingredient)
        {
            $explode = explode("\n", $ingredient);
            $ingredientsArray[] = substr($explode[1], 6);
        }

        $question = new ChoiceQuestion("Bitte Zutaten für die Pizza angeben:", $ingredientsArray);
        $question->setMultiselect(true);
        $selectedIngredients = $helper->ask($input, $output, $question);
        echo "Du hast folgende Zutaten ausgewählt: " . implode(", ", $selectedIngredients) . "\n";

        $question = new ConfirmationQuestion("Möchtest du die Pizza jetzt erstellen?\n", true, "/^(y|j)/i");

        if (!$helper->ask($input, $output, $question))
        {
            echo "Okay die Pizza wurde nicht erstellt!\n";
            return;
        }

        $newPizza = new Pizza();
        $newPizza->setName($pizzaName);
        $newPizza->setPrice($price);

        foreach ($selectedIngredients as $selectedIngredient)
        {
            foreach ($ingredients as $ingredient)
            {
                if (stristr($ingredient, $selectedIngredient)) $newPizza->addIngredient($ingredient);
            }

        }

        $newPizza->save();

        echo "Okay die Pizza $pizzaName wurde erstellt!\n";

    }

}