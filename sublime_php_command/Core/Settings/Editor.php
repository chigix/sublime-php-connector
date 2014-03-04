<?php 
	namespace Chigi\Sublime\Settings;

	use Chigi\Sublime\Settings\Environment;
	
	class Editor {
		public function __construct(){
			$env = Environment::getInstance();
			$this->currentEditingFile = $env->getArgument('file');
		}
		private $currentEditingFile;
		public function getCurrentEditingFile(){
			return $this->currentEditingFile;
		}
		
		// Operation Code mappings
		public static $NONE_ACTION = 0;
		public static $OPEN_FILE = 1;
		public static $OPEN_QUICK_PANEL = 9;
	}
?>