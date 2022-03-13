<?php 

namespace App;

class CustomHelper
{
    public static function getDate($date) {
        $getDate 	= date('F d, Y', strtotime($date));
        
        $hour 		= date("H",strtotime($date));
        $minute 	= date("i",strtotime($date));
        
        if($hour > 12) {
            $hours = $hour - 12;
        }
        else {
            $hours = $hour;
        }
        if($hour > 11) {
            $period = 'PM';
        }
        else {
            $period = 'AM';
        }

        $getTime = $hours . ":" . $minute . " " . $period;

        return $getDate . " " . $getTime;
    }

    public static function getDateOnly($date) {
        $getDate 	= date('F d, Y', strtotime($date));
        
        $hour 		= date("H",strtotime($date));
        $minute 	= date("i",strtotime($date));
        
        if($hour > 12) {
            $hours = $hour - 12;
        }
        else {
            $hours = $hour;
        }
        if($hour > 11) {
            $period = 'PM';
        }
        else {
            $period = 'AM';
        }

        $getTime = $hours . ":" . $minute . " " . $period;

        return $getDate . " " . $getTime;
    }

    public static function getTime($date) {
        $getDate 	= date('F d, Y', strtotime($date));
        
        $hour 		= date("H",strtotime($date));
        $minute 	= date("i",strtotime($date));
        
        if($hour > 12) {
            $hours = $hour - 12;
        }
        else {
            $hours = $hour;
        }
        if($hour > 11) {
            $period = 'PM';
        }
        else {
            $period = 'AM';
        }

        $getTime = $hours . ":" . $minute . " " . $period;

        return $getTime;
    }

    public static function getDiff($date) {
        $now 		= time();
        $your_date 	= strtotime($date);
        $datediff 	= $your_date - $now;

        return round($datediff / (60 * 60 * 24));
    }

    public static function getDayName($id) {
        $dayNames = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

        return $dayNames[$id];
    }

}