from distutils.core import setup
import os, sys

if __name__=='__main__':
    pkgDir=os.path.dirname(sys.argv[0])
    if not pkgDir:
        pkgDir=os.getcwd()
    if not os.path.isabs(pkgDir):
        pkgDir=os.path.abspath(pkgDir)
    sys.path.insert(0,pkgDir)
    os.chdir(pkgDir)

    import preppy
    version = preppy.VERSION
    scriptsPath=os.path.join(pkgDir,'build','scripts')

    def makeScript(modName):
        try:
            bat=sys.platform in ('win32','amd64')
            scriptPath=os.path.join(scriptsPath,modName+(bat and '.bat' or ''))
            exePath=sys.executable
            f = open(scriptPath,'w')
            try:
                if bat:
                    text = '@echo off\nrem startup script for %s-%s\n"%s" -m "%s" %%*\n' % (modName,version,exePath,modName)
                else:
                    text = '#!/bin/sh\n#startup script for %s-%s\nexec "%s" -m "%s" $*\n' % (modName,version,exePath,modName)
                f.write(text)
            finally:
                f.close()
        except:
            print('script for %s not created or erroneous' % modName)
            import traceback
            traceback.print_exc(file=sys.stdout)
            return None
        print('Created "%s"' % scriptPath)
        return scriptPath

    scripts = []
    if not os.path.isdir(scriptsPath): os.makedirs(scriptsPath)
    scripts.extend(filter(None,[
            makeScript('preppy'),
        ]))

    setup(name='preppy',
        version=version,
        description='preppy - a Preprocessor for Python',
        author='Robin Becker, Andy Robinson, Aaron Watters',
        author_email='andy@reportlab.com',
        url='http://bitbucket.org/rptlab/preppy',
        py_modules=['preppy'],
        scripts=scripts,
        )
