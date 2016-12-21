<?php
namespace Lib;
use Lib\Db\MysqlDriver;

class Model{
    protected $table;
    protected $pk;
    protected $where;
    protected $field;
    protected $order;
    protected $limit;
    protected $stmt;
    public function __construct(){
        $this->db = MysqlDriver::getInstance([],true);
        isset($this->pk) ? : $this->pk = 'id';
    }
    public function save($data,$where = []){
        if($where){
            $this->where($where);
        }
        foreach($data as $key => $value){
            if($key == $this->pk){
                $this->where($value);
                break;
            }
        }

        if($this->where){
            return $this->field($data)->update();
        }
        return $this->field($data)->insert();

    }
    public function query(){
        $sql = $this->parseSelect();
        $this->stmt = $this->db->query($sql);
        return $this;
    }
    public function select($fetchMode = \PDO::FETCH_ASSOC){
        $result = $this->stmt instanceof \PDOStatement ? $this->stmt->fetchAll($fetchMode) : $this->stmt;
//        $this->init();
        return $result;
    }
    public function find($fetchMode = \PDO::FETCH_ASSOC){
        $result = $this->stmt instanceof \PDOStatement ? $this->stmt->fetch($fetchMode) : $this->stmt;
//        $this->init();
        return $result;
    }
    public function insert(){
        $sql = $this->parseInsert();
        $result = $this->db->exec($sql);
        return $result ? $this->db->lastInsertId() : $result;
    }
    public function update(){
        $sql = $this->parseUpdate();
        return $this->db->exec($sql);
    }
    private function parseSelect(){
        return "SELECT ".$this->parseSelectField()." FROM `".$this->table."` ".$this->parseWhere()
            .$this->parseOrder().$this->parseLimit();
    }
    private function parseInsert(){
        return 'INSERT INTO `'.$this->table.'` '.$this->parseInsertField();
    }
    private function parseUpdate(){
        return "UPDATE `".$this->table.'`'.$this->parseUpdateField().$this->parseWhere();
    }
    public function where($where = []){
        if(is_int($where) || ($where == $where + 0)){
            $where = ["`".$this->pk .'`=\''. $where."'"];
        }
        if(is_string($where)){
            $where = explode('=',$where);
            if(count($where) !== 2){
                throw new \Exception('Not Allowed Where '.implode('=',$where));
            }
            $where = ['`'.$where[0].'`=\''.$where[1]."'"];
        }
        if(!is_array($where)){
            throw new \Exception('Where Type Is Not Allowed'.json_encode($where,JSON_UNESCAPED_UNICODE));
        }
        if($where){
            $this->where = array_unique(array_merge((array)$this->where,$where));
        }
        return $this;
    }
    private function parseWhere(){
        if(!is_array($this->where)){
            throw new \Exception('Where Type Is Not Allowed'.var_export($this->where,true));
        }
        if(!$this->where){
            return ' WHERE false';
        }
        return ' WHERE '.implode(' AND ',$this->where);
    }

    /**
     * order = [id=>desc,name=>asc] | id=desc | id
     * @param $order
     */
    public function order($order){
        if(is_string($order)){
            $order[] = $order;
        }
        if(is_array($order)){
            $this->order = array_merge($this->order,$order);
        }
        return $this;
    }
    private function parseOrder(){
        if($this->order && is_array($this->order)){
            return 'ORDER BY '.implode(',',$this->order);
        }
        return '';
    }

    /**
     * @param $limit
     */
    public function limit($limit){
        if(is_string($limit) && $limit){
            $this->limit = $limit;
        }
        if($limit && is_array($limit) && count($limit) < 3){
            $this->limit = implode(',',$limit);
        }
        return $this;
    }
    private function parseLimit(){
        if($this->limit){
            return ' LIMIT '.$this->limit;
        }
        return '';
    }

    /**
     * $field = 'id,name'|[id,name]|[id=1,name=lisi]|*
     * @param $field
     */
    public function field($field){
        if($field && is_string($field)){
            $field = explode(',',$field);
        }
        if($field && is_array($field)){
            $this->field = array_merge((array)$this->field,$field);
        }
        return $this;
    }
    private function parseSelectField(){
        return $this->field ? implode(',',$this->field) : '*';
    }
    private function parseUpdateField(){
        if(!$this->field || !is_array($this->field)){
            throw new \Exception('Not Allowed Field'.var_export($this->field,true));
        }
        $field = [];
        foreach($this->field as $key => $value){
            $field[] = '`'.$key.'`="'.$value.'"';
        }
        return ' SET '.implode(',',$field);
    }

    /**
     * $field = [id=>1,name=lisi]|[1,lisi]
     * @throws \Exception
     */
    private function parseInsertField(){
        if(!$this->field || !is_array($this->field)){
            throw new \Exception('Not Allowed Field'.var_export($this->field,true));
        }
        $key = [];
        $value = [];
        foreach($this->field as $k => $v){
            if(is_int($k)){
                throw new \Exception('Not Allowed Key '.$k.' In array '.var_export($this->field,true));
            }
            $key[] = '`'.trim($k).'`';
            $value[] = "'".$v."'";
        }
        return '('.implode(',',$key).') VALUES ('.implode(',',$value).')';
    }
    public function getTable(){
        return $this->table;
    }
}
 