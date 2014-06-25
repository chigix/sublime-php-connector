# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re, time, base64, binascii

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
        
    def executeReceive(self, result):
        returned_data = result[2];
        data_type = "UNKNONW";
        if(result[0][1] is 0):
            data_type = "NUMBER";
        elif result[0][1] is 1:
            data_type = "STRING";
        elif result[0][1] is 2:
            data_type = "EXCEPTION";
        elif result[0][1] is 3:
            data_type = "ARRAY";
        elif result[0][1] is 4:
            data_type = "OBJECT";
        elif result[0][1] is 5:
            data_type = "NONE";
        if(result[0][2] is 1):
            # TODO Open a file
            pass;
        elif result[0][2] is 3:
            # RUN Developed PHP CMD OBJ
            self.runCmd("ax_text",{
                "call" : result[2][2], 
                "cmd_args":result[2][7]
            });
            pass;
        elif result[0][2] is 6:
            print(u"【INFO】 " + result[1]);
        elif result[0][2] is 7:
            # TODO Copy to clipboard
            pass;
        elif result[0][2] is 8:
            # DEBUG
            print(u"【" + data_type + u"】 " + result[1]);
            print(returned_data);
        elif result[0][2] is 9:
            # TODO show quick panel
            show_list = [];
            obj_list = [];
            for item in result[2]:
                show_list.append(item[0]);
                obj_list.append(item[1]);
            def quick_panel_ondone(input):
                self.executeReceive(obj_list[input]);
            def quick_panel_run_command():
                ChigiArgs.GetInstance().currentView.window().show_quick_panel(show_list, quick_panel_ondone);
            sublime.set_timeout(quick_panel_run_command, 1)
            pass;
        else:
            print(result);

    def run(self):
        temp_buffer = '';
        while True:
            out = self.stdout.read(1).decode("UTF-8");
            if out == '' and p.poll() != None:
                # break;
                pass;
            else:
                if out == "\n":
                    result_str_raw = temp_buffer;
                    temp_buffer = "";
                    result_str = "";
                    try:
                        result_str = base64.b64decode(result_str_raw);
                    except (TypeError):
                        print(result_str_raw);
                        continue;
                    except (binascii.Error):
                        print(result_str_raw);
                        continue;
                    result = 0;
                    try:
                        result = json.loads(result_str.decode('utf-8'));
                    except (ValueError):
                        print('The return value for the php plugin is wrong JSON.',True);
                        if len(result_str)>0:
                            try:
                                sublime.error_message(u"PHP ERROR:\n{0}".format(result_str.decode('utf-8')));
                            except(UnicodeDecodeError):
                                sublime.error_message(u"PHP ERROR:\n{0}".format(result_str_raw));
                        continue;
                    # -------------------------------------------------------------------
                    #                 PHP 通信完成，开始处理结果
                    # -------------------------------------------------------------------
                    self.executeReceive(result);
                else:
                    temp_buffer = temp_buffer + out;
    def onDone(self, input):
        pass;
    def runCmd(self, name, args):
        def now_to_run():
            ChigiArgs.GetInstance().currentView.window().run_command(name, args);
        sublime.set_timeout(now_to_run, 1);