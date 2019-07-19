<?php
	function getHourMin($date){ 
        $hour = substr($date,11,5);
        return $hour;
	} 
	
	function countTime($date1,$date2){
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $diff = abs($date1 - $date2);
        $hour = (int)($diff / 3600);
        $min =  $diff / 60 % 60;
        $time = $hour.'h'.$min.'m';
        return $time;
    }

    function getMonth($date){
        $month = substr($date,5,2);
        if($month[0] == '0'){
            $month = $month[1];
        }
        return $month;
    }

    function getDay($date){
        $day = substr($date,8,2);
        if($day[0] == '0'){
            $day = $day[1];
        }
        return $day;
    }
	
	function interge($k){
        return (int)$k;
    }
