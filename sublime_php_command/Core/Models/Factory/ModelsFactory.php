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

namespace Chigi\Sublime\Models\Factory;

use Chigi\Sublime\Enums\EditorAction;
use Chigi\Sublime\Enums\ReturnDataLevel;
use Chigi\Sublime\Enums\ReturnDataType;
use Chigi\Sublime\Models\BaseModel;
use Chigi\Sublime\Models\ReturnDataSpec\PlainMsgData;
use Chigi\Sublime\Models\ReturnDataSpec\QuickPanelData;
use Chigi\Sublime\Settings\Environment;
use Exception;

/**
 * Description of ModelsFactory
 *
 * @author 郷
 */
class ModelsFactory {

    public static function initManager() {
        Environment::getInstance();
    }

    public static function registerModel(BaseModel $model) {
        Environment::getInstance()->getModelsManager()->push($model);
    }

    /**
     * PlainMsg 工厂
     * @param mixed $msg 要写入的内容
     * @return PlainMsgData
     */
    public static function createPlainMsg($msg = null) {
        $model = new PlainMsgData();
        Environment::getInstance()->getModelsManager()->push($model);
        $model->setData($msg);
        return $model;
    }

    /**
     * QuickPanel 工厂
     * @return QuickPanelData
     */
    public static function createQuickPanel() {
        $model = new QuickPanelData();
        Environment::getInstance()->getModelsManager()->push($model);
        return $model;
    }

    /**
     * 
     * @param BaseModel $model
     * @return array
     */
    public static function pushFormatter(BaseModel $model) {
        /* @var $actionCode int */
        $actionCode = 0;
        /* @var $dataType int */
        $dataType = 0;
        if ($model instanceof PlainMsgData) {
            if ($model->getDataLevel() === ReturnDataLevel::DEBUG) {
                $actionCode = EditorAction::PRINT_LOG;
            }
        } elseif ($model instanceof QuickPanelData) {
            $actionCode = EditorAction::QUICK_PANEL;
        }
        if (is_int($model->getData()) || is_float($model->getData())) {
            $dataType = ReturnDataType::NUMBER;
        } elseif (is_string($model->getData())) {
            $dataType = ReturnDataType::STRING;
        } elseif (is_array($model->getData())) {
            $dataType = ReturnDataType::ARR;
        } elseif (is_object($model->getData())) {
            $modelOrigData = $model->getData();
            if ($modelOrigData instanceof Exception) {
                $dataType = ReturnDataType::EXCEPTION;
                $model->setMsg("<" . get_class($modelOrigData) . ">  " . $modelOrigData->getMessage());
                $model->setDataLevel(ReturnDataLevel::WARNING);
                if ($model->getDataLevel() === ReturnDataLevel::DEBUG) {
                    // 按 调试模式，对异常信息格式化成文本字符串输出
                    $msg = "    " . $modelOrigData->getFile() . " : " . $modelOrigData->getLine() . "\n";
                    $msg .= '    【CODE】' . $modelOrigData->getCode() . "\n";
                    $msg .= '    【TRACE】' . str_replace("\n", "\n             ", $modelOrigData->getTraceAsString()) . "\n";
                    $model->setData($msg);
                }
            } else {
                $dataType = ReturnDataType::OBJECT;
            }
        } elseif (is_null($model->getData())) {
            $dataType = ReturnDataType::NONE;
        }
        return array(
            array($model->getDataLevel(), $dataType, $actionCode),
            $model->getMsg(),
            $model->getData()
        );
    }

}
