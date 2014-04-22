<?php

namespace Chigi\Sublime\Exception;

/**
 * Description of ClassNotFoundException
 *
 * @author 郷
 */
class ClassNotFoundException extends \Exception {

    public function __construct($className,$code,$previous) {
        parent::__construct(sprintf("The Class '%s' NOT FOUND.Please check namespace provided correctly", $className),$code,$previous);
    }
    
    public function setFile($fileName){
        $this->file = $fileName;
        return $this;
    }
    public function setLine($line){
        $this->line = $line;
        return $this;
    }

}
