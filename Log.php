<?php
class Log{
    private $logfile;
    private $level;
    private function __construct(){
        $this->logfile = basedir().'/seat.log';
    }
    public static function __callStatic($method,$msg){
        if(in_array($method,['debug','info','error','warning','notice','deprecated',])){
            $debug_backtrace = debug_backtrace();
            $msg = $debug_backtrace[0]['file'].' line'.$debug_backtrace[0]['line'].' '.$method.':'.json_encode($msg[0])."\r\n";
            $obj = new static();
            $obj->level = $method;
            $obj->write($msg);
        }else{
            throw new \Exception('Not Defined Method :'.$method);
        }
    }
    private function write($msg){
        $fh = fopen($this->logfile,'a+');
        if($fh){
            fwrite($fh,$msg);
        }
        fclose($fh);
    }
}