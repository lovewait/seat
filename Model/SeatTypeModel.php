<?php
namespace Model;
use Lib\Model;
class SeatTypeModel extends Model{
    protected $pk = 'seat_id';
    protected $table = 'seat_type';
    public function find($fetchMode = \PDO::FETCH_ASSOC){
        return parent::find($fetchMode);
    }
}