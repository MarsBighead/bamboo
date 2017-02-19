# Copyright ReportLab Europe Ltd. 2000-2015
# see license.txt for license details

# Load testing/ Stress testing suite for Preppy.py
# See check_basics.py for basic testing

# $Author$ (John Precedo - johnp@reportlab.com)
# $Date$


import os, glob
import preppy
import unittest

class LoadTestCase(unittest.TestCase):
    def lc01(self):
        # creates a 500 item dictionary
        howBig = 500
        d = makeBigDictionary(howBig)
        processTest('loadsample001', d)
    
    def lc02(self):
        # creates a 1,000 item dictionary
        howBig = 1000
        d = makeBigDictionary(howBig)
        processTest('loadsample002', d)

    def loadcheck03HugeDictionary10000(self):
        # creates a 10,000 item dictionary
        howBig = 10000
        d = makeBigDictionary(howBig)
        processTest('loadsample003', d)

    def loadcheck04_65KbFile(self):
        fileName = "sixtyfiveKTestFile.txt"
        size = 65
        makeBigFile(size, fileName)
        prepFilePartOne = """<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

        <HTML>
        <HEAD>
        <TITLE>ReportLab Preppy Test Suite - Load Test 004</TITLE>
        </HEAD>

        <BODY>

        <FONT COLOR=#000000>

        <TABLE BGCOLOR=#0000CC BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100% >
        <TR>
        <TD>
        <FONT COLOR=#FFFFFF>
        <CENTER>
        <H1>Preppy Load Test 004 - Testing Preppy With A 65Kb file</H1>
        </CENTER>
        </FONT>
        </TD>
        </TR>
        </TABLE>

        <BR>
        This test creates a file which is 65Kb in length, and checks that Preppy can handle a .prep file of that length.
        <H2>Expected Output</H2>
        You should see the words <I>Start</I> and <I>End</I> separated by 3 dots between the following lines.
        <BR><BR>

        <HR>
        <BR><BR>
        <CENTER>
        <TABLE>
        <TR><TD>"""
        prepFilePartTwo = """<BR>

        </TD></TR>
        </TABLE>
        </CENTER>

        <BR><BR>
        <HR>

        </FONT>
        </BODY>
        </HTML>"""
        input = open('sixtyfiveKTestFile.txt', 'r')
        prepMiddlebit = input.read()
        prepFile = prepFilePartOne + prepMiddlebit + prepFilePartTwo
        output = open('loadsample004.prep', 'w')
        output.write(prepFile)
        output.close()
        processTest('loadsample004')

# This is being commented out, since 1 Meg files seem to cause problems...
    def loadcheck05_1MbFile(self):
        fileName = "oneMegTestFile.txt"
        size = 1024
        makeBigFile(size, fileName)
        prepFilePartOne = """<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

        <HTML>
        <HEAD>
        <TITLE>ReportLab Preppy Test Suite - Load Test 005</TITLE>
        </HEAD>

        <BODY>

        <FONT COLOR=#000000>

        <TABLE BGCOLOR=#0000CC BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100% >
        <TR>
        <TD>
        <FONT COLOR=#FFFFFF>
        <CENTER>
        <H1>Preppy Test 005 - Testing Preppy With A 1Mb file</H1>
        </CENTER>
        </FONT>
        </TD>
        </TR>
        </TABLE>

        <BR>
        This test creates a file which is 1 Mb in length, and checks that Preppy can handle a 1 Meg .prep file.
        <H2>Expected Output</H2>
        You should see the words <I>Start</I> and <I>End</I> separated by 3 dots between the following lines.
        <BR><BR>

        <HR>
        <BR><BR>
        <CENTER>
        <TABLE>
        <TR><TD>"""
        prepFilePartTwo = """<BR>

        </TD></TR>
        </TABLE>
        </CENTER>

        <BR><BR>
        <HR>

        </FONT>
        </BODY>
        </HTML>"""
        input = open('oneMegTestFile.txt', 'r')
        prepMiddlebit = input.read()
        prepFile = prepFilePartOne + prepMiddlebit + prepFilePartTwo
        output = open('loadsample05.prep', 'w')
        output.write(prepFile)
        output.close()
        processTest('loadsample05')
           
def processTest(filename, dictionary={}):
    root, ext = os.path.splitext(filename)
    outFileName = root + '.html'
    mod = preppy.getModule(root)
    outFile = open(outFileName, 'w')
    mod.run(dictionary, outputfile = outFile)
    outFile.close()

def clean(dirname='.'):
    for filename in glob.glob('loadsample*.prep')+glob.glob('sample*.prep'):
        root, ext = os.path.splitext(filename)
        if os.path.isfile(root + '.html'):
            os.remove(root + '.html')
        if os.path.isfile(root + '.py'):
            os.remove(root + '.py')
        if os.path.isfile(root + '.pyc'):
            os.remove(root + '.pyc')
        if filename!='loadsample003.prep' and not filename.startswith('sample'): os.remove(filename)
    # Get rid of dynamically generated stuff not caught by the above code...
    for filename in ('loadsample04.prep','loadsample05.prep',
                'sixtyfiveKTestFile.txt', 'oneMegTestFile.txt', 'sample007.html',
                ):
        try:
            os.remove(filename)
        except:
            pass
            
def makeBigFile(howBig, fileName):
    outFile = open(fileName, 'w')
    outFile.write('Start')
    outFile.close()
   # Make sure we start with a zero length file...
    tempString = ""
    # verbose = prints a length count to screen
    #verbose=1
    verbose=0
    # testmode = prints a length count in the output file
    #testmode=1
    testmode=0
    oneK(tempString, verbose, howBig, fileName, testmode)
    outFile = open(fileName, 'a')
    outFile.write('...End')
    outFile.close()
    printLine = str(howBig)+"K test file created OK"
    if howBig == 1024:
        printLine = "1Mb test file created OK"

def makeBigDictionary(howBig):
    # This function creates a dictionary of howBig * numbers  
    from collections import OrderedDict
    dictionary = OrderedDict()
    for loopCounter in range(0,howBig):
        key = "key"+str.zfill(str(loopCounter), 4)
        dictionary[key]=(((loopCounter*13)%17) * ((loopCounter*19)%23) * 7) % 1000
    return dictionary

def oneK(tempString, verbose, howBig, fileName, testmode):
    for outerCounter in range(1,howBig+1):
        for innerCounter in range(0,1024):
            tempString = tempString + " "
        if testmode:
            lengthString = str(outerCounter)+"K"+"\n"
            tempString = tempString[:(len(tempString)-(len(lengthString)+1))]
            tempString = tempString+lengthString
        outFile = open(fileName, 'a')
        outFile.write(tempString)
        outFile.close()
        tempString = ""
    return tempString

if __name__=='__main__':
    import sys
    if len(sys.argv)==2:
        arg = sys.argv[1]
        if arg == 'clean':
            clean()
            sys.exit()
        else:
            print('argument not recognised!')
    else:
        runner = unittest.TextTestRunner()
        suite = unittest.makeSuite(LoadTestCase,'load')
        runner.run(suite)
