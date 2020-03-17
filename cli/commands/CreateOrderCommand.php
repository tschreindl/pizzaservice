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
use Pizzaservice\Propel\Models\Order;
use Pizzaservice\Propel\Models\Pizza;
use Pizzaservice\Propel\Models\PizzaOrder;
use Pizzaservice\Propel\Models\PizzaQuery;
use PropelCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateOrderCommand
 *
 * @package Pizzaservice\cli\commands
 */
class CreateOrderCommand extends Command
{
    protected function configure()
    {
        $this->setName("create:order");
        $this->setDescription("Erstellt eine Bestellung");
        $this->setHelp("Dieser Befehl erstellt eine neue Bestellung in der Datenbank");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customers = CustomerQuery::create()->find();
        $customersArray = array();
        foreach ($customers as $customer)
        {
            /** @var Customer $customer */
            $customersArray[] = $customer->getFirstName() . " " . $customer->getLastName() . ", " . $customer->getStreet() . " " . $customer->getHouseNumber() . ", " . $customer->getPostCode() . " " . $customer->getPlace();
        }

        $helper = $this->getHelper("question");
        $question = new ChoiceQuestion("Für wen ist die Bestellung?\n", $customersArray);
        $question->setMultiselect(false);
        $customerID = array_search($helper->ask($input, $output, $question), $customersArray);

        $pizzas = PizzaQuery::create()->find();
        $pizzaArray = array();
        foreach ($pizzas as $pizza)
        {
            /** @var Pizza $pizza */
            $pizzaArray[] = "Pizza " . $pizza->getName() . " für " . number_format($pizza->getPrice(), 2) . "€";
        }

        $order = new Order();
        $order->addCustomer($customers[$customerID]);
        $order->setDate(date('Y-m-d'));
        $order->setTime(date("H:i:s"));

        $question = new ChoiceQuestion("\nWas möchte der Kunde bestellen?\n", $pizzaArray);
        $question->setMultiselect(true);
        $total = 0;
        $dataCollection = array();
        foreach ($helper->ask($input, $output, $question) as $answer)
        {
            $amountQuestion = new Question("\nWie viele $answer?\n", 1);
            $amount = $helper->ask($input, $output, $amountQuestion);
            if (!is_numeric($amount)) return;

            $pizzaID = array_search($answer, $pizzaArray);
            $total += $amount * $pizzas[$pizzaID]->getPrice();

            $pizzaOrder = new PizzaOrder();
            $pizzaOrder->setPizza($pizzas[$pizzaID]);
            $pizzaOrder->setOrder($order);
            $pizzaOrder->setAmount($amount);
            $dataCollection[] = $pizzaOrder;
        }

        $order->setTotal($total);
        $collection = new PropelCollection();
        $collection->setData($dataCollection);
        $order->setPizzaOrders($collection);

        $question = new ConfirmationQuestion("\nSoll deine Bestellung über " . number_format($total, 2) . "€ aufgegeben werden?\n", true, "/^(y|j)/i");

        if (!$helper->ask($input, $output, $question))
        {
            echo "Okay deine Bestellung wurde storniert!\n";
            return;
        }

        $order->save();
        echo "Okay deine Bestellung wurde aufgegeben!\n";
    }
}