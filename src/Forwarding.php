<?php
namespace webapi;

class Forwarding {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function active() {
        $bts = $this->api->get('forwarding/active', null);
        $b = json_decode($bts, true);
        return $b;
    }

    public function start($hostname, $eventid, $authToken) {
        $values = [
            'hostname' => $hostname,
            'eventid' => $eventid,
            'authToken' => $authToken,
        ];
        $this->api->get('forwarding/start', $values);
    }

    public function restart() {
        $this->api->get('forwarding/restart', null);
    }

    public function stop() {
        $this->api->get('forwarding/stop', null);
    }

    public function info() {
        $bts = $this->api->get('forwarding/info', null);
        $info = json_decode($bts, true);
        return $info;
    }
}

class ForwardingInfo {
    public $BytesSent;
    public $BytesReceived;
}

// Utilizza la classe ForwardingInfo per accedere alle informazioni sui dati di forwarding ricevuti.
