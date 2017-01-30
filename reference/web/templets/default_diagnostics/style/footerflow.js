window.onload=function()
{
	var tag=document.getElementsByTagName('li');
	var map = new Array();
	for(var i=0;i<tag.length;i++)
	{
		var arr=tag[i].id.split('_');
		if(!map[arr[0]]){map[arr[0]]="";}
		map[arr[0]]+=arr[1]+";";
	}
	get3(map);
}
function get3(map)
{
	for(var id in map)
	{
		var arrtmp=map[id].split(';');
		var tmp=map[id];
		for(var i=0;i<3;i++)
		{
			var arr=tmp.split(';');
			var rand=Math.floor(Math.random()*(arr.length-1));
			tmp=tmp.replace(arr[rand]+";","");
		}
		arrtmp=tmp.split(';');
		for(var i=0;i<arrtmp.length;i++)
		{
			try{document.getElementById(id+"_"+arrtmp[i]).style.display="none";}
			catch(e){}
		}
	}
}
