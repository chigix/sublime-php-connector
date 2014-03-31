<?php
// Markdown 编译成 PDF
namespace Chigi;

use Chigi\Sublime\Models\ReturnData;
use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Models\File;

class BuildMdToPdf {

    private $file;

    public function __construct() {
        $env = Environment::getInstance();
        $this->file = $env->getEditor()->getCurrentEditingFile();
    }

    public function run() {
        require('pandoc/config.php');
        $cmd = "pandoc \"" . $this->file->getRealPath(FALSE) . "\" -o \"" . $this->file->getDirPath() . DIRECTORY_SEPARATOR . $this->file->extractFileName() . ".pdf\" "
                . "--latex-engine=xelatex --toc --smart --template=\"" . $config['pandoc']['template_pdf'] . "\"";
        $returnData = new ReturnData();
        $this->execCmd($cmd, $returnData);
        return $returnData;
    }

    public function execCmd($cmd, &$returnData) {
        $outputFrmCmd = array();
        $status = 0;
        // $cmd = "pandoc -f";
        exec(iconv('utf-8', Environment::getInstance()->getFileSystemEncoding(), $cmd) . ' 2>&1', $outputFrmCmd, $status);
        if (count($outputFrmCmd) > 0) {
            // standard error output
            $returnData->setCode(520);
            $returnData->setMsg('Error Building.');
            $returnData->setStatusMsg('Error Building to PDF.');
            $returnData->setData($cmd . "\n\n" . $outputFrmCmd[0]);
        } else {
            // builded successfully
            $returnData->setCode(208);
            $returnData->setMsg('Build ended.');
            $returnData->setStatusMsg($this->file->extractFileName() . '.pdf builded SUCCESSFULLY, VIEW it directly.');
            $returnData->setData($cmd);
        };
    }

}

?>