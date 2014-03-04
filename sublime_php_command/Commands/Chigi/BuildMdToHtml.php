<?php
	namespace Chigi;
	use Chigi\Sublime\Models\ReturnData;
	use Chigi\Sublime\Settings\Environment;
	use Chigi\Sublime\Models\File;
	class BuildMdToHtml{
		public function run(){
			$env = Environment::getInstance();
			$file = new File($env->getArgument('file'));
			require_once('pandoc/config.php');
			$cmd = "pandoc --toc -s --self-contained -c \"" . $config['pandoc']['css_path'] . "\" \"" . $env->getArgument('file') . "\" -t html5 -o \"" . $file->getDirPath() . '/' .  $file->extractFileName() . ".html\" " 
		. "--smart --template=\"" . $config['pandoc']['template_html'] . "\"";
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