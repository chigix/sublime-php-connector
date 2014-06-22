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
            $arguments = json_decode(base64_decode($inputCommand), TRUE);
            executePush(ModelsFactory::createPlainMsg($arguments['args'])->setMsg("ARGUMENTS"));
            try {
                /* @var $command Models\BaseCommand */
                $command = new $arguments['call']($arguments['id']);
                Settings\Environment::getInstance()->getCommandsManager()->registCommand($command);
            } catch (Exception\UnexpectedTypeException $exc) {
                // call 参数中指定的不是正确的 BaseCommand 的子类
                // 即无法作为正确的指令对象进行调用
                executePush(ModelsFactory::createPlainMsg('<' . $arguments['call'] . '> IS not valid command class.'));
            } catch (\Exception $exc) {
                executePush($exc);
            }
            $command->setArgs($arguments['args']);
            $returnDataFrmRun = null;
            try {
                /* @var $returnDataFrmRun Models\BaseReturnData */
                $returnDataFrmRun = $command->run();
            } catch (Exception $exc) {
                executePush($exc);
            }
            if (!is_null($returnDataFrmRun)) {
                executePush($returnDataFrmRun->setMsg($returnDataFrmRun->getMsg() . " --Return Data From <" . $arguments['call'] . ">"));
            }
            executePush(ModelsFactory::createPlainMsg(Settings\Environment::getInstance()->getFileSystemEncoding()));
            // executePush(ModelsFactory::createPlainMsg(json_decode(base64_decode($inputCommand), TRUE)));
            executePush(ModelsFactory::createPlainMsg("COMMAND FINISHED 指令结束"));
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