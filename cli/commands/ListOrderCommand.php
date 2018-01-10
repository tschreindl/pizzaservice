<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\cli\commands;

use Pizzaservice\Propel\Models\Customer;
use Pizzaservice\Propel\Models\Order;
use Pizzaservice\Propel\Models\OrderQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListOrderCommand
 *
 * @package Pizzaservice\cli\commands
 */
class ListOrderCommand extends Command
{
    protected function configure()
    {
        $this->setName("list:orders");
        $this->setDescription("Listet alle Bestellungen");
        $this->setHelp("Dieser Befehl listet alle Bestellungen die in der Datenbank gespeichert sind");
        $this->addOption("include-completed", null, InputOption::VALUE_NONE, "Abgeschlossene Bestellungen listen?");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption("include-completed"))
        {
            $orders = OrderQuery::create()->find();
        }
        else
        {
            $orders = OrderQuery::create()->filterByCompleted(false)->find();
        }

        if (!count($orders)) echo "Keine Bestellungen gefunden!";
        echo "\n\n";
        foreach ($orders as $order)
        {
            /** @var Order $order */
            $customers = $order->getCustomers();
            foreach ($customers as $customer)
            {
                /** @var Customer $customer */
                $output->writeln("Bestellung #" . $order->getId() . " für " . $customer->getFirstName() . " " . $customer->getLastName());
            }

            $pizzas = $order->getPizzaOrdersJoinPizza();
            foreach ($pizzas as $pizza)
            {
                $output->writeln("-> Pizza " . $pizza->getPizza()->getName() . " (" . $pizza->getAmount() . "x)");
            }
            $output->writeln("Summe: " . number_format($order->getTotal(), 2) . "€");
            if ($order->getCompleted())
            {
                $output->writeln("Status: Abgeschlossen\n\n");
            }
            else
            {
                $output->writeln("Status: In Bearbeitung\n\n");
            }
        }
    }
}