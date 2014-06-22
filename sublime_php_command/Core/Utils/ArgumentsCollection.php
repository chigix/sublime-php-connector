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

namespace Chigi\Sublime\Util;

/**
 * Description of ArgumentsCollection
 *
 * @author 郷
 */
class ArgumentsCollection {

    /**
     *
     * @var array
     */
    private $arguments = null;

    function __construct($arguments) {
        $this->arguments = $arguments;
    }

    /**
     * 获取原始参数数组
     * @return array
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * 获得指定参数名的参数值
     * @param string $argName
     * @return mixed
     */
    public function getArg($argName) {
        return isset($this->arguments[$argName]) ? $this->arguments[$argName] : null;
    }

    /**
     * 移除指定参数，并返回该被移出的参数值
     * @param string $argName
     * @return mixed
     */
    public function popArg($argName = NULL) {
        $returnValue = null;
        if (isset($this->arguments[$argName])) {
            $returnValue = $this->arguments[$argName];
            unset($this->arguments[$argName]);
        }
        return $returnValue;
    }

}
