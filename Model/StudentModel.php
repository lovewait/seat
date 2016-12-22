<?php
namespace Model;
use Lib\Model;
class StudentModel extends Model{
    protected $pk = 'id';
    protected $table = 'student';
    public function addScore($score,$student_id = ''){
        if($student_id){
            $student = $this->where($student_id)->query()->find();
            $student['score'] += $score;
            $this->field($student)->where($student_id)->update();
            return $student;
        }
        return false;
    }
    public function decScore($score,$student_id = ''){
        if($student_id){
            $student = $this->where($student_id)->query()->find();
            $student['score'] -= $score;
            $this->field($student)->where($student_id)->update();
            return $student;
        }
    }
}