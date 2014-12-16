# -*- coding: utf-8 -*-
import sublime, sublime_plugin
import os, subprocess, string, json, threading, re, time, signal

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    from .php_input import PhpInputThread
    from .php_output import PhpOutputThread
    def cmp(str_a,str_b):
        return  (str_a > str_b) - (str_a < str_b);
else:
    from chigi_args import ChigiArgs
    from php_input import PhpInputThread
    from php_output import PhpOutputThread

class CheckEnvironmentCommandThread(threading.Thread):
    """
    A thread to prevent wizard for configure from freezing the UI
    """

    instance=None;
    mutex=threading.Lock();
    @staticmethod
    def GetInstance():
        if(CheckEnvironmentCommandThread.instance==None):
            CheckEnvironmentCommandThread.mutex.acquire()
            if(CheckEnvironmentCommandThread.instance==None):
                # print('初始化实例')
                CheckEnvironmentCommandThread.instance=CheckEnvironmentCommandThread()
            else:
                # print('单例已经实例化')
                pass;
            CheckEnvironmentCommandThread.mutex.release()
        else:
            #print('单例已经实例化')
            pass;
           
        return CheckEnvironmentCommandThread.instance

    def __init__(self):
        threading.Thread.__init__(self);
        self.running = False;
        self.setting = sublime.load_settings("phpConnector.sublime-settings");
        self.encoding = self.setting.get("filesystem_encoding");
        self.namespace = self.setting.get("namespaces");
        self.composer = self.setting.get("composer");
        self.php_path = None;
        self.window = None;
        self.windows = [];

    def run(self):
        self.running = True;
        # 检测 PHP 环境
        def freshSettings():
            self.setting = sublime.load_settings("phpConnector.sublime-settings");
            self.encoding = self.setting.get("filesystem_encoding");
            self.namespace = self.setting.get("namespaces");
            self.php_path = self.setting.get("php_path");
            print("1###");
            print(self.php_path);
        time.sleep(1);
        sublime.set_timeout(freshSettings,1);
        time.sleep(1);
        print("2###");
        check_php_path = os.popen(self.php_path + ' -v').read();
        print("3###");
        pattern = re.compile(r'^PHP \d+.\d+');
        if pattern.match(check_php_path):
            self.check_php_path = True;
        else:
            self.check_php_path = False;
        # 检测 sublime 窗口打开完毕
        def freshWindows():
            self.windows = sublime.windows();
        while(True):
            historyWindows = self.windows;
            time.sleep(0.5);
            sublime.set_timeout(freshWindows,1);
            if(len(self.windows) > len(historyWindows)):
                self.window = self.windows[0];
                break;
            pass;
        if(self.check_php_path is True):
            # 注册 PHP 主进程
            popen_list = [self.php_path, os.path.join(ChigiArgs.CMD_DIR(), 'shell.php')];
            if self.composer:
                popen_list.append(self.composer);
                pass
            php_main = subprocess.Popen(popen_list, stdin=subprocess.PIPE,stdout=subprocess.PIPE,shell=True, stderr=subprocess.PIPE, creationflags=subprocess.CREATE_NEW_CONSOLE);
            ChigiArgs.GetInstance().phpMain = php_main;
            PhpOutputThread(php_main.stdout).start();
            def initPHP():
                self.window.run_command("ax_text",{
                    "call":"\\Chigi\\Sublime\\Commands\\SetupEnvironment",
                    "cmd_args":{
                        "file_system_encoding":self.encoding,
                        "namespace_map":self.namespace
                    }
                });
            sublime.set_timeout(initPHP, 1);
            print("4###");
            #php_main.stdin.write("bankai\n".encode("UTF-8"));
            #php_main.stdin.write("QQCUM\n".encode("UTF-8"));
            #php_main.stdin.write(bytes("QQCUM\n","UTF-8"));
            #print(self.commanderApp.PHP_MAIN);
            return;
        # 当前 PHP 解释器不可用，自动进入配置向导
        time.sleep(0.3);
        wizard_open = False;
        if(self.check_php_path is False):
            wizard_open = sublime.ok_cancel_dialog("PhpConnector: \n\nPlease provide an available PHP binary file into the environment setting of PhpConnector.");
        def inputPhpPath():
            self.window.show_input_panel('PHP PATH on your system', self.setting.get("php_path"),self.onDone, self.onChange, self.onCancel)
            # sublime.run_command("open_file",{"file": "${packages}/PhpConnector/phpConnector.sublime-settings"});
        if(wizard_open is True):
            sublime.set_timeout(inputPhpPath, 10);
    def onDone(self, input):
        self.setting.set('php_path', input);
        sublime.save_settings('phpConnector.sublime-settings');
        sublime.status_message(('%s successfully ' 
            + 'specified') % input);
        self.checkFileSystemEnc();
    def onChange(self, input):
        pass;
    def onCancel(self):
        pass;
        
    def checkFileSystemEnc(self):
        wizard_open = False;
        wizard_open = sublime.ok_cancel_dialog(u"Then please ensure the correct encoding on your current file system.\n\n中文 Windows 系统请在接下来的输入框中输入 gbk\n\n日本語のシステムは shift-jis を入力ください");
        def inputEnc():
            self.window.show_input_panel('File System Encoding', self.setting.get("filesystem_encoding"),self.doneFileSystemEnc, self.onChange, self.onCancel);
        if(wizard_open is True):
            sublime.set_timeout(inputEnc, 10);
        pass;
    def doneFileSystemEnc(self,input):
        self.setting.set('filesystem_encoding', input);
        sublime.save_settings('phpConnector.sublime-settings');
        sublime.status_message(('%s successfully ' 
            + 'specified') % input);
        if(cmp(input.lower(),'gbk')==0):
            sublime.ok_cancel_dialog(u"开始嗨皮地使用 PHP 来开发 Sublime 插件吧~~");
            self.window.open_file(os.path.join(ChigiArgs.PKGPATH(),'readme.md'));
            os.startfile(os.path.join(ChigiArgs.PKGPATH(),'docs','welcome.zhcn.html'));
            pass;
        else:
            self.window.open_file(os.path.join(ChigiArgs.PKGPATH(),'readme.md'));
        pass;