<?php

function date_to_word($date){
	if($date != ''){
		$myArray = explode('-', $date);
		$year = $myArray[0];// year of birth
	    $month = $myArray[1];// month of birth
	    $day = $myArray[2];// date of birth
	    $month_array = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	    $month_string = $month_array[intval($month)-1];
	    $date_ = $day.', '.$month_string.' '.$year;

	    return $date_;
	}
}

