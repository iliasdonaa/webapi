<?php

namespace Iliasdonaa\Webapi;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class EventAPI
{
    private $eventID;
    private $api;

    public function __construct($eventID, $api)
    {
        $this->eventID = $eventID;
        $this->api = $api;
    }

    public function ageGroups()
    {
        return new AgeGroups($this);
    }

    public function archives()
    {
        return new Archives($this);
    }

    // public function backup()
    // {
    //     return new Backup($this);
    // }

    // public function bibRanges()
    // {
    //     return new BibRanges($this);
    // }

    // public function certificates()
    // {
    //     return new Certificates($this);
    // }

    // public function certificateSets()
    // {
    //     return new CertificateSets($this);
    // }

    // public function chat()
    // {
    //     return new Chat($this);
    // }

    // public function chipFile()
    // {
    //     return new ChipFile($this);
    // }

    // public function contests()
    // {
    //     return new Contests($this);
    // }

    public function customFields()
    {
        return new CustomFields($this);
    }

    public function data()
    {
        return new Data($this);
    }

    // public function dependencies()
    // {
    //     return new Dependencies($this);
    // }

    // public function emailTemplates()
    // {
    //     return new EmailTemplates($this);
    // }

    // public function entryFees()
    // {
    //     return new EntryFees($this);
    // }

    // public function exporters()
    // {
    //     return new Exporters($this);
    // }

    // public function file()
    // {
    //     return new File($this);
    // }

    public function forwarding()
    {
        return new Forwarding($this);
    }

    public function groupTimes()
    {
        return new GroupTimes($this);
    }

    public function history()
    {
        return new History($this);
    }

    public function information()
    {
        return new Information($this);
    }

    // public function kiosks()
    // {
    //     return new Kiosks($this);
    // }

    // public function labels()
    // {
    //     return new Labels($this);
    // }

    // public function lists()
    // {
    //     return new Lists($this);
    // }

    // public function overwriteValues()
    // {
    //     return new OverwriteValues($this);
    // }

    public function participants()
    {
        return new Participants($this);
    }

    // public function pictures()
    // {
    //     return new Pictures($this);
    // }

    // public function rankings()
    // {
    //     return new Rankings($this);
    // }

    // public function rawData()
    // {
    //     return new RawData($this);
    // }

    // public function rawDataRules()
    // {
    //     return new RawDataRules($this);
    // }

    public function results()
    {
        return new Results($this);
    }

    // public function settings()
    // {
    //     return new Settings($this);
    // }

    // public function simpleAPI()
    // {
    //     return new SimpleAPI($this);
    // }

    // public function splits()
    // {
    //     return new Splits($this);
    // }

    // public function statistics()
    // {
    //     return new Statistics($this);
    // }

    public function synchronization()
    {
        return new Synchronization($this);
    }

    // public function teamScores()
    // {
    //     return new TeamScores($this);
    // }

    public function times()
    {
        return new Times($this);
    }

    // public function timingPoints()
    // {
    //     return new TimingPoints($this);
    // }

    // public function vouchers()
    // {
    //     return new Vouchers($this);
    // }

    // public function webHooks()
    // {
    //     return new WebHooks($this);
    // }

    // public function timingPointRules()
    // {
    //     return new TimingPointRules($this);
    // }

    // public function userDefinedFields()
    // {
    //     return new UserDefinedFields($this);
    // }

    public function eventID()
    {
        return $this->eventID;
    }

    public function multiRequest($requests)
    {
        $req = json_encode($requests);
        $bts = $this->api->post($this->eventID, "multirequest", null, "application/json", $req);
        $dest = json_decode($bts, true);
        return $dest;
    }

    public function get($cmd, $values)
    {
        return $this->api->get($this->eventID, $cmd, $values);
    }

    public function post($cmd, $values, $data)
    {
        return $this->api->post($this->eventID, $cmd, $values, "", $data);
    }
}
