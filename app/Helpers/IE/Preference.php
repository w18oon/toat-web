<?php

    function decodeDataValue($dataType,$dataValue)
    {
        if($dataType == 'json'){
            if(!$dataValue){ return []; }
    		return json_decode($dataValue);
    	}else{
            if(!$dataValue){ return ; }
    		return json_decode($dataValue)[0];
    	}
    }

    function encodeDataValue($dataType,$dataValue)
    {
        if($dataValue == ''){ return ; }
        
        if($dataType == 'json'){
            if(is_array($dataValue)){ // ARRAY => JSON
                $result = json_encode($dataValue);
            }else{ // STRING WITH COMMA => JSON
                $result = json_encode(array_map('trim',explode(',',$dataValue )));
            }
        }else{ // RETURN ONLY 1 DATA RESULT
            $arr = array_map('trim',explode(',',$dataValue ));
            $data = $arr[0];
            $result = json_encode([$data]);
        }
        return $result;
    }

    function isEloquentCollection($data)
    {
        return is_a($data, "Illuminate\Database\Eloquent\Collection");
    }
