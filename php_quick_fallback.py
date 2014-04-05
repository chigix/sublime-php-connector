import sublime, sublime_plugin
import os, subprocess, string
from chigi_args import ChigiArgs

class PhpQuickFallbackCommand(sublime_plugin.TextCommand):
    def run(self, edit):
        self.chigiArgs = {
            'view': self.view,
            'quick_load' : True
        };
        if self.view.file_name():
            #print(self.view.file_name());
            self.setting = sublime.load_settings("phpConnector.sublime-settings");
            php_path = self.setting.get("php_path");
            ChigiArgs.arguments = self.chigiArgs;
            self.view.window().run_command('php_connector');
        else :
            print("SYSTEM ERROR");

    def is_visible(self):
        return True
