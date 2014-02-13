<?php
	require_once('functions.php');
	require_once('pandoc/config.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	exec("pandoc \"" . $args['file'] . "\" -o \"" . $file_name . ".pdf\" " 
		. "--latex-engine=xelatex --toc --smart --template=\"" . $config['pandoc']['template_pdf'] . "\"");
	//exec("nohup \"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf" > /dev/null &');
	// exec("\"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf"');
	// echo("\"C:/Program Files (x86)/Foxit Software/Foxit Reader/Foxit Reader.exe\" \"" . $file_name . '.pdf"');
	echo $file_name . '.pdf';
?>