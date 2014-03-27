<?php
// 在浏览器中打开当前MD文档
namespace Chigi;

use Chigi\Sublime\Models\ReturnData;
use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Models\File;

class ViewInHtml {

    /**
     *
     * @var File
     */
    private $file;

    function __construct() {
        $env = Environment::getInstance();
        $this->file = $env->getEditor()->getCurrentEditingFile();
    }

    public function run() {
        $returnData = new ReturnData();
        if (file_exists(
                        iconv(
                                'utf-8', Environment::getInstance()->getFileSystemEncoding(), $this->file->getDirPath() . '/' . $this->file->extractFileName() . '.html')
                )
        ) {
            $returnData->setCode(221);
            $returnData->setMsg('Open Successfully.');
            $returnData->setStatusMsg($this->file->extractFileName() . '.html opened.');
            $returnData->setData($this->file->getDirPath() . '/' . $this->file->extractFileName() . '.html');
        } else {
            $returnData->setCode(520);
            $returnData->setMsg("The file " . $this->file->extractFileName() . '.html NOT EXISTS.');
            $returnData->setStatusMsg('Please build this markdown file to html first.');
            $returnData->setData("Please build this markdown file to html first.");
        }
        return $returnData;
    }

}

?>