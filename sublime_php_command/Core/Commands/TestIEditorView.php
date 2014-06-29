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
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Models\Interfaces\IEditorViewAware;
use Chigi\Sublime\Models\SublimeView;
use Chigi\Sublime\Settings\Environment;

/**
 * Description of TestIEditorView
 *
 * @author 郷
 */
class TestIEditorView extends BaseCommand implements IEditorViewAware {

    private $view;
    public function __initial() {
        Environment::getInstance()->debugOn();
    }

    public function getAuthor() {
        
    }

    public function getName() {
        
    }

    public function run() {
        executePush($this->view->getFileName());
    }

    public function setArgs($arguments) {
        
    }

    /**
     * Editor View 对象注入接口
     * @param SublimeView $view
     */
    public function setEditorView($view) {
        executePush(ModelsFactory::createPlainMsg($view)->setMsg("Test IEditor View Setter"));
        $this->view = $view;
    }

}
