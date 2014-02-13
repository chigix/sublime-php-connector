<?php
	require_once('functions.php');
	require_once('pandoc/config.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	if (!file_exists($file_name . '.pdf')) {
		// 目标 PDF 文件不存在，需先进行 Pandoc 编译
		exec("pandoc \"" . $args['file'] . "\" -o \"" . $file_name . ".pdf\" " 
			. "--latex-engine=xelatex --template=\"" . $config['pandoc']['template_path'] . "\""); 
	}
	$return = array(
			'code'=>212,
			'status_message'=>$file_name . '.pdf opened.',
			'msg'=>'Open Successfully',
			'data'=>$file_name . '.pdf'
		);
	echo json_encode($return);
?>