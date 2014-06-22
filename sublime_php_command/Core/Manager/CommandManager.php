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

namespace Chigi\Sublime\Manager;

use Chigi\Sublime\Exception\CommandNotExistException;
use Chigi\Sublime\Exception\UnexpectedTypeException;
use Chigi\Sublime\Models\BaseCommand;

/**
 * 执行命令管理器
 *
 * @author 郷
 */
class CommandManager {

    /**
     *
     * @var array<BaseCommand>
     */
    private $commandsCollection = array();

    function __construct() {
        $this->commandsCollection = array();
    }

    /**
     * 根据 ID 获取指令对象
     * @param int $id
     * @return BaseCommand
     * @throws CommandNotExistException
     */
    public function getCommandById($id) {
        if (isset($this->commandsCollection[$id])) {
            return $this->commandsCollection[$id];
        } else {
            throw new CommandNotExistException($id);
        }
    }

    /**
     * 将目标指令对象注册于 Manager 中
     * @param BaseCommand $command
     * @throws UnexpectedTypeException
     */
    public function registCommand($command) {
        if ($command instanceof BaseCommand) {
            $this->commandsCollection[$command->getId()] = $command;
        } else {
            throw new UnexpectedTypeException($command, BaseCommand::getClassName());
        }
    }

}
