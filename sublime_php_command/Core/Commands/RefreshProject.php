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
use Chigi\Sublime\Settings\Environment;

/**
 * The command to refresh the current project context information
 *
 * @author 郷
 */
class RefreshProject extends BaseCommand {

    public function __initial() {
        Environment::getInstance()->debugOn();
    }

    public function getAuthor() {
        return "Richard Lea <chigix@zoho.com>";
    }

    public function getName() {
        return "Refresh the project context info.";
    }

    public function run() {
        // 刷新项目元数据文件
        $project_info_dir = Environment::getInstance()->getContextProject()->getProjectInfoDir();
        file_put_contents(
                iconv('utf-8', Environment::getInstance()->getFileSystemEncoding(), $project_info_dir . DIRECTORY_SEPARATOR . 'project.json')
                , json_encode(
                        Environment::getInstance()->getContextProject()->toMetaArr(), JSON_PRETTY_PRINT
                )
        );
    }

    public function setArgs($arguments) {
        foreach ($arguments["paths"] as $path) {
            if (substr($path, -strlen("phpconnector.project")) === "phpconnector.project") {
                // 当前为 Connector 可识别工程
                $meta_data = null;
                try {
                    $meta_data = json_decode(file_get_contents(realpath($path) . DIRECTORY_SEPARATOR . 'project.json'), TRUE);
                } catch (\Chigi\Sublime\Exception\FileNotFoundException $exc) {
                    touch(realpath($path) . DIRECTORY_SEPARATOR . 'project.json');
                    file_put_contents(realpath($path) . DIRECTORY_SEPARATOR . 'project.json', json_encode(array('project_type' => ''), JSON_PRETTY_PRINT));
                    throw new \Chigi\Sublime\Exception\WrapperedException("Please fill project.json");
                }
                if (isset($meta_data['project_type']) && !empty($meta_data['project_type'])) {
                    Environment::getInstance()->setContextProject(new $meta_data['project_type']($path));
                }
                break;
            }
        }
    }

}
