<?php 
    $title = "jQuery pseudo-class animation smoothing for block elements";
    @include_once "inc/header.php"; 
?>
<script type="text/javascript" src="js/jquery-1.2.6.js"></script>     
<script src="js/effects.core.js" type="text/javascript"></script>  
<script type="text/javascript" src="js/sheetup.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>

        
<p>This only operates on block elements because it duplicates the inner html of the element into an inner span inside. 
This span fades into view on mouseover. sheetUp simplifies renaming the :hover class.</p>





<script type="text/javascript">

    $.fn.block = function (t) {    
        return this.each(function() {      
            var $this = $(this),                  
                $span = $('<span class="hover">'+$(this).html()+'</span>');
            
            //expand the span inside the element   
            $this.append($span);
            $this.css({position:'relative'});
            $span.css({position:'absolute',width:'100%',height:'100%',left:0,top:0,cursor:'pointer'});
  
            //rename the hover class for the new span and hide it
            ss(this.className+':hover').rename('.'+this.className+' span.hover'); //sheetUp useful here
            $span.css({opacity: 0});
			
			//animate
            $this.hover(function() {   
                $span.stop().animate({opacity: 1}, t);
            }, function() { 
                $span.stop().animate({opacity: 0}, t);  
            });
        });      
    };

    $(function() {
        $('.fadein').block(250);    
    });

</script>



<style type="text/css">
	
    .wrap ul li{display:block;float:left;text-align:center;font-weight:bold;}
    .wrap .fadein {display:inline;float:left;width:100px;height:20px;line-height:20px;color:#02243C;background:#5195CE;text-decoration:none;}    
    .wrap .fadein:hover{background:#E6E6E6; color:Black;}  
	
	ul {height:40px;}
</style>



<div class="wrap">

    <h2>Block fade in</h2>    
	<ul>
		<li><a class="fadein" href="#">Home</a></li>
		<li><a class="fadein" href="#">Blog</a></li>
		<li><a class="fadein" href="#">Contact</a></li><!---->
	</ul>
	

<h2 class="clear">The Code</h2>
<pre class="eg">
&lt;style&gt;
.wrap ul li{display:block;float:left;text-align:center;font-weight:bold;}
.wrap .fadein {display:inline;float:left;width:100px;height:20px;line-height:20px;color:#02243C;background:#5195CE;text-decoration:none;}    
.wrap .fadein:hover{background:#E6E6E6; color:Black;}  
&lt;/style&gt;

&lt;script type="text/javascript" src="<a href="js/jquery-1.2.6.js">js/jquery-1.2.6.js</a>"&gt;&lt;/script&gt;     
&lt;script type="text/javascript" src="<a href="js/jquery.color.js">js/jquery.color.js</a>"&gt;&lt;/script&gt;
<span class="hi">&lt;script type="text/javascript" src="<a href="js/sheetup.js">js/sheetup.js</a>"&gt;&lt;/script&gt;</span>

&lt;script&gt;
$.fn.block = function (t) {    
    return this.each(function() {      
        var $this = $(this),                  
            $span = $('<span class="hover">'+$(this).html()+'</span>');
        
        //expand the span inside the element   
        $this.append($span);
        $this.css({position:'relative'});
        $span.css({position:'absolute',width:'100%',height:'100%',left:0,top:0,cursor:'pointer'});

        //rename the hover class for the new span and hide it
<span class="hi">        ss(this.className+':hover').rename('.'+this.className+' span.hover'); //sheetUp useful here</span>        $span.css({opacity: 0});

        //animate
        $this.hover(function() {   
            $span.stop().animate({opacity: 1}, t);
        }, function() { 
            $span.stop().animate({opacity: 0}, t);  
        });
    });      
};


$(function() {
    $('.fadein').block(250);    
});
&lt;/script&gt;


</pre>



</div>
<?php @include_once "inc/footer.php"; ?>
        
