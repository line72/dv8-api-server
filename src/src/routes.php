<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $mapper = new RouteMapper($this->db);
    $routes = $mapper->getRoutes();

    return $response->withJson(array_map(function($n) {
        return $n->toArray();
    }, $routes));
});
