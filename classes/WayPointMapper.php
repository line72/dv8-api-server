<?php

class WayPointMapper extends Mapper {
    public function getWayPoints($trip_id, $start_date, $end_date, $limit = 1000, $page = 0) {
        $sql = "SELECT w.id, w.date, w.latitude, w.longitude,
                       w.deviation, w.opStatus, w.onBoard,
                       w.direction, w.driver, w.trip_id
                FROM waypoints w
                WHERE w.trip_id = :trip_id";

        $params = ['trip_id' => $trip_id, 'limit' => $limit];
        
        if ($start_date != null) {
            $sql .= " AND w.date >= :start_date";
            $params['start_date'] = $start_date->format('Y-m-d H:i:s.u');
        }
        if ($end_date != null) {
            $sql .= " AND w.date <= :end_date";
            $params['end_date'] = $end_date->format('Y-m-d H:i:s.u');
        }
        $sql .= " ORDER BY id ASC";
        $sql .= " LIMIT :limit";
        if ($page > 0) {
            $sql .= " OFFSET :offset";
            $params['offset'] = ($page * $limit);
        }

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($params);

        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new WayPoint($row);
        }

        return $results;
    }

    /**
     * Get waypoints in the range
     *  across ALL trips. Join with
     *  the trips and upstream routes.
     */
    public function getAllWayPoints($start_date, $end_date, $limit = 1000, $page = 0) {
        $sql = "SELECT w.id, w.date, w.latitude, w.longitude,
                       w.deviation, w.opStatus, w.onBoard,
                       w.direction, w.driver, w.trip_id,
                       t.id AS tripId, t.tId, t.name, t.runId, t.route_id
                FROM waypoints w
                LEFT JOIN trips t
                WHERE w.trip_id = tripId";

        $params = ['limit' => $limit];
        
        if ($start_date != null) {
            $sql .= " AND w.date >= :start_date";
            $params['start_date'] = $start_date->format('Y-m-d H:i:s.u');
        }
        if ($end_date != null) {
            $sql .= " AND w.date <= :end_date";
            $params['end_date'] = $end_date->format('Y-m-d H:i:s.u');
        }
        $sql .= " ORDER BY w.id ASC";
        $sql .= " LIMIT :limit";
        if ($page > 0) {
            $sql .= " OFFSET :offset";
            $params['offset'] = ($page * $limit);
        }

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($params);

        $results = [];
        while ($row = $stmt->fetch()) {
            $waypoint = new WayPoint($row);

            $tripData = array("id" => $row['trip_id'],
                              "tId" => $row['tId'],
                              "name" => $row['name'],
                              "runId" => $row['runId'],
                              "route_id" => $row['route_id']);

            $trip = new Trip($tripData);

            // add the trip to the waypoint
            $waypoint->addTrip($trip);
            
            $results[] = $waypoint;
        }

        return $results;
    }
}