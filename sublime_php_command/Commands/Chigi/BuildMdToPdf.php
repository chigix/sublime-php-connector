<?php
	namespace Chigi;
	use Chigi\Sublime\Models\ReturnData;
	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\File;
	class BuildMdToPdf{
		public function run(){
			$env = Environment::getInstance();
			$file = new File($env->getArgument('file'));
			require_once('pandoc/config.php');
			$cmd = "pandoc \"" . $env->getArgument('file') . "\" -o \"" . $file->getDirPath() . '/' .  $file->extractFileName() . ".pdf\" " 
		. "--latex-engine=xelatex --toc --smart --template=\"" . $config['pandoc']['template_pdf'] . "\"";
			exec($cmd);
			$returnData = new ReturnData();
			$returnData->setCode(208);
			$returnData->setMsg('Build ended.');
			$returnData->setStatusMsg($file->extractFileName() . '.html builded SUCCESSFULLY, VIEW it directly.');
			$returnData->setData($cmd);
			return $returnData;
		}
	}
?>