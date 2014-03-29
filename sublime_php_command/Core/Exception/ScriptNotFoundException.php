<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Chigi\Sublime\Exception;

/**
 * Description of ScriptNotFoundException
 *
 * @author 郷
 */
class ScriptNotFoundException extends \Exception {

    function __construct($script) {
        parent::__construct(sprintf("The Script %s NOT FOUND.", $script));
    }

}
