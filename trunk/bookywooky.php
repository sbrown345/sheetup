<?php 
    $title = "BookyWooky - A bookmarklet/favelet manager";
	$id = "bookywooky";
	$desc = "BookyWooky is a bookmarklet/favelet Javascript library manager.";
	$keywords = "double click bookmarklet, double click favelet";
    @include_once "inc/header.php"; 
?>


 
  
  <p>
   <a href="http://www.learningjquery.com/2008/06/updated-jquery-bookmarklet">
      Karl
      Swedberg's jQueryify</a> gave me an idea. 
    I wanted to extend it to allow a user to easily load up any library or tools they wanted.
    For now it's limited to Firebug Lite, jQuery, Prototype,
    MooTools and sheetUp. I've quickly tested it on IE6/7, Opera 10, Firefox 3 (not yet compatible with Webkit.)
    If you double-click the bookmarklet it will only load the default options without showing the dialog.
    And, the dialog generates a custom bookmark. The question marks link to the respective documentation.
  </p>

  <p>
    <a href="javascript:bookyBaseUrl='http://<?php 
    
    if ($_SERVER['HTTP_HOST']=="localhost")        
      echo $_SERVER['HTTP_HOST']."/sheetup";
    else
      echo $_SERVER['HTTP_HOST'];
    
    ?>/bookywooky/';bookyDefaults='Firebug,jQuery';function loadScript(url,callback){url=typeof url==='undefined'?bookyBaseUrl+'bookywooky.js':url;var scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('head')[0].appendChild(scr);}if(typeof bookyStatus==='undefined'){var bookyStatus='waiting2ndclick';var bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript();},200);}else if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript();}else{alert('BookyWooky is already loaded!');}void(0);" title="BookyWooky Bookmarklet">BookyWooky</a>.
   &lt;-- Try clicking it now. Works best with Firefox if dragged onto the Bookmarks Toolbar.
  </p>

<br />
<br />
<br />
<br />
<br />
<br />

<h2>Modifying BookyWooky</h2>

<p>You can update the bookmarklet to use other bookmarklets.</p>





<fieldset>
  <p>
    <label for="custom">The following custom bookmarklet that removes the normal jQuery from the list and adds jQuery 1.3 Beta 1:</label><br />
<textarea id="custom" style="width:800px;height:200px;">
var bookyMerge = {
    jQuery13: {
                  name:   'jQuery 1.3 Beta 1', 
                  url:    'http://code.jquery.com/jquery-1.3b1.js', 
                  loaded: function() {return typeof jQuery !== 'undefined'}, 
                  docs:   'http://blog.jquery.com/2008/12/22/help-test-jquery-13-beta-1/'
              },
              
    jQuery:   null
};
</textarea>
</p>
<p>
<label for="defaultLoading">Default things to be checked on a single-click or loaded on a double-click:</label>
<input style="width:800px;display:block;" id="defaultLoading" value="bookyDefaults='Firebug,jQuery13';" /></p>

<pre id="pre2"></pre>
<p>
  Your generated bookmark: <a href="" id="customBookmarklet">BookyWooky</a>
</p>
</fieldset>

<script type="text/javascript">
  var ta = document.getElementById("custom"),
  input = document.getElementById("defaultLoading"),
  pre2 = document.getElementById("pre2"),
  defaultLoading = document.getElementById("defaultLoading"),
  customBookmarklet = document.getElementById("customBookmarklet");

  ta.onkeyup = function() {
  pre2.innerHTML = customBookmarklet.href =
  "javascript:" +
  defaultLoading.value +
  ta.value.replace(/\n/g, "") +
  "bookyBaseUrl='http://<?php   if ($_SERVER['HTTP_HOST']=="localhost")   echo $_SERVER['HTTP_HOST']."/sheetup";  else  echo $_SERVER['HTTP_HOST']; ?>/bookywooky/';" +
  "function%20loadScript(url,callback){url=typeof%20url==='undefined'?bookyBaseUrl+'bookywooky.js':url;var%20scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('head')[0].appendChild(scr);}if(typeof%20bookyStatus==='undefined'){var%20bookyStatus='waiting2ndclick';var%20bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript();},200);}else%20if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript();}else{alert('BookyWooky%20is%20already%20loaded!');}void(0);";
  
  };
  
  ta.onkeyup();
  
  
</script>


<br />
<br />


<h3>Custom loading function</h3>
<p>If the bookmarklet requres a special function to load. E.g. it might need to run an init function like Firebug does then a forth paramenter can be added to bookyMerge. E.g. <code>{name: "", loaded: Function, docs: "", func: function() {}}</code>
. This code will need to append the script to the page.</p>

<p>The defaults array that the custom settings gets merged into are the following, notice the Firebug init func:</p>

<pre>

var defaults = {
    Firebug:    {name: "Firebug 1.2",           
    url:        "",
    loaded:     function() {return document.getElementById("_firebugConsole") !== null || typeof firebug !== "undefined"},
    docs:       "http://getfirebug.com/docs.html",
    func:       function() {
                    document.location.href = "javascript:"+
                    "var firebug=document.createElement('script');"+
                    "firebug.setAttribute('src','http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js');"+
                    "document.body.appendChild(firebug);"+
                    "(function(){if(window.firebug.version){firebug.init();document.getElementById('bookyDiv').innerHTML "+
                    "+= '&lt;div class=\"bookyLoaded\"&gt;Loaded Firebug&lt;/div&gt;';}else{setTimeout(arguments.callee);}})();"+
                    "void(firebug);";}},

    jQuery:     {name:  "jQuery 1.2.6",          
                url:    "http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js",
                loaded: function() {return typeof jQuery !== "undefined"},
                docs:   "http://docs.jquery.com/"},

    Prototype:  {name:  "Prototype 1.6.0.3",     
                url:    "http://prototypejs.org/assets/2008/9/29/prototype-1.6.0.3.js",
                loaded: function() {return typeof Prototype !== "undefined"},
                docs:   "http://prototypejs.org/api"},

    MooTools:   {name:  "MooTools 1.2.1 ",       
                url:    "http://mootools.net/download/get/mootools-1.2.1-core-yc.js",
                loaded: function() {return typeof MooTools !== "undefined"},
                docs:   "http://mootools.net/docs/"},

    sheetUp:   {name:   "sheetUp 0.1.1",         
                url:    "http://sheetup.com/js/sheetup.packed.js",
                loaded: function() {return typeof sheetUp !== "undefined"},
                docs:   "http://code.google.com/p/sheetup/w/list"}
};



</pre>




<?php @include_once "inc/footer.php"; ?>