<?php
namespace webapi;

use JsonException;


class Participants {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function getFields($bib, $fields) {
        $values = [
            'bib' => $bib,
            'fields' => $fields,
        ];
        $bts = $this->api->get('part/getfields', $values);
        return $this->parseVariantMap($bts);
    }

    public function getFieldsWithChanges($bib, $fields, $changes) {
        $values = [
            'bib' => $bib,
            'fields' => $fields,
        ];
        $bts = $this->api->post('part/getfieldswithchanges', $values, $changes);
        return $this->parseVariantMap($bts);
    }

    public function saveExpression($bib, $field, $expression, $noHistory) {
        $values = [
            'bib' => $bib,
            'field' => $field,
            'expression' => $expression,
            'noHistory' => $noHistory,
        ];
        $this->api->get('part/saveexpression', $values);
    }

    public function saveValueArray($values, $noHistory) {
        $uvalues = [
            'noHistory' => $noHistory,
        ];
        $this->api->post('part/savevaluearray', $uvalues, $values);
    }

    public function saveFields($bib, $values, $noHistory) {
        $uvalues = [
            'bib' => $bib,
            'noHistory' => $noHistory,
        ];
        $this->api->post('part/savefields', $uvalues, $values);
    }

    public function save($values, $noHistory) {
        $uvalues = [
            'noHistory' => $noHistory,
        ];
        $this->api->post('part/savefields', $uvalues, $values);
    }

    public function delete($filter, $bib, $contest) {
        $values = [
            'filter' => $filter,
        ];
        if ($bib == 0) {
            $values['bib'] = "ALL";
        } else {
            $values['bib'] = $bib;
        }
        if ($contest == 0) {
            $values['contest'] = "ALL";
        } else {
            $values['contest'] = $contest;
        }
        $this->api->get('part/delete', $values);
    }

    public function new($bib, $contest, $firstfree) {
        $values = [
            'bib' => $bib,
            'contest' => $contest,
            'firstfree' => $firstfree,
        ];
        $bts = $this->api->get('part/new', $values);
        return $this->parseInt($bts);
    }

    public function entryFee($bibs) {
        $values = [
            'bibs' => $this->intSliceToString($bibs),
        ];
        $bts = $this->api->get('part/entryfee', $values);
        return $this->parseEntryFeeItemArray($bts);
    }

    public function createBlanks($from, $to, $contest, $skipExcluded) {
        $values = [
            'from' => $from,
            'to' => $to,
            'contest' => $contest,
            'skipExcluded' => $skipExcluded,
        ];
        $this->api->get('part/clearbankinformation', $values);
    }

    public function swapBibs($bib1, $bib2) {
        $values = [
            'bib1' => $bib1,
            'bib2' => $bib2,
        ];
        $this->api->get('part/swapbibs', $values);
    }

    public function resetBibs($sort, $firstBib, $ranges, $filter, $noHistory) {
        $values = [
            'sort' => $sort,
            'firstBib' => $firstBib,
            'ranges' => $ranges,
            'filter' => $filter,
            'noHistory' => $noHistory,
        ];
        $this->api->get('part/resetbibs', $values);
    }

    public function dataManipulation($values, $filter, $noHistory) {
        $uvalues = [
            'filter' => $filter,
            'noHistory' => $noHistory,
        ];
        $this->api->post('part/datamanipulation', $uvalues, $values);
    }

    public function clearBankInformation($bib, $contest, $filter) {
        $values = [
            'bib' => $bib,
            'contest' => $contest,
            'filter' => $filter,
        ];
        $this->api->get('part/clearbankinformation', $values);
    }

    public function importSES($file, $filter, $identity, $addParticipants, $updateParticipants, $contestFrom, $contestTo, $timesFrom, $timesTo, $importRawData) {
        $values = [
            'filter' => $filter,
            'identity' => $identity,
            'addParticipants' => $addParticipants,
            'updateParticipants' => $updateParticipants,
            'contestFrom' => $contestFrom,
            'contestTo' => $contestTo,
            'timesFrom' => $timesFrom,
            'timesTo' => $timesTo,
            'importRawData' => $importRawData,
        ];
        $bts = $this->api->post('part/importses', $values, $file);
        return $this->parseImportResult($bts);
    }

    public function import($file, $addParticipants, $updateParticipants, $colHandling, $identityColumns, $lang) {
        $values = [
            'addParticipants' => $addParticipants,
            'updateParticipants' => $updateParticipants,
            'colHandling' => $colHandling,
            'identityColumns' => $identityColumns,
            'lang' => $lang,
        ];
        $bts = $this->api->post('part/import', $values, $file);
        return $this->parseImportResult($bts);
    }

    public function freeBib($maxBibPlus1, $contest, $preferred) {
        $values = [
            'maxBibPlus1' => $maxBibPlus1,
            'contest' => $contest,
            'preferred' => $preferred,
        ];
        $bts = $this->api->get('part/freebib', $values);
        return $this->parseInt($bts);
    }

    public function frequentClubs($wildcard, $maxNumber) {
        $values = [
            'wildcard' => $wildcard,
            'maxNumber' => $maxNumber,
        ];
        $bts = $this->api->get('part/frequentclubs', $values);
        return $this->parseJsonStringArr($bts);
    }

    private function parseInt($jsonString) {
        try {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return 0;
        }
    }

    private function parseVariantMap($jsonString) {
        try {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [];
        }
    }

    private function parseEntryFeeItemArray($jsonString) {
        try {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [];
        }
    }

    private function parseImportResult($jsonString) {
        try {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
    }

    private function intSliceToString($intSlice) {
        return implode(',', $intSlice);
    }

    private function parseJsonStringArr($jsonString) {
        try {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return [];
        }
    }
}
