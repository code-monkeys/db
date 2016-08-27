<?php
namespace M;


class Record implements RecordInterface
{

    protected $config = [
        "host" => "localhost",
        "port" => 3306,
        "user" => "root",
        "pass" => "root",
        "db"   => "test",
    ];

    protected $mysql = null;

    public static function fromConfig(array $config)
    {
        return new self($config);
    }

    public static function fromUrl($url)
    {
        $config = parse_url($url);
        $config["db"] = trim($config["path"], "/");
        return self::fromConfig($config);
    }

    public function __construct(array $config = [])
    {
        $this->config($config);
    }

    public function config($name = null, $value = null)
    {
        if ($name === null) {
            return $this->config;
        }

        if (is_array($name)) {
            $this->config = array_merge($this->config, $name);
            return;
        }

        if ($value === null) {
            return isset($this->config[$name]) ? $this->config[$name] : $default;
        }

        $old = $this->config[$name];
        $this->config[$name] = $value;

        return $old;
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
            $this->config["host"],
            $this->config["user"],
            $this->config["pass"],
            $this->config["db"],
            $this->config["port"]
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
