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

namespace Chigi\Sublime\Models\Interfaces;

/**
 * 自动注入 Editor View 编辑视图对象
 * @author 郷
 */
interface IEditorViewAware {
    /**
     * Editor View 对象注入接口
     * @param \Chigi\Sublime\Models\SublimeView $view
     */
    public function setEditorView($view);
}
