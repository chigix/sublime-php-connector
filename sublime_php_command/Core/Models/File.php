<?php

namespace Chigi\Sublime\Models;

use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Exception\FileNotFoundException;

class File extends \SplFileInfo {

    /**
     * 程序内部使用的目录字符串，UTF-8 格式，不用于IO级处理
     * @var string
     */
    private $path_str = "";
    /**
     * 当前文件所在的文件系统编码
     * @var string
     */
    private $enc = "utf-8";

    /**
     * Constructs a new file from the given path.
     *
     * @param string  $path      The path to the file
     * @param Boolean $checkPath Whether to check the path or not
     * @param Boolean $fileSystemEncoding Specific the filesystem encoding
     *
     * @throws FileNotFoundException If the given path is not a file
     *
     * @api
     */
    public function __construct($path, $checkPath = true, $fileSystemEncoding = null) {
        if (is_null($fileSystemEncoding)) {
            $fileSystemEncoding = Environment::getInstance()->getFileSystemEncoding();
        }
        $this->enc = $fileSystemEncoding;
        if ($checkPath && !is_file(iconv('utf-8', $fileSystemEncoding, $path))) {
            throw new FileNotFoundException($path);
        }
        $this->path_str = $path;
        parent::__construct(iconv('utf-8', $fileSystemEncoding, $path));
    }

    /**
     * 获取绝对路径
     * @param boolean $asUtf8Str 是否以 utf-8 格式返回，默认为FALSE，即返回 真实文件系统编码 的路径。
     * @return string
     */
    public function getRealPath($asUtf8Str = false) {
        return $asUtf8Str ?
                $this->path_str :
                (parent::getRealPath());
    }

    /**
     * 获取当前文件所在目录路径
     * @param boolean $asUtf8Str 是否以 utf-8 格式返回，默认为 FALSE，即返回 真实文件系统编码的路径
     * @return string
     */
    public function getDirPath($asUtf8Str = false) {
        $result_str = substr($this->path_str, 0, strrpos($this->path_str, DIRECTORY_SEPARATOR));
        return $asUtf8Str?
                $result_str:  iconv("utf-8", $this->enc, $result_str);
    }

    public function extractFileName() {
        $file_name = substr($this->path_str, $tempos = strripos($this->path_str, DIRECTORY_SEPARATOR) + 1, strripos($this->path_str, '.') - $tempos);
        return $file_name;
    }

    public function extractFileSuffix() {
        $suffix = substr($this->path_str, strripos($this->path_str, '.') + 1);
        return $suffix;
    }

}

?>