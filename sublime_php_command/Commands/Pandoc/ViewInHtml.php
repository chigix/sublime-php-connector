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

use Chigi\Sublime\Exception\FileNotFoundException;
use Chigi\Sublime\Exception\WrapperedException;
use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Models\File;
use Chigi\Sublime\Settings\Environment;

/**
 * Description of ViewInHtml
 *
 * @author 郷
 */
class ViewInHtml extends BaseCommand {

    /**
     *
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
        return "Markdown: View in HTML";
    }

    public function run() {
        $returnData = null;
        try {
            $returnData = ModelsFactory::createOpenFileInOS($this->file->getDirPath(TRUE) . DIRECTORY_SEPARATOR . $this->file->extractFileName() . '.html');
        } catch (FileNotFoundException $exc) {
            throw new WrapperedException($exc->getMessage(), 0, $exc);
        }
        $returnData->setMsg("Open Successfully");
        executePush(ModelsFactory::createStatusMsg($this->file->extractFileName() . '.html opened.'));
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
