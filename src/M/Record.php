<?php
namespace M;


class Record implements RecordInterface
{

    protected static $config = [
        "host" => "localhost",
        "port" => 3306,
        "user" => "root",
        "pass" => "root",
        "db"   => "test",
    ];

    protected $mysql = null;

    public static function config($name = null, $value = null)
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

        $old = self::$config[$name];
        self::$config[$name] = $value;

        return $old;
    }

    public static function fromUrl($url)
    {
        $config = parse_url($url);
        $config["db"] = trim($config["path"], "/");
        self::config($config);
    }

    public function read($sql)
    {
        $rows = [];
        $res  = $this->exec($sql);
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function write($sql)
    {
        $this->exec($sql);
        return $this->mysql->affected_rows;
    }

    public function insertId()
    {
        return $this->mysql->insert_id;
    }

    protected function connect()
    {
        if ($this->mysql) {
            return;
        }

        $this->mysql = new \mysqli(
            self::$config["host"],
            self::$config["user"],
            self::$config["pass"],
            self::$config["db"],
            self::$config["port"]
        );
    }

    protected function exec($sql)
    {
        $this->connect();

        $res = $this->mysql->query($sql);
        if ($res === false) {
            throw new \RuntimeException(sprintf(
                "%s from query <%s>.",
                $this->mysql->error,
                $sql
            ));
        }

        return $res;
    }

}
