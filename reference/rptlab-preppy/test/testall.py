# Copyright ReportLab Europe Ltd. 2000-2015
# see license.txt for license details
# runs all key preppy tests.  Assumes preppy
# is on the path.

import os, sys
import unittest



def makeSuite():
    import check_basics, check_algorithms, check_load, check_lowlevel, test_import_hook
    suite = check_algorithms.makeSuite()
    suite.addTests(check_basics.suite)
    suite.addTests(unittest.makeSuite(check_load.LoadTestCase,'load'))
    suite.addTests(check_lowlevel.makeSuite())
    suite.addTests(test_import_hook.makeSuite())
    return suite


if __name__=='__main__':

    #try to pick up the preppy.py in the directory above
    parentDir = os.path.dirname(os.getcwd())
    sys.path.insert(0, parentDir)

    runner = unittest.TextTestRunner()
    runner.run(makeSuite())
