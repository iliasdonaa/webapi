<?php
namespace Iliasdonaa\Webapi;
use \JsonSerializable;
use \JsonException;

class AgeGroups {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function PDF() {
        return $this->api->get("agegroups/pdf", null);
    }

    public function Get($contest, $set, $name) {
        $values = array(
            "contest" => $contest,
            "set" => $set,
            "name" => $name
        );
        $bts = $this->api->get("agegroups/get", $values);
        if ($bts === null) {
            return null;
        }
        $dest = array();
        try {
            $dest = json_decode($bts, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
        return $dest;
    }

    public function Delete($id, $contest, $set) {
        $values = array(
            "id" => $id,
            "contest" => $contest,
            "set" => $set
        );
        $this->api->get("agegroups/delete", $values);
    }

    public function Save($items) {
        $bts = $this->api->post("agegroups/save", null, $items);
        if ($bts === null) {
            return null;
        }
        return json_decode($bts);
    }

    public function Generate($m) {
        // TODO: Implement Generate method
    }
}
?>