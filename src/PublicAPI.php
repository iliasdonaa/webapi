<?php

namespace Iliasdonaa\Webapi;

use GuzzleHttp\Client;
use DateTime;

class PublicAPI
{
    private $api;
    private $sessionID;

    public function __construct($api)
    {
        $this->api = $api;
        $this->sessionID = "0";
    }

    public function login($user, $pw)
    {
        // $values = [
        //     'user' => $user,
        //     'pw' => $pw,
        // ];
        //$resp = $this->api->post("", "public/login", null, "application/x-www-form-urlencoded", http_build_query($values));
        $client = new Client([
            'base_uri' => 'https://events.raceresult.com/api/',
            'verify'=>false
        ]);
        
        try {
            $response = $client->post('public/login', [
                'form_params' => [
                    'user' => $user,
                    'pw' => $pw,
                ],
            ]);
        
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
        
            if ($statusCode === 200) {
                $this->sessionID = $body;    
            }
        } catch (\Exception $e) {
            echo 'Eccezione: ' . $e->getMessage();
        }
    }

    public function logout()
    {
        if ($this->sessionID == "") {
            throw new \Exception("not logged in");
        }
        $this->api->get("", "public/logout", null);
    }

    public function eventList($year, $filter)
    {
        //echo $this->sessionID();
        $values = [
            'year' => $year,
            'filter' => $filter,
            'addsettings' => "EventName,EventDate,EventDate2,EventLocation,EventCountry",
        ];
        try {
            $bts = $this->api->get("", "public/eventlist", $values);
            $dest = ($bts);
            return $dest;
        } catch (\Exception $e) {
            echo "ERRORE: ".$e->getMessage();
        }
    }

    public function createEvent($eventName, $eventDate, $eventCountry, $copyOf, $templateID, $mode, $laps)
    {
        $values = [
            'name' => $eventName,
            'date' => $eventDate->format(DateTime::ATOM),
            'country' => $eventCountry,
            'copyOf' => $copyOf,
            'templateID' => $templateID,
            'mode' => $mode,
            'laps' => $laps,
        ];
        $resp = $this->api->get("", "public/createevent", $values);

        return new EventAPI($resp, $this->api);
    }

    public function deleteEvent($eventID)
    {
        $values = [
            'eventID' => $eventID,
        ];
        $this->api->get("", "public/deleteevent", $values);
    }

    public function tokenFromSession()
    {
        $bts = $this->api->get("", "public/tokenfromsession", null);

        $dest = json_decode($bts);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error decoding JSON: " . json_last_error_msg());
        }
        return $dest;
    }

    public function userInfo()
    {
        $bts = $this->api->get("", "public/userinfo", null);

        $dest = json_decode($bts);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error decoding JSON: " . json_last_error_msg());
        }
        return $dest;
    }

    public function userRightsGet($eventID)
    {
        $values = [
            'eventID' => $eventID,
        ];
        $bts = $this->api->get("", "userrights/get", $values);

        $dest = json_decode($bts);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Error decoding JSON: " . json_last_error_msg());
        }
        return $dest;
    }

    public function userRightsSave($eventID, $user, $rights)
    {
        $values = [
            'eventID' => $eventID,
            'user' => $user,
            'rights' => $rights,
        ];
        $this->api->get("", "userrights/save", $values);
    }

    public function userRightsDelete($eventID, $userID)
    {
        $values = [
            'eventID' => $eventID,
            'userID' => $userID,
        ];
        $this->api->get("", "userrights/delete", $values);
    }

    public function sessionID()
    {
        return $this->sessionID;
    }
}
