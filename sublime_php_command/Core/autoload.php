<?php

use Chigi\Sublime\Exception\ScriptNotFoundException;
use Chigi\Sublime\Settings\Environment;

function __autoload($class) {
    $baseDir = dirname(dirname(__FILE__));
    $parts = explode('\\', $class);
    if ($parts[0] == 'Chigi' && $parts[1] == 'Sublime') {
        // Chigi core classes --> /Core
        array_shift($parts);
        array_shift($parts);
        require_once($baseDir . '/Core/' . implode('/', $parts) . '.php' );
    } else {
        // Other namespaces --> map file
        $tmpParts = array();
        // 常用快捷路径替换映射
        $quickPath = array(
            '${entryDir}' => $baseDir
        );
        $map = Environment::getInstance()->getNamespacesMap();
        for ($i = count($parts) - 1; $i >= -1; $i--) {
            $tmpNamespace = implode('\\', $parts);
            if (isset($map[$tmpNamespace])) {
                // 例如'Chigi' namespace
                $scriptFile = str_replace(
                                array_keys($quickPath), array_values($quickPath), $map[$tmpNamespace]
                        )
                        . '/' . implode('/', $tmpParts) . '.php';
                if (@include_once(iconv('utf-8', Environment::getInstance()->getFileSystemEncoding(), $scriptFile))){ // @ - to suppress warnings, 
                    ;
                } else if(@include_once($scriptFile)){
                    ;
                } else{
                    throw new ScriptNotFoundException($scriptFile);
                }
                return;
            } elseif (isset($map[$tmpNamespace . '\\'])) {
                // 例如'Chigi\' namespace
                $scriptFile = str_replace(
                                array_keys($quickPath), array_values($quickPath), $map[$tmpNamespace . '\\']
                        )
                        . '/' . implode('/', $tmpParts) . '.php';
                if (@include_once(iconv('utf-8', Environment::getInstance()->getFileSystemEncoding(), $scriptFile))){ // @ - to suppress warnings, 
                    ;
                } else if(@include_once($scriptFile)){
                    ;
                } else{
                    throw new ScriptNotFoundException($scriptFile);
                }
                return;
            }else{
                // 都不符合，则将末节 namespace 移至 $tmpParts 前缀拼接，重新检索
                try {
                    array_unshift($tmpParts, $parts[$i]);
                    unset($parts[$i]);
                } catch (\Chigi\Sublime\Exception\ArrayIndexOutOfBoundsException $e) {
                    $callStack = debug_backtrace();
                    $lastStack = $callStack[0];
                    $exToThrow = new \Chigi\Sublime\Exception\ClassNotFoundException($class,0,null);
                    $exToThrow->setFile($lastStack['file'])->setLine($lastStack['line']);
                    throw $exToThrow;
                    return;
                } catch (Exception $e) {
                    throw $e;
                    return;
                }
            }
        }
    }
}

?>