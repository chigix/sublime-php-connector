import sublime, sublime_plugin
import os, subprocess, string, json, threading, re, time, fnmatch

ST3 = int(sublime.version()) > 3000
if ST3:
    from .chigi_args import ChigiArgs
    from .check_env import CheckEnvironmentCommandThread
else:
    from chigi_args import ChigiArgs
    from check_env import CheckEnvironmentCommandThread

class PhpConnectorCommand(sublime_plugin.WindowCommand):
    def __init__(self, window):
        self.window = window;
        setting = sublime.load_settings("phpConnector.sublime-settings");
    def run(self):
        ListCommandThread(self.window).start()
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
        self.commandList = [];
        self.commandObjList = [];
        if self.chigiArgs.get('quick_load') is True:
            # Accelerate on ctrl+shift+r
            for namespace in self.setting.namespaces:
                edits = [("${entryDir}", ChigiArgs.CMD_DIR())]; # etc.
                for search, replace in edits:
                    self.setting.namespaces[namespace] = self.setting.namespaces[namespace].replace(search, replace);
                for root, dirnames, filenames in os.walk(self.setting.namespaces[namespace]):
                    for filename in fnmatch.filter(filenames, '*.phpconnector-commands'):
                        f = open(os.path.join(root, filename));
                        for command in json.load(f):
                            if command.get('format'):
                                for format in command.get('format'):
                                    if self.currentFileName[-len(format):] == format:
                                        tmp_to_list = [];
                                        tmp_to_list.append(command.get('name'));
                                        self.commandObjList.append(command);
                                        self.commandList.append(tmp_to_list);
                                        pass;
                            else:
                                tmp_to_list = [];
                                tmp_to_list.append(command.get('name'));
                                self.commandObjList.append(command);
                                self.commandList.append(tmp_to_list);
                        pass;
                    pass;
        else:
            # fetch the data of command list and render it into panel directly
            self.chigiArgs.get("view");
            for command in self.chigiArgs.get("commandList"):
                print(command.get('format'));
                tmp_to_list = [];
                tmp_to_list.append(command.get('name'));
                self.commandObjList.append(command);
                self.commandList.append(tmp_to_list);
            pass;
        def show_quick_panel():
            self.window.show_quick_panel(self.commandList, self.on_done);
            # if not self.package_list:
                # print('There are no packages to list')
                # return
        sublime.set_timeout(show_quick_panel, 10)
    def on_done(self, picked):
        """
        Quick panel user selection handler - opens the homepage for any
        selected package in the user's browser

        :param picked:
            An integer of the 0-based package name index from the presented
            list. -1 means the user cancelled.
        """
        if picked >= 0:
            commandPicked = self.commandObjList[picked];
            self.chigiArgs.get("view").run_command('php_connector_text',
                {
                    "classPath":commandPicked['class'],
                    "user_args":commandPicked['user_args']
                });
            pass;
        else:
            print("BANKAI");
            pass;