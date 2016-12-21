<?php
namespace Lib;
class App implements \ArrayAccess{
    private static $app;
    private function __construct(){}
    public static function getInstance(){
        if(!self::$app){
            self::$app = new self();
        }
        return self::$app;
    }
    public function __invoke($class){
        return self::$app[$class] ? self::$app[$class] : null;
    }
    public function offsetExists ($key){
        return isset(self::$app[$key]);
    }
    public function offsetGet ($key){
        return self::$app[$key];
    }
    public function offsetSet ($key,$value){
        self::$app[$key] = $value;
    }
    public function offsetUnset($key){
        unset(self::$app[$key]);
    }
}
 