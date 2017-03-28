from __future__ import unicode_literals

from django.db import models

# Create your models here.
class Report(models.Model):
    name = models.CharField(max_length = 128)
    keywords = models.CharField(max_length = 100, blank = True) # keyword tags 
    date_time = models.DateTimeField(auto_now_add = True )
    institution = models.CharField(max_length = 128)
    content = models.TextField(blank = True, null = True)
    def __unicode__(self):
        return self.name
    class Meta:
        ordering = ['-date_time']  
