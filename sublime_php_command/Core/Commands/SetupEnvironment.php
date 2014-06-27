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

namespace Chigi\Sublime\Commands;

use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\BaseReturnData;
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Utils\ArgumentsCollection;

/**
 * 指定环境配置
 *
 * @author 郷
 */
class SetupEnvironment extends BaseCommand {

    /**
     *
     * @var ArgumentsCollection
     */
    private $arguments;

    public function __initial() {
        Environment::getInstance()->debugOn();
    }

    /**
     * 获得作者信息
     * @return string
     */
    public function getAuthor() {
        return "chigix@zoho.com";
    }

    public function getName() {
        return "Setup Current Global Environment object";
    }

    public function setArgs($arguments) {
        $this->arguments = new ArgumentsCollection($arguments);
    }

    /**
     * 指令实现类的最核心实现：该指令的运行方法内容
     * @return BaseReturnData 
     */
    public function run() {
        $tmpValue = null;
        if ($tmpValue = $this->arguments->getArg("file_system_encoding")) {
            Environment::getInstance()->setFileSystemEncoding($tmpValue);
        }
        if ($tmpValue = $this->arguments->getArg("namespace_map")) {
            Environment::getInstance()->setNamespacesMap($tmpValue);
        }
        return ModelsFactory::createStatusMsg("PhpConnector loading complete");
    }

    public function isVisible() {
        return FALSE;
    }

}
