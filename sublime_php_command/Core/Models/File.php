<?php

namespace Chigi\Sublime\Models;

use Chigi\Sublime\Settings\Environment;
use Chigi\Sublime\Exception\FileNotFoundException;

class File extends \SplFileInfo {

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
        if ($checkPath && !is_file(iconv('utf-8', $fileSystemEncoding, $path))) {
            throw new FileNotFoundException($path);
        }
        parent::__construct(iconv('utf-8', $fileSystemEncoding, $path));
    }

    /**
     * 获取绝对路径
     * @param boolean $rawSysEncode 是否采用FileSystemEncoding，针对PHP内部字符串处理则使用false
     * @return string
     */
    public function getRealPath($rawSysEncode = true) {
        return $rawSysEncode ?
                (parent::getRealPath()) :
                (iconv(Environment::getInstance()->getFileSystemEncoding(), 'utf-8', parent::getRealPath()));
    }

    /**
     * 获取当前文件所在目录路径
     * @return string
     */
    public function getDirPath() {
        return substr($this->getRealPath(FALSE), 0, strrpos($this->getRealPath(FALSE), DIRECTORY_SEPARATOR));
    }

    public function extractFileName() {
        $file_name = substr($this->getRealPath(false), $tempos = strripos($this->getRealPath(false), DIRECTORY_SEPARATOR) + 1, strripos($this->getRealPath(false), '.') - $tempos);
        return $file_name;
    }

    public function extractFileSuffix() {
        $suffix = substr($this->getRealPath(false), strripos($this->getRealPath(false), '.') + 1);
        return $suffix;
    }

}

?>