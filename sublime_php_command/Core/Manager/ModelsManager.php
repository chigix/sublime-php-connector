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

use ArrayIterator;
use Chigi\Sublime\Models\BaseModel;

/**
 * 数据模型对象管理器
 *
 * @author 郷
 */
class ModelsManager {

    /**
     * 模型对象迭代器
     * @var ArrayIterator
     */
    private $modelsCollection = null;

    /**
     * 模型对象 ID 值索引记录
     * @var int
     */
    protected static $idIndex = 1;

    function __construct() {
        $this->modelsCollection = new ArrayIterator();
    }

    public function getModelsCollection() {
        return $this->modelsCollection;
    }

    /**
     * 模型对象入栈
     * @param BaseModel $model
     * @return ModelsManager
     */
    public function push(BaseModel $model) {
        if ($model->getId() < 0) {
            $model->setId(ModelsManager::$idIndex);
            $this->modelsCollection->offsetSet(ModelsManager::$idIndex ++, $model);
        } else {
            $this->modelsCollection->offsetSet($model->getId(), $model);
        }
        return $this;
    }

    /**
     * 移除模型对象
     * @param BaseModel $model
     * @return ModelsManager
     */
    public function remove(BaseModel $model) {
        $this->modelsCollection->offsetUnset($model->getId());
        return $this;
    }

}
