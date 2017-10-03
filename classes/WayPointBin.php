<?php

class WayPointBin {
    protected $name;
    protected $start;
    protected $end;
    protected $total;
    protected $on_board_max;
    protected $on_board_min;
    protected $on_board_avg;
    protected $deviation_max;
    protected $deviation_min;
    protected $deviation_avg;
    protected $trip_id;
    protected $trip;

    public function __construct(array $data) {
        $this->name = $data['bin'];
        $this->total = $data['total'];
        $this->on_board_max = $data['onBoardMax'];
        $this->on_board_min = $data['onBoardMin'];
        $this->on_board_avg = $data['onBoardAvg'];
        $this->deviation_max = $data['deviationMax'];
        $this->deviation_min = $data['deviationMin'];
        $this->deviation_avg = $data['deviationAvg'];
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
                      'on_board_min' => $this->on_board_min,
                      'on_board_avg' => $this->on_board_avg,
                      'deviation_max' => $this->deviation_max,
                      'deviation_min' => $this->deviation_min,
                      'deviation_avg' => $this->deviation_avg,
                      'trip_id' => $this->trip_id);

        if ($this->trip != null) {
            $data['trip'] = $this->trip->toArray();
        }
        
        return $data;
    }
}