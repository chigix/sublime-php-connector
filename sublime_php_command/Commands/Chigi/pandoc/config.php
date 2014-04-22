<?php
use Chigi\Sublime\Settings\Environment;
$config['pandoc']['template_pdf'] = iconv(Environment::getInstance()->getFileSystemEncoding(), 'utf-8', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'pm-template.latex';
$config['pandoc']['template_html'] = iconv(Environment::getInstance()->getFileSystemEncoding(), 'utf-8', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'pm-template.html5';
// $config['pandoc']['css_path'] = 'D:\Developer\sublime_php_command\pandoc\stylesheets\markdown10.css';
$config['pandoc']['css_path'] = iconv(Environment::getInstance()->getFileSystemEncoding(), 'utf-8', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'stylesheets' . DIRECTORY_SEPARATOR . 'pandoc.css';
$config['pandoc']['exe'] = iconv(Environment::getInstance()->getFileSystemEncoding(), 'utf-8', dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'pandoc.exe';
?>