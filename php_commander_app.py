import sublime, sublime_plugin
import os, sys, subprocess, string, json, threading, re, time, fnmatch

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    from .check_env import CheckEnvironmentCommandThread
else:
    from chigi_args import ChigiArgs
    from check_env import CheckEnvironmentCommandThread
    
class PhpConnectorAppCommand(sublime_plugin.ApplicationCommand):
    def __init__(self):
        self.PHP_MAIN = None;
        setting = sublime.load_settings("phpConnector.sublime-settings");
        print("#####################");
        CheckEnvironmentCommandThread(self).start();
        print("BANKAI");
        # this.php_main = subprocess.Popen([self.php_path,os.path.join(ChigiArgs.CMD_DIR(), 'shell.php')], stdin=subprocess.PIPE,stdout=subprocess.PIPE,shell=True, stderr=subprocess.PIPE, creationflags=subprocess.CREATE_NEW_CONSOLE);
        # sublime.error_message("BANKAISIMASU");
    def __del__(self):
        # sulime.error_message(ChigiArgs.PHP_MAIN);
        self.PHP_MAIN.stdin.write("quit\n");
        self.PHP_MAIN.kill();
        # time.sleep(6);
        # os.system("php -a");
        # os.system(ChigiArgs.PHP_MAIN);
        pass;
    def run(self):
        print("VVVVVVVVVVVVVVVVVVVVVVV");
        pass;
        # ListCommandThread(self.window).start()
    def is_visible(self):
        return True;

class ListCommandThread(threading.Thread):
    """
    A thread to prevent the listing of commands from freezing the UI
    """

    def __init__(self, window):
        args = ChigiArgs();
        self.chigiArgs = args.getArgs();
        self.setting = sublime.load_settings("phpConnector.sublime-settings");
        self.setting.namespaces = self.setting.get("namespaces");
        self.window = window;
        self.currentFileName = self.chigiArgs.get('view').file_name();
        threading.Thread.__init__(self);

    def run(self):
        pass;