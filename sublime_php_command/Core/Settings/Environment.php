<?php

namespace Chigi\Sublime\Settings;

use Chigi\Sublime\Exception\FileSystemEncodingException;

class Environment {

    private static $sInstance = null;

    private function __construct() {
        $this->arguments = json_decode(base64_decode($_SERVER['argv'][1]), true);
        $this->corePath = dirname(dirname(__FILE__));
        // 特定细节参数处理
        $this->userArgs = $this->rmArg('user_args');
        $this->fileSystemEncoding = $this->rmArg('enc');
        $this->namespacesMap = $this->rmArg('ns');
    }
    
    /**
     * 处理特定细节参数工具方法
     * @param string $name
     * @return mixed
     */
    private function rmArg($name) {
        $value = $this->arguments[$name];
        unset($this->arguments[$name]);
        return $value;
    }

    /**
     * 全局运行环境单例
     * @return Environment
     * @throws FileSystemEncodingException
     */
    public static function getInstance() {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new Environment();
            try {
                self::$sInstance->editor = new Editor(self::$sInstance->arguments['editor']);
            } catch (FileSystemEncodingException $exc) {
                throw $exc;
                //echo $exc->getTraceAsString();
            }
        }
        return self::$sInstance;
    }

    /**
     * 当前 sublime 编辑器配置信息
     * @var Editor
     */
    private $editor;

    /**
     * 
     * @return Editor
     */
    public function getEditor() {
        return $this->editor;
    }

    private $arguments;

    public function getArguments() {
        return $this->arguments;
    }

    public function getArgument($argName) {
        return isset($this->arguments[$argName]) ? $this->arguments[$argName] : NULL;
    }

    private $userArgs;

    public function getUserArgs() {
        return $this->userArgs;
    }

    public function getUserArg($argName) {
        return isset($this->userArgs[$argName]) ? $this->userArgs[$argName] : NULL;
    }

    private $corePath;

    public function getCorePath() {
        return $this->corePath;
    }

    private $fileSystemEncoding;

    public function getFileSystemEncoding() {
        return $this->fileSystemEncoding;
    }
    
    private $namespacesMap = array();
    public function getNamespacesMap() {
        return $this->namespacesMap;
    }

}

?>