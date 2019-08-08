<?php

namespace App\Service\Database;

use UUID;

class SystemService
{
    protected $db;

    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = \DB::connection();
        }
    }

    public function getTableList() {
        $dbName = config("database.connections")[config("database.default")]["database"];
        $sql = "
            select
                table_name as name
            from information_schema.tables
            where table_schema='" . $dbName . "'
        ";
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }

    public function getTableDetail($tableName) {
        $dbName = config("database.connections")[config("database.default")]["database"];
        $sql = "
            select
                COLUMN_NAME as name,
                DATA_TYPE as type,
                CHARACTER_MAXIMUM_LENGTH as length
            from information_schema.columns
            where table_schema='".$dbName."'
                and table_name = '".$tableName."'
        ";
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }

    public function getTableData($talbeName) {
        $dbName = config("database.connections")[config("database.default")]["database"];
        $sql = "
            select
                *
            from ".$talbeName."
        ";
        $res = $this->db->select($sql);
        return empty($res) ? [] : $res;
    }
}