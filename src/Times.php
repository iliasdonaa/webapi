<?php

namespace Iliasdonaa\Webapi;


class Times {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function excelExport($bib, $result, $lang) {
        $values = [
            "bib" => $bib,
            "result" => $result,
            "lang" => $lang,
        ];
        return $this->api->get("times/excelexport", $values);
    }

    public function delete($bib, $contest, $result, $filter, $filterInfo) {
        $values = [
            "bib" => $bib,
            "contest" => $contest,
            "result" => $result,
            "filter" => $filter,
            "filterInfo" => $filterInfo,
        ];
        $result = $this->api->get("times/delete", $values);
        return $result['error'];
    }

    public function swap($bib1, $bib2) {
        $values = [
            "bib1" => $bib1,
            "bib2" => $bib2,
        ];
        $result = $this->api->get("times/swap", $values);
        return $result['error'];
    }

    public function singleStart($result, $contest, $firstTime, $interval, $sort, $filter, $noHistory) {
        $values = [
            "result" => $result,
            "contest" => $contest,
            "firstTime" => $firstTime->toString(), // Convert Decimal to string
            "interval" => $interval->toString(), // Convert Decimal to string
            "sort" => $sort,
            "filter" => $filter,
            "noHistory" => $noHistory,
        ];
        $result = $this->api->get("times/singlestart", $values);
        return $result['error'];
    }

    public function randomTimes($result, $contest, $minTime, $maxTime, $offsetResult, $filter, $noHistory) {
        $values = [
            "result" => $result,
            "contest" => $contest,
            "minTime" => $minTime->toString(), // Convert Decimal to string
            "maxTime" => $maxTime->toString(), // Convert Decimal to string
            "offsetResult" => $offsetResult,
            "filter" => $filter,
            "noHistory" => $noHistory,
        ];
        $result = $this->api->get("times/randomtimes", $values);
        return $result['error'];
    }

    public function copy($bibFrom, $bibTo, $overwriteExisting) {
        $values = [
            "bibFrom" => $bibFrom,
            "bibTo" => $bibTo,
            "overwriteExisting" => $overwriteExisting,
        ];
        $result = $this->api->get("times/copy", $values);
        return $result['error'];
    }

    public function interpolate($destID, $helperID, $contest, $helpers) {
        $values = [
            "destID" => $destID,
            "helperID" => $helperID,
            "contest" => $contest,
            "helpers" => $helpers,
        ];
        $result = $this->api->get("times/interpolate", $values);
        return $result['error'];
    }

    public function get($bib, $result) {
        $values = [
            "bib" => $bib,
            "result" => $result,
        ];
        $result = $this->api->get("times/get", $values);
        if ($result['error']) {
            return [null, $result['error']];
        }

        $dest = json_decode($result['data'], true);
        return [$dest, null];
    }

    public function count($bib, $contest, $result, $filter) {
        $values = [
            "bib" => $bib,
            "contest" => $contest,
            "result" => $result,
            "filter" => $filter,
        ];
        $result = $this->api->get("times/count", $values);
        if ($result['error']) {
            return [0, $result['error']];
        }

        $count = json_decode($result['data']);
        return [$count, null];
    }

    public function add($passings, $returnFields, $contestFilter, $ignoreBibToBibAssign) {
        $values = [
            "returnFields" => $returnFields,
            "contestFilter" => $contestFilter,
            "ignoreBibToBibAssign" => $ignoreBibToBibAssign,
        ];
        $result = $this->api->post("times/add", $values, $passings);
        if ($result['error']) {
            return [null, $result['error']];
        }

        $dest = json_decode($result['data'], true);
        return [$dest, null];
    }
}

?>
