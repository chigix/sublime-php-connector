import os
import re

import sublime,copy

class ChigiArgs(object): 
    '''my very first class:FooClass''' 
    version = 0.1   #static
    arguments = {}  #static
    def __init__(self,name='hejian'):
        '''constructor'''
        self.name = name    #class instance(data) attribute
    def showname(self):
        '''display instance attribute and class name'''
        print 'Your name is ',self.name
        print 'My name is',self.__class__.__name__  #Class Name
   
    @classmethod
    def showver(self):
        '''display class(static) attribute'''
        print self.version
    def addMe2Me(self,x):
        return x + x
    def getVersion(self):
        return self.version
    def setVersion(self,ver):
        self.version = ver
    def getArgs(self):
        tmpArgs = copy.copy(self.arguments);
        ChigiArgs.arguments = {};
        return tmpArgs;
    def getClassName(self):
        return self.__class__.__name__
    @staticmethod
    def staticMethod():
        print "static method"