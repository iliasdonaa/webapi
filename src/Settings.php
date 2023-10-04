<?php

namespace Iliasdonaa\Webapi;

class Settings
{
    private $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function Get(...$names)
    {
        $values = [];
        switch (count($names)) {
            case 0:
                return [];
            case 1:
                $values["name"] = $names[0];
                break;
            default:
                $values["names"] = implode(',', $names);
        }

        $bts = $this->api->get("settings/getsettings", $values);

        $dest = json_decode($bts, true);

        return $dest ?: [];
    }

    public function GetValue($name)
    {
        $vv = $this->Get($name);

        return isset($vv[$name]) ? $vv[$name] : null;
    }

    public function Save($values)
    {
        $this->api->post("settings/savesettings", null, $values);
    }

    public function SaveValue($name, $value)
    {
        $this->Save([[
            "Name" => $name,
            "Value" => $value,
        ]]);
    }

    public function Delete($name, $contest, $result)
    {
        $values = [
            "name" => $name,
            "contest" => $contest,
            "result" => $result,
        ];

        $this->api->get("settings/delete", $values);
    }

    public function NamesByPrefix($prefix)
    {
        $values = [
            "prefix" => $prefix,
        ];

        $bts = $this->api->get("settings/settingnamesbyprefix", $values);

        return json_encode($bts);
    }
}
