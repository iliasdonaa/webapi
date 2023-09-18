<?php
namespace iliasdonaa\webapi;

use \JsonSerializable;

class CustomFields {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function Get() {
        $bts = $this->api->get("fields/get", null);
        if ($bts === null) {
            return null;
        }
        $dest = json_decode($bts);
        if ($dest === null) {
            return null;
        }
        return $dest;
    }

    public function GetOne($id) {
        $values = array(
            "id" => $id
        );
        $bts = $this->api->get("fields/get", $values);
        if ($bts === null) {
            return null;
        }
        $dest = json_decode($bts);
        if ($dest === null) {
            return null;
        }
        return $dest;
    }

    public function Delete($id) {
        $values = array(
            "id" => $id
        );
        $this->api->get("fields/delete", $values);
    }

    public function Save($items) {
        $bts = $this->api->post("fields/save", null, $items);
        if ($bts === null) {
            return null;
        }
        return json_decode($bts);
    }
}