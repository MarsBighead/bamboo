#!/usr/bin/python
# -*- coding: UTF-8 -*-
from xml.dom.minidom import parse
import xml.dom.minidom

# 使用minidom解析器打开 XML 文档
DOMTree = xml.dom.minidom.parse("config.xml")
collection = DOMTree.documentElement
if collection.hasAttribute("shelf"):
    print "Root element : %s" % collection.getAttribute("shelf")

# 在集合中获取所有电影
movies = collection.getElementsByTagName("databases")

# 打印每部电影的详细信息
for movie in movies:
    print "*****Movie*****"
    if movie.hasAttribute("title"):
        print "Title: %s" % movie.getAttribute("title")
        
        type = movie.getElementsByTagName('dbType')[0]
        print "Type: %s" % type.childNodes[0].data
        format = movie.getElementsByTagName('dbName')[0]
        print "Format: %s" % format.childNodes[0].data
        rating = movie.getElementsByTagName('dbUser')[0]
        print "Rating: %s" % rating.childNodes[0].data
        description = movie.getElementsByTagName('password')[0]
        print "Description: %s" % description.childNodes[0].data
