<?php
namespace Lib;
class Action{
    private $view;
    public function __construct()
    {
        $this->view = new View();
    }

    public function display($args = []){
//        var_dump(get_defined_vars());
        $classname=get_called_class();
        $backtrace = debug_backtrace();
        $method = $backtrace[1]['function'];
        $i = explode('\\',$classname);
        call_user_func_array([$this->view,'display'],[str_replace('Action','',end($i)),$method,$args]);
    }
    public function assign($key,$value){
        $this->view->assign($key,$value);
    }
}