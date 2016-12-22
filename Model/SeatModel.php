<?php
namespace Model;
use Lib\Model;
class SeatModel extends Model{
    protected $pk = 'id';
    protected $table = 'seat';
    public function position($seat_id = 0){
        $seat = $this->where($seat_id)->query()->find();
        $seatTypeModel = new PositionModel();
        return $seatTypeModel->where($seat['position_id'])->query()->find();
    }
    public function type($seat_id = 0){
        $seat = $this->where($seat_id)->query()->find();
        $seatTypeModel = new SeatTypeModel();
        $type = $seatTypeModel->where($seat['type_id'])->query()->find();
        return $type;
    }
}
 