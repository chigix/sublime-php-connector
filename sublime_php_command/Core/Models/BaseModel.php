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
 * 模型基类
 *
 * @author 郷
 */
abstract class BaseModel {

    /**
     * @var int
     */
    private $id;

    /**
     * 获取当前模型 ID 标识
     * @return int
     */
    public final function getId() {
        return $this->id;
    }

    public final function setId($id) {
        $this->id = $id;
        return $this;
    }

    public final function __construct($id = -1) {
        $this->id = $id;
        $this->__initial();
    }

    /**
     * 子类模型对象构造器
     */
    abstract public function __initial();
}
