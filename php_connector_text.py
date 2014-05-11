# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re
import base64

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    from .check_env import CheckEnvironmentCommandThread
else:
    from chigi_args import ChigiArgs
    from check_env import CheckEnvironmentCommandThread

class PhpConnectorTextCommand(sublime_plugin.TextCommand):
    def __init__(self,view):
        self.view = view;
    def run(self, edit, classPath, user_args):
        self.chigiArgs = {
            'view': self.view,
            'call' : classPath,
            'user_args': user_args
        };
        if self.view.file_name():
            # 1. 加载配置信息
            self.setting = sublime.load_settings("phpConnector.sublime-settings");
            php_path = self.setting.get("php_path");
            # 2. 验证当前 PHP 解释器可用性
            p_check = subprocess.Popen([php_path,"-v"],stdout=subprocess.PIPE,shell=True);
            check_php_path = p_check.communicate()[0];
            pattern = re.compile(r'^PHP \d+.\d+');
            if pattern.match(check_php_path.decode(self.setting.get("filesystem_encoding"))):
                pass;
            else:
                sublime.error_message("PhpConnector: \n\nPlease provide an available PHP binary file.");
                return;
            # 3. 加载参数列表
            command_to_run = {
                'call' : classPath,
                'editor' : {
                    'currentView' : {
                        'fileName' : self.view.file_name()
                    }
                },
                'ns' : self.setting.get("namespaces"),
                'user_args' : user_args,
                'enc' : self.setting.get("filesystem_encoding")
            }
            # 4. 开始进行 PHP 通信
            print('"' + php_path + '" "' + ChigiArgs.CMD_PATH() + '" ' + base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8'));
            p1 = subprocess.Popen([php_path,ChigiArgs.CMD_PATH(),base64.b64encode(json.dumps(command_to_run, sort_keys=True).encode('utf-8')).decode('utf-8')],stdout=subprocess.PIPE,shell=True);
            result_str_raw = p1.communicate()[0];
            result_str = "";
            try:
                result_str = base64.b64decode(result_str_raw);
            except (TypeError):
                print(result_str_raw);
                sublime.error_message(u"PhpConnector: \n\nSYSTEM ERROR!!!");
            result = 0;
            try:
                result = json.loads(result_str.decode('utf-8'));
            except (ValueError):
                print('The return value for the php plugin is wrong JSON.',True);
                if len(result_str)>0:
                    sublime.error_message(u"PHP ERROR:\n{0}".format(result_str));
                return;
            # -------------------------------------------------------------------
            #                 PHP 通信完成，开始处理结果
            # -------------------------------------------------------------------
            # --push status message--
            if result.get('status_message'):
                sublime.status_message(u'PhpConnector: ' + result.get('status_message'));
            # END--push status message--

            # --Determine on code--
            ones = result.get('code')%10;
            tens = (result.get('code') % 100)/10;
            if result.get('code') >= 200 and result.get('code') < 300:
                if ones == 0:
                    # NONE ACTION
                    pass;
                elif ones == 1:
                    # OPEN a File
                    try:
                        os.startfile(result.get('data'));
                    except Exception as e:
                        print(e);
                    finally:
                        pass;
                elif ones == 7:
                    # Copy to Clipboard
                    sublime.set_clipboard(result.get("data"));
                    pass;
                elif ones == 8:
                    print(result);
                    pass;
                elif ones == 9:
                    # Render a json list onto the quickPanel
                    ChigiArgs.arguments = self.chigiArgs;
                    self.chigiArgs['commandList'] = result.get('data');
                    self.view.window().run_command('php_connector');
                    pass;
                else:
                    pass;
            elif result.get('code') >= 500 and result.get('code') < 600:
                # ERROR LEVEL: Must alert the msg.
                if tens == 2:
                    # The data is to be used as a string.
                    # Alert the string data as message.
                    print(result.get('data'));
                    sublime.error_message(u"PhpConnector: \n\n{0}".format(result.get('data')));
                else:
                    # Alert the message directly.
                    sublime.error_message(u"PhpConnector: \n\n{0}".format(result.get('msg')));
            else:
                # WARNING LEVEL: Base upon the php return.
                pass;
            # END --Determine on code--
        else :
            print("SYSTEM ERROR");
    def is_visible(self):
        return True;