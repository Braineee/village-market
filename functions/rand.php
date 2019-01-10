<?php

function generate_rand(){
	  $alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
	  $number = ['0','1','2','3','4','5','6','7','8','9'];
	  $randAlph = mt_rand(0, 25);
	  $randAlph_ = mt_rand(0, 25);
	  $rand1 = mt_rand(0, 9);
	  $rand2 = mt_rand(0, 9);
	  $rand3 = mt_rand(0, 9);
	  $rand4 = mt_rand(0, 9);

	  $generate_number = $alphabet[$randAlph].$alphabet[$randAlph_].$number[$rand1].$number[$rand2].$number[$rand3].$alphabet[$randAlph].$number[$rand4];

	  return $generate_number;
}

function serial_rand(){
	$random_number = mt_rand(0000000000, 9999999999);
	
	return $random_number;
}