<?php
namespace webapi;

class Information {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function frequentNames($prefix, $maxNo) {
        $values = [
            'prefix' => $prefix,
            'maxNo' => $maxNo,
        ];
        $bts = $this->api->get('information/frequentnames', $values);
        return json_decode($bts);
    }

    public function getSex($name) {
        $values = [
            'name' => $name,
        ];
        $bts = $this->api->get('information/getsex', $values);
        return $bts;
    }

    public function addFirstName($name, $sex) {
        $values = [
            'name' => $name,
            'sex' => $sex,
        ];
        $this->api->get('information/addfirstname', $values);
    }
}

// Assicurati di sostituire `YourNamespace` con il tuo spazio dei nomi desiderato.
