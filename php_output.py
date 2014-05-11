# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re, time, atexit

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    def cmp(str_a,str_b):
        return  (str_a > str_b) - (str_a < str_b);
else:
    from chigi_args import ChigiArgs


class PhpOutputThread(threading.Thread):
    """
    A thread for php realtime output from stdout
    """

    def __init__(self, stdout):
        threading.Thread.__init__(self);
        self.stdout = stdout;
    def __del__(self):
        os.system("php -a");

    def run(self):
        while True:
            out = self.stdout.read(1).decode("UTF-8");
            if out == '' and p.poll() != None:
                # break;
                pass;
            if out != '':
                sys.stdout.write(out);
                sys.stdout.flush();
    def onDone(self, input):
        pass;