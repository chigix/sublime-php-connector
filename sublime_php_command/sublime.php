<?php

namespace Chigi\Sublime;

use Chigi\Sublime\Exception\FileSystemEncodingException;
use Chigi\Sublime\Exception\ScriptNotFoundException;
use Chigi\Sublime\Models\ReturnData;
use Chigi\Sublime\Settings\Environment;

$base_dir = dirname(__FILE__);
require_once($base_dir . '/Core/functions.php');
require_once( $base_dir . '/Core/autoload.php');
/* @var $env Environment */
$env;
try {
    $env = Environment::getInstance();
} catch (FileSystemEncodingException $ex) {
    $returnData = new ReturnData();
    $returnData->setCode(208);
    $returnData->setMsg('File system encoding specific error!!');
    $returnData->setStatusMsg('Please specific the correct system encoding.');
    $returnData->setData('Please specific the correct system encoding.');
    echo base64_encode($returnData->getJSON());
    exit;
}
//$classToCall = is_null($env->getArgument('call'))? ('\\'): ('\\' . $env->getArgument('call'));
$classToCall = '\\' . $env->getArgument('call');
$objToCall;
try {
    $objToCall = new $classToCall();
} catch (ScriptNotFoundException $exc) {
    $returnData = new ReturnData();
    $returnData->setCode(208);
    $returnData->setMsg($exc->getMessage());
    $returnData->setStatusMsg($exc->getMessage());
    $returnData->setData($exc->getMessage());
    echo base64_encode($returnData->getJSON());
    exit;
}
//echo json_encode($objToCall->run());
//var_dump($objToCall->run());
//var_dump($objToCall->run()->getJSON());
echo base64_encode($objToCall->run()->getJSON());
?>