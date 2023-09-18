<?php
namespace webapi;

class GroupTimes {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function get($ttype) {
        $values = [
            'type' => $ttype,
        ];
        $bts = $this->api->get('grouptimes/get', $values);
        $dest = json_decode($bts, true);
        return $dest;
    }

    public function save($ttype, $item) {
        $values = [
            'type' => $ttype,
        ];
        $this->api->post('grouptimes/save', $values, $item);
    }
}

// class GroupTimesItem {
//     // Definisci la struttura dell'oggetto GroupTimesItem, se necessario.
// }

// // Utilizza la classe GroupTimesItem per rappresentare gli oggetti da salvare tramite l'API.
