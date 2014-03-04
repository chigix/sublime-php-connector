<?php
	namespace Chigi;
	use Chigi\Sublime\Models\ReturnData;
	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\File;
	class ViewInPdf{
		public function run(){
			$env = Environment::getInstance();
			$file = new File($env->getArgument('file'));
			$returnData = new ReturnData();
			$returnData->setCode(221);
			$returnData->setMsg('Open Successfully.');
			$returnData->setStatusMsg($file->extractFileName() . '.pdf opened.');
			$returnData->setData($file->getDirPath() . '/' .  $file->extractFileName() . '.pdf');
			if(!file_exists($file->getDirPath() . '/' . $file->extractFileName() . 'pdf')){
				$returnData->setCode(520);
				$returnData->setData('Please Build firstly');
				$returnData->setStatusMsg('File Open Error');
			}
			return $returnData;
		}
	}
?>