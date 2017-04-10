from django.shortcuts import render
from django.http import HttpResponse
from pms.models import Report 
from datetime import datetime

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

def detail(request, my_args):
    post = Article.objects.all()[int(my_args)]
    str =("name = %s, keywords = %s, date_time = %s, content = %s"
        % (post.name, post.keywords, post.date_time, post.content)
    )
    return HttpResponse(str)

def home(request):
    return render(request, "home.htm", {'current_time':datetime.now()})
