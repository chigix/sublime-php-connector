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
?>