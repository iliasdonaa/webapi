<?php
namespace webapi;

class History {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function get($bib) {
        $values = [
            'bib' => $bib,
        ];
        $bts = $this->api->get('history/get', $values);
        $dest = json_decode($bts, true);
        return $dest;
    }

    public function excelExport($bib, $lang) {
        $values = [
            'bib' => $bib,
            'lang' => $lang,
        ];
        return $this->api->get('history/excelexport', $values);
    }

    public function delete($bib, $contest, $field, $dateForm, $dateTo, $filter) {
        $values = [
            'bib' => $bib,
            'contest' => $contest,
            'field' => $field,
            'dateForm' => $dateForm,
            'dateTo' => $dateTo,
            'filter' => $filter,
        ];
        $this->api->get('history/delete', $values);
    }

    public function count($bib, $contest, $field, $dateForm, $dateTo, $filter) {
        $values = [
            'bib' => $bib,
            'contest' => $contest,
            'field' => $field,
            'dateForm' => $dateForm,
            'dateTo' => $dateTo,
            'filter' => $filter,
        ];
        $bts = $this->api->get('history/count', $values);
        $count = json_decode($bts, true);
        return $count;
    }
}

// Assicurati di sostituire `YourNamespace` con il tuo spazio dei nomi desiderato.
