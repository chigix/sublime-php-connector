<?php 
function __autoload($class)
{
	$baseDir = dirname(dirname(__FILE__));
	$parts = explode('\\', $class);
	if($parts[0]=='Chigi' && $parts[1]=='Sublime'){
		// Chigi core classes --> /Core
		array_shift($parts);
		array_shift($parts);
		require_once($baseDir . '/Core/' . implode('/',$parts) . '.php' );
	}else{
		// Other namespaces --> map file
		$tmpParts = array();
		$map = require_once('autoload_namespaces.php');
		for($i = count($parts) -1; $i >= -1; $i--){
			$tmpNamespace = implode('\\',$parts);
			if(isset($map[$tmpNamespace])){
				require_once( $map[$tmpNamespace] . '/' . implode('/',$tmpParts) . '.php' );
				return;
			}
			try{
				array_unshift($tmpParts, $parts[$i]);
				unset($parts[$i]);
			}catch(Exception $e){
				return;
			}
		}
	}
}
?>