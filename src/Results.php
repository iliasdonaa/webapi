<?php
namespace Iliasdonaa\Webapi;

class Results {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function get($name, $onlyFormulas, $onlyNoFormulas) {
        $values = [
            "name" => $name,
            "onlyFormulas" => $onlyFormulas,
            "onlyNoFormulas" => $onlyNoFormulas
        ];

        $result = $this->api->get("results/get", $values);
        if ($result['error']) {
            return [null, $result['error']];
        }

        $dest = json_decode($result['data'], true);
        return [$dest, null];
    }

    public function getOne($id) {
        $values = [
            "id" => $id
        ];

        $result = $this->api->get("results/get", $values);
        if ($result['error']) {
            return [null, $result['error']];
        }

        $dest = json_decode($result['data'], true);
        return [$dest, null];
    }

    public function delete($id) {
        $values = [
            "id" => $id
        ];

        $result = $this->api->get("results/delete", $values);
        return $result['error'];
    }

    public function save($items) {
        $result = $this->api->post("results/save", null, $items);
        return $result['error'];
    }
}
?>
