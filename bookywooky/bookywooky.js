
(function() {

//put into one big function.......anon
//tidy up - easy to add another lib etc
//make little fadein or slide animtion
//way to add custom libraries...AND TOOLS!!!!!!!. - could be really useful then!
var baseUrl = "http://localhost/booky/";

function loadScript(url, callback) {
    url = typeof url === "undefined" ? baseUrl + 'bookywooky.js' : url;
    var scr=document.createElement('script');
    scr.setAttribute('src', url);
    scr.onload = callback;
    document.body.appendChild(scr);
}

function showWindow(html) {
    if(gid("bookyDiv")) {
        gid("bookyDiv").innerHTML += html;
    }
    else {        
    
        var bookyCss = "#bookyDiv {padding:5px;font-size:11px;font-family:Arial, sans-serif;position:absolute;left:0;top:0;color:fff;background:#000;width:190px;}" +
        "#bookyClose{color:red;cursor:pointer;float:right;padding:0px 7px 0 0;}" +
        "#bookyDiv a{color:#eee;text-decoration:none;border-bottom:1px dotted #fff;}" +
        "#bookyGo {float:right;border:none;position:relative;top:3px;}"+
        "#bookyGo .bookyLoaded{display:block;}"+
        "#bookyGo .bookyError{color:red;font-weight:bold;}";        
        
        if(document.createStyleSheet) {   
            document.createStyleSheet().cssText = bookyCss;
        }   
        else {  
            var cssNode = document.createElement('style');
            cssNode.type  = 'text/css';
            cssNode.media = 'screen';
            cssNode.rel   = 'stylesheet';
            document.body.appendChild(cssNode);
            cssNode.appendChild(document.createTextNode(bookyCss));
            cssNode = cssNode.sheet;
        }                
    
        var bookyHtml = "<span id=bookyClose onclick='bookyClose()' title='Close BookyWooky'>x</span><style type='text/css'>#bookyDiv {padding:5px;font-size:11px;font-family:Arial, sans-serif;position:absolute;left:0;top:0;color:fff;background:#000;width:190px;}" +
        "#bookyClose{color:red;cursor:pointer;float:right;padding:0px 7px 0 0;} #bookyDiv a{color:#eee;text-decoration:none;border-bottom:1px dotted #fff;}    " +
        "#bookyGo {float:right;border:none;position:relative;top:3px;}"+
        "#bookyGo .bookyLoaded{display:block;}"+
        "</style>" +  html;    
                   
        var bookyDiv = document.createElement("DIV");
        bookyDiv.id = "bookyDiv";
        bookyDiv.title = "BookyWooky - Load JavaScript libraries and Firebug console on to any webpage anywhere. http://sheetup.com/";
        bookyDiv.innerHTML = bookyHtml;
        document.body.appendChild(bookyDiv);
    }
}

function slide() {}
function fade () {}
function gid(id) {return document.getElementById(id);} 

//menu
if(bookyStatus == "loading1") {
    var bookyHtml = 
               "<input type=checkbox id=bookyFb><label for=bookyFb>Firebug 1.2</label> <a title=Documentation target=_blank href=http://getfirebug.com/docs.html>?</a><br>"+  
               "<input type=checkbox id=bookyJ><label for=bookyJ>jQuery 1.2.6</label> <a title=Documentation  target=_blank href=http://docs.jquery.com/>?</a><br>"+  
               "<input type=checkbox id=bookyP><label for=bookyP>Prototype 1.6.0.3</label> <a title=Documentation  target=_blank href=http://prototypejs.org/api>?</a><br>"+  
               "<input type=checkbox id=bookyMoo><label for=bookyMoo>MooTools 1.2.1</label> <a title=Documentation  target=_blank href=http://mootools.net/docs/>?</a><br>"+  
               "<input type=checkbox id=bookysheet><label for=bookysheet>sheetUp</label> <a title=Documentation  target=_blank href=http://code.google.com/p/sheetup/w/list>?</a><br>"+  
               "<input type=button id=bookyGo value='Load JS'>"+
               ""+
               "<div id=bookyBookmarkDefaults title='This is a generated bookmarklet with these options set as default. Double-click the bookmarklet to open them without this dialog.'></div>";
               
                              
    showWindow(bookyHtml);
    
    var firebugbooky = gid("bookyFb"), //careful with vars...should get rid of these incase
        prototype = gid("bookyP"),
        mootools = gid("bookyMoo"),   
        jquery = gid("bookyJ");      
        sheetup = gid("bookysheet");    
        
    //setup checkboxes
    if(typeof jQuery !== "undefined" || "$" !== "undefined")
        jquery.disabled = true;
    else if(bookyDefaults.indexOf("jQuery") > -1)
        jquery.checked = true;
    
    if(typeof Prototype !== "undefined")
        prototype.disabled = true;
    else if(bookyDefaults.indexOf("Prototype") > -1)
        prototype.checked = true;
            
    if(typeof ss !== "undefined")
        sheetup.disabled = true;
    else if(bookyDefaults.indexOf("sheetUp") > -1)
        sheetup.checked = true;
           
    if(typeof MooTools !== "undefined")
        mootools.disabled = true;
    else if(bookyDefaults.indexOf("MooTools") > -1)
        mootools.checked = true;
            
            
    //disable firebug if its loaded already
    if(gid("_firebugConsole")) 
        firebugbooky.disabled = "disabled";    
    else if (bookyDefaults.indexOf("Firebug") > -1)
        firebugbooky.checked = true;
        

    function loadStuff() {   
        if(firebugbooky.checked)
            loadFirebug();        
        
        if(jquery.checked)
            loadLib("http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js", "jQuery");
        
        if(prototype.checked)
             loadLib("http://prototypejs.org/assets/2008/9/29/prototype-1.6.0.3.js", "Prototype");
            
        if(mootools.checked)
            loadLib("http://mootools.net/download/get/mootools-1.2.1-core-yc.js", "MooTools");
                    
        if(sheetup.checked)
            loadLib("http://sheetup.com/js/sheetup.packed.js", "sheetUp");
                    
        gid("bookyFb")   .disabled =
        gid("bookyP")    .disabled =
        gid("bookyMoo")  .disabled =
        gid("bookyJ")    .disabled =
        gid("bookysheet").disabled =
        gid("bookyGo")   .disabled = true;          
            
    }
    
    //Events
    gid("bookyFb").onclick =
    gid("bookyP").onclick =
    gid("bookyJ").onclick =
    gid("bookyMoo").onclick =
    gid("bookysheet").onclick = makeDefaultBookmarklet;     
    
    gid("bookyGo").onclick = loadStuff;

    
    makeDefaultBookmarklet();
}


//looks at defaulits variable - easy way of making custom book mark
else if (bookyStatus == "loading2") {    
    //Firebug   
    if(gid("_firebugConsole")) {
        if(bookyDefaults.indexOf("firebug") > -1)
            loadFirebug();        
    }
    //jQuery
    if(bookyDefaults.indexOf("jQuery") > -1)
        loadLib("http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js", "jQuery");
    
    if(bookyDefaults.indexOf("Prototype") > -1)
        loadLib("http://prototypejs.org/assets/2008/9/29/prototype-1.6.0.3.js", "Prototype");

    if(bookyDefaults.indexOf("MooTools") > -1)
        loadLib("http://mootools.net/download/get/mootools-1.2.1-core-yc.js", "MooTools");

    if(bookyDefaults.indexOf("sheetUp") > -1)
        loadLib("http://sheetup.com/js/sheetup.packed.js", "sheetUp");

}


/*Load*/
function loadLib(url, libName, func) {
    if (typeof func == "function") func()
    else loadScript(url, function(){showWindow("<div class='bookyLoaded'>Loaded "+libName+"</div>");});
    
}






function makeDefaultBookmarklet() {
    var html ="<a href=\"javascript:bookyDefaults='";
    
    if(firebugbooky.checked)
        html += "Firebug,";
    
    if(prototype.checked)
        html += "Prototype,";
    
    if(jquery.checked)
        html += "jQuery,";    
    
    if(mootools.checked)
        html += "MooTools,";
    
    if(sheetup.checked)
        html += "sheetUp,";
    
    
    html+="';function%20loadScript(url,callback){url=typeof%20url==='undefined'?'"+baseUrl+"bookywooky.js':url;var%20scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('body')[0].appendChild(scr);}if(typeof%20bookyStatus==='undefined'){var%20bookyStatus='waiting2ndclick';var%20bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript('http://localhost/booky/bookywooky.js');},200);}else%20if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript('http://localhost/booky/bookywooky.js');}else{alert('Loaded%20already');}void(0);"
    
    gid("bookyBookmarkDefaults").innerHTML = (html + "\">Default bookmarklet</a>");    
}



bookyClose = function() {
    gid("bookyDiv").parentNode.removeChild(gid("bookyDiv"));
    bookyStatus = undefined;
    //todo...
    //rmove any event listeners?
    //shoud hvae 1 big func for whoel thingm, then set that to undefeind and remove that
   
}
})();