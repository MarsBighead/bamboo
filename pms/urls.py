"""toger URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/1.9/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.conf.urls import url, include
    2. Add a URL to urlpatterns:  url(r'^blog/', include('blog.urls'))
"""
from django.conf.urls import include, url
from pms import views

app_name = 'pms'

urlpatterns = [
    url(r'^$|^home$|^index$',views.home, name= 'home'),
    url(r'^index.html$|^index.htm$',views.index, name= 'index'),
    url(r'^index2.html$|^index2.htm$',views.index2, name= 'index2'),
    url(r'^index3.html$|^index3.htm$',views.index3, name= 'index3'),
    url(r'^form.html$|^form.htm$',views.form, name= 'form'),
    url(r'^form_buttons.html$|^form_buttons.htm$',views.form_buttons, name= 'form_buttons'),
    url(r'^form_upload.html$|^form_upload.htm$',views.form_upload, name= 'form_upload'),
    url(r'^form_wizards.html$|^form_wizards.htm$',views.form_wizards, name= 'form_wizards'),
    url(r'^form_validation.html$|^form_validation.htm$',views.form_validation, name= 'form_validation'),
    url(r'^form_advanced.html$|^form_advanced.htm$',views.form_advanced, name= 'form_advanced'),
]

