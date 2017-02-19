import os, sys, unittest
import preppy

class ImportTestCase(unittest.TestCase):
    def setUp(self):
        self.cwd = os.getcwd()
        dn = os.path.dirname(sys.argv[0])
        if dn: os.chdir(dn)
        preppy.installImporter()

    def testImport1(self):
        if os.path.isfile('sample001.pyc'):
            os.remove('sample001.pyc')
        import sample001
        sample001.getOutput({})

        #uninstallImporter seems not to work
    def testImport2(self):
        if os.path.isfile('sample001n.pyc'):
            os.remove('sample001n.pyc')
        import sample001n
        sample001n.get(A=4)

    def testImport3(self):
        parentDir = os.path.normpath(os.path.join(os.getcwd(),'..'))
        sys.path.insert(0,parentDir)
        try:
            for name in 'sample001 sample001n'.split():
                if name in sys.modules:
                    sys.modules[name]
            import test.sample001, test.sample001n
        finally:
            sys.path.remove(parentDir)

    def tearDown(self):
        preppy.uninstallImporter()
        if self.cwd!=os.getcwd():
            os.chdir(self.cwd)

def makeSuite():
    return unittest.makeSuite(ImportTestCase)

if __name__=='__main__':
    runner = unittest.TextTestRunner()
    runner.run(makeSuite())
