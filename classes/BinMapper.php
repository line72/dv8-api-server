<?php

class BinMapper extends Mapper {

    /**
     * Get a summary of waypoints in the range
     *  across ALL trips binned based
     *  on the bin size.
     */
    public function getWayPoints($start_date, $end_date, $bin_size = 3600) {
        $params = [];
        
        // create all the cases based on the bin size (in seconds)
        $interval = new DateInterval("PT" . $bin_size . "S");
        $current_date = clone $start_date;

        $sql = "SELECT w.date AS date, w.onBoard, w.trip_id,
                       t.id AS tripId, t.tId, t.name, t.runId, t.route_id,\n";
        $sql .= "  CASE\n";
        $index = 0;
        while ($current_date <= $end_date) {
            $next_date = clone $current_date;
            $next_date->add($interval);

            $var1 = "date_" . $index;
            $var2 = "date_" . ($index + 1);
            
            $sql .= "    WHEN date >= :" . $var1;
            $sql .= " AND date < :" . $var2 . " THEN \"". $index . "\"\n";
            
            $params[$var1] = $current_date->format('Y-m-d H:i:s.u');
            $params[$var2] = $next_date->format('Y-m-d H:i:s.u');

            $current_date = $next_date;
            $index += 1;
        }
        $sql .= "    ELSE \"_\"\n";
        $sql .= "  END as bin, COUNT(date) AS total, MAX(w.onBoard) as onBoardMax\n";
        $sql .= "FROM waypoints w\n";
        $sql .= "LEFT JOIN trips t\n";
        $sql .= "WHERE\n";
        $sql .= "  w.trip_id = tripId\n";

        if ($start_date != null) {
            $sql .= "  AND w.date >= :start_date\n";
            $params['start_date'] = $start_date->format('Y-m-d H:i:s.u');
        }
        if ($end_date != null) {
            $sql .= "  AND w.date <= :end_date\n";
            $params['end_date'] = $end_date->format('Y-m-d H:i:s.u');
        }
       
        $sql .= "GROUP BY w.trip_id, bin\n";
        $sql .= "ORDER BY bin ASC, t.route_id ASC, w.trip_id ASC\n";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute($params);

        $results = [];
        while ($row = $stmt->fetch()) {
            $bin = new WayPointBin($row);

            $tripData = array("id" => $row['trip_id'],
                              "tId" => $row['tId'],
                              "name" => $row['name'],
                              "runId" => $row['runId'],
                              "route_id" => $row['route_id']);
            $trip = new Trip($tripData);

            $bin->addTrip($trip);
            
            $results[] = $bin;
        }

        return $results;
    }
}