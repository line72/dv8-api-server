<?php

class RouteMapper extends Mapper {
    public function getRoutes() {
        $sql = "SELECT r.id, r.rId, r.name
            FROM routes r";
        $stmt = $this->db->query($sql);

        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Route($row);
        }

        return $results;
    }

    public function getRouteById($route_id) {
        $sql = "SELECT r.id, r.rId, r.name
            FROM routes r
            WHERE r.id = :route_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["route_id" => $route_id]);

        if ($result) {
            return new Route($stmt->fetch());
        }

        return null;
    }
}