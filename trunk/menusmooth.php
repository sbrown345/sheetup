<?php 
    $title = "jQuery psudeo-class animation smooth";
	$id = "eg";
	$desc = "Make smooth menu animation easy.";
	$keywords = "smooth menu, menu tween, javascript tween";
    @include_once "inc/header.php"; 
?>
<script type="text/javascript" src="js/jquery-1.2.6.js"></script>     
<script type="text/javascript" src="js/jquery.color.js"></script>
<script type="text/javascript" src="js/sheetup.js"></script>

 <!--      
<p>This jQuery plugin searches for any rules with -ss-psuedo-fix- in the stylesheet, (will implement later)<br />
 stores the :hover variables and deletes it. Then for each object  </p>
-->


<p>A basic example using jQuery and sheetUp that smooths the animation between the normal and hover state. It copies the rules from the :hover rule associated with that class and adds it to a jQuery animation.</p>

<script type="text/javascript">
ss.fn.ignore = [ss.ds[0]];  //ignore main sheet

$.fn.simple = function (t) {                
    return this.each(function() {
        var org   = ss("."+this.className).eq(0).getRulesAsArray(true), 
            hover = ss("."+this.className+":hover").eq(0).getRulesAsArray(true), 
            $this = $(this);
        
        $this.css(org);
        
        $this.hover(function(){  $this.stop().animate(hover, t);
        },          function(){  $this.stop().animate(org,   t);});
          
    });      
};

$(function() {
    $(".inline, .tab, .text, .button").simple(300);
});

</script>



<style>
h2                  {clear:both;}
input               {font-weight:bold;}    
    
.wrap p             {font-size:0.8em;}    
.wrap a, a:hover    {color:inherit;}

.wrap a.inline      {color:#A99FFF;background-color:white;}
.wrap a.inline:hover{color:white;background-color:#A99FFF;}

.wrap .tab          { padding-left:20px;    padding-right:20px;      color:#aaa;}
.wrap .tab:hover    { padding-left:10px;    padding-right:10px;     color:#fff}
.wrap .tabs  a      {overflow:hidden;font-weight:bold;background-color:#333;display:inline;float:left;height:30px;line-height:30px; }

.wrap .text         {background-color:#fff;color:#000;}
.wrap .text:hover   {background-color:#000;color:#fff;}

.wrap .button       {color:#666;}
.wrap .button:hover {color:#000;}


.tabs {height:40px;}
</style>



<div class="wrap">


    <h2>Inline links</h2>
    <p>
        <a class="inline" href="#">Mauris ut sem.</a> Mauris eu leo ut turpis eleifend blandit. Suspendisse
        potenti. Nunc elit tellus, bibendum in, auctor in, ullamcorper id, velit. Proin
        cursus nisl ut felis. Etiam at eros. Cras hendrerit. Ut ultricies, dolor eget faucibus
        ornare, nulla risus feugiat lorem, <a class="inline"  href="#">sed porttitor turpis</a> arcu ac nunc. Fusce at magna
        nec felis hendrerit blandit. Vivamus bibendum nulla et tellus. Nam gravida, urna
        porta pretium eleifend, felis magna aliquet <a class="inline"  href="#">mauris, eget iaculis felis urna sed</a>
        arcu. Nam hendrerit. 
    </p>
        
    <h2>Tabs</h2>
    <div class="tabs">
        <a class="tab" href="#">Tab 1</a><a class="tab" href="#">Tab 2</a><a class="tab" href="#">Tab 3</a>  
    </div>      
    
    <h2>Form</h2>
    <p class="form">
        <input class="text" type="text" value="Text 1" /><br />
        <input class="text" type="text" value="Text 2" /><br />
        <input class="text" type="text" value="Text 3" /><input type="button" class="button" value="Button" />
    </p>
    

<!-- Todo: could use getComputedStyles to remove the need to dupelicate the property to be animated in the non-hover state!!!! -->





<h2>Code</h2>
<pre class="eg">

&lt;style&gt;
.wrap .button       {color:#666;}
.wrap .button:hover {color:#000;}
&lt;/style&gt;

&lt;script  src="<a href="js/jquery-1.2.6.js">js/jquery-1.2.6.js</a>"&gt;&lt;/script&gt;     
&lt;script  src="<a href="js/jquery.color.js">js/jquery.color.js</a>"&gt;&lt;/script&gt;
<span class="hi">&lt;script  src="<a href="js/sheetup.js">js/sheetup.js</a>"&gt;&lt;/script&gt;</span>

&lt;script&gt;
<span class="hi">ss.fn.debug = false;
ss.fn.ignore = [ss.ds[0]];  //ignore main sheet</span>

$.fn.simple = function (t) {                
    return this.each(function() {
<span class="hi">        var org   = ss('.'+this.className)         .eq(0).getRulesAsArray(true), 
            hover = ss('.'+this.className+":hover").eq(0).getRulesAsArray(true), </span>            $this = $(this);
        
        $this.css(org);
        
        $this.hover(function(){  $this.stop().animate(hover, t);
        },          function(){  $this.stop().animate(org,   t);});
          
    });      
};


$(function() {
    $(".button").simple(300);
});
&lt;/script&gt;
</pre>








</div>
<?php @include_once "inc/footer.php"; ?>
        
