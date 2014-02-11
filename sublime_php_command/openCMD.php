<?php
	require_once('functions.php');
	$args = parseArgs();
	exec("emeditor"); 
	var_dump(parseArgs());
	echo "调用成功";
?>