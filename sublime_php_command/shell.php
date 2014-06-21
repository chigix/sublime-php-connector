<?php

namespace Chigi\Sublime;

use Chigi\Sublime\Manager\ModelsManager;
use Chigi\Sublime\Settings\Environment;

$base_dir = dirname(__FILE__);

require_once($base_dir . '/Core/functions.php');
require_once( $base_dir . '/Core/autoload.php');

// 开始系统环境初始化
Models\Factory\ModelsFactory::initManager();

/* @var $inputCommand string 完整命令接收传入 */
$inputCommand = "";
while (1) {
    /* @var $x string 临时接收字符 */
    $x = "";
    if (non_block_read(STDIN, $x)) {
        if ($x == "\n") {
            $return = array(
                'code' => 200,
                'status_message' => '状态栏测试文字',
                'msg' => '开发者消息',
                'data' => '开发者数据'
            );
            // echo base64_encode(json_encode($return)) . "\n";
            // echo "Input: " . $inputCommand . "\n";
            //$env = new Environment(json_decode(base64_decode($inputCommand), TRUE));
            //echo $inputCommand . "\n";
            executePush(Models\Factory\ModelsFactory::createPlainMsg(json_decode(base64_decode($inputCommand), TRUE)));
            executePush(Models\Factory\ModelsFactory::createPlainMsg("COMMAND FINISHED 指令结束"));
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