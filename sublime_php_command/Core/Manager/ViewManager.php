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

namespace Chigi\Sublime\Manager;

use Chigi\Sublime\Exception\UnexpectedTypeException;
use Chigi\Sublime\Models\SublimeView;

/**
 * SublimeView 对象管理器
 *
 * @author 郷
 */
class ViewManager {

    /**
     *
     * @var array<SublimeView>
     */
    private $viewsCollection = array();
    private $currentView = null;

    function __construct() {
        $this->viewsCollection = array();
    }

    /**
     * 通过 ID 获取 Editor View 对象
     * @param int $id
     * @return SublimeView
     */
    public function getViewById($id) {
        if (isset($this->viewsCollection[$id])) {
            return $this->viewsCollection[$id];
        } else {
            return null;
        }
    }

    /**
     * 注册目标编辑视图对象
     * @param SublimeView $view
     * @throws UnexpectedTypeException
     */
    public function registView(SublimeView $view) {
        if ($view instanceof SublimeView) {
            $this->viewsCollection[$view->getId()] = $view;
            $this->currentView = $view;
        } else {
            throw new UnexpectedTypeException($view, SublimeView::getClassName());
        }
    }

    /**
     * 
     * @return SublimeView
     */
    public function getCurrentView() {
        return $this->currentView;
    }

}
