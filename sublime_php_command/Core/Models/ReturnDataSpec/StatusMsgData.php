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
use Chigi\Sublime\Models\BaseReturnData;

/**
 * 底部状态栏文字设置
 *
 * @author 郷
 */
class StatusMsgData extends BaseReturnData {

    /**
     * 设置要输出到状态栏的字符串内容
     * @param string $data
     * @return StatusMsgData
     */
    public function setData($data) {
        if (!is_string($data)) {
            $data = print_r($data, TRUE);
        }
        return parent::setData($data);
    }

    public function getDataLevel() {
        return ReturnDataLevel::SUCCESS;
    }

}
