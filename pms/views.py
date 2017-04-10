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

def detail(request, my_args):
    post = Article.objects.all()[int(my_args)]
    str =("name = %s, keywords = %s, date_time = %s, content = %s"
        % (post.name, post.keywords, post.date_time, post.content)
    )
    return HttpResponse(str)

def home(request):
    return render(request, "home.htm", {'current_time':datetime.now()})
