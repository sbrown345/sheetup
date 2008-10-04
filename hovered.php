<?php 
    $title = "HoverEd";
	$id = "eg";
    @include_once "inc/header.php"; 
?>
           
<script type="text/javascript" src="js/sheetup.js"></script>
<script  type="text/javascript" >
var output, div, del, label, input, selectorText;		
window.onload = function() {
    refresh();
	
	//setup events
	gid("addrules").onclick = function() {
        ss(gid("newrules").value);
        refresh();
	};
	
	gid("refresh").onclick = refresh;	
};



function beginDrag(dragged, event) {      
    var x = parseInt(dragged.style.left),
        y = parseInt(dragged.style.top);
        dX = event.clientX - x;
        dY = event.clientY - y;      
       
    if(document.addEventListener) {
        document.addEventListener("mousemove", moveHandler, true);
        document.addEventListener("mouseup", upHandler, true);    
    }  else if(document.attachEvent) {  
        dragged.attachEvent("onmousemove", moveHandler);
        dragged.attachEvent("onmouseup", upHandler);   
        dragged.setCapture();           
    }    
   
    if(event.stopPropagation)	event.stopPropagation(); 
    else event.cancelBubble = true;    
        
    if(event.preventDefault)	event.preventDefault();
    else event.returnValue = false;

    function moveHandler(e) {
        if(!e)e=window.event;        
     
        dragged.style.left = (e.clientX - dX) + "px";
        dragged.style.top = (e.clientY - dY) + "px";
        
        if(e.stopPropagation)  e.stopPropagation(); 
        else e.cancelBubble = true;        
    }

    function upHandler(e) {
        if(!e)e=window.event;
        if(document.removeEventListener) {
            document.removeEventListener("mouseup", upHandler, true);
            document.removeEventListener("mousemove", moveHandler, true);
        } else if(document.detachEvent) {
            dragged.detachEvent("onmouseup", upHandler);
            dragged.detachEvent("onmousemove", moveHandler);
            dragged.releaseCapture();
        }        
        if(e.stopPropagation)  e.stopPropagation(); 
        else e.cancelBubble = true;    
        
    }
}


function refresh() { 
    gid("rules").innerHTML = "";
	
    //build up the rule list 
	ss().each(function(i, rule) {    
       
        ruleDiv = document.createElement("div");
        ruleDiv.className = "rule";
        selectorText = document.createElement("span");
        selectorText.className = "selectorText";
        selectorText.innerHTML = this.selectorText + " {";
        selectorText.onclick = function() {     ss(this.innerHTML.substring(0, this.innerHTML.length-2)).remove(); refresh();    };
        closeText = document.createElement("span");
        closeText.innerHTML = "}";
        closeText.className = "close";
        ruleDiv.appendChild(selectorText);
        
        ss.fn.eachStyle(rule, function(si, name, value) {
            
            if(ss.fn.checkStyle(name)) {
            
                div = document.createElement("div"); 
                del = document.createElement("a"); 
                label = document.createElement("label"); 
                input = document.createElement("input");   
                
                div.className = "style";
                del.className = "del";
                label.className = "name";
                input.className = "value";
                
                del.innerHTML = "x ";
                del.rule = input.rule = rule;
                del.propName = input.propName = name;
                label.innerHTML = name;      
                input.value = value;                
    
                div.appendChild(del);
                div.appendChild(label);
                div.appendChild(input);
             
                ruleDiv.appendChild(div);                
                
                del.onclick  = function(){ ss(this.rule); ss(this.rule).removeProperty(this.propName); refresh(); }    //need a remvoe property????   
                input.onblur = function(){ss(this.rule).property(this.propName, this.value); refresh(); };
            }            
        });
        
        add = document.createElement("a"); 
        add.innerHTML = "Add...";
        add.href = "#";
        add.rule = rule;
        add.className = "add";
        add.onclick = function(){var name = prompt("Name"), value = prompt("Value"); ss(this.rule).property(name, value); refresh();return false;};
        ruleDiv.appendChild(add);        
        
        ruleDiv.appendChild(closeText);
        
	    gid("rules").appendChild(ruleDiv);        
        
    });
}


	
</script>

<p>This example shows sheetUp being used to build a simple style editing window. 
It simply iterates through the rules to create a list of them. (Use mouse wheel to scroll - will fix later.)
Use your browser's "View Source" option to view how it's made.</p>

<div id="handle" onmousedown="beginDrag(this, event);"  style="top:140px;left:120px;">
    <div id="hover">
        <div>
            New rule<br />
            <textarea id="newrules" cols="25" rows="5"></textarea><input type="button" id="addrules" value="Add" /></div>
        <input type="button" value="Refresh Rules" id="refresh" /><br />
        <br />
        <div id="rules">
        </div>
    </div>
</div>

<?php @include_once "inc/footer.php"; ?>
        
