<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\cli\commands;

use Pizzaservice\Propel\Models\Customer;
use Pizzaservice\Propel\Models\CustomerQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class ListCustomersCommand
 *
 * @package Pizzaservice\cli\commands
 */
class ListCustomersCommand extends Command
{
    protected function configure()
    {
        $this->setName("list:customers");
        $this->setDescription("Listet alle Kunden");
        $this->setHelp("Dieser Befehl listet alle Kunden die in der Datenbank gespeichert sind");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customers = CustomerQuery::create()->find();

        foreach ($customers as $customer)
        {
            /** @var Customer $customer */
            echo "\nKunde #" . $customer->getId() . "\n";
            echo $customer->getFirstName() . " " . $customer->getLastName() . "\n";
            echo $customer->getStreet() . " " . $customer->getHouseNumber() . "\n";
            echo $customer->getPostCode() . " " . $customer->getPlace() . "\n\n";
        }
    }
}