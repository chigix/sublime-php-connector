<?php

namespace Chigi\Sublime\Settings;

use Chigi\Sublime\Exception\FileSystemEncodingException;
use Chigi\Sublime\Manager\CommandManager;
use Chigi\Sublime\Manager\ModelsManager;

/**
 * 运行环境类
 */
class Environment {

    private static $sInstance = null;

    /**
     * Envirionment 对象构造器
     * @param array $params_arr
     */
    private function __construct() {
        $this->corePath = dirname(dirname(__FILE__));
        $this->fileSystemEncoding = "UTF-8";
        $this->CommandsManager = new CommandManager();
        $this->ModelsManager = new ModelsManager();
    }

    /**
     * 全局运行环境单例
     * @return Environment
     * @throws FileSystemEncodingException
     */
    public static function getInstance() {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new Environment();
        }
        return self::$sInstance;
    }

    private $corePath;

    public function getCorePath() {
        return iconv($this->fileSystemEncoding, "utf-8", $this->corePath);
    }

    private $fileSystemEncoding = "UTF-8";

    public function getFileSystemEncoding() {
        return $this->fileSystemEncoding;
    }

    public function setFileSystemEncoding($fileSystemEncoding) {
        $this->fileSystemEncoding = $fileSystemEncoding;
        return $this;
    }

    private $namespacesMap = array();

    public function getNamespacesMap() {
        return $this->namespacesMap;
    }

    public function setNamespacesMap($namespacesMap) {
        $this->namespacesMap = $namespacesMap;
        return $this;
    }

    /**
     *
     * @var CommandManager
     */
    private $CommandsManager;

    public function getCommandsManager() {
        return $this->CommandsManager;
    }

    /**
     *
     * @var ModelsManager
     */
    private $ModelsManager;

    public function getModelsManager() {
        return $this->ModelsManager;
    }

}

?>