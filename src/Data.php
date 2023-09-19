<?php
namespace Iliasdonaa\Webapi;

class Data {
    private $api;

    public function __construct($api) {
        $this->api = $api;
    }

    public function count($filter) {
        $values = [
            'filter' => $filter,
        ];
        $bts = $this->api->get('data/count', $values);
        $dest = json_decode($bts, true);
        return $dest;
    }

    public function list($fields, $filter, $sort, $limitFrom, $limitTo, $groups, $multiplierField, $selectorResult) {
        $values = [
            'fields' => $fields,
            'filter' => $filter,
            'sort' => $sort,
            'limitFrom' => $limitFrom,
            'limitTo' => $limitTo,
            'groups' => $groups,
            'multiplierField' => $multiplierField,
            'selectorResult' => $selectorResult,
            'listFormat' => 'JSON',
        ];
        $bts = $this->api->get('','data/list', $values);
        var_dump($bts);


        //return $dest;
    }

    public function transformation($colField, $rowFields, $filter, $field, $mode, $sortByValue) {
        $values = [
            'colField' => $colField,
            'rowFields' => $rowFields,
            'filter' => $filter,
            'field' => $field,
            'mode' => $mode,
            'sortByValue' => $sortByValue,
        ];
        $bts = $this->api->get('data/transformation', $values);

        $arr = json_decode($bts, true);

        $dest = [];
        foreach ($arr as $col) {
            $vl = [];
            foreach ($col as $x) {
                $vl[] = $x; // Assuming variant.ToVariant(x) is not needed in PHP
            }
            $dest[] = $vl;
        }
        return $dest;
    }
}
