# -*- coding: utf-8 -*-
import os, sublime
import re

import sublime,copy

class ChigiArgs(object): 
    version = 2.5   #static
    name = "PhpConnector";
    arguments = {}  #static
    CHECK_IS_BOOT = True #static
    def __init__(self,name='PhpConnector'):
        '''constructor'''
        self.name = name    #class instance(data) attribute
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