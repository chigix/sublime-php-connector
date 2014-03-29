import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re
import base64
from chigi_args import ChigiArgs
from check_env import CheckEnvironmentCommandThread

class PhpConnectorTextCommand(sublime_plugin.TextCommand):
    def __init__(self,view):
        self.view = view;
        if(ChigiArgs.CHECK_IS_BOOT):
            CheckEnvironmentCommandThread(sublime,view.window()).start();
            ChigiArgs.CHECK_IS_BOOT = False;
    def run(self, edit, classPath, user_args):
        self.chigiArgs = {
            'view': self.view,
            'call' : classPath,
            'user_args': user_args
        };
        if self.view.file_name():
            self.setting = sublime.load_settings("phpConnector.sublime-settings");
            php_path = self.setting.get("php_path");
            check_php_path = os.popen(php_path + ' -v').read();
            pattern = re.compile(r'^PHP \d+.\d+');
            if pattern.match(check_php_path):
                pass
            else:
                sublime.error_message("PhpConnector: \n\nPlease provide an available PHP binary file.");
                return;
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
            print(php_path + ' ' + ChigiArgs.CMD_PATH() + ' ' + base64.b64encode(json.dumps(command_to_run, sort_keys=True)));
            result_str_raw = os.popen(php_path + ' ' + ChigiArgs.CMD_PATH() + ' ' + base64.b64encode(json.dumps(command_to_run, sort_keys=True))).read();
            result_str = "";
            try:
                result_str = base64.b64decode(result_str_raw);
            except (TypeError):
                sublime.error_message("PhpConnector: \n\n{0}".format(result_str_raw))
                print(result_str);
            result = 0;
            try:
                result = json.loads(result_str);
            except (ValueError):
                print('The return value for the php plugin is wrong JSON.',True);
                if len(result_str)>0:
                    sublime.error_message("PHP ERROR:\n{0}".format(result_str));
                return;
            # --push status message--
            if result.get('status_message'):
                sublime.status_message('PhpConnector: ' + result.get('status_message'));
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
                    except Exception, e:
                        print(e);
                    finally:
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
                    sublime.error_message("PhpConnector: \n\n{0}".format(result.get('data')));
                else:
                    # Alert the message directly.
                    sublime.error_message("PhpConnector: \n\n{0}".format(result.get('msg')));
            else:
                # WARNING LEVEL: Base upon the php return.
                pass;
            # END --Determine on code--
        else :
            print("SYSTEM ERROR");
	def is_visible(self):
		return True;
		# return self.view.file_name() and (self.view.file_name()[-3:] == ".md" or
		# 	#self.view.file_name()[-5:] == ".HTML" or
		# 	#self.view.file_name()[-4:] == ".htm" or
		# 	self.view.file_name()[-9:] == ".markdown")