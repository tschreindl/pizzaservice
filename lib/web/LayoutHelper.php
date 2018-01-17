<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Pizzaservice\Lib\Web;

/**
 * Class LayoutHelper
 *
 * @package Pizzaservice\lib\web
 */
class LayoutHelper
{
    function renderHead($_activeMenu)
    {
        $headHTML[] = "<!DOCTYPE html>";
        $headHTML[] = "<html lang=\"de\">";
        $headHTML[] = "<head>";
        $headHTML[] = "    <meta charset=\"UTF-8\">";
        $headHTML[] = "    <title>Pizzaservice</title>";
        $path = "../";
        if ($_activeMenu == "order")
        {
            $path = "../../";
        }
        $headHTML[] = "    <script src=\"" . $path . "vendor/components/jquery/jquery.min.js\"></script>";
        $headHTML[] = "    <script src=\"" . $path . "web/js/" . $_activeMenu . ".js\"></script>";
        $headHTML[] = "    <link href=\"" . $path . "vendor/twbs/bootstrap/dist/css/bootstrap.css\" rel=\"stylesheet\">";
        $headHTML[] = "    <link href=\"" . $path . "web/css/main.css\" rel=\"stylesheet\">";
        $headHTML[] = "</head>\n";

        return implode("\n", $headHTML);

    }

    function renderHeader(string $_activeMenu)
    {
        $counter = 0;
        if (isset($_SESSION["order"]))
        {
            foreach ($_SESSION["order"] as $order)
            {
                $counter += $order[1];
            }
        }

        $bodyHTML[] = "<body>";
        $bodyHTML[] = "<div class=\"container\">";
        $bodyHTML[] = "    <div class=\"navbar navbar-default navbar-static-top\">";
        $bodyHTML[] = "        <a href=\"index.php\" class=\"navbar-brand\">PizzaService</a>";
        $bodyHTML[] = "        <ul class=\"nav navbar-nav nav-pills\">";
        if ($_activeMenu == "pizza")
        {
            $bodyHTML[] = "            <li class=\"nav-item active\"><a href=\"index.php\">Pizzakarte</a></li>";
            $bodyHTML[] = "            <li class=\"nav-item\"><a href=\"order/index.php\">Bestellung<sup id=\"counter\">" . $counter . "</sup></a></li>";
        }
        else if ($_activeMenu == "order")
        {
            $bodyHTML[] = "            <li class=\"nav-item\"><a href=\"../index.php\">Pizzakarte</a></li>";
            $bodyHTML[] = "            <li class=\"nav-item active\"><a href=\"index.php\">Bestellung<sup id=\"counter\">" . $counter . "</sup></a></li>";
        }
        $bodyHTML[] = "        </ul>";
        $bodyHTML[] = "    </div>";

        return implode("\n", $bodyHTML);
    }

    function renderFooter()
    {
        $footerHTML[] = "</div>";
        $footerHTML[] = "</body>";
        $footerHTML[] = "</html>";
        return implode("\n", $footerHTML);
    }
}