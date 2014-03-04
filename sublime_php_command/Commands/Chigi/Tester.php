<?php
	namespace Chigi;
	use Chigi\Sublime\Models\ReturnData;
	use Chigi\Sublime\Settings\Environment;
	class Tester{
		public function run(){
			$env = Environment::getInstance();
			$data = json_decode(file_get_contents(dirname($env->getCorePath()) . '/List.json'));
			$returnData = new ReturnData();
			$returnData->setCode(239);
			$returnData->setMsg('Show Command list on quick panel.');
			$returnData->setStatusMsg(NULL);
			$returnData->setData($data);
			return $returnData;
		}
	}
?>