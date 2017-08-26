<?php

class Trip {
    protected $id;
    protected $trip_id;
    protected $name;
    protected $run_id;
    protected $route_id;

    public function __construct(array $data) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->trip_id = $data['tId'];
        $this->name = $data['name'];
        $this->run_id = $data['runId'];
        $this->route_id = $data['route_id'];
    }

    public function toArray() {
        $data = array('id' => $this->id,
                      'trip_id' => $this->trip_id,
                      'name' => $this->name,
                      'run_id' => $this->run_id,
                      'route_id' => $this->route_id);
        return $data;
    }
}