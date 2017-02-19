# Copyright ReportLab Europe Ltd. 2000-2015
# see license.txt for license details

# Basic test suite for Preppy.py
# See check_load.py for load testing

# $Id$

import os, glob
import preppy
import unittest

class SimpleTestCase(unittest.TestCase):
    def setUp(self):
        import check_basics
        self.dirName = os.path.dirname(check_basics.__file__)

    def check01ScriptTag(self):
        processTest('sample001')

    def check02ForAndWhileLoops(self):
        processTest('sample002')

    def check03IfTags(self):
        processTest('sample003')

    def check04PassingDictionaries(self):
        dictionary = {"song1": {"songtitle": "The Lumberjack Song", "by": "Monthy Python"},
                      "song2": {"songtitle": "My Way", "by": "Frank Sinatra"}}
        processTest('sample004', dictionary)

    def check05Escapes(self):
        processTest('sample005')

    def check06NoPythonFile(self):
        mod = preppy.getModule(os.path.join(self.dirName, 'sample006'), savefile=0)
        outFile = open(os.path.join(self.dirName, 'sample006.html'), 'w')
        mod.run(dictionary={}, outputfile = outFile)
        outFile.close()

    def check07NoOutputFile(self):
        sourceString = """<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
        <HTML>
        <HEAD>
        <TITLE>ReportLab Preppy Test Suite 007</TITLE>
        </HEAD>

        <BODY>
        <FONT COLOR=#000000>
        <TABLE BGCOLOR=#0000CC BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100%>
        <TR>
        <TD>
        <FONT COLOR=#FFFFFF>
        <CENTER>
        <H1>Preppy Test 007 - Creating A Module Without Using The Filesystem</H1>
        </CENTER>
        </FONT>
        </TD>
        </TR>
        </TABLE>

        <BR>

        This test creates a preppy source module in memory. It does <I>not</I> have a preppy source file (a file ending in '.prep')

        <H2>Expected Output</H2>
        <P>

        Below is a listing of the files in the same directory as this HTML file. There should be no file called <I>sample007.prep</I>.


        <BR><HR>
        <BR><CENTER>
        <TABLE>
        {{script}}
        import os
        leftColumn = []
        rightColumn = []

        fileList = os.listdir(os.getcwd())

        for item in range(0,len(fileList),2):
            if os.path.isfile(fileList[item]):
                leftColumn.append(fileList[item])

        for item in range(1,len(fileList)-1,2):
            if os.path.isfile(fileList[item]):
                rightColumn.append(fileList[item])

        for loopCounter in range(0, len(leftColumn)):
            __write__("<TR><TD WIDTH=30%>")
            __write__(leftColumn[loopCounter])
            __write__("</TD>")
            __write__("<TD WIDTH=30%>")
            try:
                __write__(rightColumn[loopCounter])
                __write__("</TD></TR>")
            except:
                __write__(" ")
                __write__("</TD></TR>")
                {{endscript}}
        </TD></TR>
        </TABLE>
        </CENTER>

        <BR>
        <HR>

        </FONT>
        </BODY>
        </HTML>"""

        mod = preppy.getModule("dummy_module", sourcetext=sourceString)
        modDataList=[]
        tempDict={'temp':'temporary variable'}

        # this way it goes to the string
        #from reportlab.lib.utils import getStringIO
        #f = getStringIO()
        #mod.run(tempDict, outputfile=f)
        #f.seek(0)
        #output = f.read()

        #this way it goes to the list and also gets printed
        mod.run(tempDict, __write__ = modDataList.append)
        #print('length of list is %d' % len(modDataList))
        output=''.join(modDataList)
        outFile=open('sample007.html', 'w')
        outFile.write(output)
        outFile.close()

    def check08_StringKeysThatLookLikeIntegers(self):
        # This test case now works as expected
        processTest('sample008',
                    {'1':'The key for this dictionary item looks like a number, but is actually a string',
                     '2':'So is this one - it looks like an integer'}
                    )

    def check09_StringKeysThatLookLikeFloats(self):
        # This test case now works as expected too
        processTest('sample009',
                    {'1.01':'The key for this dictionary item looks like a number, but is actually a string',
                     '2.78':'So is this one - it looks like a floating point number'}
                    )

    def check10_PreppyInternals_VariableNames(self):
        # This list contains a number of names of variables that are/might be used internally within Preppy.
        preppyVariables = ["STARTDELIMITER", "ENDDELIMITER",
        "QSTARTDELIMITER", "QENDDELIMITER", "QUOTE", "QUOTEQUOTE",
        "UNESCAPES", "VERSION", "KEYWORDS","out","a", "start",
        "lines", "firstpass", "linemax", "result","s", "x",
        "Substringquotes", "cursor", "lineno", "DIAGNOSTIC_FUNCTION",
        "dictlines", "adddict", "done", "starttaglen", "endtaglen",
        "dictassntemplate", "key_seen", "findpercent", "findstarttag",
        "findmin", "sclean", "cursor", "findendtag", "savecursor",
        "ValueError", "block", "blockx", "sblock", "c", "rc",
        "substitutionline", "dictassntemplate", "stringsub",
        "addpart", "teststring", "yislonger", "loop",
        "TOPLEVELWRAPPER", "__save_sys_stdout__", "TOPLEVELPROLOG",
        "outputfile", "NameError", "__write__", "__d__", "__n__",
        "__c__", "__forbidden__", "indentstring", "toplevel",
        "DIAGNOSTIC_FUNCTION", "segment", "outputlist", "prints",
        "newcursor", "oldcursor", "inputtext", "startblock", "sblock",
        "conditional", "iconditional", "inif", "complexdirective",
        "inif", "directive", "ddblock", "blockmode",
        "compilemode","endtag", "endlocation", "inputtext",
        "endtag","t", "v", "tb", "code", "output", "starttaglen",
        "endtaglen", "newcursor", "inputtext", "findendtag",
        "startblock", "endblock", "block", "iout", "result",
        "module_source_template", "lk", "test", "lines",
        "module_source_template" "line0", "sline0", "ssline0",
        "firstword", "findfirstword", "indent", "linesout", "l",
        "lindent", "fn", "P", "out", "name", "result",
        "GLOBAL_LOADED_MODULE_DICTIONARY", "sourcetext", "verbose",
        "sourcefilename", "savefile", "module", "checksum",
        "sourcechecksum", "out", "outfilename", "outfile", "result",
        "textlines", "i", "l", "l1", "l2", "l3","getModule" ]
        dictionary = {}
        for f in range(0, len(preppyVariables)):
            tempvar = preppyVariables[f]
            #print("tempvar = %r" %tempvar)
            dictionary[tempvar] = tempvar
        processTest('sample010', dictionary)

    def check11_PreppyInternals_FunctionNames(self):
        # This lists contains a number of names of functions that are used internally within Preppy.
        preppyFunctions = ["unescape", "printstmt", "countnewlines",
        "quotestring" ,"diag" ,"slen", "quotedparts", "addpart",
        "indent", "__call__", "diag", "check_condition",
        "strip", "getDirectiveBlock", "module_source",
        "proctologist", "check_condition", "complexdirective",
        "dedent", "parsetest", "testgetmodule", "getPreppyModule",
        "cleantext", "new_module", "getPreppyModule"]
        dictionary = {}
        for f in range(0, len(preppyFunctions)):
            tempvar = preppyFunctions[f]
            #print("tempvar = %r" %tempvar)
            dictionary[tempvar] = tempvar
        processTest('sample011', dictionary)

    def check12_quotingOverride(self):
        processTest('sample012')

suite = unittest.makeSuite(SimpleTestCase,'check')

def processTest(filename, dictionary={}):
    #this ensures we search for prep files in the module
    #where this tests lives, wherever we invoked them from.
    import check_basics
    dirName = os.path.dirname(check_basics.__file__)
    #print('processTest: %r'%dictionary)
    root, ext = os.path.splitext(filename)
    outFileName = os.path.join(dirName, root + '.html')
    mod = preppy.getModule(os.path.join(dirName, root))
    outFile = open(outFileName, 'w')
    mod.run(dictionary, outputfile = outFile)
    outFile.close()
    #print('wrote %r' %outFileName)

def clean(dirname='.'):
    for filename in glob.glob('sample*.prep'):
        root, ext = os.path.splitext(filename)
        if os.path.isfile(root + '.html'):
            os.remove(root + '.html')
        if os.path.isfile(root + '.py'):
            os.remove(root + '.py')
        if os.path.isfile(root + '.pyc'):
            os.remove(root + '.pyc')
    for filename in glob.glob('*TestFile*.txt'):
        os.remove(filename)
    # Get rid of dynamically generated stuff not caught by the above code...
    try:
        os.remove('sample007.html')
        os.remove('sample013.prep')
        os.remove('sample014.prep')
    except:
        pass

if __name__=='__main__':
    import sys
    if len(sys.argv) == 2:
        arg = sys.argv[1]
        if arg == 'clean':
            clean()
            sys.exit()

        else:
            print('argument not recognised!')
    else:
        runner = unittest.TextTestRunner()
        runner.run(suite)
        print('\nplease read all sample*.html files')
