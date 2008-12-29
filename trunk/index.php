<?php 
    $title = "document.styleSheets Helper Library";
	$id = "home";
	$desc = "sheetUp is a Javascript library that makes manipulating DOM stylesheets easy.";
	$keywords = "easy dom stylesheets, javascript stylesheets made easy, javascript stylesheet library, double click bookmarklet, double click favelet";
    @include_once "inc/header.php"; 
?>
<script src="js/sheetup.js" type="text/javascript"></script>
<div>

<div class="leftbox">
	<div id="features">
		<h2>What?</h2>
		<p>Simplify the tedious task of manipulating stylesheet objects contained in document.styleSheets.</p>
		<h2>Features</h2>
		
		<ul>
			<!--<li>Select rules from style sheets and then operate on them</li>-->
			<li>View and edit CSS rules and their properties</li>
			<li>Add and remove stylesheets</li>
			<li>Easily iterate through sheets, rules and properties </li>
			<li>@import rule support</li>
			<li>Tested with IE 5.5+, Firefox 3, Opera 9.6, Safari 2.1, Chrome</li>
		</ul>
		
		
		<h2>What's next?</h2>
	<p>Thinking about fixing the variation in browsers with a middle layer that simulates the stylesheets as text. The problem at the moment is that the 
	browser reformats the rule cssText. For instance, "h1, h2 {}" can become two rules in some browsers and "green" may 
	become "#008000". It will come with a performance penalty but it will make output consistent, it should be able to be turned off too. 
	Apart from that, I've got a few bugs to fix but will concentrate on making some other javascript apps, which will probably use sheetUp.
	
	
	
	</p>
	<p>New site with a new test suite and a proper tutorial and examples.</p>
	</div>
</div>



<div class="rightbox">
  <div id="download">
    <h2>Download</h2>
    <ul>
      <li>
        <a href="js/sheetup.js">
          Uncompressed - <span>45kb</span>
        </a>
      </li>
      <li>
        <a href="js/sheetup.packed.js">
          YUI Minified - <span>15 KB</span>
        </a>

      </li>
      <li>
        <a href="http://sheetup.googlecode.com/svn/trunk/js/">
          SVN Trunk
        </a>

      </li>
    </ul>
  </div>

</div>
<div class="rightbox">
  <div class="whats">
    <h2>What's on this site</h2>
	<p>So much needs doing, like a redesign, but here's the main stuff for now:</p>
	<dl>
		<dd><a href="tutorial.php">Tutorial</a></dd>
		<dt>Have a quick spin with the library.</dt>
		<dd><a href="test.php">Test Cases</a></dd>
		<dt>Run some basic test cases.</dt>
		<dd><a href="benchmark.php">Benchmark</a></dd>
		<dt>See how it performs at the moment.</dt>
		<dd><a href="examples.php">Examples</a></dd>
		<dt>Check out basic usage of the library.</dt>
		<!--<dd><a href="cheatsheet.php">Cheatsheet</a></dd>
		<dt>An interactive resource on using sheetUp </dt>-->
	</dl>
	
	
	
<div class="clear"></div>  
</div>

</div>

<div class="rightbox">
  <div class="whats">
	<h2>Bookmarklet</h2>
	<p>Use in combination with Firebug, right-click the link below and Bookmark</p>
    <p><a href="javascript:var%20scr=document.createElement('script');scr.setAttribute('src','http://www.sheetup.com/js/sheetup.js');document.body.appendChild(scr);void(0);" title="Add sheetUp Bookmarklet">sheetUp Bookmarklet</a></p>
<!--
    <p>
      For a bookmarklet manager, to load sheetUp along with other libraries, try <a href="#bookywooky">BookyWooky</a>.
    </p>-->
  
	
	
<div class="clear"></div>  
</div>

</div>

  <div id="lets">
    <h2>Let's try it out &ndash; click the code</h2>
    <div class="idea ideatop">
		<h3>Let's add two styles for .button</h3>
		<pre><code>ss(".button{color:yellow;background:black;padding:0 5px;font-weight:bold} .button:hover{color:black;background:yellow}");</code></pre>
		<a href="#" class="button">.button</a>
    <div>
	
    <div class="idea">
		<h3>We can also chain the sheetUp object</h3>		
		<pre><code>ss('code')
    .remove()
    .add('code{}')
        .property({padding:   '10px',
                   display:   'block',
                   color:     '#ccc',
                   background:'#000'})				
        .add('code:hover{color:#fff;}');</code></pre>
	<p>This code selects the buttons style rule and removes it. It then adds a rule and sets its properties.</p>
		


    </div>




    </div>
    </div>


</div>

</div>


<p>sheetUp is a javascript stylesheet library to simplyify the manipulation of DOM style sheet objects.</p>
<div id="news">
  <h2>News</h2>
 
  <h3 id="bookywooky"><a href="bookywooky.php">BookyWooky - A bookmarklet/favelet manager</a></h3>
  
  <p>
    <a href="javascript:bookyBaseUrl='http://<?php 
    
    if ($_SERVER['HTTP_HOST']=="localhost")        
      echo $_SERVER['HTTP_HOST']."/sheetup";
    else
      echo $_SERVER['HTTP_HOST'];
    
    ?>/bookywooky/';bookyDefaults='Firebug,jQuery';function loadScript(url,callback){url=typeof url==='undefined'?bookyBaseUrl+'bookywooky.js':url;var scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('head')[0].appendChild(scr);}if(typeof bookyStatus==='undefined'){var bookyStatus='waiting2ndclick';var bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript();},200);}else if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript();}else{alert('BookyWooky is already loaded!');}void(0);" title="BookyWooky Bookmarklet">BookyWooky</a>.
    &lt;- Try clicking it now. Works best with Firefox if dragged onto the Bookmarks Toolbar.
  </p>

  <p>
   <a href="http://www.learningjquery.com/2008/06/updated-jquery-bookmarklet">
      Karl
      Swedberg's jQueryify</a> gave me an idea. 
    I wanted to extend it to allow a user to easily load up any library or tools they wanted.
    For now it's limited to Firebug Lite, jQuery, Prototype,
    MooTools and sheetUp. I've quickly tested it on IE6/7, Opera 10, Firefox 3.
    If you double-click the bookmarklet it will only load the default options without showing the dialog.
    And, the dialog generates a custom bookmark. The question marks link to the respective documentation.
  </p>

  <p><a href="bookywooky.php">Customise BookyWooky</a></p>





  <h3>tEd - template Editor</h3>
  <p>
    <strong>
      With sheetUp to help I've been making an in-browser CSS/HTML editor. Try it out right now by clicking
      <a title="Click here to test it out" style="text-decoration:underline;" rel="nowfollow" href="javascript:var%20scr=document.createElement('script');scr.setAttribute('src','http://templateed.com/ted2.js');document.body.appendChild(scr);void(0);">this bookmarklet</a>
    </strong>.
    It is <em>kinda buggy</em> at the mo and only really works in Firefox 3 and 3.1.
  </p>

  <p>
    <a href="http://uk.youtube.com/watch?v=uxF7zFMCzIY" title="templateEd html/css editor video preview">YouTube Video here</a>
  </p>

  <p>
    <a href="http://templateed.com/">tEd or templateEd</a> is designed for editing basic web pages, in-browser. It features basic code highlighting, css formatting and you can even save to disk.
  </p>



</div>

<?php @include_once "inc/footer.php"; ?>




<script src="js/sheetup.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[
  window.onload = function() {

    //click code to evaluate
    var codeClips = document.getElementsByTagName("code");
    for(var i=0;i<codeClips.length;i++) {
        codeClips[i].onclick = function() { eval(this.innerHTML); };
    }
    
    

};
//]]>
</script>

        
