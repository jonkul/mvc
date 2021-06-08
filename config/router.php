<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? null;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
    $router->addRoute("GET", "/destroy21", ["\Mos\Controller\Session", "destroy21"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});

$router->addGroup("/dice", function (RouteCollector $router) {
    $router->addRoute("GET", "/playGame", ["\Mos\Controller\Game", "playGame"]);
});

$router->addGroup("/dice21", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Game21", "index"]);
    $router->addRoute("GET", "/throw", ["\Mos\Controller\Game21", "throw"]);
    $router->addRoute("GET", "/cthrow", ["\Mos\Controller\Game21", "cthrow"]);
    $router->addRoute("GET", "/clear", ["\Mos\Controller\Game21", "clear"]);
    $router->addRoute("GET", "/clearL", ["\Mos\Controller\Game21", "clearL"]);
    $router->addRoute("GET", "/hold", ["\Mos\Controller\Game21", "hold"]);
    $router->addRoute("GET", "/playGame21", ["\Mos\Controller\Game21", "playGame21ctrl"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Game21", "process"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Yatzy", "playGame"]);
    $router->addRoute("GET", "/roll", ["\Mos\Controller\Yatzy", "roll"]);
    $router->addRoute("GET", "/round", ["\Mos\Controller\Yatzy", "round"]);
    $router->addRoute("GET", "/reset", ["\Mos\Controller\Yatzy", "reset"]);
    $router->addRoute("GET", "/save0", ["\Mos\Controller\Yatzy", "save0"]);
    $router->addRoute("GET", "/save1", ["\Mos\Controller\Yatzy", "save1"]);
    $router->addRoute("GET", "/save2", ["\Mos\Controller\Yatzy", "save2"]);
    $router->addRoute("GET", "/save3", ["\Mos\Controller\Yatzy", "save3"]);
    $router->addRoute("GET", "/save4", ["\Mos\Controller\Yatzy", "save4"]);
});

$router->addGroup("/yatzyF", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\YatzyF", "playGame"]);
});
