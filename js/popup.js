var tid = 0, x = 0, y = 0;
var obj;

document.onmousemove=track;

function track(e)
{
    x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX;
    y = (document.all) ? window.event.y + document.body.scrollTop : e.pageY;
}

function show(id)
{
    obj = document.getElementById("popup" +id);
    obj.style.left = x - 20;
    obj.style.top = y - 55;
    obj.style.display = "block";
    tid = window.setTimeout("show("+id+")",1);
}

function hide(id)
{
    obj = document.getElementById("popup" +id);
    window.clearTimeout(tid);
    obj.style.display = "none";
}