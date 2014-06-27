# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re
import base64

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
else:
    from chigi_args import ChigiArgs

class AxTextCommand(sublime_plugin.TextCommand):
    def __init__(self,view):
        self.view = view;
        ChigiArgs.GetInstance().cmdManager[id(self)] = self;
    def __del__(self):
        print(u"结束");
        ChigiArgs.GetInstance().cmdManager[id(self)] = None;
        pass;
    def run(self, edit, call, cmd_args):
        # 1. 加载配置信息
        self.setting = sublime.load_settings("phpConnector.sublime-settings");
        print(self.view.id());
        command_to_run = {
            'id':id(self),
            'call':call,
            'editor':{
                'currentView':{
                    'filename':self.view.file_name()
                }
            },
            'args' : cmd_args
        };
        cmd_str = base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8');
        ChigiArgs.GetInstance().currentView = self.view;
        ChigiArgs.PHP_MAIN.stdin.write(cmd_str.encode("UTF-8"));
        ChigiArgs.PHP_MAIN.stdin.write("\n".encode("UTF-8"));
        pass;

    def is_visible(self):
        return True;
