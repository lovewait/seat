<?php
namespace Lib;
class View{
    private $vars;
    public function display($arg,$arg2){
        $content = file_get_contents(basedir().'/View/'.$arg.'/'.$arg2.'.html');
        $result = preg_match_all('/\$([\w]*)\W/',$content,$match);
        if($result){
            foreach($match[0] as $key => $value){
                if(isset($this->vars[$match[1][$key]])){
                    $content = str_replace('$'.$match[1][$key],'$this->vars["'.$match[1][$key].'"]',$content);
                }
            }
        }
//        var_dump($content);
        eval('?>'.$content);
    }
    public function assign($key,$value){
        $this->vars[$key] = $value;
    }
}