<?php 
	namespace Chigi\Sublime\Models;

	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\FileNotFoundException;
	
	class File extends \SplFileInfo {
		/**
    		 * Constructs a new file from the given path.
		 *
     	 * @param string  $path      The path to the file
     	 * @param Boolean $checkPath Whether to check the path or not
     	 *
     	 * @throws FileNotFoundException If the given path is not a file
     	 *
     	 * @api
     	 */
    	 	public function __construct($path, $checkPath = true)
    		{
        		if ($checkPath && !is_file($path)) {
            		throw new FileNotFoundException($path);
        		}
        		parent::__construct($path);
    		}
		
		public function getDirPath(){
			return dirname($this->getRealPath());
		}
		
		public function extractFileName(){
			$file_name = substr($this->getRealPath(), 
				$tempos = strripos($this->getRealPath(),'/')+1, 
				strripos($this->getRealPath(), '.')-$tempos);
			return $file_name;
		}
		public function getRealPath(){
			return str_replace('\\', '/', parent::getRealPath());
		}
		public function extractFileSuffix(){
			$suffix = substr($a_replaced, strripos($a_replaced, '.')+1);
			return $suffix;
		}
	}
?>