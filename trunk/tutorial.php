<?php 
    $title = "Tutorial";
	$id = "tut";
    @include_once "inc/header.php"; 
?>

<script src="js/sheetup.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[

var timer;
var current = 1;
//test whether the function has been done

function test(test) {   /*timer = setInterval(test, 2000);*/        }
function stopTest() {   alert(msgs[current]); clearTimeout(timer);   }


    function slidePrev(){ if(current>1 ) slide(current-1);  }    
    function slideNext(){ if(current<max ) slide(current+1);  }    
    function slide(n) {  
        if(n<0 || n>max) return false;
        wrap.style.marginTop =  cont.clientHeight - (n * cont.clientHeight) + "px"; //could use ss().animate
        //ss("#slidewrapper").animate("margin-top", ((n - current) * cont.clientHeight)+"px", 100);
        curr.innerHTML = n;
        window.location.hash = "#"+n; //broken???
        current = n;
        clearTimeout(timer);
        test(tests[n]);
    }
    


var cont,wrap,next,prev,curr,code,exec,max = 0;


window.onload = function() {   
    


    cont = gid("tutorialcontainer");
    wrap = gid("slidewrapper");
    next = gid("next");
    prev = gid("prev");
    curr = gid("current");
    code = gid("code");
    exec = gid("exec");
    
    //get the number of slides
    var divs = document.getElementsByTagName("div");
    for(var i=0;i<divs.length;i++)
        if(divs[i].parentNode.id == "slidewrapper")
            max++;
 
              
 
    next.onclick = function(){slideNext(); return false;};
    prev.onclick = function(){slidePrev(); return false;};
    exec.onclick = function(){eval(code.value); return false;};
    
    
    //click code to evaluate
    var codeClips = document.getElementsByTagName("code");
    for(var i=0;i<codeClips.length;i++) {
        codeClips[i].onclick = function() { eval(this.innerHTML); };
    }
    
    
    //goto page 
    var hash = parseInt(window.location.hash.substr(1));
    if(hash > 0 && hash <= max) {
        slide(hash);
        current = hash;
    }
    
    
    //make index
    var titles = document.getElementsByTagName("h2");
    var html = "<ol start='2'>";
    for(var i=1;i<titles.length;i++) {
        html += "<li><a href='javascript:slide("+(i+1)+")'>"+titles[i].innerHTML+ "<\/a><\/li>";
        //titles[i].onclick = function() { slide(i); };
    }
    gid("index").innerHTML = html +"<\/ol>";
    
};


var tests = [null];
var msgs = [null];
tests.push(function(a){ if(ss(".yellow").property("background").indexOf("yellow") != -1) stopTest();  });//slide 1
msgs.push("Mr Yellow is very happy now! Please click next to test out the copy rule function.");
tests.push(function(a){ if(ss(".mrsgreen").property("background").indexOf("green") != -1) stopTest();  });
msgs.push("Whay, Mr and Mrs Green are super happy now!");

//broke in opera, safari





//]]>


</script>









        <div id="tutorial">
        <div id="tutorialcontainer">
            <div id="slidewrapper">
                        
            
            
                <div class="slide">
                    <h2>Index</h2>
                    <div id="index"></div>
                </div>
                    
            
                <div class="slide">
                    <h2>Adding a new rule</h2>
                    <div class="task">
                        <p>Mr Yellow Box is unhappy because he's lost his lovely little yellow coat!</p>
                        <p>No worries though, we can get him a new one by giving him a new class. Just type the following to help our friend.</p>
                        <p><code>ss(".yellow{background:yellow;}");</code></p>
                        <p>Or you can just click on the code sample.</p>
                    
                    </div>
                    <div class="box red left">.red</div>
                    <div class="box green left">.green</div>
                    <div class="box blue left">.blue</div>
                    <div class="box yellow left" id="Div1">.yellow :*(</div>
                    
                    <p class="clear">This code dynamicaly adds the new .yellow CSS rule to the first stylesheet.</p>
                    <p>This is the same as doing <code>ss().add(".yellow{background:yellow;}");</code></p>
                    
                    <p>We can remove it with <code>ss(".yellow").remove();</code></p>
                    
                </div>
                    
                    
                    
                    
                    
                    
                <div class="slide">
                    <h2>Copying a rule</h2>
                    <div class="task">
                        <p>Mr Green Box loves his new green sweater and wants Mrs Green Box to have one too,
                         unforutnately Mr Green Box has lost his job. Help them out by copying the green class across!</p>
                        
                        <p><code>ss(".green").copy(".mrsgreen");</code></p>
                        
                        This function copies all the styles from .green into a new rule .mrsgreen.
                    
                    </div>   
                    
                    
                    <div class="box green left">.green</div>
                    <div class="box mrsgreen left">.mrsgreen</div>
   
                </div>
                
                
                
                
                
                
                
                <div class="slide"><h2>Editing a rule</h2>
                    <div class="task">
                        <p>Mrs Green is very fussy and now she wants a different coloured name.</p>
                        
                        <p><code>ss(".mrsgreen").property("color", "pink");</code></p>
                        
                        <p>You can set multiple properties like so:</p>
                        
                        <p><code>ss(".mrsgreen").property({"font-weight":"bold", "border":"1px solid pink"});</code></p>
                    
                    
                    </div>        
                
                
                    <div class="box green left">.green</div>
                    <div class="box mrsgreen left">.mrsgreen</div>

                </div>
                
                
                
                
                
                
                <div class="slide"><h2>Selecting</h2>     
                    <div class="task">           
                        <p>There are two main ways of selecting, the first we will cover here is a simple text search. But this has its limitations.</p>            
                        <p>For example, if we do <code>alert(ss("green").selectorList());</code>, this will select any selector that has "green" in its selector text.
                        
                         So it will find .green, .mrsgreen, #green and so on.</p>
                         
                         <p>Or you can use <a href="http://getfirebug.com/" rel="external" onclick="this.target='_blank';">Firebug's</a> console.log() to analyse the object. <code>console.log(ss("green"));</code></p>
                    
                         
                         
                         
                    </div>        
                    
                
                    <div class="box green left">.green</div>
                    <div class="box mrsgreen left">.mrsgreen</div>
    
                </div>
                
                
                
                
                
                
                
                <div class="slide"><h2>Selecting slice()</h2>
                    <p>We can narrow a selection down to a particular index or indicies. With this function.</p>                  
                    
                    <code>console.log(ss("green").slice(0));</code><br />
                    <code>console.log(ss().slice(2,6));</code><br />
                    <code>alert(ss("green").slice(0).selectorList());</code>
					  
                    
                    
                    <p>This also introduces chaining. For instance we could select all rules with ":hover" in their selector text, then in that result finds anything with "input".</p>
                   <p>Find() is explicitly used here, whereas before it has been called automatically once the initiliser reconised its argument as a possible selector.</p>
                   
                   <code>console.log(ss(":hover").find("input"));</code><br />
                    <code>alert(ss(":hover").find("input").selectorList());</code>         
                </div>
                
                
                
                
                
                
                <div class="slide"><h2>Selecting regexp</h2>
                    <p>We can narrow a selection down to a particular index. With this function.</p>                  
                    
                    <code>console.log(ss(/green/));</code><br />
                    <code>alert(ss(/green/).selectorList());</code>
                    
                </div>
                
                
                
                
                
                
                <div class="slide"><h2>Selecting -- multiselect</h2>
                    <p>Rather than chaining a few finds() it may be easier to use the  "--" selecting shortcut.</p>                
                    <p>Here we want to select ".class #id .classtofind"</p>
                    <code>console.log(ss("--.class #id"));</code><br />
                    <code>alert(ss("--.class #id .classtofind").selectorList());</code>     
                                       
                </div>
                
                
                <div class="slide"><h2>Selecting -- push</h2>
                    <p>Add items to the selection with push()</p>
					
                    <code>
					ss(".coat").push(".card").log();					
					</code>   
                                       
                </div>
                
                
                
                
                <div class="slide"><h2>Selecting end</h2>
              
                    <p>The end() function allows for the creation of longer chains.
                     Say, Mr Yellow block might have got a bit peckish on the way to get a birthday card 
                     for his grandma. He's got a bit bigger after eating those cakes and needs a bigger coat. He also dislikes colour of the card and wants to recolour it.</p>
                     
                    
                     
                     
                     <pre><code>
ss(".mryellow")                     //find rules with ".mryellow" in
    .find("coat")                   //find in that selection rules with "coat" in them
        .property("width", "120px") //fix the width of mr yellows coat
        .end()                      //return to the previous ".mryellow" selection
    .find("card")                   //find rules with "card" in them
        .property("background", "pink")  //change the card colour to pink
</code></pre>

                    
                    <div class=" left mryellow">
                        .mryellow
                        <div class="card">.card</div>
                        <div class="coat">.coat</div>
                    </div>
                    
                    
                </div>
                
                
                
                
                
                <div class="slide"><h2>Adding new stylesheets</h2>
                    <p>
                        We can use three variables to creates a stylesheet:</p>
                    <ol>
                        <li>Css Text</li>
                        <li>Url</li>
                        <li>??? im sure there was a 3rd</li>
                    </ol>
                    
                    <code>ss("css/tutnewss.css");</code><br />
                    <code>ss().newSS("css/tutnewss.css");</code><br />
                    <code>ss().newSS("#newss{display:block;color:red;}", "Style Sheet Title");</code><br />
                    
                    
                    
                    <div id="newssfile">Whay, you've added tutnewss.css</div>
                    <div id="newss">Yay, you've added some new styles as a stylesheet.</div>
                    
                    <p>The second argument is the stylesheet's title, this may help keep track of multiple stylesheets..</p>
                    
                    
                </div>
                
                
                                
                
                <div class="slide"><h2>Each</h2>
                    <p>We can iterate through the selection with the each() function.</p>
                    
                    <code>ss().each(function() {console.log(this);});</code>
                    
                    
                    <p>Whereas in the previous line <em>this</em> refers to the current rule we can specify two more variables: the index and one for the rule.</p>
                    
                    <pre><code>ss().each(function(i, rule) {
    console.log("Rule " + i + ": " + rule.selectorText);
});</code></pre>
                    
                    
                    
                    
                    
                    
                    <p>There is also a shortcut to iterating through the style sheet objects</p>
                    <pre><code>ss(".ruleobject").eachSheet(function(i, sheet) {
    console.log(sheet);
});</code></pre>
                    
                    
                    
                   
                    
                </div>
                
                
                
                <div class="slide"><h2>Extending</h2>
<p>We can extend the sheetUp object by using prototype or the jQuery like shortcut fn. Inside the loop the ss() object can be refered to using _self.</p>
  
  <p>This function changes any color style in the selection that is blue to red.</p>                  
<pre><code>ss.fn.make10px30px = function (){
    return this.each(function() {            
        if(ss(this).property("height") == "10px") {
            ss(this).property("height", "30px");
        }
    });
                    
};

ss(".extend").make10px30px();</code></pre>
                    <p>This function operates on each of the selected rules and returns itself making it fully chainable.</p>
                    <div class="extend1 box left purple"></div>
                    <div class="extend2 box left green"></div>
                    <div class="extend3 box left blue"></div>
                    <div class="extend4 box left red"></div>
                    <div class="clear"></div>
                    
 
                    
                    
                </div>
                
                
                
                <div class="slide">
                    <h2>Copy(), rename()</h2>
                    <p>---Copy is a dupe</p>
                    
                    
                    <p>There are some built in short cuts to make copying and renaming styles easier.</p>
                    <p>Both these functions copy the first rule in the slection to a new location. The rename one deletes the previous rule.</p>
                    
                    
                    
                    <p><code>ss().copy(".greenAndRed");</code></p>
                    <p><code>ss().rename(".greenAndRed");</code></p>
                    
                    <h3>Notes</h3>
                    <p>Perhaps it might be quite useful to be able to copy all the styles from the selected rules into a new rule.</p>
                    <p>Not all browsers seem to support changing the selectorText property, so the rename copies and deletes rather than simly renaming the rule.</p>
                </div>
                
                
                
                
                <div class="slide"><h2>Text()</h2>
                    <p><strong>Bug: it adds a whole new rule instead of editing the blank one.</strong></p>
                
                    <p>We can view and set the css text as it were propeties.</p>
                
                    <p>Lets quickly change the properties in any rules with span in their selector text. This will replace all style that it had previously held.</p>
                    
                    
                    <p><code>ss(".text").text("color: yellow;   background: black;");</code></p>
                    
                    
                    <p>We can also return the css text as a string if we don't pass an argument to text();</p>
                    <p><code>alert(ss(".text").text());</code></p>
                    
                    
                    
                    <p>Get text for a whole style sheet</p>
                    <code>alert(ss(document.styleSheets[0]).text(true));</code>
                    
                    <p>Get text for all style sheets</p>
                    <code>alert(ss().text(true));</code>
                    
                    
                    <div class="box text left">.text</div>
                </div>
                
                
                <div class="slide"><h2>Utils 1: getComputedStyle &amp; getRulesAsArray</h2>
                    <p>Lets examine the rules applied to an object. We can do 
                    this by using the shortcut to getComputedStyles.</p>
                    
                      <p><code>console.log(ss(document.getElementById("comp")));</code></p>
                      <p><code>console.log(ss().getComputedStyle(document.getElementById("comp")));</code></p>
                      <p><code>alert(ss().getComputedStyle(document.getElementById("comp")).color);</code></p>
                 
                
                    
                <p>It may be useful to get some styles as an array. For instance for using jQueries animation function.</p>

                    <p><code>console.log(ss("box").getRulesAsArray());</code></p>
                    
                    
                    <div class="box blue left" id="comp">#comp</div>
                    
                    
                    
                    
                </div>
                
                
                
                
            
                
                
                
                                
                <div class="slide"><h2>Stylesheet object functions</h2>
                
                 http://code.google.com/p/sheetup/wiki/StylesheetSwitching
                    
                    
                </div>
                
                
            
            
            
            
                
                
                

                
                    
                
                                
                <div class="slide"><h2>How it works</h2>
                
                    <p>When the ss() is called an object is created storing:</p>
                    
                    <ul>                    
                        <li>References to stylesheets</li>
                        <li>References to rules</li>
                        <li>Selector text</li>
                        <li>Previous object for chaining</li>
                    </ul>
                    <p>
                        You can check this out by using Firebug's console.log(). Clicking <code>console.log(ss());</code>
                        that will initialise an object with the default options. There is no selector passed
                        to it so it will select all the rules avaliable from all the sheets, including disabled
                        sheets. It stores a reference to each of these rules like an array. This means you
                        can access the first rule by ss()[0] and the second like ss[0] and so on.</p>
                    <p>
                        A length variable is also available to ditermine how many rules are selected. Do
                        <code>alert(ss().length);</code> to find out how many rules are on the current page.
                    </p>

                    
                </div>
                                 
                                  
                                  
                                  
             
                    
                
                                
                <div class="slide"><h2>How it works - Storing rule as a variable</h2>
                
                    <p>We can store these rules as variables
                    </p>
                    <pre><code>var rule = ss(".variable")[0];
alert(rule.selectorText); 
ss(rule).property("color", "pink"); </code></pre>
                    <div class="variable">
                        .variable</div>

                    
                    
                </div>                             
                                  
                                  
                                  
                                  
                                  
                                  
                                  
                                  
                                                
                <div class="slide"><h2>How it works 2 - Storing ss() as a variable</h2>
                    <p>
                        We can cache the reference to selected rules so they do not need to be selected
                        again. The following code stores two ss() objects which can be modified after.</p>
                    <pre><code>
                    
var divRules = ss(/\bdiv\b/);
var headingRules = ss("h1 | h2");

headingRules.property("color", "gray");
divRules.property("border", "solid 1px gray");
                    
                    </code></pre>
                    
                    
                                        
                </div>
                
                                
           
                                  
                                                
                <div class="slide"><h2>The End</h2>
      
                   
                    
                    
                                        
                </div>
                
                                

                
                    
                
                                

                
                
                
                
                
                
                
                
                
                
                    
            </div>
        </div>

        <div id="nav"><a href="#" id="prev">Prev</a> <span id="current">1</span> <a href="#" id="next">Next</a></div>



        <textarea id="code" cols="70" rows="4"></textarea>
        <input id="exec" type="button" value="Execute" />
</div>

<?php @include_once "inc/footer.php"; ?>