<?php

/*
 * Copyright 2014 郷.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Connector\Commands\Pandoc;

use Chigi\Sublime\Enums\ReturnDataLevel;
use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Models\File;
use Chigi\Sublime\Settings\Environment;

/**
 * Description of BuildMdToHtml
 *
 * @author 郷
 */
class BuildMdToHtml extends BaseCommand {

    /**
     * 本条指令要编辑的目标文件对象
     * @var File 
     */
    private $file;

    public function __initial() {
        Environment::getInstance()->debugOn();
    }

    public function getAuthor() {
        return "chigix@zoho.com";
    }

    public function getName() {
        return "Markdown: Build to Html";
    }

    public function run() {
        require_once 'pandoc/config.php';
        $cmd = "\"" . $config['pandoc']['exe'] . "\" --toc -s --self-contained -c \"" . $config['pandoc']['css_path'] . "\""
                . " \"" . $this->file->getRealPath(TRUE) . "\""
                . " -t html5 "
                . "-o \"" . $this->file->getDirPath(TRUE) . DIRECTORY_SEPARATOR . $this->file->extractFileName() . ".html\" "
                . "--smart --template=\"" . $config['pandoc']['template_html'] . "\"";
        return $this->execCmd($cmd);
    }

    public function execCmd($cmd) {
        $returnData = null;
        $outputFrmCmd = array();
        $status = 0;
        exec(iconv('utf-8', $this->file->getEnc(), $cmd) . ' 2>&1', $outputFrmCmd, $status);
        executePush($cmd);
        if (count($outputFrmCmd) > 0) {
            // standard error output
            $returnData = ModelsFactory::createAlertMsg();
            $returnData->setMsg("Error Building to HTML");
            $returnData->setData("$cmd\n\n" . $outputFrmCmd[0]);
        } else {
            // builded successfully
            $returnData = ModelsFactory::createStatusMsg();
            $returnData->setDataLevel(ReturnDataLevel::SUCCESS);
            $returnData->setMsg("Build Ended");
            $returnData->setData($this->file->extractFileName() . '.html builded SUCCESSFULLY, VIEW it directly.');
        };
        return $returnData;
    }

    public function setArgs($arguments) {
        if (isset($arguments['file'])) {
            $this->file = new File($arguments['file']);
        } else {
            $this->file = Environment::getInstance()->getViewsManager()->getCurrentView()->getFile();
        }
    }
    
    public function isVisible() {
        if (in_array(Environment::getInstance()->getViewsManager()->getCurrentView()->getFile()->extractFileSuffix(), array('md'), TRUE)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


}
