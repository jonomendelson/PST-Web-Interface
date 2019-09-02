<?php
$target_file  = filter_input(INPUT_GET, "file", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$target_file_overlay = substr($target_file, 0, strrpos($target_file, ".")) . "_overlay" . substr($target_file, strrpos($target_file, "."));
$new_file = filter_input(INPUT_GET, "new_file", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$gaussian = filter_input(INPUT_GET, "gaussian", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$phase = filter_input(INPUT_GET, "phase", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$warp = filter_input(INPUT_GET, "warp", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$min = filter_input(INPUT_GET, "min", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$max = filter_input(INPUT_GET, "max", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$morph = filter_input(INPUT_GET, "morph", FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$command = "python3 pst_alg.py " . $target_file . " " . $gaussian . " " . $phase . " " . $warp . " " . $min . " " . $max;
if($morph == "true"){
	$command = $command . " 1";
}else{
	$command = $command . " 0";
}

$command = $command . " TEMP_" . $new_file . " 0";
if(strlen($new_file) < 16){
	error_log("MORPH: " . $morph);
	shell_exec($command);
}

$log_output = $_SERVER["REMOTE_ADDR"] . " made request " . $command;

$myfile = file_put_contents('log.txt', $log_output.PHP_EOL , FILE_APPEND | LOCK_EX);
?>
