<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\cli\commands;

use Pizzaservice\Propel\Models\CustomerQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;


/**
 * Class EditCustomerCommand
 *
 * @package Pizzaservice\cli\commands
 */
class EditCustomerCommand extends Command
{
    protected function configure()
    {
        $this->setName("edit:customer");
        $this->setDescription("Bearbeitet einen Kunden.");
        $this->setHelp("Dieser Befehl bearbeitet einen Kunden in der Datenbank.");
        $this->addArgument("customerID", InputArgument::REQUIRED, "Die ID des Kunden");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customerID = $input->getArgument("customerID");
        $customer = CustomerQuery::create()->filterById($customerID)->findOne();
        if (!$customer)
        {
            $output->writeln("Keinen Kunden mit der ID $customerID gefunden");
        }
        else
        {
            $helper = $this->getHelper("question");
            $question = new ChoiceQuestion("Was soll bearbeitet werden?", array("Vorname:         " . $customer->getFirstName(), "Nachname:        " . $customer->getLastName(), "Straße:          " . $customer->getStreet(), "Hausnummer:      " . $customer->getHouseNumber(), "Postleitzahl:    " . $customer->getPostCode(), "Wohnort:         " . $customer->getPlace() . "\n", "abbrechen"));
            $question->setMultiselect(true);
            $changes = $helper->ask($input, $output, $question);
            if (array_search("abbrechen", $changes) !== false) die("Bearbeiten abgebrochen.\n");
            foreach ($changes as $change)
            {
                if (stristr($change, "Vorname:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet der neue Vorname?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || is_numeric($answer)) die($answer . " ist nicht gültig!");
                    $customer->setFirstName(trim($answer));
                    $output->writeln("Vorname zu $answer geändert.\n");
                }
                if (stristr($change, "Nachname:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet der neue Nachname?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || is_numeric($answer)) die($answer . " ist nicht gültig!");
                    $customer->setLastName(trim($answer));
                    $output->writeln("Nachname zu $answer geändert.\n");
                }
                if (stristr($change, "Straße:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet die neue Straße?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || is_numeric($answer)) die($answer . " ist nicht gültig!");
                    $customer->setStreet(trim($answer));
                    $output->writeln("Straße zu $answer geändert.\n");
                }
                if (stristr($change, "Hausnummer:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet die neue Hausnummer?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || !ctype_alnum($answer) || !is_numeric(substr($answer, 0, 1))) die($answer . " ist nicht gültig!");
                    $customer->setHouseNumber(trim($answer));
                    $output->writeln("Hausnummer zu $answer geändert.\n");
                }
                if (stristr($change, "Postleitzahl:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet die neue Postleitzahl?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || !is_numeric($answer)) die($answer . " ist nicht gültig!");
                    $customer->setPostCode(trim($answer));
                    $output->writeln("Postleitzahl zu $answer geändert.\n");
                }
                if (stristr($change, "Wohnort:"))
                {
                    $helper = $this->getHelper("question");
                    $question = new Question("Wie lautet der neue Wohnort?\n");
                    $answer = $helper->ask($input, $output, $question);
                    if (!$answer || is_numeric($answer)) die($answer . " ist nicht gültig!");
                    $customer->setPlace(trim($answer));
                    $output->writeln("Wohnort zu $answer geändert.\n");
                }
            }
            $customer->save();
        }
    }
}