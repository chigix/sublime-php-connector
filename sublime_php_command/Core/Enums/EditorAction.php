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

namespace Chigi\Sublime\Enums;

/**
 * Description of EditorAction
 *
 * @author 郷
 */
class EditorAction {
    const NONE = 0;
    const OPEN_FILE = 1;
    const RUN_EDITOR_CMD = 2;
    const RUN_PHP_CMD = 3;
    const PRINT_MSG = 6;
    const CLIPBOARD = 7;
    const PRINT_LOG = 8;
    const QUICK_PANEL = 9;
}
