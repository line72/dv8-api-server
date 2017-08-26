<?php

class TripMapper extends Mapper {
    public function getTrips($route_id) {
        $sql = "SELECT t.id, t.tId, t.name, t.runId, t.route_id
            FROM trips t
            WHERE t.route_id = :route_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["route_id" => $route_id]);

        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new Trip($row);
        }

        return $results;
    }

    public function getTripById($trip_id) {
        $sql = "SELECT t.id, t.tId, t.name, t.runId, t.route_id
            FROM trips t
            WHERE t.id = :trip_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["trip_id" => $trip_id]);

        if ($result) {
            return new Trip($stmt->fetch());
        }

        return null;
    }
}
