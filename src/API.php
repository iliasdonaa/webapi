<?php

namespace Iliasdonaa\Webapi;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class API
{
    private $server;
    private $secure;
    private $public;
    private $timeout_ms;
    private $userAgent;
    private $errorGen;

    public function __construct($server, $https, $userAgent = "")
    {
        if ($userAgent === "") {
            $userAgent = "webapi/1.0";
        }
        $this->server = $server;
        $this->secure = $https;
        $this->timeout_ms = 30000;
        $this->userAgent = $userAgent;
        $this->public = new PublicAPI($this);
        $this->errorGen = null;
    }

    public function eventAPI($eventID)
    {
        return new EventAPI($eventID, $this);
    }

    public function getPublic()
    {
        return $this->public;
    }

    public function setTimeout($timeout)
    {
        $this->timeout_ms = $timeout->milliseconds;
    }

    public function getTimeout()
    {
        return \DateInterval::createFromDateString($this->timeout_ms . ' milliseconds');
    }

    public function setErrorGen($fn)
    {
        $this->errorGen = $fn;
    }

    public function sessionID()
    {
        return $this->public->sessionID();
    }

    public function get($eventID = '', $cmd, $values)
    {
        $url = $this->buildURL($eventID, $cmd, $values);
        //echo $url;
        $headers = [
            'Authorization' => 'Bearer ' . $this->public->sessionID(),
            'User-Agent' => $this->userAgent,
        ];
        //return $this->doRequest('GET', $url, $headers);
        $client = new Client(['verify' => false]);

        try {
            $response = $client->get($url, [
                'headers' => $headers,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            // Gestisci la risposta qui
            if ($statusCode === 200) {
                return $body;
            } else {
                // Gestisci gli errori qui
                echo 'Errore: ' . $statusCode . ' - ' . $body;
            }
        } catch (\Exception $e) {
            // Gestisci le eccezioni qui
            echo 'Eccezione: ' . $e->getMessage();
        }
    }

    public function post($eventID, $cmd, $values, $contentType, $data)
    {
        $url = $this->buildURL($eventID, $cmd, $values);
        $headers = [
            'Authorization' => 'Bearer ' . $this->public->sessionID(),
            'User-Agent' => $this->userAgent,
        ];
        $body = null;

        if ($data !== null) {
            if (is_string($data)) {
                $body = $data;
            } elseif (is_resource($data)) {
                $body = $data;
            } else {
                $body = json_encode($data);
            }
        }

        return $this->doRequest('POST', $url, $headers, $body, $contentType);
        
    }

    private function doRequest($method, $url, $headers, $body = null, $contentType = null)
    {
        $client = new Client(['timeout' => $this->getTimeout(), 'verify'=>false]);
        $options = [
            'headers' => $headers,
            'body' => $body,
        ];

        if ($contentType !== null) {
            $options['headers']['Content-Type'] = $contentType;
        }

        try {
            $response = $client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode === 200) {
                return $body;
            }

            $errMsg = '';

            $jsonError = json_decode($body);
            if ($jsonError !== null && isset($jsonError->Error)) {
                $errMsg = $jsonError->Error;
            } else {
                $errMsg = $body;
            }

            if ($this->errorGen !== null) {
                return $errMsg;
            } else {
                return new \Exception($errMsg);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function buildURL($eventID, $cmd, $values)
    {
        $scheme = $this->secure ? 'https' : 'http';
        $url = "{$scheme}://{$this->server}";

        if (!empty($eventID)) {
            $url .= "/_{$eventID}";
        }

        $url .= "/api/{$cmd}";

        if (is_array($values) && !empty($values)) {
            $url .= '?' . http_build_query($values);
        }

        return $url;
    }
}
