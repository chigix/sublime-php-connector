<?php 
	namespace Chigi\Sublime\Models;

	use Chigi\Sublime\Settings\Environment;
	
	class Command {
		public function __construct(){
		}
		private $name;
		private $description;
		private $classPath;
		private $repo_url;
		private $author;
	}
?>