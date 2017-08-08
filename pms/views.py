from django.shortcuts import render, render_to_response
from django.http import HttpResponse
from pms.models import Report 
from datetime import datetime
import json

# Create your views here.
def index(request):
    return render(request, "gentelella/index.htm", {'current_time':datetime.now()})

def index2(request):
    return render(request, "gentelella/index2.htm", {'current_time':datetime.now()})

def index3(request):
    return render(request, "gentelella/index3.htm", {'current_time':datetime.now()})

def form(request):
    return render(request, "gentelella/form.htm", {'current_time':datetime.now()})

def form_buttons(request):
    return render(request, "gentelella/form_buttons.htm", {'current_time':datetime.now()})

def form_advanced(request):
    return render(request, "gentelella/form_advanced.htm", {'current_time':datetime.now()})

def form_validation(request):
    return render(request, "gentelella/form_validation.htm", {'current_time':datetime.now()})

def form_upload(request):
    return render(request, "gentelella/form_upload.htm", {'current_time':datetime.now()})

def form_wizards(request):
    return render(request, "gentelella/form_wizards.htm", {'current_time':datetime.now()})

def general_elements(request):
    return render(request, "gentelella/general_elements.htm", {'current_time':datetime.now()})

def icons(request):
    return render(request, "gentelella/icons.htm", {'current_time':datetime.now()})

def inbox(request):
    return render(request, "gentelella/inbox.htm", {'current_time':datetime.now()})

def e_commerce(request):
    return render(request, "gentelella/e_commerce.htm", {'current_time':datetime.now()})

def projects(request):
    return render(request, "gentelella/projects.htm", {'current_time':datetime.now()})

def project_detail(request):
    return render(request, "gentelella/project_detail.htm", {'current_time':datetime.now()})

def profile(request):
    return render(request, "gentelella/profile.htm", {'current_time':datetime.now()})

def contacts(request):
    return render(request, "gentelella/contacts.htm", {'current_time':datetime.now()})

def login(request):
    return render(request, "gentelella/login.htm", {'current_time':datetime.now()})

def media_gallery(request):
    return render(request, "gentelella/media_gallery.htm", {'current_time':datetime.now()})

def typography(request):
    return render(request, "gentelella/typography.htm", {'current_time':datetime.now()})

def calendar(request):
    return render(request, "gentelella/calendar.htm", {'current_time':datetime.now()})

def pricing_tables(request):
    return render(request, "gentelella/pricing_tables.htm", {'current_time':datetime.now()})

def level2(request):
    return render(request, "gentelella/level2.htm", {'current_time':datetime.now()})

def fixed_footer(request):
    return render(request, "gentelella/fixed_footer.htm", {'current_time':datetime.now()})

def fixed_sidebar(request):
    return render(request, "gentelella/fixed_sidebar.htm", {'current_time':datetime.now()})

def tables(request):
    return render(request, "gentelella/tables.htm", {'current_time':datetime.now()})

def demo_api(request):
    return render_to_response( 'demo_api.xml', content_type ="application/xml" ) 

def demo_json(request):
    owner = {'email':'owner@126.com'}
    data = {
         'filename':'Report Demo.pdf',
         'data':'Dato',
	 'email':'hbu@localhost',
	 'owner': owner,
	 'author':'Toger'}
    response_data=json.dumps(data,indent=4)
    return HttpResponse(response_data, content_type="application/json")  

def tables_dynamic(request):
    return render(request, "gentelella/tables_dynamic.htm", {'current_time':datetime.now()})

def chartjs(request):
    return render(request, "gentelella/chartjs.htm", {'current_time':datetime.now()})

def chartjs2(request):
    return render(request, "gentelella/chartjs2.htm", {'current_time':datetime.now()})

def other_charts(request):
    return render(request, "gentelella/other_charts.htm", {'current_time':datetime.now()})

def morisjs(request):
    return render(request, "gentelella/morisjs.htm", {'current_time':datetime.now()})

def echarts(request):
    return render(request, "gentelella/echarts.htm", {'current_time':datetime.now()})

def widgets(request):
    return render(request, "gentelella/widgets.htm", {'current_time':datetime.now()})

def invoice(request):
    return render(request, "gentelella/invoice.htm", {'current_time':datetime.now()})

def glyphicons(request):
    return render(request, "gentelella/glyphicons.htm", {'current_time':datetime.now()})

def page_403(request):
    return render(request, "gentelella/page_403.htm", {'current_time':datetime.now()})

def page_404(request):
    return render(request, "gentelella/page_404.htm", {'current_time':datetime.now()})

def page_500(request):
    return render(request, "gentelella/page_500.htm", {'current_time':datetime.now()})

def detail(request, my_args):
    post = Article.objects.all()[int(my_args)]
    str =("name = %s, keywords = %s, date_time = %s, content = %s"
        % (post.name, post.keywords, post.date_time, post.content)
    )
    return HttpResponse(str)

def home(request):
    return render(request, "home.htm", {'current_time':datetime.now()})
