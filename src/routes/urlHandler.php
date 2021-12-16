<?php

class URLHandler{
    public function getRoute($URL){
        array_shift($URL);
        $str = '';
        foreach($URL as $value){
            if(str_starts_with($value, '?')){
                $param = $this->getParamName($value);
                $str = $str.'/'.$param;
            }else{
                
                $str = $str.'/'.$value;
            }
        }
        return $str;
    }
    
    public function getParamName($param){
        return explode('=', $param)[0];
    }
    
    public function removeBlank($array){
        $blankIndex = array_search("", $array);
        if($blankIndex != false){
            unset($array[$blankIndex]);
        }
        return $array;
    }
    public function removeApi($array){
        $blankIndex = array_search("api", $array);
        if($blankIndex != false){
            unset($array[$blankIndex]);
        }
        return $array;
    }
}