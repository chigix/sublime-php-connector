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

namespace Chigi\Sublime\Models\ReturnDataSpec;

use Chigi\Sublime\Enums\ReturnDataLevel;
use Chigi\Sublime\Exception\FileNotFoundException;
use Chigi\Sublime\Exception\UnexpectedTypeException;
use Chigi\Sublime\Models\BaseReturnData;
use Chigi\Sublime\Models\File;

/**
 * 在 OS 中打开指定文件<br/>
 * data 数据即为目标文件路径
 *
 * @author 郷
 */
class OpenFileDataInOs extends BaseReturnData {

    public function getData() {
        if (parent::getData() instanceof File) {
            return parent::getData()->getRealPath(TRUE);
        } else {
            return parent::getData();
        }
    }

    /**
     * 
     * @param File|string $data 文件对象 或 目标文件路径
     * @return OpenFileDataInOs
     * @throws UnexpectedTypeException
     * @throws FileNotFoundException
     */
    public function setData($data) {
        if (is_string($data)) {
            $file = null;
            try {
                $file = new File($data);
            } catch (FileNotFoundException $exc) {
                throw $exc;
            }
            return parent::setData($file);
        } elseif ($data instanceof File) {
            return parent::setData($data);
        } else {
            throw new UnexpectedTypeException($data, '\Chigi\Sublime\Models\File');
        }
    }
    
    private $dataLevel = ReturnDataLevel::SUCCESS;
    
    public function setDataLevel($dataLevel) {
        $this->dataLevel = $dataLevel;
        return $this;
    }

    public function getDataLevel() {
        return $this->dataLevel;
    }


}
