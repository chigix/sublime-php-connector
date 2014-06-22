# -*- coding: utf-8 -*-
import sublime, sublime_plugin
import os, sys, subprocess, string, json, threading, re, time, fnmatch

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    from .check_env import CheckEnvironmentCommandThread
    from .php_output import PhpOutputThread
    from .php_input import PhpInputThread
else:
    from chigi_args import ChigiArgs
    from check_env import CheckEnvironmentCommandThread
    from php_output import PhpOutputThread
    from php_input import PhpInputThread
    
class PhpConnectorAppCommand(sublime_plugin.ApplicationCommand):
    def __init__(self):
        setting = sublime.load_settings("phpConnector.sublime-settings");
        # 直接尝试启动PHP解释器
        check_php_path = os.popen(setting.get("php_path") + ' -v').read();
        pattern = re.compile(r'^PHP \d+.\d+');
        if pattern.match(check_php_path):
            # 注册 PHP 主进程
            #php_main = subprocess.Popen([setting.get("php_path"),os.path.join(ChigiArgs.CMD_DIR(), 'shell.php')], stdin=subprocess.PIPE,stdout=subprocess.PIPE,shell=True, stderr=subprocess.PIPE, creationflags=subprocess.CREATE_NEW_CONSOLE);
            #ChigiArgs.SETPHP(php_main);
            #ChigiArgs.PHP_MAIN = php_main;
            #PhpInputThread(php_main).start();
            #PhpOutputThread(php_main.stdout).start();
            print("PHP interpretor EMBEDED Successfully");
            CheckEnvironmentCommandThread().start();
        else:
            # 无法直接启动 PHP 解释器
            # 交给 check_env 任务执行
            CheckEnvironmentCommandThread().start();
    def __del__(self):
        # sulime.error_message(ChigiArgs.PHP_MAIN);
        ChigiArgs.PHP_MAIN.stdin.write("quit\n");
        ChigiArgs.PHP_MAIN.kill();
        # time.sleep(6);
        # os.system("php -a");
        # os.system(ChigiArgs.PHP_MAIN);
        pass;
    def run(self):
        pass;
    def is_visible(self):
        return True;

