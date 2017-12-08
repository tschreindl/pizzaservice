<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Cli\Commands;

use Pizzaservice\Propel\Models\Customer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateCustomerCommand
 *
 * @package Pizzaservice\Cli\Commands
 */
class CreateCustomerCommand extends Command
{
    protected function configure()
    {
        $this->setName("create:customer");
        $this->setDescription("Erstellt einen Kunden");
        $this->setHelp("Dieser Befehl erstellt einen neuen Kunden in der Datenbank");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper("question");
        $question = new Question("Wie heißt der Kunden? (z.B. Max Mustermann)\n");
        $customerName = $helper->ask($input, $output, $question);
        if (!$customerName) return;

        $question = new Question("In welcher Straße und Hausnummer wohnt der Kunde? (z.B. Musterstrasse 1)\n");
        $street = $helper->ask($input, $output, $question);
        if (!$street) return;

        $question = new Question("In welchem Ort wohnt der Kunde? (z.B. 12345 Musterstadt)\n");
        $place = $helper->ask($input, $output, $question);
        if (!$place) return;

        echo "\nOkay du möchtest folgenden Kunden anlegen:\n\n->$customerName\n->$street\n->$place\n";

        $question = new ConfirmationQuestion("\nSoll der Kunde jetzt angelegt werden?\n", true, "/^(y|j)/i");

        if (!$helper->ask($input, $output, $question))
        {
            echo "Okay der Kunde wurde nicht angelegt!\n";
            return;
        }

        $customer = new Customer();
        $name = explode(" ", $customerName);
        $customer->setFirstName($name[0]);
        $customer->setLastName($name[1]);

        $street = explode(" ", $street);
        $customer->setStreet($street[0]);
        $customer->setHouseNumber($street[1]);

        $place = explode(" ", $place);
        $customer->setPostCode($place[0]);
        $customer->setPlace($place[1]);

        $customer->save();

        echo "Okay. Der Kunde $customerName wurde angelegt!\n";
    }
}