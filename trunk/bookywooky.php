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
    <a href="javascript:bookyBaseUrl='http://<?php echo $_SERVER['HTTP_HOST']?>/sheetup/bookywooky/';bookyDefaults='Firebug,jQuery';function loadScript(url,callback){url=typeof url==='undefined'?bookyBaseUrl+'bookywooky.js':url;var scr=document.createElement('script');scr.setAttribute('src',url);document.getElementsByTagName('head')[0].appendChild(scr);}if(typeof bookyStatus==='undefined'){var bookyStatus='waiting2ndclick';var bookyFunc1=window.setTimeout(function(){bookyStatus='loading1';loadScript();},200);}else if(bookyStatus==='waiting2ndclick'){window.clearTimeout(bookyFunc1);bookyStatus='loading2';loadScript();}else{alert('BookyWooky is already loaded!');}void(0);" title="BookyWooky Bookmarklet">BookyWooky</a>.
   &lt;-- Try clicking it now. Works best with Firefox if dragged onto the Bookmarks Toolbar.
  </p>

<?php @include_once "inc/footer.php"; ?>