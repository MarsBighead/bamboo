#!/usr/bin/python
# -*- coding: UTF-8 -*-

import xml.sax

class ConfigHandler( xml.sax.ContentHandler ):
    def __init__(self):
        self.CurrentData = ""
        self.dbType = ""
        self.dbName = ""
        self.dbUser = ""
        self.rating = ""
        self.password = ""
        self.description = ""
        
    # 元素开始事件处理
    def startElement(self, tag, attributes):
        self.CurrentData = tag
        if tag == "databases":
            print "*****Config*****"
            print "Tag:",tag 
        
    # 元素结束事件处理
    def endElement(self, tag):
       if self.CurrentData == "dbType":
           print "dbType:", self.dbType
       elif self.CurrentData == "dbName":
           print "dbName:", self.dbName
       elif self.CurrentData == "dbUser":
           print "dbUser:", self.dbUser
       elif self.CurrentData == "password":
           print "Password:", self.password
       self.CurrentData = ""
       
    # 内容事件处理
    def characters(self, content):
        if self.CurrentData == "dbType":
            self.dbType = content
        elif self.CurrentData == "dbName":
            self.dbName = content
        elif self.CurrentData == "dbUser":
            self.dbUser = content
        elif self.CurrentData == "password":
            self.password = content
        
if ( __name__ == "__main__"):
    
    # 创建一个 XMLReader
    parser = xml.sax.make_parser()
    # turn off namepsaces
    parser.setFeature(xml.sax.handler.feature_namespaces, 0)
    
    # 重写 ContextHandler
    Handler = ConfigHandler()
    parser.setContentHandler( Handler )
    
    parser.parse("config.xlm")
