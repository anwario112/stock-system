<?php


function chkPass($P) {
   $hasCapital = false;
   $hasDigit = false;
   $hasSymbol = false;
   $hasSmall = false;

   for ($i = 0; $i < strlen($P); $i++) {
       $char = $P[$i];

       if (ctype_upper($char)) {
           $hasCapital = true;
       } elseif (ctype_lower($char)) {
           $hasSmall = true;
       } elseif (is_numeric($char)) {
           $hasDigit = true;
       } else {
           $hasSymbol = true;
       }
   }

   if ($hasCapital && $hasSmall && $hasDigit && $hasSymbol) {
       return true;
   }

   return false;
}








?>