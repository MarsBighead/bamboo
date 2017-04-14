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
    url(r'^general_elements.html$|^general_elements.htm$',views.general_elements, name= 'general_elements'),
    url(r'^icons.html$|^icons.htm$',views.icons, name= 'icons'),
    url(r'^inbox.html$|^inbox.htm$',views.inbox, name= 'inbox'),
    url(r'^login.html$|^login.htm$',views.login, name= 'login'),
    url(r'^calendar.html$|^calendar.htm$',views.calendar, name= 'calendar'),
    url(r'^media_gallery.html$|^media_gallery.htm$',views.media_gallery, name= 'media_gallery'),
    url(r'^typography.html$|^typography.htm$',views.typography, name= 'typography'),
    url(r'^level2.html$|^level2.htm$',views.level2, name= 'level2'),
    url(r'^pricing_tables.html$|^pricing_tables.htm$',views.pricing_tables, name= 'pricing_tables'),
    url(r'^contacts.html$|^contacts.htm$',views.contacts, name= 'contacts'),
    url(r'^profile.html$|^profile.htm$',views.profile, name= 'profile'),
    url(r'^projects.html$|^projects.htm$',views.projects, name= 'projects'),
    url(r'^project_detail.html$|^project_detail.htm$',views.project_detail, name= 'project_detail'),
    url(r'^e_commerce.html$|^e_commerce.htm$',views.e_commerce, name= 'e_commerce'),
    url(r'^echarts.html$|^echarts.htm$',views.echarts, name= 'echarts'),
    url(r'^chartjs.html$|^chartjs.htm$',views.chartjs, name= 'chartjs'),
    url(r'^chartjs2.html$|^chartjs2.htm$',views.chartjs2, name= 'chartjs2'),
    url(r'^other_charts.html$|^other_charts.htm$',views.other_charts, name= 'other_charts'),
    url(r'^morisjs.html$|^morisjs.htm$',views.morisjs, name= 'morisjs'),
    url(r'^page_404.html$|^page_404.htm$',views.page_404, name= 'page_404'),
    url(r'^page_403.html$|^page_403.htm$',views.page_403, name= 'page_403'),
    url(r'^page_500.html$|^page_500.htm$',views.page_500, name= 'page_500'),
    url(r'^invoice.html$|^invoice.htm$',views.invoice, name= 'invoice'),
    url(r'^widgets.html$|^widgets.htm$',views.widgets, name= 'widgets'),
    url(r'^glyphicons.html$|^glyphicons.htm$',views.glyphicons, name= 'glyphicons'),
    url(r'^fixed_footer.html$|^fixed_footer.htm$',views.fixed_footer, name= 'fixed_footer'),
    url(r'^fixed_sidebar.html$|^fixed_sidebar.htm$',views.fixed_sidebar, name= 'fixed_sidebar'),
    url(r'^tables.html$|^tables.htm$',views.tables, name= 'tables'),
    url(r'^tables_dynamic.html$|^tables_dynamic.htm$',views.tables_dynamic, name= 'tables_dynamic'),
    url(r'^demo_api$',views.demo_api, name= 'demo_api'),
]

