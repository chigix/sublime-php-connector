<?php 
function parseArgs(){
	$env = Environment::getInstance();
	$editor = new Chigi\Sublime\Settings\Environment();
	$args=array();
	for ($i=0;$i<count($_SERVER['argv']);$i++){
		$currentArgs=strtolower($_SERVER['argv'][$i]);
		$currentValue="";
		$position=strpos($currentArgs,"=");
		if ($position >0) {
			$argsName=substr($currentArgs,0,$position);
			$argsValue=substr($currentArgs,$position+1);
			$args["$argsName"]=$argsValue;
		}
	}
	return $args;
}

// 设定 错误转异常控制器
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        if(strpos($message,"Undefined offset:") !== FALSE){
            throw new \Chigi\Sublime\Exception\ArrayIndexOutOfBoundsException($message, 0, new ErrorException($message, 0, $severity, $filename, $lineno));
        }else{
            throw new ErrorException($message, 0, $severity, $filename, $lineno);
        }
    }
}

?>