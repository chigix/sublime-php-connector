<?php
	namespace Chigi\Sublime;

	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\ReturnData;
	
	$base_dir = dirname(__FILE__);
	require_once($base_dir . '/Core/functions.php');
	require_once( $base_dir . '/Core/autoload.php');
	$env = Environment::getInstance();
	//$classToCall = is_null($env->getArgument('call'))? ('\\'): ('\\' . $env->getArgument('call'));
	$classToCall =  '\\' . $env->getArgument('call');
	$objToCall = new $classToCall();
	//echo json_encode($objToCall->run());
	echo $objToCall->run()->getJSON();
?>