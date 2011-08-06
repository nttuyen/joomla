<?php
/**
 * Check validate ranges of date and dupblicate between these ranges
 * See example at end of file
 * @param Array $dates ($key => array($startDate, $endDate));
 * @return true if ok else return array(
 * 									'result' => false,
 * 									'invalid' = array of invalid $key
 * 									'dupblicate' = array of couple of dupblicate key array($key1, $key2)
 * 								  )
 */
function checkDuplicateDate($dates) {
	$keys = array_keys($dates);
	$count = count($keys);
	$return = true;
	
	//If have not data, return true
	if(empty($dates)) return $return;
	
	//Re-order
	for($i = 0; $i < $count; $i++) {
		for($j = $i+1; $j < $count; $j++) {
			$startI = strtotime($dates[$keys[$i]][0]);
			$startJ = strtotime($dates[$keys[$j]][0]);
			if($startJ < $startI) {
				$temp = $keys[$i];
				$keys[$i] = $keys[$j];
				$keys[$j] = $temp;
			}
		}
	}
	
	//Check validate and duplicate
	$return = array();
	for($i = 0; $i < $count; $i++){
		$dateI = $dates[$keys[$i]];
		$dateI1 = isset($keys[$i+1]) ? $dates[$keys[$i+1]] : false;
		
		//Check validate
		$startI = strtotime($dateI[0]);
		$endI = strtotime($dateI[1]);
		if($startI <= 0 || $endI <= 0 || $startI > $endI) {
			$return['result'] = false;
			if(!isset($return['invalid'])) $return['invalid'] = array();
			array_push($return['invalid'], $keys[$i]);
		}
		
		if($dateI1) {
			//Check duplicate
			$startI1 = strtotime($dateI1[0]);
			if(!$startI1 || $startI1 < $endI) {
				$return['result'] = false;
				if(!isset($return['duplicate'])) $return['duplicate'] = array();
				array_push($return['duplicate'], array($keys[$i], $keys[$i + 1]));
			}
		}
	}
	
	if(empty($return)) return true;
	return $return;
}


//Test sample
$dates = array(
	2 	=> 	array('04/01/2011', '06/30/2011'),
	3 	=> 	array('06/29/2011', '07/31/2011'),
	10 	=> 	array('01/01/2011', '03/31/2011'),
	11 	=> 	array('02/01/2011', '03/01/2011'),
	4 	=> 	array('08/01/2011', '07/31/2011')
);

$result = checkDuplicateDate($dates);
var_dump($result);