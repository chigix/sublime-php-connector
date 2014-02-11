<?php
	require_once('functions.php');
	require_once('pandoc/config.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	exec("pandoc -s --self-contained -c \"" . $config['pandoc']['css_path'] . "\" \"" . $args['file'] . "\" -o \"" . $file_name . ".html\"");
	//exec("nohup \"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf" > /dev/null &');
	// exec("\"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf"');
	// echo("\"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf"');
	echo $file_name . '.html';
?>