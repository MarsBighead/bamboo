function $(obj) 
{ 
    return document.getElementById(obj); 
} 

function close_open(tree) 
{ 
    if($(tree).style.display == "none") 
    { 
        $(tree).style.display = ""; 
    } 
    else 
    { 
        $(tree).style.display = "none";
    } 
} 