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
 * The region object of selection text
 *
 * @author 郷
 */
class SelectionRegion {

    private $posStart = 0;
    private $posEnd = 0;

    function __construct($posStart, $posEnd) {
        $this->posStart = $posStart;
        $this->posEnd = $posEnd;
    }

    public function getPosStart() {
        return $this->posStart;
    }

    public function getPosEnd() {
        return $this->posEnd;
    }

    private $scope = 'text.plain';

    /**
     * 
     * @return string
     */
    public function getScope() {
        return $this->scope;
    }

    /**
     * 
     * @param string $scope
     * @return SelectionRegion
     */
    public function setScope($scope) {
        $this->scope = $scope;
        return $this;
    }

}
