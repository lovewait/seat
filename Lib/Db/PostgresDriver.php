<?php
namespace Lib\Db;
class PostgresDriver{
    private static $conn;
    private $db;
    private $sql;
    private function __construct($config = []){
        $host = isset($config['host']) ? $config['host'] : env('PGSQL_HOST','localhost');
        $port = isset($config['port']) ? $config['port'] : env('PGSQL_PORT','5432');
        $user = isset($config['user']) ? $config['user'] : env('PGSQL_USER','postgres');
        $pwd  = isset($config['pwd']) ? $config['pwd'] : env('PGSQL_PWD','postgres');
        $dbname = isset($config['dbname']) ? $config['dbname'] : env('PGSQL_DBNAME','postgres');
        $dsn = 'pgsql:dbname='.$dbname.';host='.$host.';port='.$port;
        $this->db = new \PDO($dsn,$user,$pwd);
    }
    public static function getInstance($config = []){
        if(!self::$conn){
            self::$conn = new self($config);
        }
        return self::$conn;
    }

    public function query($sql){
        $this->sql = $sql;
        $stmt = $this->db->query($sql);
        if($stmt){
            return $stmt->fetchAll();
        }
        return false;
    }
    public function exec($sql){
        $this->sql = $sql;
        return $this->db->exec($sql);
    }
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }
    public function beginTransaction(){
        $this->db->beginTransaction();
    }
    public function commit(){
        $this->db->commit();
    }
    public function rollBack(){
        $this->db->rollBack();
    }
    public function errorCode(){
        return $this->db->errorCode();
    }
    public function errorInfo(){
        return $this->db->errorInfo();
    }
    public function toSql(){
        return $this->sql;
    }
}