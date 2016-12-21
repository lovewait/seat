<?php
namespace Lib\Db;
class MysqlDriver{
    private static $conn;
    private $db;
    private $sql;
    private function __construct($config = []){
        $host = isset($config['host']) ? $config['host'] : \Config::get('db.mysql.host');
        $port = isset($config['port']) ? $config['port'] : \Config::get('db.mysql.port');
        $user = isset($config['user']) ? $config['user'] : \Config::get('db.mysql.user');
        $pwd  = isset($config['pwd'])  ? $config['pwd']  : \Config::get('db.mysql.pwd');
        $dbname = isset($config['dbname']) ? $config['dbname'] : \Config::get('db.mysql.dbname');
        $dsn  = 'mysql:dbname='.$dbname.';host='.$host.';port='.$port;
//        var_dump($dsn,$user,$pwd);
        $this->db = new \PDO($dsn,$user,$pwd);
    }
    public static function getInstance($config = [],$new){
        if(!self::$conn || $new){
            self::$conn = new self($config);
        }
        return self::$conn;
    }

    public function fetchAll($stmt){
        return $stmt instanceof \PDOStatement ? $stmt->fetchAll() : false;
    }

    public function fetch($stmt){
        return $stmt instanceof \PDOStatement ? $stmt->fetchAll() : false;
    }
    public function query($sql){
        $this->sql = $sql;
        return $this->db->query($sql);
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
