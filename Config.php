<?php
class Config{
    private static $config;
    public static function get($key,$default = null)
    {
        if(empty(self::$config)){
            self::dumpConfig(basedir().'/config');
        }
        return array_get(self::$config,$key,$default);
    }

    private static function dumpConfig($dirname,$deep = false){
        $dh = dir($dirname);
        $dir = [];
        while(($f = $dh->read()) !== false){
            if($f == '.' || $f == '..'){
                continue;
            }
            $newf = $dirname.'/'.$f;
            if(is_dir($newf)){
                if($deep) {
                    $dir[$f] = self::dumpConfig($newf);
                    self::$config[$f] = require $dirname.'/'.$newf;
                }
                continue;
            }
            $dir[basename($f,'.php')] = $f;
            self::$config[basename($f,'.php')] = require $dirname.'/'.$f;
        }
        return $dir;
    }
}