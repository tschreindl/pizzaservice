<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\cli\commands;

use Pizzaservice\Propel\Models\OrderQuery;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CompleteOrderCommand
 *
 * @package Pizzaservice\cli\commands
 */
class CompleteOrderCommand extends Command
{
    protected function configure()
    {
        $this->setName("complete:order");
        $this->setDescription("Schließt eine Bestellung ab.");
        $this->setHelp("Dieser Befehl schließt eine offene Bestellung in der Datenbank ab.");
        $this->addArgument("orderID", InputArgument::REQUIRED, "Die ID der Bestellung");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $orderID = $input->getArgument("orderID");
        $order = OrderQuery::create()->filterById($orderID)->findOne();
        if (!$order)
        {
            $output->writeln("Keine Bestellung mit der ID $orderID gefunden!");
        }
        else
        {
            if ($order->getCompleted())
            {
                $output->writeln("Bestellung mit der ID $orderID wurde bereits als abgeschlossen markiert.");
                return;
            }
            $order->setCompleted(true);
            $order->save();
            $output->writeln("Bestellung mit der ID $orderID wurde als abgeschlossen markiert.");
        }
    }
}