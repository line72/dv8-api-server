<?php
// Routes

$app->get('/routes', function ($request, $response, $args) {
    $mapper = new RouteMapper($this->db);
    $routes = $mapper->getRoutes();

    return $response->withJson(array_map(function($n) {
        return $n->toArray();
    }, $routes));
});

$app->get('/route/{id}', function ($request, $response, $args) {
    $mapper = new RouteMapper($this->db);
    $route = $mapper->getRouteById((int)$args['id']);

    return $response->withJson($route->toArray());
});
