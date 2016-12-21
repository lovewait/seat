<?php
function autoload($classname){
    $file = basedir().'/'.str_replace('\\','/',$classname).'.php';
    if(file_exists($file)){
        require $file;
    }
}
function env($key,$default = null){
    $envFile = basedir().'/.env';
    $env = parse_ini_file($envFile,true);
    return isset($env[$key]) ? $env[$key] : $default;
}
function basedir(){
    return dirname(__FILE__);
}
function array_get($arr,$key = null,$default = null){
    if(isset($key) && is_string($key)){
        $key = explode('.',$key);
        foreach($key as $v){
            if($v){
                $arr = isset($arr[$v]) ? $arr[$v] : $default;
            }else{
                break;
            }
        }
        return $arr;
    }else{
        throw new \Exception("Key {$key} is not allowed");
    }
}
function dirfile($dirname,$deep = false){
    $dh = dir($dirname);
    $dir = [];
    while(($f = $dh->read()) !== false){
        if($f == '.' || $f == '..'){
            continue;
        }
        $newf = $dirname.'/'.$f;
        if(is_dir($newf)){
            if($deep) {
                $dir[$f] = dirfile($newf);
            }
            continue;
        }
        $dir[basename($f,'.php')] = $f;
    }
    return $dir;
}