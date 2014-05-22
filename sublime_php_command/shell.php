<?php
/* @var $inputCommand string 完整命令接收传入 */
$inputCommand = "";
function non_block_read($fd, &$data) {
    $read = array($fd);
    $write = array();
    $except = array();
    $result = stream_select($read, $write, $except, 0);
    if ($result === false) {
        throw new Exception('stream_select failed');
    }
    if ($result === 0) {
        return false;
    }
    $data = stream_get_line($fd, 1);
    return true;
}

while (1) {
    /* @var $x string 临时接收字符 */
    $x = "";
    if (non_block_read(STDIN, $x)) {
        if ($x == "\n") {
            echo "Input: " . $inputCommand . "\n";
            $inputCommand = "";
        }  else {
            $inputCommand .= $x;
        }
        // handle your input here
    } else {
        echo ".";
        // perform your processing here
    }
}
?>