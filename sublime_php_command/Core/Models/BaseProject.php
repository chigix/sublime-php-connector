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

namespace Chigi\Sublime\Models;

/**
 * The Base class for project abstraction.
 *
 * @author 郷
 */
abstract class BaseProject {

    /**
     * 项目信息文件存放路径
     * @var string
     */
    private $projectInfoDir = null;
    private $projectCacheDir = null;
    private $projectRootDir = null;

    public final function getProjectInfoDir() {
        return $this->projectInfoDir;
    }

    /**
     * 
     * @param string $projectInfoDir 项目信息文件存放路径
     */
    public final function __construct($projectInfoDir) {
        $this->projectInfoDir = realpath($projectInfoDir);
        $meta_info = array();
        if (file_exists(iconv('utf-8', \Chigi\Sublime\Settings\Environment::getInstance()->getFileSystemEncoding(), $projectInfoDir . DIRECTORY_SEPARATOR . 'project.json'))) {
            $meta_info = json_decode(file_get_contents($projectInfoDir . DIRECTORY_SEPARATOR . 'project.json'), TRUE);
        }
        // 处理获得 项目工作根目录
        if (isset($meta_info['document_root']) && !empty($meta_info['document_root'])) {
            $this->projectRootDir = realpath($meta_info['document_root']);
        } else {
            $this->projectRootDir = dirname($projectInfoDir);
        }
        $this->projectCacheDir = $this->projectInfoDir . DIRECTORY_SEPARATOR . 'cache';
        if (!file_exists($this->projectCacheDir)) {
            mkdir($this->projectCacheDir, 0755);
        }
        $this->__init();
    }

    /**
     * Return the root directory path for current project
     * @return string
     */
    public function getProjectRootDir() {
        return $this->projectRootDir;
    }

    /**
     * Return the cache directory path for current project
     * @return string
     */
    public function getProjectCacheDir() {
        return $this->projectCacheDir;
    }

    /**
     * Convert to array of meta info.
     * @return array
     */
    public function toMetaArr() {
        $meta_data = array(
            'project_type' => get_class($this),
            'document_root' => $this->projectRootDir
        );
        return $meta_data;
    }

    /**
     * The Custom initial script
     */
    abstract public function __init();
}
