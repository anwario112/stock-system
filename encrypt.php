<?php

function encrypt($p){
    $encP='';

    for($i=0;$i < strlen($p);$i++){
        $ch=$p[$i];

        if($ch>='A' && $ch<='Z'){
            $encp=$encP . chr(ord($ch) + 5);
        }else 
           if($ch>='a' && $ch<='z'){
            $encP=$encP . chr(ord($ch) - 5);
           }else 
             if($ch>='0' && $ch<= '9'){
                $encP=$encP . chr(ord($ch) + 3);
             }else
                 if($ch = ' '){
                    $encP=$encP . 's4';
             }else{
                $encP=$encP . chr(ord($ch) - 3);
             }


    }

    return $encP;
}

?>