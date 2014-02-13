<?php
	require_once('functions.php');
	require_once('pandoc/config.php');
	$args = parseArgs();
	$file_name = substr($args['file'], 0, strripos($args['file'], '.'));
	if (!file_exists($file_name . '.html')) {
		// 目标 PDF 文件不存在，需先进行 Pandoc 编译
		exec("pandoc -s --self-contained -c \"" . $config['pandoc']['css_path'] . "\" \"" . $args['file'] . "\" -o \"" . $file_name . ".html\"");
	}
	$return = array(
			'code'=>212,
			'status_message'=>$file_name . '.html opened.',
			'msg'=>'Open Successfully',
			'data'=>$file_name . '.html'
		);
	echo json_encode($return);
?>