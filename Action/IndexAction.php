<?php
namespace Action;
use Lib\Action;
use Model\SeatModel;
use Model\StudentModel;

class IndexAction extends Action{
    public function index($args){
        $seatModel = new SeatModel();
        $seat = $seatModel->where(1)->query()->find();
        $seatType = $seatModel->type($seat['type_id']);
        $seatPosition = $seatModel->position($seat['position_id']);
        $student = (new StudentModel())->where(1)->query()->find();
        var_dump($student);
        var_dump((new StudentModel())->addScore('1','1'));
//        var_dump($seat);
//        var_dump($seatType);
//        var_dump($seatPosition);
//        var_dump($args);
    }
    public function test(){
        var_dump(__METHOD__);
    }
}