<?php 
	namespace Chigi\Sublime\Settings;

	class Environment {
		private static $sInstance = null;
		private function __construct(){
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
			$this->arguments = $args;
			$this->corePath = dirname(dirname(__FILE__));
		}
		public static function getInstance(){
			if(is_null(self::$sInstance)){
				self::$sInstance = new Environment();
				self::$sInstance->editor = new Editor();
			}
			return self::$sInstance;
		}
		private $editor;
		public function getEditor(){
			return $this->editor;
		}
		
		private $arguments;
		public function getArguments(){
			return $this->arguments;
		}
		public function getArgument($argName){
			return isset($this->arguments[$argName])?$this->arguments[$argName]:NULL;
		}
		
		private $corePath;
		public function getCorePath(){
			return $this->corePath;
		}
	}
?>