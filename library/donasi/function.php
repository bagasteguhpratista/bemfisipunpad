<?php 
function check_input($input, $data) {
	$input = array_keys($input);
	$false = 0;
	foreach ($data as $key) {
		if (in_array($key, $input) == false) {
			$false++;
		}
	}
	if ($false == 0) {
		return true;
	} else {
		return false;
	}
}
function check_empty($input) {
	$result = true;
	foreach ($input as $key => $value) {
		$result = false;
		if (empty($value) == true) {
			$result = true;
			break;
		}
	}
	return $result;
}