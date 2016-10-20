## php调用shell

出现问题：无论是使用,system(),exec(),shell_exec(),都没有反应

在大腿的提示下，看了眼error_log啊，果然有报错

```python
Traceback (most recent call last):
  File "/opt/lampp/htdocs/PMS/py/api.py", line 3, in <module>
    import cv2
ImportError: /opt/lampp/lib/libstdc++.so.6: version `GLIBCXX_3.4.21' not found (required by /usr/local/lib/python2.7/dist-packages/cv2.so)
Error in sys.excepthook:
Traceback (most recent call last):
  File "/usr/lib/python2.7/dist-packages/apport_python_hook.py", line 63, in apport_excepthook
    from apport.fileutils import likely_packaged, get_recent_crashes
  File "/usr/lib/python2.7/dist-packages/apport/__init__.py", line 5, in <module>
    from apport.report import Report
  File "/usr/lib/python2.7/dist-packages/apport/report.py", line 16, in <module>
    from xml.parsers.expat import ExpatError
  File "/usr/lib/python2.7/xml/parsers/expat.py", line 4, in <module>
    from pyexpat import *
ImportError: /usr/lib/python2.7/lib-dynload/pyexpat.x86_64-linux-gnu.so: undefined symbol: XML_SetHashSalt

Original exception was:
Traceback (most recent call last):
  File "/opt/lampp/htdocs/PMS/py/api.py", line 3, in <module>
    import cv2
ImportError: /opt/lampp/lib/libstdc++.so.6: version `GLIBCXX_3.4.21' not found (required by /usr/local/lib/python2.7/dist-packages/cv2.so)
```

有类似的解决方案，http://blog.csdn.net/shan165310175/article/details/48268677，http://askubuntu.com/questions/575505/glibcxx-3-4-20-not-found-how-to-fix-this-error

不知道在生产环境下，会不会也有这问题，心疼1s...

```shell
strings /usr/lib/x86_64-linux-gnu/libstdc++.so.6 | grep GLIBCXX
```

注意现在生成的文件是有权限的。。