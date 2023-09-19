<?php
namespace Iliasdonaa\Webapi;


use GuzzleHttp\Exception\RequestException;

class Archives {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function createNewRegNo() {
        try {
            $response = $this->api->get('archives/createnewregno');
            $dest = json_decode($response->getBody(), true);
            return $dest;
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function getMatches($prefix, $maxNumber) {
        $values = [
            'prefix' => $prefix,
            'maxNumber' => $maxNumber
        ];
        try {
            $response = $this->api->get('archives/getmatches', ['query' => $values]);
            $dest = json_decode($response->getBody(), true);
            return $dest;
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function getEntry($id, $regNo) {
        $values = [
            'id' => $id,
            'regNo' => $regNo
        ];
        try {
            $response = $this->api->get('archives/getentry', ['query' => $values]);
            $dest = json_decode($response->getBody(), true);
            return $dest;
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}