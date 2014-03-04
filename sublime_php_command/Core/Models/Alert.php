<?php 
	namespace Chigi\Sublime\Models;

	use Chigi\Sublime\Settings\Environment;
	
	class Alert {
		public function __construct(){
		}
		private $code;
		private $msg;
		private $description;
		private $class;
		private $repo_url;
		private $author;
	}
?>