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
}