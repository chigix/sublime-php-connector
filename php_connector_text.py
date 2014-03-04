import sublime, sublime_plugin
import os, subprocess, string, json, threading, re
from chigi_args import ChigiArgs

class PhpConnectorTextCommand(sublime_plugin.TextCommand):
	def run(self, edit, script, classPath, args_string):
		self.chigiArgs = {
			'view': self.view,
			'script': script,
			'call' : classPath,
			'args_string': args_string
		};
		if self.view.file_name():
			self.setting = sublime.load_settings("phpConnector.sublime-settings");
			php_path = self.setting.get("php_path");
			command_dir = self.setting.get("commands_dir");
			check_php_path = os.popen(php_path + ' -v').read();
			pattern = re.compile(r'^PHP \d+.\d+');
			if pattern.match(check_php_path):
				pass
			else:
				sublime.error_message("PhpConnector: \n\nPlease provide an available PHP binary file.");
				return;
			#print(php_path);
			#print(command_dir + '/' + script);
			result_str = os.popen(php_path + ' ' + command_dir+'/'+script + ' ' + 'call=' + classPath + ' ' + args_string + ' file="' + self.view.file_name() + '"').read();
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
					# Alert the string as message.
					sublime.error_message("PhpConnector: \n\n{0}".format(result.get('data')));
				else:
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