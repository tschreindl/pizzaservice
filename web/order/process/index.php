<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require __DIR__ . "/../../../vendor/autoload.php";

Propel::init(__DIR__ . "/../../../propel/conf/pizzaservice-conf.php");

session_start();

use Pizzaservice\Propel\Models\Customer;
use Pizzaservice\Propel\Models\Order;
use Pizzaservice\Propel\Models\PizzaOrder;
use Pizzaservice\Propel\Models\PizzaQuery;

$firstName = $_GET["first_name"];
$lastName = $_GET["last_name"];
$street = $_GET["street"];
$number = $_GET["number"];
$zip = $_GET["zip"];
$city = $_GET["city"];

$customer = new Customer();
$customer->setFirstName($firstName);
$customer->setLastName($lastName);
$customer->setStreet($street);
$customer->setHouseNumber($number);
$customer->setPostCode($zip);
$customer->setPlace($city);

$order = new Order();
$order->addCustomer($customer);
$order->setDate(date("Y-m-d"));
$order->setTime(date("H:i:s"));

if (isset($_SESSION["order"]))
{
    $pizzaIds = array();
    $amount = array();
    foreach ($_SESSION["order"] as $singleOrder)
    {
        $pizzaIds[] = $singleOrder[0];
        $amount[] = $singleOrder[1];
    }

    $pizzas = PizzaQuery::create()->findPks($pizzaIds);
    $total = 0;
    $dataCollection = array();
    foreach ($pizzas as $i => $pizza)
    {
        $total += $amount[$i] * $pizza->getPrice();
        $pizzaOrder = new PizzaOrder();
        $pizzaOrder->setOrder($order);
        $pizzaOrder->setPizza($pizza);
        $pizzaOrder->setAmount($amount[$i]);
        $dataCollection[] = $pizzaOrder;
    }
    $collection = new PropelCollection();
    $collection->setData($dataCollection);
    $order->setPizzaOrders($collection);
    $order->setTotal($total);
    $order->setCompleted(false);

    $order->save();

    unset($_SESSION["order"]);
}