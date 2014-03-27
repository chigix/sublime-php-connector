import sublime, sublime_plugin
import os, subprocess, string, json, threading, re, time

class CheckEnvironmentCommandThread(threading.Thread):
	"""
	A thread to prevent wizard for configure from freezing the UI
	"""

	def __init__(self, sublime,window):
		threading.Thread.__init__(self);
		self.window = window;
		self.setting = sublime.load_settings("phpConnector.sublime-settings");
		php_path = self.setting.get("php_path");
		check_php_path = os.popen(php_path + ' -v').read();
		pattern = re.compile(r'^PHP \d+.\d+');
		if pattern.match(check_php_path):
			self.check_php_path = True;
		else:
			self.check_php_path = False;

	def run(self):
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
			+ 'specified') % input)
	def onChange(self, input):
		pass;
	def onCancel(self):
		pass;