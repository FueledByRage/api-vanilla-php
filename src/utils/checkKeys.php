<?php

class CheckKeys{

    function execute($array, $keys){
        foreach($keys as $key){
            if(!array_key_exists($key, $array)){
                return false;
            }
        }
        return true;
    }
}
