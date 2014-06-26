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

namespace Chigi\Sublime\Commands;

use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\BaseReturnData;
use Chigi\Sublime\Models\Factory\ModelsFactory;
use Chigi\Sublime\Settings\Environment;

/**
 * Description of CommandsListPanel
 *
 * @author 郷
 */
class CommandsEntrancePanel extends BaseCommand {

    public static $COMMANDS_LIST = array();
    public function __initial() {
        Environment::getInstance()->debugOn();
    }

    public function getAuthor() {
        return "chigix@zoho.com";
    }

    public function getName() {
        return "Show the list panel of all the valid commands.";
    }

    /**
     * 指令实现类的最核心实现：该指令的运行方法内容
     * @return BaseReturnData 
     */
    public function run() {
        $panel_list = ModelsFactory::createQuickPanel();
        foreach (self::$COMMANDS_LIST as $item) {
            $command = new $item[0]();
            if ($command instanceof BaseCommand) {
                $command->setArgs($item[1]);
            }
            $panel_list->pushItem($command);
        }
        return $panel_list;
    }

    /**
     * 传入参数列表接口
     * @param array $arguments
     */
    public function setArgs($arguments) {
        unset($arguments);
    }

    public function isVisible() {
        return TRUE;
    }

}
