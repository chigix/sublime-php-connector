import sublime, sublime_plugin
import os, subprocess, string

class PhpConnectorCommand(sublime_plugin.TextCommand):
	def run(self, edit, script, args_string):
		if self.view.file_name():
			#print(self.view.file_name());
			self.setting = sublime.load_settings("phpConnector.sublime-settings");
			php_path = self.setting.get("php_path");
			command_dir = self.setting.get("commands_dir");
			#print(php_path);
			#print(command_dir + '/' + script);
			result = os.popen(php_path + ' ' + command_dir+'/'+script + ' ' + args_string + ' file="' + self.view.file_name() + '"').read();
			print(result);
		else :
			print("SYSTEM ERROR");

	def is_visible(self):
		return self.view.file_name() and (self.view.file_name()[-3:] == ".md" or
			#self.view.file_name()[-5:] == ".HTML" or
			#self.view.file_name()[-4:] == ".htm" or
			self.view.file_name()[-9:] == ".markdown")
