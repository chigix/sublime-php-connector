<?php

namespace Chigi;

use Chigi\Sublime\Models\ReturnData;
use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Models\File;

class BuildMdToHtml {

    /**
     * 当前插件运行环境配置
     * @var Environment
     */
    private $env;
    
    /**
     * 当前sublime 中打开的文件对象
     * @var File
     */
    private $file;
    function __construct() {
        $this->env = Environment::getInstance();
        $this->file = $this->env->getEditor()->getCurrentEditingFile();
    }

    public function run() {
        require_once('pandoc/config.php');
        $cmd = "pandoc --toc -s --self-contained -c \"" . $config['pandoc']['css_path'] . "\"" 
                . " \"" . $this->file->getRealPath(false) . "\"" 
                . " -t html5 " 
                . "-o \"" . $this->file->getDirPath() . '/' . $this->file->extractFileName() . ".html\" "
                . "--smart --template=\"" . $config['pandoc']['template_html'] . "\"";
        $returnData = new ReturnData();
        $this->execCmd($cmd, $returnData);
        return $returnData;
    }
    
    public function execCmd($cmd, &$returnData) {
        $outputFrmCmd = array();
        $status = 0;
        // $cmd = "pandoc -f";
        exec(iconv('utf-8', Environment::getInstance()->getFileSystemEncoding(), $cmd) . ' 2>&1', $outputFrmCmd, $status);
        if ($status == 2) {
            // standard error output
            $returnData->setCode(520);
            $returnData->setMsg('Error Building.');
            $returnData->setStatusMsg($outputFrmCmd[0]);
            $returnData->setData($cmd);
        } else {
            // builded successfully
            $returnData->setCode(208);
            $returnData->setMsg('Build ended.');
            $returnData->setStatusMsg($this->file->extractFileName() . '.html builded SUCCESSFULLY, VIEW it directly.');
            $returnData->setData($cmd);
        };
    }

}

?>