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

namespace Chigi\Sublime\Models;

use Chigi\Sublime\Exception\FileNotFoundException;
use Chigi\Sublime\Exception\NonFileBoundException;

/**
 * Description of SublimeView
 *
 * @author 郷
 */
class SublimeView extends BaseModel {

    public function __initial() {
        
    }

    /**
     * 当前视图名称
     * @var string
     */
    private $viewName = "";

    public function getViewName() {
        return $this->viewName;
    }

    public function setViewName($viewName) {
        $this->viewName = $viewName;
        return $this;
    }

    /**
     *
     * @var File
     */
    private $file = null;

    /**
     * 获取当前编辑视图所编辑的目标文件名
     * @return string
     */
    public function getFileName() {
        return $this->file->getRealPath(TRUE);
    }

    /**
     * 设置文件名
     * @param string $fileName 必须为 UTF-8 格式的路径字符串
     * @return SublimeView
     */
    public function setFileName($fileName) {
        try {
            $this->file = new File($fileName);
        } catch (FileNotFoundException $exc) {
            if (empty($fileName)) {
                return $this;
            } else {
                executePush($exc);
            }
        }

        return $this;
    }

    /**
     * 获取本视图 Editor View 所对应的 File 对象
     * @return File
     * @throws NonFileBoundException
     */
    public function getFile() {
        if (is_null($this->file)) {
            throw new NonFileBoundException();
        }
        return $this->file;
    }

    /**
     * 当前编辑器中被选中的文字区域
     * @var SelectionRegion
     */
    private $selection;

    public function getSelection() {
        return $this->selection;
    }

    public function setSelection(SelectionRegion $selection) {
        $this->selection = $selection;
        return $this;
    }

        
    /**
     * 全局文件的语法
     * @var string
     */
    private $scope;
    
    /**
     * 获得文件所用的语言格式
     * @return string
     */
    public function getScope() {
        return $this->scope;
    }

    /**
     * 设置文件所用的语言格式
     * @param string $scope
     * @return SublimeView
     */
    public function setScope($scope) {
        $this->scope = $scope;
        return $this;
    }



}
