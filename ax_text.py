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
        ChigiArgs.GetInstance().viewManager[self.view.id()] = self.view;
        ChigiArgs.GetInstance().currentView = self.view;
        command_to_run = {
            'id':id(self),
            'call':"\\Chigi\\Sublime\\Commands\\UpdateCurrentView",
            'args' : {
                'id' : self.view.id(),
                'file_name' : self.view.file_name(),
                'file_scope' : self.view.scope_name(0),
                'sel_pos' : [self.view.sel()[0].begin(),self.view.sel()[0].end()],
                'sel_scope' : self.view.scope_name(self.view.sel()[0].begin())
            }
        };
        cmd_str = base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8');
        ChigiArgs.GetInstance().phpMain.stdin.write(cmd_str.encode("UTF-8"));
        ChigiArgs.GetInstance().phpMain.stdin.write("\n".encode("UTF-8"));
        command_to_run = {
            'id':id(self),
            'call':call,
            'args' : cmd_args
        };
        cmd_str = base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8');
        ChigiArgs.GetInstance().phpMain.stdin.write(cmd_str.encode("UTF-8"));
        ChigiArgs.GetInstance().phpMain.stdin.write("\n".encode("UTF-8"));
        pass;

    def is_visible(self):
        return True;
