<?php
	require_once('functions.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	exec("pandoc \"" . $args['file'] . "\" -o \"" . $file_name . ".pdf\" " 
		. "--latex-engine=xelatex --template=\"D:/Developer/sublime_php_command/pages/pandoc/pm-template.latex\""); 
	echo "\n" . "调用成功";
?>