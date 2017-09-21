<?php

// Add in CORS Support
// https://www.slimframework.com/docs/cookbook/enable-cors.html
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

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

$app->get('/route/{route_id}/trips', function ($request, $response, $args) {
    $mapper = new TripMapper($this->db);
    $trips = $mapper->getTrips((int)$args['route_id']);

    return $response->withJson(array_map(function($n) {
        return $n->toArray();
    }, $trips));
});

$app->get('/route/{route_id}/trip/{trip_id}', function ($request, $response, $args) {
    $mapper = new TripMapper($this->db);
    $trip = $mapper->getTripById((int)$args['trip_id']);

    return $response->withJson($trip->toArray());
});

$app->get('/route/{route_id}/trip/{trip_id}/waypoints', function ($request, $response, $args) {
    $mapper = new WayPointMapper($this->db);

    // check for some optional args:
    // start_date
    // end_data
    // limit
    // page
    $start_date = null;
    $end_date = null;
    $limit = 1000;
    $page = 0;
    
    $params = $request->getQueryParams();
    if (key_exists('start_date', $params)) {
        $start_date = new DateTime($params['start_date']);
    }
    if (key_exists('end_date', $params)) {
        $end_date = new DateTime($params['end_date']);
    }
    if (key_exists('limit', $params)) {
        $limit = (int)$params['limit'];
        if ($limit > 1000)
            $limit = 1000;
    }
    if (key_exists('page', $params)) {
        $page = $params['page'];
    }
    
    $waypoints = $mapper->getWayPoints((int)$args['trip_id'],
                                       $start_date, $end_date,
                                       $limit, $page);

    return $response->withJson(array_map(function($n) {
        return $n->toArray();
    }, $waypoints));
});

$app->get('/waypoints', function($request, $response, $args) {
    $mapper = new WayPointMapper($this->db);

    // check for some optional args:
    // start_date
    // end_data
    // limit
    // page
    $start_date = null;
    $end_date = null;
    $limit = 1000;
    $page = 0;
    
    $params = $request->getQueryParams();
    if (key_exists('start_date', $params)) {
        $start_date = new DateTime($params['start_date']);
    }
    if (key_exists('end_date', $params)) {
        $end_date = new DateTime($params['end_date']);
    }
    if (key_exists('limit', $params)) {
        $limit = (int)$params['limit'];
        if ($limit > 1000)
            $limit = 1000;
    }
    if (key_exists('page', $params)) {
        $page = $params['page'];
    }

    $waypoints = $mapper->getAllWayPoints($start_date, $end_date,
                                          $limit, $page);

    return $response->withJson(array_map(function($n) {
        return $n->toArray();
    }, $waypoints));
});