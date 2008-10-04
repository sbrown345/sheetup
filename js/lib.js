function gid(id){return document.getElementById(id);}


function getElementsByClassName(c, tag) {  
    var output = [],   
        cells = document.getElementsByTagName("td"),
        i;
    
    for(i=0;i<cells.length;i++)
        if(cells[i].className == c)
            output.push(cells[i]);
    
    return output;
}

var libDEBUG = true;
function log(m, m2) {
    if(libDEBUG) {			
        try {			   	        
            if(arguments.length > 1) console.log(m, m2);	 
            else console.log(m); 
        }catch(e){}
    }
}
