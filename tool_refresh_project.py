# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re
import base64

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
else:
    from chigi_args import ChigiArgs

class ToolRefreshProjectCommand(sublime_plugin.TextCommand):
    def __init__(self,view):
        self.view = view;
        ChigiArgs.GetInstance().cmdManager[id(self)] = self;
    def __del__(self):
        print(u"结束");
        ChigiArgs.GetInstance().cmdManager[id(self)] = None;
        pass;
    def run(self, edit):
        # 1. 加载配置信息
        self.setting = sublime.load_settings("phpConnector.sublime-settings");
        ChigiArgs.GetInstance().viewManager[self.view.id()] = self.view;
        ChigiArgs.GetInstance().currentView = self.view;
        command_to_run = {
            'id':id(self),
            'call':"\\Chigi\\Sublime\\Commands\\RefreshProject",
            'args' : {
                "paths" : self.view.window().folders()
            }
        };
        cmd_str = base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8');
        ChigiArgs.GetInstance().phpMain.stdin.write(cmd_str.encode("UTF-8"));
        ChigiArgs.GetInstance().phpMain.stdin.write("\n".encode("UTF-8"));
        pass;

    def is_visible(self):
        return True;
