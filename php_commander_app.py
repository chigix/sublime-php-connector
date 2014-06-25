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

