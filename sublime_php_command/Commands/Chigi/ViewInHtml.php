<?php
	namespace Chigi;
	use Chigi\Sublime\Models\ReturnData;
	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\File;
	class ViewInHtml{
		public function run(){
			$env = Environment::getInstance();
			$file = new File($env->getArgument('file'));
			$returnData = new ReturnData();
			$returnData->setCode(221);
			$returnData->setMsg('Open Successfully.');
			$returnData->setStatusMsg($file->extractFileName() . '.html opened.');
			$returnData->setData($file->getDirPath() . '/' .  $file->extractFileName() . '.html');
			return $returnData;
		}
	}
?>