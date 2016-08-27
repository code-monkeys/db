<?php
namespace Dotser;


class Record
{

    public static $config = [
        "host" => "localhost",
        "user" => "root",
        "pass" => "root",
        "db"   => "test",
    ];

    protected $db = null;

    public static function config($name = null, $value = null, $default = null)
    {
        if ($name === null) {
            return self::$config;
        }

        if (is_array($name)) {
            self::$config = array_merge(self::$config, $name);
            return;
        }

        if ($value === null) {
            return array_key_exists($name, self::$config) ? self::$config[$name] : $default;
        }

        self::$config[$name] = $value;
    }

    public static function fromUrl($url)
    {
        $config = parse_url($url);
        $config["db"] = trim($config["path"], "/");
        self::config($config);
    }

    protected function connect()
    {
        if ($this->db) {
            return;
        }

        $this->db = new \mysqli(
            self::$config["host"],
            self::$config["user"],
            self::$config["pass"]
        );
        $this->db->select_db(self::$config["db"]);
    }

    public function exec($sql)
    {
        $this->connect();

        $res = $this->db->query($sql);
        if ($res === false) {
            throw \RuntimeException($this->db->error . ': ' . $sql);
        }

        return $res;
    }

    public function query($sql, $key = null)
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
