<?php

declare(strict_types=1);

namespace Mos\Router;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

use Jonkul\Dice\Game21;


/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/session/destroy21") {
            destroySession();
            redirectTo(url("/dice21"));
            return;
        } else if ($method === "GET" && $path === "/throw") {
            $_SESSION["throw"] = 1;
            
            $callable = new Game21;
            $callable->playGame21();

            return;
        
        } else if ($method === "GET" && $path === "/cthrow") {
            $_SESSION["cthrow"] = 1;
            
            $callable = new Game21;
            $callable->playGame21();

            return;

        } else if ($method === "GET" && $path === "/clear") {
            $_SESSION["cthrow"] = null;
            $_SESSION["throw"] = null;
            $_SESSION["hold"] = null;
            $_SESSION["cpuwon"] = null;
            $_SESSION["pwon"] = null;
            $_SESSION["dieNum"] = null;
            $_SESSION["playerDH"] = null;
            $_SESSION["playerDHLastSumTot"] = null;
            $_SESSION["playerDHLastSum"] = null;
            $_SESSION["playerDHFinalSumTot"] = null;
            $_SESSION["status"] = null;
            $_SESSION["playerClose"] = null;
            $_SESSION["cpuDH"] = null;
            $_SESSION["cpuDHLastSumTot"] = null;
            $_SESSION["cpuDHFinalSumTot"] = null;
            $_SESSION["cpuClose"] = null;
            $_SESSION["rounddone"] = null;
            
            redirectTo(url("/dice21"));

        return;

        } else if ($method === "GET" && $path === "/clearL") {
            $_SESSION["cpuwin"] = null;
            $_SESSION["pwin"] = null;
            
            redirectTo(url("/dice21"));

        return;

        } else if ($method === "GET" && $path === "/hold") {
            $_SESSION["hold"] = 1;
            $_SESSION["throw"] = 1;
            
            $callable = new Game21;
            $callable->playGame21();

            return;

        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dice") {
            $callable = new \Jonkul\Dice\Game();
            $callable->playGame();

            return;
        } else if ($method === "GET" && $path === "/dice21") {
            $data = [
            "header" => "Game 21",
            "message" => "A little PHP Black Jack game",
            "action" => url("/dice21/process"),
            "dieNum" => $_SESSION["dieNum"] ?? null,
            "pwin" => $_SESSION["pwin"] ?? null,
            "cpuwin" => $_SESSION["cpuwin"] ?? null
            ];
            $body = renderView("layout/dice21.php", $data);
            sendResponse($body);
            return;

        } else if ($method === "GET" && $path === "/form/view") {
            $data = [
                "header" => "Form",
                "message" => "Press submit to send the message to the result page.",
                "action" => url("/form/process"),
                "output" => $_SESSION["output"] ?? null,
            ];
            $body = renderView("layout/form.php", $data);
            sendResponse($body);
            return;

        } else if ($method === "POST" && $path === "/form/process") {
            $_SESSION["output"] = $_POST["content"] ?? null;
            redirectTo(url("/form/view"));
            return;

        } else if ($method === "POST" && $path === "/dice21/process") {
            $_SESSION["dieNum"] = $_POST["content"] ?? null;
            redirectTo(url("/dice21"));
            return;
        }

        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
