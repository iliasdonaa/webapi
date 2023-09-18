<?php
namespace iliasdonaa\webapi;

class Synchronization {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function isCheckedOut() {
        $result = $this->api->get("synchronization/isCheckedOut", null);
        if ($result['error']) {
            return [false, $result['error']];
        }

        $dest = json_decode($result['data']);
        return [$dest, null];
    }

    public function setCheckedIn() {
        $result = $this->api->get("synchronization/setCheckedIn", null);
        return $result['error'];
    }
}
?>
