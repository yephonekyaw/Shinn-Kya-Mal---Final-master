
// Date Or Category

var date = new Date();

var month=date.getMonth();

 function SelectElement(months,month )
{    
    var element = document.getElementById(months);
    element.value = month;
}

function bydate() {
    var date = document.getElementById("date");
    var cata = document.getElementById("bycata");
    var border1 = document.getElementById("borderchange1");
    var border2 = document.getElementById("borderchange2");
    border1.style.borderBottom ="4px solid #444444 "  ;
    border2.style.borderBottom="";
    if (cata.style.visibility === "visible") 
    {
      date.style.display = "";
      cata.style.visibility="hidden";
      
    }
    else
    {
      date.style.display="";
    }
    
}
function bycata()
{
  var date = document.getElementById("date");
  var cata = document.getElementById("bycata");
  var border2 = document.getElementById("borderchange2");
  var border1 = document.getElementById("borderchange1");
  border2.style.borderBottom ="4px solid #444444  " ;
  border1.style.borderBottom="";
  if(date.style.display === "")
    {
      cata.style.visibility="visible";
      date.style.display="none";
    }
    else{
      cata.style.display="";
    }
}



// pop up modal input

var modal = document.getElementById("mymodal");
var btn = document.getElementById("plusButton");
var span = document.getElementsByClassName("close")[0];

