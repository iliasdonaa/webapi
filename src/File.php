<?php

namespace Iliasdonaa\Webapi;

use GuzzleHttp\Client;

class File
{
    private $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function activate($bib, $filter, $maxActivations)
    {
        $values = [
            'bib' => $bib,
            'filter' => $filter,
            'maxActivations' => $maxActivations,
        ];

        $bts = $this->api->get('file/activate', $values);

        $dest = json_decode($bts);

        if ($dest === null) {
            return 0;
        }

        return $dest;
    }

    public function notActivated($filter)
    {
        $values = [
            'filter' => $filter,
        ];

        $bts = $this->api->get('file/notactivated', $values);

        $dest = json_decode($bts);

        if ($dest === null) {
            return 0;
        }

        return $dest;
    }

    public function sesVersion()
    {
        $bts = $this->api->get('file/sesversion');

        $dest = json_decode($bts);

        if ($dest === null) {
            return null;
        }

        return $dest;
    }

    public function checkExpression($expressions, $returnTree)
    {
        $values = [
            'expressions' => $expressions,
            'returnTree' => $returnTree,
        ];

        $bts = $this->api->get('file/checkexpression', $values);

        return $bts;
    }

    public function getFile()
    {
        $bts = $this->api->get('','file/getfile','');

        return $bts;
    }

    public function modJobID()
    {
        $bts = $this->api->get('file/modjobid');

        $dest = json_decode($bts);

        if ($dest === null) {
            return 0;
        }

        return $dest;
    }

    public function modJobIDs()
    {
        $bts = $this->api->get('file/modjobids');

        $arr = explode(';', $bts);

        if (count($arr) !== 2) {
            throw new \Exception('response invalid');
        }

        $mid = (int)$arr[0];
        $midSettings = (int)$arr[1];

        return [$mid, $midSettings];
    }

    public function filename()
    {
        $bts = $this->api->get('file/filename');

        return $bts;
    }

    public function owner()
    {
        $bts = $this->api->get('file/owner');

        $dest = json_decode($bts);

        if ($dest === null) {
            return 0;
        }

        return $dest;
    }

    public function isOwner()
    {
        $bts = $this->api->get('file/isowner');

        $dest = json_decode($bts);

        if ($dest === null) {
            return false;
        }

        return $dest;
    }

    public function rights()
    {
        $bts = $this->api->get('file/rights');

        return $bts;
    }
}

?>
