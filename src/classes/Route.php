<?php

class Route {
    protected $id;
    protected $route_id;
    protected $name;

    public function __construct(array $data) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->route_id = $data['rId'];
        $this->name = $data['name'];
    }

    public function toArray() {
        $data = array('id' => $this->id,
                      'route_id' => $this->route_id,
                      'name' => $this->name);
        return $data;
    }
}