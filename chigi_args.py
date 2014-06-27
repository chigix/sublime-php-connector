# -*- coding: utf-8 -*-
import sublime, sublime_plugin, sys
import os, subprocess, string, json, threading, re, time, base64, binascii

import sublime,copy

class ChigiArgs(object): 
    version = 2.5;   #static
    name = "PhpConnector";
    arguments = {};  #static
    CHECK_IS_BOOT = True; #static
    PHP_MAIN = None;
    instance=None;
    mutex=threading.Lock();
    @staticmethod
    def GetInstance():
        if(ChigiArgs.instance==None):
            ChigiArgs.mutex.acquire()
            if(ChigiArgs.instance==None):
                # print('初始化实例')
                ChigiArgs.instance=ChigiArgs()
            else:
                # print('单例已经实例化')
                pass;
            ChigiArgs.mutex.release()
        else:
            #print('单例已经实例化')
            pass;
           
        return ChigiArgs.instance
    def __init__(self,name='PhpConnector'):
        '''constructor'''
        self.name = name    #class instance(data) attribute
        self.cmdManager = {};
        self.currentView = None;
    def showname(self):
        '''display instance attribute and class name'''
        print('Your name is ' + self.name);
        print('My name is' + self.__class__.__name__);  #Class Name
   
    @classmethod
    def showver(self):
        '''display class(static) attribute'''
        print(self.version);
    def addMe2Me(self,x):
        return x + x
    def getVersion(self):
        return self.version
    def setVersion(self,ver):
        self.version = ver
    def getName(self):
    	return self.name;
    # Get the current arguments only once and clear it
    def getArgs(self):
        tmpArgs = copy.copy(self.arguments);
        ChigiArgs.arguments = {};
        return tmpArgs;
    def getClassName(self):
        return self.__class__.__name__
    @staticmethod
    def staticMethod():
        print("static method");
    @staticmethod
    def PKGPATH():
        return os.path.join(sublime.packages_path(), "PhpConnector");
    @staticmethod
    def CMD_DIR():
        return os.path.join(ChigiArgs.PKGPATH(), 'sublime_php_command');
    @staticmethod
    def CMD_PATH():
        return os.path.join(ChigiArgs.CMD_DIR(), 'sublime.php');