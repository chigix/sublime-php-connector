# -*- coding: utf-8 -*-
import sublime, sublime_plugin
import os, subprocess, string, json, threading, re, time

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    def cmp(str_a,str_b):
        return  (str_a > str_b) - (str_a < str_b);
else:
    from chigi_args import ChigiArgs


class PhpInputThread(threading.Thread):
    """
    A thread for php stdin pipe
    """

    def __init__(self, stdin):
        threading.Thread.__init__(self);
        self.setting = sublime.load_settings("phpConnector.sublime-settings");
        php_path = self.setting.get("php_path");
        self.stdin = stdin;

    def run(self):
        pass;
    def onDone(self, input):
        pass;