<?php

namespace Chigi\Sublime;

use Chigi\Sublime\Models\Factory\ModelsFactory;

$base_dir = dirname(__FILE__);

require_once($base_dir . '/Core/functions.php');
require_once( $base_dir . '/Core/autoload.php');

// 开始系统环境初始化
Settings\Environment::getInstance();

/* @var $inputCommand string 完整命令接收传入 */
$inputCommand = "";
while (1) {
    // 临时接收字符
    /* @var $x string */
    $x = "";
    if (non_block_read(STDIN, $x)) {
        if ($x == "\n") {
            // 默认关闭调试模式
            Settings\Environment::getInstance()->debugOff();
            $arguments = json_decode(base64_decode($inputCommand), TRUE);
            // executePush(ModelsFactory::createPlainMsg($arguments['args'])->setMsg("ARGUMENTS")->setDataLevel(Enums\ReturnDataLevel::DEBUG));
            try {
                /* @var $command Models\BaseCommand */
                $command = new $arguments['call']($arguments['id']);
                Settings\Environment::getInstance()->getCommandsManager()->registCommand($command);
            } catch (Exception\UnexpectedTypeException $exc) {
                // call 参数中指定的不是正确的 BaseCommand 的子类
                // 即无法作为正确的指令对象进行调用
                executePush(ModelsFactory::createPlainMsg('<' . $arguments['call'] . '> IS not valid command class.')->setDataLevel(Enums\ReturnDataLevel::ERROR));
            } catch (\Exception $exc) {
                executePush($exc);
            }
            try {
                $command->setArgs($arguments['args']);
                // 针对自动注入接口进行自动操作
                if ($command instanceof Models\Interfaces\IEditorViewAware) {
                    $command->setEditorView(Settings\Environment::getInstance()->getViewsManager()->getCurrentView());
                }
                // 开始运行 指令对象
                $returnDataFrmRun = null;
                /* @var $returnDataFrmRun Models\BaseReturnData */
                $returnDataFrmRun = $command->run();
                // 对指令对象返回进行处理和判断
                if (!is_null($returnDataFrmRun)) {
                    executePush($returnDataFrmRun->setMsg($returnDataFrmRun->getMsg() . " --Return Data From <" . $arguments['call'] . ">"));
                }
            } catch (\Exception $exc) {
                executePush($exc);
            }

            // executePush(ModelsFactory::createPlainMsg(json_decode(base64_decode($inputCommand), TRUE)));
            executePush(ModelsFactory::createPlainMsg("")->setMsg("## COMMAND FINISHED 指令结束 : " . $arguments['call']));
            $inputCommand = "";
        } else {
            $inputCommand .= $x;
        }
        // handle your input here
    } else {
        echo ".";
        // perform your processing here
    }
}
?>