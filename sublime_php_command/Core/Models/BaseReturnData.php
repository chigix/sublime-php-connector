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

use Chigi\Sublime\Enums\ReturnDataLevel;

/**
 * Description of BaseReturnData
 *
 * @author 郷
 */
abstract class BaseReturnData extends BaseModel {

    private $dataLevel;
    private $msg;
    private $data;

    /**
     * 获得数据级别
     * @return int
     */
    public function getDataLevel() {
        return $this->dataLevel;
    }

    /**
     * 设置数据级别
     * @param int $dataLevel
     * @return \Chigi\Sublime\Models\BaseReturnData
     */
    public function setDataLevel($dataLevel) {
        $this->dataLevel = $dataLevel;
        return $this;
    }

    /**
     * 获得数据消息
     * @return string
     */
    public function getMsg() {
        return $this->msg;
    }

    /**
     * 返回数据内容
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * 设置数据消息
     * @param string $msg
     * @return \Chigi\Sublime\Models\BaseReturnData
     */
    public function setMsg($msg) {
        $this->msg = $msg;
        return $this;
    }

    /**
     * 设置返回数据内容
     * @param mixed $data
     * @return \Chigi\Sublime\Models\BaseReturnData
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function __initial() {
        $this->dataLevel = ReturnDataLevel::DEBUG;
        $this->data = null;
        $this->msg = "FROM CLASS " . get_class($this);
    }

}
