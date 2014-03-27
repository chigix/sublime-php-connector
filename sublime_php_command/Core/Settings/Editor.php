<?php

namespace Chigi\Sublime\Settings;

use Chigi\Sublime\Exception\FileSystemEncodingException;
use Chigi\Sublime\Models\File;
use Chigi\Sublime\Settings\Environment;

class Editor {

    public function __construct($arr_setting) {
        $charset = Environment::getInstance()->getFileSystemEncoding();
        if (file_exists(iconv('utf-8', $charset, $arr_setting['currentView']['fileName']))) {
            $this->currentEditingFile = new File($arr_setting['currentView']['fileName']);
        } else {
            throw new FileSystemEncodingException($charset);
        }
    }

    /**
     *
     * @var File
     */
    private $currentEditingFile;

    /**
     * 
     * @return File
     */
    public function getCurrentEditingFile() {
        return $this->currentEditingFile;
    }

    // Operation Code mappings
    public static $NONE_ACTION = 0;
    public static $OPEN_FILE = 1;
    public static $OPEN_QUICK_PANEL = 9;

}

?>