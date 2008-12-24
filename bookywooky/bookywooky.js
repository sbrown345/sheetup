/*
todo
    Add custom scripts to the bookmarklet e.g. other tools and libraries
    Major code clean up (and bookmarklet link)
    Script onload for ie
    Perhaps some snazzy fade or slide in/out
    Some way of auto-managing conflicts between libraries
    Webkit compatiblity
    Double-click bookmarklet in IE

*/


(function() {
//tidy up - easy to add another lib etc
//make little fadein or slide animtion
//way to add custom libraries...AND TOOLS!!!!!!!. - could be really useful then!

/*
var bookyMerge = {
    Test : {name: "Test", url: "new url", loaded: function() {}, docs: "aoo", func: function() {}},
    Firebug : null
};
*/

var defaults = {
    Firebug :   {name: "Firebug 1.2",           url:    "",
                                                loaded: function() {return document.getElementById("_firebugConsole") !== null || typeof firebug !== "undefined"},
                                                docs:   "http://getfirebug.com/docs.html", 
                                                func:   function() {
                                                        document.location.href = "javascript:"+
                                                        "var firebug=document.createElement('script');"+
                                                        "firebug.setAttribute('src','http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');"+
                                                        "document.body.appendChild(firebug);"+
                                                        "(function(){if(window.firebug.version){firebug.init();document.getElementById('bookyDiv').innerHTML "+
                                                        "+= '<div  style=\"color:#fff\"  class=\"bookyLoaded\">Loaded Firebug</div>';}else{setTimeout(arguments.callee);}})();"+
                                                        "void(firebug);";
                                                }},
                                                
    jQuery :    {name: "jQuery 1.2.6",          url:    "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js", 
                                                loaded: function() {return typeof jQuery !== "undefined"},
                                                docs:   "http://docs.jquery.com/"},
                                                
    Prototype : {name: "Prototype 1.6.0.3",     url:    "http://prototypejs.org/assets/2008/9/29/prototype-1.6.0.3.js", 
                                                loaded: function() {return typeof Prototype !== "undefined"},
                                                docs:"  http://prototypejs.org/api"},
                                                
    MooTools :  {name: "MooTools 1.2.1 ",       url:    "http://mootools.net/download/get/mootools-1.2.1-core-yc.js", 
                                                loaded: function() {return typeof MooTools !== "undefined"},
                                                docs:   "http://mootools.net/docs/"},
                                                
    sheetUp :   {name: "sheetUp 0.1.1",         url:    "http://sheetup.com/js/sheetup.packed.js", 
                                                loaded: function() {return typeof sheetUp !== "undefined"},
                                                docs:   "http://code.google.com/p/sheetup/w/list"}   
};


function mergeCustom() {
    if(typeof bookyMerge !== "object")
        return;
    
    
    for(def in defaults) {    
        for(merg in bookyMerge) {
            defaults[merg] = bookyMerge[merg];
        }        
    }      
    //remove nulls
    for(def in defaults) {     
        if(defaults[def] === null)
            delete defaults[def]; 
    }
}
mergeCustom();


if(bookyStatus       === "loading1") 
    singleClick();
else if (bookyStatus === "loading2") {     
    doubleClick();
}


/***************************************
    SINGLE AND DOUBLE CLICK FUNCS
***************************************/

function singleClick() {

    
    var bookyHtml = "";
    
    for(def in defaults) {
        var current = defaults[def];
        bookyHtml += "<input type='checkbox' id='booky"+def+"'> <label style='color:#fff' for='booky"+def+"'>"+current.name+"</label> <a style='color:#eee;text-decoration:none;border-bottom:1px dotted #fff;' title='Documentation' target='_blank' href='"+current.docs+"'>?</a><br />";
    }   
    
    bookyHtml +="<input type=button id=bookyGo value='Load JS' style='float:right;border:none;position:relative;top:3px;'>"+
                "<div id=bookyBookmarkDefaults style='padding-bottom:5px;' title='This is a generated bookmarklet with these options set as default. Double-click the bookmarklet to open them without this dialog.'></div>";

    showWindow(bookyHtml);

    for(def in defaults) {
        var current = defaults[def];
        if(current.loaded())
            gid("booky"+def).disabled = true;
        else if(bookyDefaults.indexOf(def) != -1)
            gid("booky"+def).checked = true;        
                
        gid("booky"+def).onclick = makeDefaultBookmarklet;
    }   
    
    gid("bookyGo").onclick = function() { 
        for(def in defaults) {    
            var current = defaults[def];
            if(gid("booky"+def).checked)
                loadLib(current.url, def, current.func);            

            gid("booky"+def).disabled = true;
        }        
    };
    
    
    
    makeDefaultBookmarklet();

}

function doubleClick() {
    //load default list of libs that are not already loaded
    for(def in defaults) {    
        var current = defaults[def];
        if(!current.loaded())
            if(bookyDefaults.indexOf(def) != -1)
                loadLib(current.url, def, current.func);           
    }       
}


/***************************************
    LIBS
***************************************/
    
function gid(id) {return document.getElementById(id);} 

function loadLib(url, libName, func) {
    if (typeof func == "function") func()
    else loadScript(url, function(){showWindow("<div class='bookyLoaded'>Loaded "+libName+"</div>");});
    
}
function slide() {}
function fade () {}

function loadScript(url, callback) {
    var scr=document.createElement('script');
        scr.src = url;
        scr.onload = callback;
    document.body.appendChild(scr);
}
   
function showWindow(html) {
    window.scrollTo(0,0);//it is absolutely positioned at the top so move the viewport there
    
    //Just add text to previously made window
    if(gid("bookyDiv")) {
        gid("bookyDiv").innerHTML += html;
    
    }
    else {
        //Add HTML
        var bookyHtml = "<span id=bookyClose style='color:red;cursor:pointer;float:right;padding:0px 7px 0 0;' onclick='document.getElementById(\"bookyDiv\").parentNode.removeChild(document.getElementById(\"bookyDiv\"));bookyStatus = undefined;' title='Close BookyWooky'>x</span>" +  html;    
        var bookyDiv = document.createElement("DIV");
        bookyDiv.id = "bookyDiv";
        bookyDiv.setAttribute("style", "color:white;text-align:left;padding:5px;font-size:11px;font-family:Arial, sans-serif;position:absolute;left:0;top:0;color:fff;background:#000;width:190px;");
        bookyDiv.title = "BookyWooky - Load JavaScript libraries and Firebug console on to any webpage anywhere. http://sheetup.com/";
        bookyDiv.innerHTML = bookyHtml;
        document.body.appendChild(bookyDiv);
    }
}

function makeDefaultBookmarklet() {
    var html ="<a style='color:#eee;text-decoration:none;border-bottom:1px dotted #fff;' href=\"javascript:bookyDefaults='";       
    
    for(def in defaults) {
        if(gid("booky"+def).checked)
            html += def+",";        
    }   
        
    html+="';bookyBaseUrl='"+bookyBaseUrl+"';";    
    html+="function%20loadScript(url,callback){url=typeof%20url==='undefined'?bookyBaseUrl+'bookywooky.js':url;var%20scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('head')[0].appendChild(scr);}if(typeof%20bookyStatus==='undefined'){var%20bookyStatus='waiting2ndclick';var%20bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript();},200);}else%20if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript();}else{alert('BookyWooky%20is%20already%20loaded!');}void(0);";
    gid("bookyBookmarkDefaults").innerHTML = (html + "\">BookyWooky</a>");    
}


function bookyCloseFunc() {
    //todo...
    //rmove any event listeners?
    //shoud hvae 1 big func for whoel thingm, then set that to undefeind and remove that
   
}

})();

