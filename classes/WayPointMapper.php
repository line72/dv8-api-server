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
}