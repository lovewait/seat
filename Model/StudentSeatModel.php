<?php
namespace Model;
use Lib\Model;
class StudentSeatModel extends Model{
    protected $pk = 'id';
    protected $table = 'student_seat';
    //座位使用方式：0未使用，1在座，2留座，3占座，4预约
    const SEAT_USE_NONE = 0;
    const SEAT_USE_PRES = 1;
    const SEAT_USE_RESE = 2;
    const SEAT_USE_HOLD = 3;
    const SEAT_USE_ORDE = 4;
    //座位使用状态：0未使用，1在座，2留座，3占座，4预约
    const SEAT_USE_STATUS_NONE = 0;
    const SEAT_USE_STATUS_PRES = 1;
    const SEAT_USE_STATUS_RESE = 2;
    const SEAT_USE_STATUS_HOLD = 3;
    const SEAT_USE_STATUS_ORDE = 4;

    public function getBySeatID($seat_id){
        $studentSeat = $this->where(['seat_id' =>$seat_id])->order('id desc')->query()->find();
        return $studentSeat;
    }
    public function getByStudentID($student_id){
        $studentSeat = $this->where(['student_id'=>$student_id])->order('id desc')->query()->find();
        return $studentSeat;
    }
    /**
     * 落座
     * @param $student_id
     * @param $seat_id
     */
    public function takeSeat($student_id,$seat_id){
        $seat = $this->getBySeatID($seat_id);
        if($seat && $seat['student_id'] != $student_id && $seat['status'] != self::SEAT_USE_NONE){
            return false;
        }
        if(!($seat['student_id'] == $student_id && $seat['status'] == self::SEAT_USE_PRES)){
            (new static())->save(['student_id' => $student_id,'seat_id' => $seat_id,'status' => self::SEAT_USE_PRES]);
        }

        return true;
    }

    /**
     * 离座
     * @param $student_id
     * @param $seat_id
     */
    public function leaveSeat($student_id,$seat_id){
        $seat = $this->getBySeatID($seat_id);
        if($seat && $seat['student_id'] == $student_id && $seat['status'] == self::SEAT_USE_PRES){
            (new static())->save(['student_id' => $student_id,'seat_id' => $seat_id,'status' => self::SEAT_USE_NONE]);
            return true;
        }
        return false;
    }

    /**
     * 预约
     * @param $student_id
     * @param $seat_id
     */
    public function orderSeat($student_id,$seat_id){
        $seat = $this->getBySeatID($seat_id);
        if($seat && $seat['student_id'] != $student_id && $seat['status'] != self::SEAT_USE_NONE){
            return false;
        }
        (new static())->save(['student_id' => $student_id,'seat_id' => $seat_id,'status' => self::SEAT_USE_ORDE]);
        return true;
    }

    /**
     * 留座
     * @param $student_id
     * @param $seat_id
     */
    public function reserveSeat($student_id,$seat_id){
        $seat = $this->getBySeatID($seat_id);
        if($seat && $seat['student_id'] != $student_id && $seat['status'] != self::SEAT_USE_NONE){
            return false;
        }
        (new static())->save(['student_id' => $student_id,'seat_id' => $seat_id,'status' => self::SEAT_USE_RESE]);
        return true;
    }

    /**
     * 占座
     * @param $student_id
     * @param $seat_id
     */
    public function holdSeat($student_id,$seat_id){
        $seat = $this->getBySeatID($seat_id);
        if($seat && $seat['student_id'] != $student_id && $seat['status'] != self::SEAT_USE_NONE){
            return false;
        }
        (new static())->save(['student_id' => $student_id,'seat_id' => $seat_id,'status' => self::SEAT_USE_HOLD]);
        return true;
    }
}