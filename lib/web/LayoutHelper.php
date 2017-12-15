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
    function renderHead()
    {
        $headHTML = "<!DOCTYPE html>\n";
        $headHTML .= "<html lang=\"en\">\n";
        $headHTML .= "<head>\n";
        $headHTML .= "    <meta charset=\"UTF-8\">\n";
        $headHTML .= "    <title>Pizzaservice</title>\n";
        $headHTML .= "    <link href=\"" . $this->basePath() . "vendor/twbs/bootstrap/dist/css/bootstrap.css\" rel=\"stylesheet\">\n";
        $headHTML .= "    <link href=\"" . $this->basePath() . "web/css/main.css\" rel=\"stylesheet\">\n";
        $headHTML .= "    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>\n";
        $headHTML .= "    <script src=\"" . $this->basePath() . "web/js/javascript.js\"></script>\n";
        $headHTML .= "</head>\n";

        return $headHTML;

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

        $bodyHTML = "<body>\n";
        $bodyHTML .= "<div class=\"container\">\n";
        $bodyHTML .= "<div class=\"navbar navbar-default navbar-static-top\">\n";
        $bodyHTML .= "<a href=\"index.php\" class=\"navbar-brand\">PizzaService</a>\n";
        $bodyHTML .= "<ul class=\"nav navbar-nav nav-pills\">\n";
        if ($_activeMenu == "pizza")
        {
            $bodyHTML .= "<li class=\"nav-item active\"><a href=\"index.php\">Pizzakarte</a></li>\n";
            $bodyHTML .= "<li class=\"nav-item\"><a href=\"order/index.php\">Bestellung<sup id=\"counter\">" . $counter . "</sup></a></li>\n";
        }
        else if ($_activeMenu == "order")
        {
            $bodyHTML .= "<li class=\"nav-item\"><a href=\"../index.php\">Pizzakarte</a></li>\n";
            $bodyHTML .= "<li class=\"nav-item active\"><a href=\"index.php\">Bestellung<sup id=\"counter\">" . $counter . "</sup></a></li>\n";
        }
        $bodyHTML .= "</ul>\n";
        $bodyHTML .= "</div>\n";

        return $bodyHTML;
    }

    function renderFooter()
    {


    }

    private function basePath()
    {
        $basedir = realpath(__DIR__ . "../../..");
        $replace = str_replace($basedir, "", getcwd());
        $count = substr_count($replace, "\\");
        $path = "";

        for ($i = 1; $i <= $count; $i++)
        {
            $path .= "../";
        }

        return $path;
    }
}