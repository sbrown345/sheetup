<?php 
    $title = "sheetUp Stylesheet Playground/Cheatsheet";
    @include_once "inc/header.php"; 
?>
    <script src="js/sheetup.js" type="text/javascript"></script>
     <div id="cheatsheetcontainer">
    
        <p></p>
        <a href="#" onclick="reset()">Click here to reset</a>
        
		
		
		
        <ul id="tabmenu"></ul>
        <div id="tabwrapper">
            <div class="tab">
                <h2>Selecting</h2>
                <p>Woo</p>                
            </div>    
            <div class="tab">
                <h2>Utils</h2>
                <p>Woo tab 2</p>                
            </div>     
            <div class="tab">
                <h2>Utils</h2>
                <p>Woo tab 3</p>                
            </div>     
            <div class="tab">
                <h2>Utils</h2>
                <p>Woo tab 4</p>                
            </div>        
        </div>
        
               
        
        
        <textarea id="code" cols="70" rows="4"></textarea>
        <input id="exec" type="button" value="Execute" onclick="eval(document.getElementById('code').value);"  />
    
    </div>



<script type="text/javascript">

function reset() {
	ss.fn.removeSS(0);  //need to remove all of them....
	
	ss('js/styles.css');	
}




window.onload = function() {
	
	gid("reset").onclick = reset;

    
    
    var divs = document.getElementsByTagName("div"),
    tabs = [], i, tablinks, 
    tabmenu = gid("tabmenu");
    for(i=0; i<divs.length; i++)
        if(divs[i].className === "tab")
            tabs.push(divs[i]);
            
    //make links
    for(i=0; i<tabs.length; i++) {    
        tab = tabs[i];
        tabmenu.innerHTML = tabmenu.innerHTML += "<li><a href=#>"+tab.getElementsByTagName("h2")[0].innerHTML+"</a></li>";
        //hide one not shown
        if(i!==0) tab.style.display = "none";     
    }
    
    
    
    //hide tabs add action to links
    tablinks = tabmenu.getElementsByTagName("a");
    tablinks[0].className = "tab tab-selected"; 
    
    
    for(i=0; i<tablinks.length; i++) {  
    
    
        tablinks[i].hash = i;        
        tablinks[i].onclick = function() {
            
        
            //hide/show tabs
            for(var t=0; t<tabs.length; t++) { 
                var tab = tabs[t],
                    tablink = tablinks[t];
                    
                if (this.hash == tablink.hash)  {
                    tab.style.display = "block";  
                    tablink.className = "tab tab-selected";  
                    
                } else {
                    tab.style.display = "none";  
                    tablink.className = "tab";
                
                }
                        
            }  
                
            return false;
        }    
    }

};




</script>

        
<?php @include_once "inc/footer.php"; ?>
        
