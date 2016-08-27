<?php
namespace Db;


class Record
{
    protected static $config = null;
    protected $db = null;

    public static function configure(array $config)
    {
        self::$config = $config;
    }

    protected function connect()
    {
        if ($this->db) {
            return;
        }

        $this->db = new mysqli(
            self::$config["host"],
            self::$config["user"],
            self::$config["pass"]
        );
        $this->db->select_db(self::$config["database"]);
    }

    public function write($sql)
    {
        $this->connect();

        $res = $this->db->query($sql);
        if ($res === false) {
            throw \RuntimeException($this->db->error . ': ' . $sql);
        }

        return $res;
    }

    public function read($sql, $key = null)
    {
        $rows = [];
        $res  = $this->exec($sql);
        while ($row = $res->fetch_assoc()) {
            if ($key) {
                $rows[$row[$key]] = $row;
            } else {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function map($sql)
    {
        $map = [];
        $res = $this->exec($sql);
        while ($row = $res->fetch_assoc()) {
            $key = array_shift($row);
            $val = array_shift($row);
            $map[$key] = $val;
        }
        return $map;
    }

    public function fetch($sql)
    {
        $rows = $this->query($sql);
        $row  = array_shift($rows);
        return $row;
    }

}
