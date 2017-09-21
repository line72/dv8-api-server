<?php

class WayPoint {
    protected $id;
    protected $date;
    protected $latitude;
    protected $longitude;
    protected $deviation;
    protected $op_status;
    protected $on_board;
    protected $direction;
    protected $driver;
    protected $trip_id;
    protected $trip;

    public function __construct(array $data) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->date = $data['date'];
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
        $this->deviation = $data['deviation'];
        $this->op_status = $data['opStatus'];
        $this->on_board = $data['onBoard'];
        $this->direction = $data['direction'];
        $this->driver = $data['driver'];
        $this->trip_id = $data['trip_id'];

        $this->trip = null;
    }

    public function addTrip($trip) {
        $this->trip = $trip;
    }

    public function toArray() {
        $data = array('id' => $this->id,
                      'date' => $this->date,
                      'latitude' => $this->latitude,
                      'longitude' => $this->longitude,
                      'deviation' => $this->deviation,
                      'op_status' => $this->op_status,
                      'on_board' => $this->on_board,
                      'direction' => $this->direction,
                      'driver' => $this->driver,
                      'trip_id' => $this->trip_id);

        if ($this->trip != null) {
            $data['trip'] = $this->trip->toArray();
        }
        
        return $data;
    }
}