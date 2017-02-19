# Copyright ReportLab Europe Ltd. 2000-2015
# see license.txt for license details

# Tests of various functions and algorithms in preppy.
# no side-effects on file system, run anywhere.
__version__=''' $Id$ '''
import sys, os, glob, string, random
import preppy
import unittest
isPy3 = sys.version_info[0]==3
if isPy3:
    xrange = range
isPy34 = isPy3 and sys.version_info[1]>=4
isPy35 = isPy3 and sys.version_info[1]>=5

def P__tokenize(source,filename='<unknown>'):
    P=preppy.PreppyParser(source,filename)
    return P._PreppyParser__tokenize()

def P__preppy(source,filename='<unknown>'):
    P=preppy.PreppyParser(source,filename)
    P._PreppyParser__tokenize()
    return P.dump(P._PreppyParser__preppy())

class PreppyParserTestCase(unittest.TestCase):
    '''test the preppy parser class'''

    def __init__(self,*args,**kwds):
        unittest.TestCase.__init__(self,*args,**kwds)
        self.maxDiff = None

    @staticmethod
    def fixup(s):
        sNN = ' None, None,'
        if isPy3:
            sTE = 'Try'
            sTFL = ' [],'
            if isPy35: sNN = ''
        else:
            sTE = 'TryExcept'
            sTFL = ''
        return s.replace('sTE',sTE).replace('sTFL',sTFL).replace('sNN',sNN)

    def assertEqualStr(self,a,b):
        b = self.fixup(b)
        for i in xrange(max(len(a),len(b))):
            if a[i:i+1]!=b[i:i+1]:
                raise ValueError('Not Equal\n%r !!!!! %r\n%r !!!!! %r' % (a[:i],a[i:],b[:i],b[i:]))

    def checkTokenize(self):
        Token = preppy.Token
        self.assertEqual(P__tokenize('Hello World!'),[('const', 1, 0, 12), ('eof', 2, 12, 12)])
        self.assertEqual(P__tokenize('{{1}}'),[('expr', 1, 2, 3), ('eof', 1, 5, 5)])
        self.assertEqual(P__tokenize('{{while 1}}'),[Token(kind='while', lineno=1, start=2, end=9), Token(kind='eof', lineno=1, start=11, end=11)])
        self.assertEqual(P__tokenize('{{for i in 1,2}}'),[Token(kind='for', lineno=1, start=2, end=14), Token(kind='eof', lineno=1, start=16, end=16)])
        self.assertEqual(P__tokenize('{{if 1}}'), [Token(kind='if', lineno=1, start=2, end=6), Token(kind='eof', lineno=1, start=8, end=8)])
        self.assertEqual(P__tokenize('{{script}}a=2{{endscript}}'),[('script', 1, 2, 8), ('const', 1, 10, 13), ('endscript', 1, 15, 24), ('eof', 1, 26, 26)])
        self.assertEqual(P__tokenize('{{script}}a=1\nb=2\nc=3{{endscript}}'), [Token(kind='script', lineno=1, start=2, end=8), Token(kind='const', lineno=1, start=10, end=21), Token(kind='endscript', lineno=3, start=23, end=32), Token(kind='eof', lineno=1, start=34, end=34)])

    def check_for(self):
        self.assertEqualStr(P__preppy('{{for i in 1,2,3}}abcdef{{endfor}}'), "[For(Name('i', Store(), lineno=1, col_offset=6), Tuple([Num(1, lineno=1, col_offset=11), Num(2, lineno=1, col_offset=13), Num(3, lineno=1, col_offset=15)], Load(), lineno=1, col_offset=11), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=18), [Str('abcdef', lineno=1, col_offset=18)], [],sNN lineno=1, col_offset=18), lineno=1, col_offset=18)], [], lineno=1, col_offset=2)]")

    def check_break(self):
        self.assertEqualStr(P__preppy('{{for i in 1,2,3}}abcdef{{if i==3}}{{break}}{{endif}}{{else}}eeeee{{endfor}}'), "[For(Name('i', Store(), lineno=1, col_offset=6), Tuple([Num(1, lineno=1, col_offset=11), Num(2, lineno=1, col_offset=13), Num(3, lineno=1, col_offset=15)], Load(), lineno=1, col_offset=11), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=18), [Str('abcdef', lineno=1, col_offset=18)], [],sNN lineno=1, col_offset=18), lineno=1, col_offset=18), If(Compare(Name('i', Load(), lineno=1, col_offset=29), [Eq()], [Num(3, lineno=1, col_offset=32)], lineno=1, col_offset=29), [Break( lineno=1, col_offset=37)], [], lineno=1, col_offset=26)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=61), [Str('eeeee', lineno=1, col_offset=61)], [],sNN lineno=1, col_offset=61), lineno=1, col_offset=61)], lineno=1, col_offset=2)]")

    def check_break_outside_loop_fails(self):
        self.assertRaises(SyntaxError,P__preppy,'{{if i==3}}{{break}}{{endif}}')

    def check_continue(self):
        self.assertEqualStr(P__preppy('{{for i in 1,2,3}}abcdef{{if i==3}}{{continue}}{{endif}}{{else}}eeeee{{endfor}}'), "[For(Name('i', Store(), lineno=1, col_offset=6), Tuple([Num(1, lineno=1, col_offset=11), Num(2, lineno=1, col_offset=13), Num(3, lineno=1, col_offset=15)], Load(), lineno=1, col_offset=11), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=18), [Str('abcdef', lineno=1, col_offset=18)], [],sNN lineno=1, col_offset=18), lineno=1, col_offset=18), If(Compare(Name('i', Load(), lineno=1, col_offset=29), [Eq()], [Num(3, lineno=1, col_offset=32)], lineno=1, col_offset=29), [Continue( lineno=1, col_offset=37)], [], lineno=1, col_offset=26)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=64), [Str('eeeee', lineno=1, col_offset=64)], [],sNN lineno=1, col_offset=64), lineno=1, col_offset=64)], lineno=1, col_offset=2)]")

    def check_continue_outside_loop_fails(self):
        self.assertRaises(SyntaxError,P__preppy,'{{if i==3}}{{continue}}{{endif}}')

    def check_while(self):
        self.assertEqualStr(P__preppy('{{while i<10}}abcdef{{endwhile}}'), "[While(Compare(Name('i', Load(), lineno=1, col_offset=8), [Lt()], [Num(10, lineno=1, col_offset=10)], lineno=1, col_offset=8), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=14), [Str('abcdef', lineno=1, col_offset=14)], [],sNN lineno=1, col_offset=14), lineno=1, col_offset=14)], [], lineno=1, col_offset=2)]")

    def check_eval(self):
        #3.4 seems to improve on the col_offsets
        if isPy34:
            CO0 = 12
            CO1 = 0
            CO2 = 17
            if isPy35:
                NN = ''
                CO2 = 8
                CO0 = 8
        else:
            CO0 = 8
            CO1 = 0
            CO2 = 8
        self.assertEqualStr(P__preppy('{{eval}}str.split(\n"this should show a list of strings")\n{{endeval}}'), "[Expr(Call(Name('__swrite__', Load(), lineno=1, col_offset=8), [Expr(Call(Attribute(Name('str', Load(), lineno=1, col_offset=8), 'split', Load(), lineno=1, col_offset=%(CO0)s), [Str('this should show a list of strings', lineno=2, col_offset=%(CO1)s)], [],sNN lineno=1, col_offset=%(CO2)s), lineno=1, col_offset=8)], [],sNN lineno=1, col_offset=8), lineno=1, col_offset=8)]"%locals())


    def check_script(self):
        self.assertEqualStr(P__preppy('{{script}}a=1\nb=2\nc=3{{endscript}}'), "[Assign([Name('a', Store(), lineno=1, col_offset=10)], Num(1, lineno=1, col_offset=12), lineno=1, col_offset=10), Assign([Name('b', Store(), lineno=2, col_offset=0)], Num(2, lineno=2, col_offset=2), lineno=2, col_offset=0), Assign([Name('c', Store(), lineno=3, col_offset=0)], Num(3, lineno=3, col_offset=2), lineno=3, col_offset=0)]")

    def check_if(self):
        self.assertEqualStr(P__preppy('{{if i}}aaa{{elif j}}bbb{{elif k}}ccc{{else}}ddd{{endif}}'), "[If(Name('i', Load(), lineno=1, col_offset=5), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=8), [Str('aaa', lineno=1, col_offset=8)], [],sNN lineno=1, col_offset=8), lineno=1, col_offset=8)], [If(Name('j', Load(), lineno=1, col_offset=18), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=21), [Str('bbb', lineno=1, col_offset=21)], [],sNN lineno=1, col_offset=21), lineno=1, col_offset=21)], [If(Name('k', Load(), lineno=1, col_offset=31), [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=34), [Str('ccc', lineno=1, col_offset=34)], [],sNN lineno=1, col_offset=34), lineno=1, col_offset=34)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=45), [Str('ddd', lineno=1, col_offset=45)], [],sNN lineno=1, col_offset=45), lineno=1, col_offset=45)], lineno=1, col_offset=26)], lineno=1, col_offset=13)], lineno=1, col_offset=2)]")

    def check_try_0(self):
        if isPy35:
            NN = ''
        self.assertEqualStr(P__preppy('aaa{{try}}bbb{{except}}ccc{{endtry}}'), "[Expr(Call(Name('__write__', Load(), lineno=1, col_offset=0), [Str('aaa', lineno=1, col_offset=0)], [],sNN lineno=1, col_offset=0), lineno=1, col_offset=0), sTE([Expr(Call(Name('__write__', Load(), lineno=1, col_offset=10), [Str('bbb', lineno=1, col_offset=10)], [],sNN lineno=1, col_offset=10), lineno=1, col_offset=10)], [ExceptHandler(None, None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=23), [Str('ccc', lineno=1, col_offset=23)], [],sNN lineno=1, col_offset=23), lineno=1, col_offset=23)], lineno=1, col_offset=15)], [],sTFL lineno=1, col_offset=5)]"%locals())

    def check_try_1(self):
        if isPy35:
            NN = ''
        self.assertEqualStr(P__preppy('aaa{{try}}bbb{{except ValueError}}eee{{except}}ccc{{endtry}}'), "[Expr(Call(Name('__write__', Load(), lineno=1, col_offset=0), [Str('aaa', lineno=1, col_offset=0)], [],sNN lineno=1, col_offset=0), lineno=1, col_offset=0), sTE([Expr(Call(Name('__write__', Load(), lineno=1, col_offset=10), [Str('bbb', lineno=1, col_offset=10)], [],sNN lineno=1, col_offset=10), lineno=1, col_offset=10)], [ExceptHandler(Name('ValueError', Load(), lineno=3, col_offset=7), None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=34), [Str('eee', lineno=1, col_offset=34)], [],sNN lineno=1, col_offset=34), lineno=1, col_offset=34)], lineno=1, col_offset=15), ExceptHandler(None, None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=47), [Str('ccc', lineno=1, col_offset=47)], [],sNN lineno=1, col_offset=47), lineno=1, col_offset=47)], lineno=1, col_offset=39)], [],sTFL lineno=1, col_offset=5)]"%locals())

    def check_try_2(self):
        self.assertEqualStr(P__preppy('aaa{{try}}bbb{{except ValueError}}eee{{except}}ccc{{else}}ddd{{endtry}}'), "[Expr(Call(Name('__write__', Load(), lineno=1, col_offset=0), [Str('aaa', lineno=1, col_offset=0)], [],sNN lineno=1, col_offset=0), lineno=1, col_offset=0), sTE([Expr(Call(Name('__write__', Load(), lineno=1, col_offset=10), [Str('bbb', lineno=1, col_offset=10)], [],sNN lineno=1, col_offset=10), lineno=1, col_offset=10)], [ExceptHandler(Name('ValueError', Load(), lineno=3, col_offset=7), None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=34), [Str('eee', lineno=1, col_offset=34)], [],sNN lineno=1, col_offset=34), lineno=1, col_offset=34)], lineno=1, col_offset=15), ExceptHandler(None, None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=47), [Str('ccc', lineno=1, col_offset=47)], [],sNN lineno=1, col_offset=47), lineno=1, col_offset=47)], lineno=1, col_offset=39)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=58), [Str('ddd', lineno=1, col_offset=58)], [],sNN lineno=1, col_offset=58), lineno=1, col_offset=58)],sTFL lineno=1, col_offset=5)]" % locals())

    def check_try_3(self):
        if isPy3:
            expected = "[Expr(Call(Name('__write__', Load(), lineno=1, col_offset=0), [Str('aaa', lineno=1, col_offset=0)], [],sNN lineno=1, col_offset=0), lineno=1, col_offset=0), Try([Expr(Call(Name('__write__', Load(), lineno=1, col_offset=10), [Str('bbb', lineno=1, col_offset=10)], [],sNN lineno=1, col_offset=10), lineno=1, col_offset=10)], [ExceptHandler(Name('ValueError', Load(), lineno=3, col_offset=7), None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=34), [Str('eee', lineno=1, col_offset=34)], [],sNN lineno=1, col_offset=34), lineno=1, col_offset=34)], lineno=1, col_offset=15), ExceptHandler(None, None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=47), [Str('ccc', lineno=1, col_offset=47)], [],sNN lineno=1, col_offset=47), lineno=1, col_offset=47)], lineno=1, col_offset=39)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=58), [Str('ddd', lineno=1, col_offset=58)], [],sNN lineno=1, col_offset=58), lineno=1, col_offset=58)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=72), [Str('fff', lineno=1, col_offset=72)], [],sNN lineno=1, col_offset=72), lineno=1, col_offset=72)], lineno=1, col_offset=5)]" % locals()
        else:
            expected = "[Expr(Call(Name('__write__', Load(), lineno=1, col_offset=0), [Str('aaa', lineno=1, col_offset=0)], [],sNN lineno=1, col_offset=0), lineno=1, col_offset=0), TryFinally([TryExcept([Expr(Call(Name('__write__', Load(), lineno=1, col_offset=10), [Str('bbb', lineno=1, col_offset=10)], [],sNN lineno=1, col_offset=10), lineno=1, col_offset=10)], [ExceptHandler(Name('ValueError', Load(), lineno=3, col_offset=7), None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=34), [Str('eee', lineno=1, col_offset=34)], [],sNN lineno=1, col_offset=34), lineno=1, col_offset=34)], lineno=1, col_offset=15), ExceptHandler(None, None, [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=47), [Str('ccc', lineno=1, col_offset=47)], [],sNN lineno=1, col_offset=47), lineno=1, col_offset=47)], lineno=1, col_offset=39)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=58), [Str('ddd', lineno=1, col_offset=58)], [],sNN lineno=1, col_offset=58), lineno=1, col_offset=58)], lineno=1, col_offset=5)], [Expr(Call(Name('__write__', Load(), lineno=1, col_offset=72), [Str('fff', lineno=1, col_offset=72)], [],sNN lineno=1, col_offset=72), lineno=1, col_offset=72)], lineno=1, col_offset=5)]"
        self.assertEqualStr(P__preppy('aaa{{try}}bbb{{except ValueError}}eee{{except}}ccc{{else}}ddd{{finally}}fff{{endtry}}'),expected)

    def check_try_4(self):
        self.assertRaises(SyntaxError,P__preppy,'{{try}}bbb{{endtry}}')

    def check_try_5(self):
        self.assertRaises(SyntaxError,P__preppy,'{{try}}bbb{{else}}ddd{{endtry}}')

def makeSuite():
    return unittest.TestSuite((unittest.makeSuite(PreppyParserTestCase,'check'),))

if __name__=='__main__':
    runner = unittest.TextTestRunner()
    runner.run(makeSuite())
