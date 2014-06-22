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

/**
 * 指令抽象基类
 *
 * @author 郷
 */
abstract class BaseCommand extends BaseModel {

    /**
     * 获得标题，若实现类中不覆盖声明，则默认取胜 Command Name
     * @return string
     */
    public function getTitle() {
        return $this->getName();
    }

    /**
     * 获得指令名称，建议采用英文，非英文的可作标题使用
     * @return string 
     */
    public abstract function getName();

    /**
     * 获得作者信息
     * @return string
     */
    public abstract function getAuthor();

    /**
     * 获得本指令运行所针对的目标文件格式（后缀）<br/>
     * 若为null， 则表示不经文件格式过滤。
     * @return array<string>
     */
    public function getTargetFileFormat() {
        return null;
    }

    /**
     * 传入参数列表接口
     * @param array $arguments
     */
    public abstract function setArgs($arguments);

    /**
     * 指令实现类的最核心实现：该指令的运行方法内容
     * @return BaseReturnData 
     */
    public abstract function run();

    /**
     * 设置当前指令是否显示在 Commands List Panel 中。<br/>
     * 默认为 TRUE，若要修改，请在子类中重写本方法。
     * @return boolean
     */
    public function isVisible() {
        return TRUE;
    }

}
