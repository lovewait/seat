<?php
namespace Model;
use Lib\Model;
class SeatModel extends Model{
    protected $pk = 'id';
    protected $table = 'seat';
    public function position($position_id = 0){
        return (new PositionModel())->where($position_id)->query()->find();
    }
    public function type($type_id = 0){
        $seatTypeModel = new SeatTypeModel();
        $type = $seatTypeModel->where($type_id)->query()->find();
        return $type;
    }
}
 