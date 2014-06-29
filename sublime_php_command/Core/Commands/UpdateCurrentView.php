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
use Chigi\Sublime\Models\SublimeView;
use Chigi\Sublime\Settings\Environment;

/**
 * 更新 Current Editor View 对象 指令
 *
 * @author 郷
 */
class UpdateCurrentView extends BaseCommand {

    /**
     *
     * @var SublimeView
     */
    private $viewToSet = null;

    public function __initial() {
        Environment::getInstance()->debugOff();
    }

    public function getAuthor() {
        return "chigix@zoho.com";
    }

    public function getName() {
        return "Update the current Editor View object.";
    }

    public function run() {
    }

    public function setArgs($arguments) {
        $this->viewToSet = new SublimeView($arguments['id']);
        $this->viewToSet->setFileName($arguments['file_name']);
        Environment::getInstance()->getViewsManager()->registView($this->viewToSet);
    }

}
