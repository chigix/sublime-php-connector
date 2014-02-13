<?php
	require_once('functions.php');
	require_once('pandoc/config.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	// exec("pandoc \"" . $args['file'] . "\" -o \"" . $file_name . ".pdf\" " 
	// 	. "--latex-engine=xelatex --toc --smart --template=\"" . $config['pandoc']['template_pdf'] . "\"");
	// echo $file_name . '.pdf';
	$return = array(
			'code'=>200,
			'status_message'=>'BANKAIMSG'
			'msg'=>'No Problem',
			'data'=>123
		);
	echo json_encode($return);
?>