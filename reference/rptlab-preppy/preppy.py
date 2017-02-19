#copyright ReportLab Inc. 2000-2015
#see license.txt for license details

"""preppy - a Python preprocessor.

This is the Python equivalent of ASP or JSP - a preprocessor which lets you
embed python expressions, loops and conditionals, and 'scriptlets' in any
kind of text file.  It provides a very natural solution for generating
dynamic HTML pages, which is not connected to any particular web server
architecture.

You create a template file (conventionally ending in .prep) containing
python expressions, loops and conditionals, and scripts.  These occur
between double curly braces:
   Dear {{surname}},
   You owe us {{amount}} {{if amount>1000}}which is pretty serious{{endif}}

On first use or any any change in the template, this is normally converted to a
python source module 'in memory', then to a compiled pyc file which is saved to
disk alongside the original.  Options control this; you can operate entirely
in memory, or look at the generated python code if you wish.

On subsequent use, the generated module is imported and loaded directly.
The module contains a run(...) function; you can pass in a dictionary of
parameters (such as the surname and amount parameters above), and optionally
an output stream or output-collection function if you don't want it to go to
standard output.

The command line options let you run modules with hand-input parameters -
useful for basic testing - and also to batch-compile or clean directories.
As with python scripts, it is a good idea to compile prep files on installation,
since unix applications may run as a different user and not have the needed
permission to store compiled modules.

"""
VERSION = '2.3.5'
__version__ = VERSION

USAGE = """
The command line interface lets you test, compile and clean up:

    preppy modulename [arg1=value1, arg2=value2.....]
       - shorthand for 'preppy run ...', see below.

    preppy run modulename [arg1=value1, arg2=value2.....]
       - runs the module, optionally with arguments.  e.g.
         preppy.py flintstone.prep name=fred sex=m

    preppy.py compile [-f] [-v] [-p] module1[.prep] module2[.prep] module3 ...
       - compiles explicit modules

    preppy.py compile [-f] [-v] [-p] dirname1  dirname2 ...
       - compiles all prep files in directory recursively

    preppy.py clean dirname1 dirname2 ...19
       - removes any py or pyc files created from past compilations


"""

STARTDELIMITER = "{{"
ENDDELIMITER = "}}"
QSTARTDELIMITER = "{${"
QENDDELIMITER = "}$}"
QUOTE = "$"
QUOTEQUOTE = "$$"
# SEQUENCE OF REPLACEMENTS FOR UNESCAPING A STRING.
UNESCAPES = ((QSTARTDELIMITER, STARTDELIMITER), (QENDDELIMITER, ENDDELIMITER), (QUOTEQUOTE, QUOTE))

import re, sys, os, imp, struct, tokenize, token, ast, traceback, time, marshal, pickle, inspect, textwrap
from hashlib import md5
isPy3 = sys.version_info.major == 3
isPy34 = isPy3 and sys.version_info.minor>=4
_usePyCache = isPy3 and False                   #change if you don't have legacy ie python 2.7 usage
from xml.sax.saxutils import escape as xmlEscape
from collections import namedtuple
Token = namedtuple('Token','kind lineno start end')
_verbose = int(os.environ.get('RL_verbose','0'))

if isPy3:
    from io import BytesIO, StringIO
    def __preppy__vlhs__(s,NAME=token.NAME,ENDMARKER=token.ENDMARKER):
        try:
            L = list(tokenize.tokenize(BytesIO(s.strip().encode('utf8')).readline))
        except:
            return False
        return len(L)<=3 and L[-2][0]==NAME and L[-1][0]==ENDMARKER

    class SafeString(bytes):
        '''either a SafeString or a SafeUnicode depending on argument type'''
        def __new__(cls,v):
            return str.__new__(SafeUnicode,v) if isinstance(v,str) else bytes.__new__(cls,v)

    class SafeUnicode(str):
        '''either a SafeString or a SafeUnicode depending on argument type'''
        def __new__(cls,v):
            return bytes.__new__(SafeString,v) if isinstance(v,bytes) else str.__new__(cls,v)

    _ucvn = '__str__'   #unicode conversion
    _bcvn = '__bytes__' #bytes conversion
    bytesT = bytes
    unicodeT = str
    strTypes = (str,bytes)
    import builtins
    rl_exec = getattr(builtins,'exec')
    del builtins
else:
    from StringIO import StringIO
    BytesIO = StringIO
    def __preppy__vlhs__(s,NAME=token.NAME,ENDMARKER=token.ENDMARKER):
        L = []
        try:
            tokenize.tokenize(BytesIO(s.strip()).readline,lambda *a: L.append(a))
        except:
            return False
        return len(L)==2 and L[0][0]==NAME and L[1][0]==ENDMARKER

    class SafeString(str):
        '''either a SafeString or a SafeUnicode depending on argument type'''
        def __new__(cls,v):
            return unicode.__new__(SafeUnicode,v) if isinstance(v,unicode) else str.__new__(cls,v)

    class SafeUnicode(unicode):
        '''either a SafeString or a SafeUnicode depending on argument type'''
        def __new__(cls,v):
            return str.__new__(SafeString,v) if isinstance(v,str) else unicode.__new__(cls,v)

    _ucvn = '__unicode__'
    _bcvn = '__str__'
    bytesT = str
    unicodeT = unicode
    strTypes = basestring
    def rl_exec(obj, G=None, L=None):
        if G is None:
            frame = sys._getframe(1)
            G = frame.f_globals
            if L is None:
                L = frame.f_locals
            del frame
        elif L is None:
            L = G
        exec("""exec obj in G, L""")
    class AstTry:
        _attributes = ('lineno','col_offset')
        _fields = ('body','handlers','orelse','finalbody')
        def __init__(self,**kwds):
            self.lineno = 1
            self.col_offset = 0
            self.__dict__.update(kwds)
        def convertTry(self):
            if not self.handlers:
                return ast.TryFinally(lineno=self.lineno,col_offset=self.col_offset,body=self.body,finalbody=self.finalbody)
            elif not self.finalbody:
                return ast.TryExcept(lineno=self.lineno,col_offset=self.col_offset,body=self.body,handlers=self.handlers,orelse=self.orelse)
            else:
                return ast.TryFinally(lineno=self.lineno,col_offset=self.col_offset,
                        body=[ast.TryExcept(lineno=self.lineno,col_offset=self.col_offset,body=self.body,handlers=self.handlers,orelse=self.orelse)],
                        finalbody=self.finalbody)
    defaultLConv = ['unicode','str']

def asUtf8(s):
    return s if isinstance(s,bytesT) else s.encode('utf8')

def asUnicode(s):
    return s if isinstance(s,unicodeT) else s.decode('utf8')

def getMd5(s):
    return md5(asUtf8(s)+asUtf8(VERSION)).hexdigest()

class AbsLineNo(int):
     pass

def uStdConv(s):
    if not isinstance(s,strTypes):
        if s is None: return u'' #we usually don't want output
        cnv = getattr(s,_ucvn,None)
        if not cnv:
            cnv = getattr(s,_bcvn,None)
        s = cnv() if cnv else str(s)
    if not isinstance(s,unicodeT):
        s = s.decode('utf8')
    return s

def bStdConv(s):
    return uStdConv(s).encode('utf8')

def __get_conv__(qf,lqf,b):
    '''return the quoteFunc, lquoteFunc given values for same and
    whether the original was bytes'''
    if qf and not lqf:
        lqf = asUtf8 if isinstance(qf(''),bytesT) else asUnicode
    elif lqf and not qf:
        qf = bStdConv if isinstance(lqf(''),bytesT) else uStdConv
    elif not qf and not lqf:
        if b:
            qf = bStdConv
            lqf = bytesT
        else:
            qf = uStdConv
            lqf = unicodeT
    return qf, lqf

#Andy's standard quote for django
_safeBase = SafeString, SafeUnicode
def uStdQuote(s):
    if not isinstance(s,strTypes):
        if s is None: return u'' #we usually don't want output
        cnv = getattr(s,_ucvn,None)
        if not cnv:
            cnv = getattr(s,_bcvn,None)
        s = cnv() if cnv else unicodeT(s)
    if isinstance(s,_safeBase):
        if isinstance(s,SafeString):
            s = s.decode('utf8')
        return s
    elif not isinstance(s,unicodeT):
        s = s.decode('utf8')
    return xmlEscape(s)

def bStdQuote(s):
    return uStdQuote(s).encode('utf8')

stdQuote = bStdQuote

def pnl(s):
    '''print without a lineend'''
    if not isPy3 and isinstance(s,unicodeT):
        s = s.encode(sys.stdout.encoding,'replace')
    sys.stdout.write(s)

def pel(s):
    '''print with a line ending'''
    pnl(s)
    pnl('\n')

def unescape(s, unescapes=UNESCAPES):
    for (old, new) in unescapes:
        s = s.replace(old, new)
    return s


teststring = """
this test script should produce a runnable program
{{script}}
  class X:
      pass
  x = X()
  x.a = "THE A VALUE OF X"
  yislonger = "y is longer!"
  import math
  a = dictionary = {"key": "value", "key2": "value2", "10%": "TEN PERCENT"}
  loop = "LOOP"
{{endscript}}
this line has a percent in it 10%
here is the a value in x: {{x.a}}
just a norml value here: {{yislonger}} string {{a["10%"]}}
 the sine of 12.3 is {{math.sin(12.3)}}
 {{script}} a=0 {{endscript}}
 these parens should be empty
 ({{if a:}}
conditional text{{endif}})
 {{script}} a=1
 {{endscript}}
 these parens should be full
 ({{if a:}}
conditional text{{endif}})
stuff between endif and while

{{while a==1:}} infinite {{loop}} forever!
{{script}} a=0 {{endscript}}
{{for (a,b) in dictionary.items():}}
the key in the dictionary is {{a}} and the value is {{b}}.  And below is a script
{{script}}
        # THIS IS A SCRIPT
        x = 2
        y = 3
        # END OF THE SCRIPT
{{endscript}}
stuff after the script
{{endfor}}
stuff after the for stmt
{{endwhile}}
stuff after the while stmt

{{script}}
# test the free variables syntax error problem is gone
alpha = 3
def myfunction1(alpha=alpha):
    try:
        return free_variable # this would cause an error in an older version of preppy with python 2.2
    except:
        pass
    try:
        return alpha
    except:
        return "oops"
beta = myfunction1()
{{endscript}}
alpha = {{alpha}} and beta = {{beta}}

{${this is invalid but it's escaped, so no problem!}$}

end of text

{{script}}
# just a comment
{{endscript}}
stop here
"""

"""
# test code for quotestring
(qs, ds, c) = PreProcessor().quoteString(teststring, cursor=0)
print "---------quoted to ", c, `teststring[c:c+20]`
print qs
print "---------dict string"
print ds
"""
def dedent(text):
    """get rid of redundant indentation in text this dedenter IS NOT smart about converting tabs to spaces!!!"""
    lines = text.split("\n")
    # omit empty lines
    lempty = 0
    while lines:
        line0 = lines[0].strip()
        if line0 and line0[0]!='#': break
        del lines[0]
        lempty += 1
    if not lines: return (0,"") # completely white
    line0 = lines[0]
    findfirstword = line0.find(line0.strip().split()[0])
    if findfirstword<0: raise ValueError('internal dedenting error')
    indent = line0[:findfirstword]
    linesout = []
    for l in lines:
        lines0 = l.strip()
        if not lines0 or lines0[0]=='#':
            linesout.append("")
            continue
        lindent = l[:findfirstword]
        if lindent!=indent:
            raise ValueError("inconsistent indent expected %s got %s in %s" % (repr(indent), repr(lindent), l))
        linesout.append(l[findfirstword:])
    return len(indent),'\n'.join(lempty*['']+linesout)


_line_d = re.compile('line\s+\d+',re.M)
_pat = re.compile('{{\\s*|}}',re.M)
_s = re.compile(r'^(?P<start>while|if|elif|for|continue|break|try|except|raise|with|import|from|assert)(?P<startend>\s+|$)|(?P<def>def\s*)(?P<defend>\(|$)|(?P<end>else|script|eval|endwhile|endif|endscript|endeval|endfor|finally|endtry|endwith)(?:\s*$|(?P<endend>.+$))',re.DOTALL|re.M)

def _denumber(node,lineno=-1):
    if node.lineno!=lineno: node.lineno = lineno
    for child in node.getChildNodes(): _denumber(child,lineno)

class PreppyParser:
    def __init__(self,source,filename='[unknown]',sourcechecksum=None):
        self.__mangle = '_%s__'%self.__class__.__name__
        self._defSeen = 0
        self.source = source
        self.filename = filename
        self.sourcechecksum = sourcechecksum
        self.__inFor = self.__inWhile = 0
        self._isBytes = isinstance(source,bytesT)

    def compile(self, display=0):
        ast = self.__get_ast()
        self.codeobject = compile(ast,self.filename,'exec')

    def __lexerror(self, msg, pos):
        text = self.source
        pos0 = text.rfind('\n',0,pos)+1
        pos1 = text.find('\n',pos)
        if pos1<0: pos1 = len(text)
        lnum = text.count('\n',0,pos)+1
        msg = _line_d.sub('line %d' % lnum,msg)
        raise SyntaxError('%s\n%s\n%s (near line %d of %s)' %(text[pos0:pos1],(' '*(pos-pos0)),msg, lnum, self.filename))

    def __tokenize(self):
        text = self.source
        self._tokens = tokens = []
        a = tokens.append
        state = 0
        ix = 0
        for i in _pat.finditer(text):
            i0 = i.start()
            i1 = i.end()
            lineno = text.count('\n',0,ix)+1
            if i.group()!='}}':
                if state:
                    self.__lexerror('Unexpected {{', i0)
                else:
                    state = 1
                    if i0!=ix: a(Token('const',lineno,ix,i0))
                    ix = i1
            elif state:
                    state = 0
                    #here's where a preppy token is finalized
                    m = _s.match(text[ix:i0])
                    if m:
                        t = m.group('start')
                        if t:
                            if not m.group('startend'):
                                if t not in ('continue','break','try','except'):
                                    self.__lexerror('Bad %s' % t, i0)
                        else:
                            t = m.group('end')
                            if t:
                                ee = m.group('endend')
                                if ee and t!='else' and ee.strip()!=':': self.__lexerror('Bad %s' % t, i0)
                            else:
                                t = m.group('def')
                                if t:
                                    if not m.group('defend'): self.__lexerror('Bad %s' % t, i0)
                                    if self._defSeen:
                                        if self._defSeen>0:
                                            self.__lexerror('Only one def may be used',i0)
                                        else:
                                            self.__lexerror('def must come first',i0)
                                    else:
                                        self._defSeen = 1
                    else:
                        t = 'expr'  #expression
                    if not self._defSeen: self._defSeen = -1
                    if i0!=ix: a(Token(t,lineno,ix,i0))
                    ix = i1
        else:
            lineno = 0
        if state: self.__lexerror('Unterminated preppy token', ix)
        textLen = len(text)
        if ix!=textLen:
            lineno = text.count('\n',0,ix)+1
            a(Token('const',lineno,ix,textLen))
        a(Token('eof',lineno+1,textLen,textLen))
        self._tokenX = 0
        return tokens

    def __tokenText(self, colonRemove=False, strip=True, forceColonPass=False):
        t = self._tokens[self._tokenX]
        text = self.source[t.start:t.end]
        if strip: text = text.strip()
        if colonRemove or forceColonPass:
            if text.endswith(':'): text = text[:-1]
            if forceColonPass: text += ':\tpass\n'
        return unescape(text)

    def __tokenPop(self):
        t = self._tokens[self._tokenX]
        self._tokenX += 1
        return t

    def __colOffset(self,t):
        '''obtain the column offset corresponding to a specific token'''
        return t.start-max(self.source.rfind('\n',0,t.start),0)

    def __rparse(self,text):
        '''parse a raw fragment of code'''
        tf = ast.parse(text,filename=self.filename,mode='exec').body
        return tf

    def __iparse(self,text):
        '''parse a start fragment of code'''
        return self.__rparse(text)[0]

    def __preppy(self,
            funcs='const expr while if for script eval def continue break try raise with import from assert'.split(),
            followers=['eof'],pop=True,fixEmpty=False):
        C = []
        a = C.append
        mangle = self.__mangle
        tokens = self._tokens
        while 1:
            t = tokens[self._tokenX].kind
            if t in followers: break
            p = t in funcs and getattr(self,mangle+t) or self.__serror
            r = p()
            if isinstance(r,list): C += r
            elif r is not None: a(r)
        if not C and fixEmpty:
            r = ast.Pass(lineno=1,col_offset=0)
            self.__renumber(r,self._tokens[self._tokenX])
            C = [r]
        if pop:
            self.__tokenPop()
        return  C

    def __def(self):
        try:
            n = self.__iparse('def get'+(self.__tokenText(forceColonPass=1).strip()[3:]))
        except:
            self.__error()
        t = self.__tokenPop()
        self._fnc_defn = t,n
        return None

    def __break(self,stmt='break'):
        text = self.__tokenText()
        if text!=stmt:
            self.__serror(msg='invalid %s statement' % stmt)
        elif not self.__inWhile and not self.__inFor:
            self.__serror(msg='%s statement outside while or for loop' % stmt)
        t = self.__tokenPop()
        n = getattr(ast,stmt.capitalize())(lineno=1,col_offset=0)
        self.__renumber(n,t)
        return n

    def __continue(self):
        return self.__break(stmt='continue')

    def __raise(self):
        text = self.__tokenText()
        try:
            n = self.__rparse(text)
        except:
            self.__error()
        t = self.__tokenPop()
        self.__renumber(n,t)
        return n

    def __renumber(self,node,t,dcoffs=0):
        if isinstance(node,list):
            for f in node:
                self.__renumber(f,t,dcoffs=dcoffs)
            return
        if isinstance(t,Token):
            lineno_offset = t.lineno-1
            col_offset = self.__colOffset(t)
        else:
            lineno_offset, col_offset = t
        if 'col_offset' in node._attributes:
            if getattr(node,'lineno',1)==1:
                node.col_offset = getattr(node,'col_offset',0)+col_offset+dcoffs
            elif not hasattr(node,'col_offset'):
                node.col_offset = dcoffs
            else:
                node.col_offset += dcoffs
        if 'lineno' in node._attributes:
            node.lineno = int(lineno_offset) if isinstance(lineno_offset,AbsLineNo) else getattr(node,'lineno',1)+lineno_offset
        t = lineno_offset,col_offset
        for f in ast.iter_child_nodes(node):
            self.__renumber(f,t,dcoffs=dcoffs)

    def __while(self):
        self.__inWhile += 1
        try:
            n = self.__iparse(self.__tokenText(forceColonPass=1))
        except:
            self.__error()
        t = self.__tokenPop()
        self.__renumber(n,t)
        n.body = self.__preppy(followers=['endwhile','else'],fixEmpty=True)
        if self._tokens[self._tokenX-1].kind=='else':
            n.orelse = self.__preppy(followers=['endwhile'])
        self.__inWhile -= 1
        return n

    def __for(self):
        self.__inFor += 1
        try:
            n = self.__iparse(self.__tokenText(forceColonPass=1))
        except:
            self.__error()
        t = self.__tokenPop()
        self.__renumber(n,t)
        n.body = self.__preppy(followers=['endfor','else'],fixEmpty=True)
        if self._tokens[self._tokenX-1].kind=='else':
            n.orelse = self.__preppy(followers=['endfor'])
        self.__inFor -= 1
        return n

    def __try(self):
        text = self.__tokenText(colonRemove=1)
        if text!='try':
            self.__serror(msg='invalid try statement')
        t = self.__tokenPop()
        n = (ast.Try if isPy3 else AstTry)(lineno=1,col_offset=0,body=[],handlers=[],orelse=[],finalbody=[])
        self.__renumber(n,t)
        n.body = self.__preppy(followers=['except','finally'],pop=False,fixEmpty=True)
        while 1:
            text = self.__tokenText(colonRemove=1)
            t = self.__tokenPop()
            if text.startswith('endtry'):
                if text != 'endtry':
                    self.__error('invalid endtry statement')
                return n if isPy3 else n.convertTry()
            elif text.startswith('finally'):
                if text != 'finally':
                    self.__error('invalid finally statement')
                n.finalbody = self.__preppy(followers=['endtry'])
                return n if isPy3 else n.convertTry()
            elif text.startswith('else'):
                if text != 'else':
                    self.__error('invalid else statement')
                n.orelse = self.__preppy(followers=['finally','endtry'],pop=False)
            elif text.startswith('except'):
                exh = self.__iparse('try:\n\tpass\n%s:\n\tpass\n' % text).handlers[0]
                exh.lineno = 1
                exh.col_offset = 0
                self.__renumber(exh,t)
                F = ['finally','else','endtry'] if text=='except' else ['except','finally','endtry','else']
                exh.body = self.__preppy(followers=F,pop=False,fixEmpty=True)
                n.handlers.append(exh)
            else:
                self.__serr('invalid syntax in try statement')

    def __with(self):
        try:
            n = self.__iparse(self.__tokenText(forceColonPass=1))
        except:
            self.__error()
        t = self.__tokenPop()
        self.__renumber(n,t)
        n.body = self.__preppy(followers=['endwith'],fixEmpty=True)
        return n

    def __import(self,stmt='import'):
        text = self.__tokenText()
        try:
            n = self.__iparse(text)
        except:
            self.__error()
        t = self.__tokenPop()
        self.__renumber(n,t)
        return n

    def __from(self):
        return self.__import(stmt='from')

    def __assert(self):
        return self.__import(stmt='assert')

    def __script(self,mode='script'):
        end = 'end'+mode
        self.__tokenPop()
        if self._tokens[self._tokenX].kind==end:
            self.__tokenPop()
            return []
        dcoffs, text = dedent(self.__tokenText(strip=0,colonRemove=False))
        scriptMode = 'script'==mode
        if text:
            try:
                n = self.__rparse(text)
            except:
                self.__error()
        t = self.__tokenPop()
        try:
            assert self._tokens[self._tokenX].kind==end
            self.__tokenPop()
        except:
            self.__error(end+' expected')
        if not text: return []
        if mode=='eval': n = ast.Expr(value=ast.Call(func=ast.Name(id='__swrite__',ctx=ast.Load()),args=n,keywords=[],starargs=None,kwargs=None))
        self.__renumber(n,t,dcoffs=dcoffs)
        return n

    def __eval(self):
        return self.__script(mode='eval')

    def __if(self):
        tokens = self._tokens
        t = 'elif'
        I = None
        while t=='elif':
            try:
                text = self.__tokenText(forceColonPass=1)
                if text.startswith('elif'): text = 'if  '+text[4:]
                n = self.__iparse(text)
            except:
                self.__error()
            t = self.__tokenPop()
            self.__renumber(n,t)
            n.body = self.__preppy(followers=['endif','elif','else'],fixEmpty=True)
            if I:
                p.orelse = [n]
            else:
                I = n
            p = n
            t = tokens[self._tokenX-1].kind #we consumed the terminal in __preppy
            if t=='elif': self._tokenX -= 1
        if t=='else':
            p.orelse = self.__preppy(followers=['endif'])
        return I

    def __const(self):
        try:
            n = ast.Expr(value=ast.Call(func=ast.Name(id='__write__',ctx=ast.Load()),args=[ast.Str(s=self.__tokenText(strip=0))],keywords=[],starargs=None,kwargs=None))
        except:
            self.__error('bad constant')
        t = self.__tokenPop()
        self.__renumber(n,t)
        return n

    def __expr(self):
        t = self.__tokenText()
        try:
            n = ast.Expr(value=ast.Call(func=ast.Name(id='__swrite__',ctx=ast.Load()),args=[self.__rparse(t)[0].value],keywords=[],starargs=None,kwargs=None))
        except:
            self.__error('bad expression')
        t = self.__tokenPop()
        self.__renumber(n,t)
        return n

    def __error(self,msg='invalid syntax'):
        pos = self._tokens[self._tokenX].start
        f = StringIO()
        traceback.print_exc(file=f)
        f = f.getvalue()
        m = 'File "<string>", line '
        i = f.rfind('File "<string>", line ')
        if i<0:
            t, v = map(str,sys.exc_info()[:2])
            self.__lexerror('%s %s(%s)' % (msg, t, v),pos)
        else:
            i += len(m)
            f = f[i:].split('\n')
            n = int(f[0].strip())+self.source[:pos].count('\n')
            raise SyntaxError('  File %s, line %d\n%s' % (self.filename,n,'\n'.join(f[1:])))

    def __serror(self,msg='invalid syntax'):
        self.__lexerror(msg,self._tokens[self._tokenX].start)

    def __parse(self,text=None):
        if text: self.source = text
        self.__tokenize()
        return self.__preppy()

    @staticmethod
    def dump(node,annotate_fields=False,include_attributes=True):
        return ('[%s]' % ', '.join(PreppyParser.dump(x,annotate_fields=annotate_fields,include_attributes=include_attributes) for x in node)
                if isinstance(node,list)
                else ast.dump(node,annotate_fields=annotate_fields, include_attributes=include_attributes))

    def __get_pre_preamble(self):
        return ('from preppy import include, __preppy__vlhs__, __get_conv__\n'
                if self._defSeen==1
                else 'from preppy import include, rl_exec as __rl_exec__, __preppy__vlhs__, __get_conv__\n')

    def __get_ast(self):
        preppyNodes = self.__parse()
        llno = (AbsLineNo(self._tokens[-1].lineno),0)   #last line number information
        if self._defSeen==1:
            t, F = self._fnc_defn
            args = F.args
            if args.kwarg:
                kwargName = args.kwarg.arg if isPy34 else args.kwarg
                CKWA = []
            else:
                if isPy3:
                    argNames = [a.arg for a in args.args] + [a.arg for a in args.kwonlyargs] 
                    if args.vararg: argNames += [args.vararg.arg if isPy34 else args.vararg]
                else:
                    argNames = [a.id for a in args.args]
                    if args.vararg: argNames += [args.vararg]
                #choose a kwargName not in existing names
                kwargName = '__kwds__'
                while kwargName in argNames:
                    kwargName = kwargname.replace('s_','ss_')
                if isPy34:
                    args.kwarg = ast.arg(kwargName,None)
                    args.kwarg.lineno = F.lineno
                    args.kwarg.col_offset = F.col_offset
                else:
                    args.kwarg = kwargName
                CKWA = ["if %s: raise TypeError('get: unexpected keyword arguments %%r' %% %s)" % (kwargName,kwargName)]

            leadNodes=self.__rparse('\n'.join([
                "__lquoteFunc__=%s.setdefault('__lquoteFunc__',None)" % kwargName,
                "%s.pop('__lquoteFunc__')" % kwargName,
                "__quoteFunc__=%s.setdefault('__quoteFunc__',None)" % kwargName,
                "%s.pop('__quoteFunc__')" % kwargName,
                '__qFunc__,__lqFunc__=__get_conv__(__quoteFunc__,__lquoteFunc__,%s)' % self._isBytes
                ] + CKWA + [
                "__append__=[].append",
                "__write__=lambda x:__append__(__lqFunc__(x))",
                "__swrite__=lambda x:__append__(__qFunc__(x))",
                ]))
            trailNodes = self.__rparse("return ''.join(__append__.__self__)")

            self.__renumber(F,t)
            self.__renumber(leadNodes,(AbsLineNo(1),0))
            self.__renumber(trailNodes,llno)
            preppyNodes = leadNodes + preppyNodes + trailNodes
            global _newPreambleAst
            if not _newPreambleAst:
                _newPreambleAst = self.__rparse(self.__get_pre_preamble()+_newPreamble)
                self.__renumber(_newPreambleAst,llno)
            F.body = preppyNodes
            extraAst = [F]+_newPreambleAst
        else:
            global _preambleAst, _preamble
            if not _preambleAst:
                #_preamble = 'from unparse import Unparser\n'+_preamble.replace('NS = {}\n','NS = {};Unparser(M,__save_sys_stdout__)\n')
                _preambleAst = self.__rparse(self.__get_pre_preamble()+(_preamble.replace('__isbytes__',str(self._isBytes))))
                self.__renumber(_preambleAst,llno)
            M = ast.parse("def __code__(dictionary, outputfile, __write__,__swrite__,__save_sys_stdout__): pass",self.filename,mode='exec')
            self.__renumber(M,(AbsLineNo(1),0))
            M.body[0].body = preppyNodes
            extraAst = self.__rparse('__preppy_nodes__=%r\n__preppy_filename__=%r\n' % (pickle.dumps(M),self.filename))+_preambleAst
        M = ast.parse('__checksum__=%r' % self.sourcechecksum,self.filename,mode='exec')
        M.body += extraAst
        return M

_preambleAst=None
_preamble='''import ast, pickle
def run(dictionary, __write__=None, quoteFunc=None, outputfile=None):
    ### begin standard prologue
    import sys
    __save_sys_stdout__ = sys.stdout
    try: # compiled logic below
        if outputfile is not None:
            stdout = sys.stdout = outputfile
            if __write__:
                raise ValueError("do not define both outputfile (%r) and __write__ (%r)." %(outputfile, __write__))
        else:
            stdout = sys.stdout
        # make sure quoteFunc is defined:
        qFunc, lconv = __get_conv__(quoteFunc,None,__isbytes__)
        globals()['__quoteFunc__'] = qFunc
        # make sure __write__ is defined
        if __write__:
            class stdout: pass
            stdout = sys.stdout = stdout()
            stdout.write = lambda x: __write__(qFunc(x))
        else:
            __write__ = lambda x: stdout.write(x)
        __swrite__ = lambda x: __write__(qFunc(x))
        __lwrite__ = lambda x: __write__(lconv(x))
        M = pickle.loads(__preppy_nodes__)
        b = M.body[0].body
        for k in dictionary:
            try:
                if k not in ('dictionary','__write__',
                        '__swrite__','outputfile','__save_sys_stdout__') and __preppy__vlhs__(k):
                    #print('dictionary[%s] = %r' % (k,dictionary[k]),file=__save_sys_stdout__)
                    b.insert(0,ast.parse('%s=dictionary[%r]' % (k,k),'???',mode='exec').body[0])
            except:
                pass
        NS = {}
        NS['include'] = include
        __rl_exec__(compile(M,__preppy_filename__,'exec'),NS)
        NS['__code__'](dictionary,outputfile,__lwrite__,__swrite__,__save_sys_stdout__)
    finally: #### end of compiled logic, standard cleanup
        import sys # for safety
        #print "resetting stdout", sys.stdout, "to", __save_sys_stdout__
        sys.stdout = __save_sys_stdout__

def getOutputFromKeywords(quoteFunc=None, **kwds):
    buf=[]
    run(kwds,__write__=buf.append, quoteFunc=quoteFunc)
    if quoteFunc is None:
        quoteFunc = __get_conv__(None,None,__isbytes__)[0]
    return quoteFunc('')[0:0].join(buf)

def getOutput(dictionary, quoteFunc=None):
    return getOutputFromKeywords(quoteFunc=quoteFunc, **dictionary)

if __name__=='__main__':
    run()
'''

_newPreambleAst=None
_newPreamble='''def run(*args,**kwds):
    raise ValueError('Wrong kind of prep file')
def getOutput(*args,**kwds):
    run()
if __name__=='__main__':
    run()
'''

def testgetOutput(name="testoutput"):
    mod = getModule(name,'.',savePyc=1,sourcetext=teststring,importModule=1)
    pel(mod.getOutput({}))

def testgetmodule(name="testoutput"):
    #name = "testpreppy"
    pel("trying to load"+name)
    result = getPreppyModule(name, verbose=1)
    pel( "load successful! running result")
    pel("=" * 100)
    result.run({})
def rl_get_module(name,dir):
    f, p, desc= imp.find_module(name,[dir])
    if name in sys.modules:
        om = sys.modules[name]
        del sys.modules[name]
    else:
        om = None
    try:
        try:
            m = imp.load_module(name,f,p,desc)
            t = getTimeStamp(m)
            if t<preppyTime: return None
            return m
        except:
            raise ImportError('%s[%s]' % (name,dir))
    finally:
        if om: sys.modules[name] = om
        del om
        if f: f.close()

def getTimeStamp(m,default=float('Inf')):
    try:
        with open(m.__file__,'rb') as f:
            f.seek(4,os.SEEK_SET)
            return struct.unpack('<L', f.read(4))[0]
    except:
        return default

def preppyTime():
    try:
        import preppy
        fn = preppy.__file__
        if fn.endswith('.py'):
            return os.stat(fn)[8]
        return getTimeStamp(preppy)
    except:
        return float('Inf')
preppyTime = preppyTime()
        
# cache found modules by source file name
FILE_MODULES = {}
SOURCE_MODULES = {}
def getModule(name,
              directory=".",
              source_extension=".prep",
              verbose=None,
              savefile=None,
              sourcetext=None,
              savePy=0,
              force=0,
              savePyc=1,
              importModule=1,
              _globals=None,
              _existing_module=None):
    """Returns a python module implementing the template, compiling if needed.

    force: ignore up-to-date checks and always recompile.
    """
    verbose = verbose or _verbose
    if isinstance(name,bytesT): name = name.decode('utf8')
    if isinstance(directory,bytesT): directory = directory.decode('utf8')
    if isinstance(source_extension,bytesT): source_extension = source_extension.decode('utf8')
    if isinstance(sourcetext,bytesT): sourcetext = sourcetext.decode('utf8')
    if hasattr(name,'read'):
        sourcetext = name.read()
        name = getattr(name,'name',None)
        if not name: name = '_preppy_'+getMd5(sourcetext)
    else:
        # it's possible that someone could ask for
        #  name "subdir/spam.prep" in directory "/mydir", instead of
        #  "spam.prep" in directory "/mydir/subdir".  Failing to get
        # this right means getModule can fail to find it and recompile
        # every time.  This is common during batch compilation of directories.
        extraDir, name = os.path.split(name)
        if extraDir:
            if os.path.isabs(extraDir):
                directory = extraDir
            else:
                directory = directory + os.sep + extraDir
        dir = os.path.abspath(os.path.normpath(directory))

        # they may ask for 'spam.prep' instead of just 'spam'.  Trim off
        # any extension
        name = os.path.splitext(name)[0]
        if verbose:
            pnl('checking %s...' % os.path.join(dir, name))
        # savefile is deprecated but kept for safety.  savePy and savePyc are more
        # explicit and are the preferred.  By default it generates a pyc and no .py
        # file to reduce clutter.
        if savefile and savePyc == 0:
            savePyc = 1

    if sourcetext is not None:
        # they fed us the source explicitly
        sourcechecksum = getMd5(sourcetext)
        if not name: name = '_preppy_'+sourcechecksum
        if verbose: pnl("sourcetext provided...")
        sourcefilename = "<input text %s>" % name
        nosourcefile = 1
        module = SOURCE_MODULES.get(sourcetext,None)
        if module:
            return module
    else:
        nosourcefile = 0
        # see if the module exists as a python file
        sourcefilename = os.path.join(dir, name+source_extension)
        module = FILE_MODULES.get(sourcefilename,None)

        try:
            module = rl_get_module(name,dir)
            checksum = module.__checksum__
            if verbose: pnl("found...")
        except: # ImportError:  #catch ALL Errors importing the module (eg name="")
            module = checksum = None
            if verbose:
                if verbose>2: traceback.print_exc()
                pnl(" pyc %s[%s] not found..." % (name,dir))
            # check against source file
        try:
            sourcefile = open(sourcefilename, "r")
        except:
            if verbose: pnl("no source file, reuse...")
            if module is None:
                raise ValueError("couldn't find source %s or module %s" % (sourcefilename, name))
            # use the existing module??? (NO SOURCE PRESENT)
            FILE_MODULES[sourcefilename] = module
            return module
        else:
            sourcetext = sourcefile.read()
            # NOTE: force recompile on each new version of this module.
            sourcechecksum = getMd5(sourcetext)
            if sourcechecksum==checksum:
                if force==0:
                    # use the existing module. it matches
                    if verbose:
                        pnl("up to date.")
                    FILE_MODULES[sourcefilename] = module
                    return module
                else:
                    # always recompile
                    if verbose: pnl('forced recompile,')
            elif verbose:
                pnl("changed,")

    # if we got here we need to rebuild the module from source
    if verbose: pel("recompiling")
    global DIAGNOSTIC_FUNCTION
    DIAGNOSTIC_FUNCTION = None
    P = PreppyParser(sourcetext,sourcefilename,sourcechecksum)
    P.nosourcefile = nosourcefile
    P.compile(0)

    # default is compile to bytecode and save that.
    if savePyc:
        if _usePyCache:
            #we're not ready to use
            dir = os.path.join(dir,'__pycache__')
            if not os.path.isdir(dir): os.makedirs(dir)
            pycPath = os.path.join(dir,'%s-cpython-%s%s.pyc' % (name,sys.version_info.major,sys.version_info.minor))
        else:
            pycPath = os.path.join(dir,name+'.pyc')
        with open(pycPath,'wb') as f:
            f.write(b'\0\0\0\0')
            f.write(struct.pack('<L',int(time.time())&0xFFFFFFFF))
            if isPy3:
                if not nosourcefile:
                    size = os.stat(sourcefilename).st_size
                else:
                    size = len(sourcetext)
                f.write(struct.pack('<L',size & 0xFFFFFFFF))
            marshal.dump(P.codeobject, f)
            f.flush()
            f.seek(0, os.SEEK_SET)
            f.write(imp.get_magic())
    else:
        pycPath = None

    if _existing_module:
        module = _existing_module
        module.__dict__.clear()
    else:
        # now make a module
        from imp import new_module
        module = new_module(name)
    if pycPath:
        module.__file__=pycPath
    rl_exec(P.codeobject,module.__dict__)
    if importModule:
        if nosourcefile:
            SOURCE_MODULES[sourcetext] = module
        else:
            FILE_MODULES[sourcefilename] = module
    return module

# support the old form here
getPreppyModule = getModule

####################################################################
#
#   utilities for compilation, setup scripts, housekeeping etc.
#
####################################################################
_preppy_importer=None
def installImporter():
    "This lets us import prep files directly"
    # the python import mechanics are only invoked if you call this,
    # since preppy has very few dependencies and I don't want to
    #add to them.
    global _preppy_importer
    if _preppy_importer is None:
        class PreppyImporter(object):
            "This allows prep files to be imported."
            def __init__(self):
                self.prepPath = None

            def find_module(self, name, path=None):
                if self.prepPath: return
                if path:
                    for p in path:
                        prepPath = os.path.join(p,name.split('.')[-1] + '.prep')
                        if os.path.isfile(prepPath): break
                    else:
                        return
                else:
                    prepPath = name + '.prep'
                    if not os.path.isfile(prepPath): return

                self.prepPath = prepPath
                return self

            def load_module(self,name):
                if not self.prepPath: return
                try:
                    #compile WITHOUT IMPORTING to avoid triggering recursion
                    try:
                        m = compileModule(self.prepPath, verbose=_verbose, importModule=0, existing_module=sys.modules.get(name,None))
                    except:
                        traceback.print_exc()
                        raise
                    m.__loader__ = self
                    m.__name__ = name
                    sys.modules[name] = m
                    return m
                finally:
                    self.prepPath = None
        _preppy_importer = PreppyImporter()
        sys.meta_path.insert(0,_preppy_importer)

def uninstallImporter():
    global _preppy_importer
    try:
        sys.meta_path.remove(_preppy_importer)
        _preppy_importer = None
    except:
        pass

def compileModule(fn, savePy=0, force=0, verbose=1, importModule=1, existing_module=None):
    "Compile a prep file to a pyc file.  Optionally, keep the python source too."
    name, ext = os.path.splitext(fn)
    d = os.path.dirname(fn)
    return getModule(os.path.basename(name), directory=d, source_extension=ext,
                     savePyc=1, savePy=savePy, force=force,
                     verbose=verbose, importModule=importModule,_existing_module=existing_module)

def compileModules(pattern, savePy=0, force=0, verbose=1):
    "Compile all prep files matching the pattern."
    import glob
    filenames = glob.glob(pattern)
    for filename in filenames:
        compileModule(filename, savePy, force, verbose)

from fnmatch import fnmatch
def compileDir(dirName, pattern="*.prep", recursive=1, savePy=0, force=0, verbose=1):
    "Compile all prep files in directory, recursively if asked"
    if verbose: pel('compiling directory %s' % dirName)
    if recursive:
        def _visit(A,D,N,pattern=pattern,savePy=savePy, verbose=verbose,force=force):
            for filename in filter(lambda fn,pattern=pattern: fnmatch(fn,pattern),
                    filter(os.path.isfile,map(lambda n, D=D: os.path.join(D,n),N))):
                compileModule(filename, savePy, force, verbose)
        os.path.walk(dirName,_visit,None)
    else:
        compileModules(os.path.join(dirName, pattern), savePy, force, verbose)

def _cleanFiles(filenames,verbose):
    for filename in filenames:
        if verbose:
            pnl('  found ' + filename + '; ')
        root, ext = os.path.splitext(os.path.abspath(filename))
        done = 0
        if os.path.isfile(root + '.py'):
            os.remove(root + '.py')
            done = done + 1
            if verbose: pnl(' removed .py ')
        if os.path.isfile(root + '.pyc'):
            os.remove(root + '.pyc')
            done = done + 1
            if verbose: pnl(' removed .pyc ')
        if done == 0:
            if verbose:
                pnl('nothing to remove')
        pel('')

def cleanDir(dirName, pattern="*.prep", recursive=1, verbose=1):
    "Removes all py and pyc files matching any prep files found"
    if verbose: pel('cleaning directory %s' % dirName)
    if recursive:
        def _visit(A,D,N,pattern=pattern,verbose=verbose):
            _cleanFiles(filter(lambda fn,pattern=pattern: fnmatch(fn,pattern),
                    filter(os.path.isfile,map(lambda n, D=D: os.path.join(D,n),N))),verbose)
        os.path.walk(dirName,_visit,None)
    else:
        import glob
        _cleanFiles(filter(os.path.isfile,glob.glob(os.path.join(dirName, pattern))),verbose)

def compileStuff(stuff, savePy=0, force=0, verbose=0):
    "Figures out what needs compiling"
    if os.path.isfile(stuff):
        compileModule(stuff, savePy=savePy, force=force, verbose=verbose)
    elif os.path.isdir(stuff):
        compileDir(stuff, savePy=savePy, force=force, verbose=verbose)
    else:
        compileModules(stuff, savePy=savePy, force=force, verbose=verbose)

def extractKeywords(arglist):
    "extracts a dictionary of keywords"
    d = {}
    for arg in arglist:
        chunks = arg.split('=')
        if len(chunks)==2:
            key, value = chunks
            d[key] = value
    return d

__notFound__ = object()
def _find_quoteValue(name,depth=2,default=__notFound__):
    try:
        while 1:
            g = sys._getframe(depth)
            if g.f_code.co_name=='__code__':
                g=g.f_globals
            else:
                g=g.f_locals
            if name in g: return g[name]
            depth += 1
    except:
        return default

def include(viewName,*args,**kwd):
    dir, filename = os.path.split(viewName)
    root, ext = os.path.splitext(filename)
    m = {}
    if dir: m['directory'] = dir
    if ext: m['source_extension'] = ext
    m = getModule(root,**m)
    if hasattr(m,'get'):
        #newstyle
        quoter = kwd.pop('__quoteFunc__',kwd.pop('quoteFunc',__notFound__))
        if quoter is __notFound__:
            quoter = _find_quoteValue('__quoteFunc__')
            if quoter is __notFound__:
                quoter = _find_quoteValue('quoteFunc',default=None)
        lquoter = kwd.pop('__lquoteFunc__',__notFound__)
        if lquoter is __notFound__:
            lquoter = _find_quoteValue('__lquoteFunc__',default=None)
        return m.get(__quoteFunc__=quoter,__lquoteFunc__=lquoter, *args,**kwd)
    else:
        #oldstyle
        if args:
            if len(args)>1:
                raise TypeError("include for old style prep file can have only one positional argument, dictionary")
            if 'dictionary' in kwd:
                raise TypeError('include: dictionary argument specified twice')
            dictionary = args[0].copy()
        elif 'dictionary' in kwd:
            dictionary = kwd.pop('dictionary').copy()
        else:
            dictionary = {}
        quoteFunc = kwd.pop('quoteFunc',kwd.pop('__quoteFunc__',__notFound__))
        if quoteFunc is __notFound__:
            quoteFunc = _find_quoteValue('quoteFunc')
            if quoteFunc is __notFound__:
                quoteFunc = _find_quoteValue('__quoteFunc__',default=None)
        dictionary.update(kwd)
        return m.getOutput(dictionary,quoteFunc=quoteFunc)

def main():
    if len(sys.argv)>1:
        name = sys.argv[1]

        if name == 'compile':
            names = sys.argv[2:]

            # save the intermediate python file
            if '--savepy' in names:
                names.remove('--savepy')
                savePy = 1
            elif '-p' in names:
                names.remove('-p')
                savePy = 1
            else:
                savePy = 0

            # force recompile every time
            if '--force' in names:
                names.remove('--force')
                force = 1
            elif '-f' in names:
                names.remove('-f')
                force = 1
            else:
                force = 0

            # extra output
            if '--verbose' in names:
                names.remove('--verbose')
                verbose = 1
            elif '-v' in names:
                names.remove('-v')
                verbose = 1
            else:
                verbose = 0

            for arg in names:
                compileStuff(arg, savePy=savePy, force=force, verbose=verbose)

        elif name == 'clean':
            for arg in sys.argv[2:]:
                cleanDir(arg, verbose=1)

        elif name == 'run':
            moduleName = sys.argv[2]
            params = extractKeywords(sys.argv)
            module = getPreppyModule(moduleName, verbose=0)
            module.run(params)

        else:
            #default is run
            moduleName = sys.argv[1]
            module = getPreppyModule(moduleName, verbose=0)
            if hasattr(module,'get'):
                pel(module.get())
            else:
                params = extractKeywords(sys.argv)
                module.run(params)
    else:
        pel("no argument: running tests")
        testgetOutput()
        pel(''); pel("PAUSING.  To continue hit return")
        raw_input("now: ")
        testgetmodule()

if __name__=="__main__":
    main()
