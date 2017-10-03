<?php

class WayPointBin {
    protected $name;
    protected $start;
    protected $end;
    protected $total;
    protected $on_board_max;
    protected $trip_id;
    protected $trip;

    public function __construct(array $data) {
        $this->name = $data['bin'];
        $this->total = $data['total'];
        $this->on_board_max = $data['onBoardMax'];
        $this->trip_id = $data['trip_id'];
        
        $this->trip = null;
    }

    public function addTrip($trip) {
        $this->trip = $trip;
    }

    public function toArray() {
        $data = array('name' => $this->name,
                      'total' => $this->total,
                      'on_board_max' => $this->on_board_max,
                      'trip_id' => $this->trip_id);

        if ($this->trip != null) {
            $data['trip'] = $this->trip->toArray();
        }
        
        return $data;
    }
}