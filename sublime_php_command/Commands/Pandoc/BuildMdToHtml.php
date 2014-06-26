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

use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Settings\Environment;

/**
 * Description of BuildMdToHtml
 *
 * @author 郷
 */
class BuildMdToHtml extends BaseCommand {

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
        executePush("BANKAISSFDFDFDF");
    }

    public function setArgs($arguments) {
        executePush(ModelsFactory::createPlainMsg($arguments)->setMsg("ARGUMENTS"));
    }

}
