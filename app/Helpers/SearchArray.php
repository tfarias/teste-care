<?php


namespace LaravelMetronic\Helpers;
class SearchArray
{
    private $result = false;
    private $rs = [];

    function search_array($array, $key){
        if(is_array($array)){
            foreach ($array as $q => $value){
                if($key == $q){
                    $this->result = true;
           }else{
                    if(is_array($value)){
                        $this->search_array($value,$key);
                    }
                    continue;
                }
            }
        }
        return $this->result;
    }

    function return_by_key($array,$key){
        if(is_array($array)){
            foreach ($array as $q => $value){
                if($key == $q){
                    $this->rs = $value;
                }else{
                    if(is_array($value)){
                        $this->return_by_key($value,$key);
                    }
                    continue;
                }
            }
        }
        return $this->rs;
    }
}