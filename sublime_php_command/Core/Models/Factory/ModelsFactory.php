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
use Chigi\Sublime\Exception\FileNotFoundException;
use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\BaseModel;
use Chigi\Sublime\Models\BaseReturnData;
use Chigi\Sublime\Models\Interfaces\ISublimeCmd;
use Chigi\Sublime\Models\ReturnDataSpec\AlertMsgData;
use Chigi\Sublime\Models\ReturnDataSpec\ClipBoardData;
use Chigi\Sublime\Models\ReturnDataSpec\OpenFileDataInOs;
use Chigi\Sublime\Models\ReturnDataSpec\PlainMsgData;
use Chigi\Sublime\Models\ReturnDataSpec\QuickPanelData;
use Chigi\Sublime\Models\ReturnDataSpec\StatusMsgData;
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
     * Status Message 工厂
     * @param string $str 要输出于状态栏上的字符串
     * @return StatusMsgData
     */
    public static function createStatusMsg($str = null) {
        $model = new StatusMsgData();
        $model->setData($str);
        Environment::getInstance()->getModelsManager()->push($model);
        return $model;
    }

    /**
     * Alert Error Message 工厂
     * @param string $str 要输出于状态栏上的字符串
     * @return AlertMsgData
     */
    public static function createAlertMsg($str = null) {
        $model = new AlertMsgData();
        $model->setData($str);
        Environment::getInstance()->getModelsManager()->push($model);
        return $model;
    }

    /**
     * Alert Error Message 工厂
     * @param string $str 要输出于状态栏上的字符串
     * @return AlertMsgData
     * @throws FileNotFoundException
     */
    public static function createOpenFileInOS($path = null) {
        $model = new OpenFileDataInOs();
        if (is_string($path)) {
            try {
                $model->setData($path);
            } catch (FileNotFoundException $exc) {
                throw $exc;
            }
        }
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
        /* @var $data mixed */
        $data = null;
        /* @var $dataLevel int */
        $dataLevel = ReturnDataLevel::DEBUG;
        /* @var $msg string */
        $msg = "";
        // 针对返回数据先初始化通用变量
        if ($model instanceof BaseReturnData) {
            $data = $model->getData();
            $msg = $model->getMsg();
            $dataLevel = $model->getDataLevel();
        }
        // 细节区分数据内容
        if ($model instanceof PlainMsgData) {
            if ($model->getDataLevel() === ReturnDataLevel::DEBUG) {
                $actionCode = EditorAction::PRINT_LOG;
            } elseif ($model->getDataLevel() === ReturnDataLevel::INFO) {
                if (is_string($model->getData())) {
                    $model->setMsg($model->getData());
                }
                $actionCode = EditorAction::PRINT_MSG;
            }
        } elseif ($model instanceof BaseCommand) {
            $dataLevel = ReturnDataLevel::INFO;
            $actionCode = EditorAction::RUN_PHP_CMD;
            $msg = "Command To Call " . get_class($model);
            $data = array(
                $model->getId(),
                $model->getName(),
                get_class($model),
                $model->getTitle(),
                $model->getAuthor(),
                $model->getDesc(),
                $model->getTargetFileFormat()
            );
        } elseif ($model instanceof AlertMsgData) {
            $actionCode = EditorAction::ERROR_ALERT;
            if (!is_string($data)) {
                $data = $msg;
            }
        } elseif ($model instanceof StatusMsgData) {
            $actionCode = EditorAction::STATUS_MSG;
        } elseif ($model instanceof QuickPanelData) {
            $actionCode = EditorAction::QUICK_PANEL;
        } elseif ($model instanceof ClipBoardData) {
            $actionCode = EditorAction::CLIPBOARD;
        } elseif ($model instanceof OpenFileDataInOs) {
            $actionCode = EditorAction::OPEN_FILE;
        } elseif ($model instanceof ISublimeCmd) {
            $actionCode = EditorAction::RUN_EDITOR_CMD;
        }
        if (is_int($data) || is_float($data)) {
            $dataType = ReturnDataType::NUMBER;
        } elseif (is_bool($data)) {
            $dataType = ReturnDataType::BOOLEAN;
            $data = $data ? "TRUE" : "FALSE";
        } elseif (is_string($data)) {
            $dataType = ReturnDataType::STRING;
        } elseif (is_array($data)) {
            $dataType = ReturnDataType::ARR;
        } elseif (is_object($data)) {
            $modelOrigData = $data;
            if ($modelOrigData instanceof Exception) {
                $dataType = ReturnDataType::EXCEPTION;
                $model->setMsg("<" . get_class($modelOrigData) . ">  " . $modelOrigData->getMessage());
                $model->setDataLevel(ReturnDataLevel::WARNING);
                if ($dataLevel === ReturnDataLevel::DEBUG) {
                    // 按 调试模式，对异常信息格式化成文本字符串输出
                    $msg = "    " . $modelOrigData->getFile() . " : " . $modelOrigData->getLine() . "\n";
                    $msg .= '    【CODE】' . $modelOrigData->getCode() . "\n";
                    $msg .= '    【TRACE】' . str_replace("\n", "\n             ", $modelOrigData->getTraceAsString()) . "\n";
                    $model->setData($msg);
                }
            } else {
                $dataType = ReturnDataType::OBJECT;
            }
        } elseif (is_null($data)) {
            $dataType = ReturnDataType::NONE;
        }
        // 返回结果
        return array(
            array($dataLevel, $dataType, $actionCode),
            $msg,
            $data
        );
    }

}
