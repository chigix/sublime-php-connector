<?php

use Chigi\Sublime\Exception\ArrayIndexOutOfBoundsException;
use Chigi\Sublime\Models\BaseModel;
use Chigi\Sublime\Settings\Environment;

/**
 * 解析命令行运行时传入参数
 * @return array
 */
function parseArgs() {
    $env = Environment::getInstance();
    $args = array();
    for ($i = 0; $i < count($_SERVER['argv']); $i++) {
        $currentArgs = strtolower($_SERVER['argv'][$i]);
        $currentValue = "";
        $position = strpos($currentArgs, "=");
        if ($position > 0) {
            $argsName = substr($currentArgs, 0, $position);
            $argsValue = substr($currentArgs, $position + 1);
            $args["$argsName"] = $argsValue;
        }
    }
    return $args;
}

// 设定 错误转异常控制器
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        if (strpos($message, "Undefined offset:") !== FALSE) {
            throw new ArrayIndexOutOfBoundsException($message, 0, new ErrorException($message, 0, $severity, $filename, $lineno));
        } elseif (strpos($message, 'failed to open stream: No such file or directory') !== FALSE) {
            //executePush($message);
            $extractedArr = array();
            preg_match("#^(file_get_contents|require_once|include_once|require|include)\((.+)\): failed to open stream: No such file or directory$#", $message, $extractedArr);
            // executePush(Chigi\Sublime\Models\Factory\ModelsFactory::createPlainMsg($message));
            $exception = new Chigi\Sublime\Exception\FileNotFoundException($extractedArr[2]);
            $exception->setCode(0);
            $exception->setFile($filename);
            $exception->setLine($lineno);
            throw $exception;
        } else {
            throw new ErrorException($message, 0, $severity, $filename, $lineno);
        }
    }
}

/**
 * 无阻塞读取标准输入
 * @param 目标输入流 $fd
 * @param 数据写入指针 $data
 * @return boolean
 * @throws Exception
 */
function non_block_read($fd, &$data) {
    $read = array($fd);
    $write = array();
    $except = array();
    $result = stream_select($read, $write, $except, 0);
    if ($result === false) {
        throw new Exception('stream_select failed');
    }
    if ($result === 0) {
        return false;
    }
    $data = stream_get_line($fd, 1);
    return true;
}

/**
 * 执行模型指令
 * @param string|BaseModel|Exception $content
 * @return boolean
 */
function executePush($content) {
    if (is_string($content) || is_array($content)) {
        // 封装字符串输出
        $model = Chigi\Sublime\Models\Factory\ModelsFactory::createPlainMsg($content);
        if (Environment::getInstance()->isDebug()) {
            // 仅针对调试模式时输出。
            echo base64_encode(json_encode(\Chigi\Sublime\Models\Factory\ModelsFactory::pushFormatter($model))) . "\n";
        }
    } elseif ($content instanceof Chigi\Sublime\Models\BaseReturnData) {
        if ($content->getDataLevel() === \Chigi\Sublime\Enums\ReturnDataLevel::DEBUG && !Environment::getInstance()->isDebug()) {
            // 非调试模式下，所有调试级数据均不输出。
            ;
        } else {
            echo base64_encode(json_encode(\Chigi\Sublime\Models\Factory\ModelsFactory::pushFormatter($content))) . "\n";
        }
    } elseif ($content instanceof BaseModel) {
        // 输出标准数据模型
        echo base64_encode(json_encode(\Chigi\Sublime\Models\Factory\ModelsFactory::pushFormatter($content))) . "\n";
    } elseif ($content instanceof \Chigi\Sublime\Exception\WrapperedException) {
        $exc = $content->getPrevious();
        $model = \Chigi\Sublime\Models\Factory\ModelsFactory::createAlertMsg($content->getMessage());
        if (Environment::getInstance()->isDebug()) {
            executePush($exc);
        }
        echo base64_encode(json_encode(\Chigi\Sublime\Models\Factory\ModelsFactory::pushFormatter($model))) . "\n";
    } elseif ($content instanceof \Exception) {
        $logMsg = Chigi\Sublime\Models\Factory\ModelsFactory::createPlainMsg($content);
        echo base64_encode(json_encode(\Chigi\Sublime\Models\Factory\ModelsFactory::pushFormatter($logMsg))) . "\n";
    } else {
        // 不支持的数据类型格式，跳过
        // @TODO 可抛异常
        return false;
    }
    return TRUE;
}

?>