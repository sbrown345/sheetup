<?php 
    $title = "Benchmark";
	$id = "bench";
	$desc = "Test the performance of the current sheetUp stylesheet library.";
	$keywords = "library test, library benchmark, stylesheet performance, dom stylesheet performance";
    @include_once "inc/header.php"; 
	
?>



<style type="text/css">
/*Table*/
td {padding:0 7px;}
th  {padding:0 7px; } /* ie adds td, th as two rules */
tr{border-bottom:1px solid #ddd;}
tr:hover{background:#eeeeee;}
table{border-collapse:collapse;}
thead {background:#ccc;font-weight:bold;}
th {text-align:left;font-weight:normal;}
table{}
.c {text-align:left;font-weight:normal;font-family:monospace;font-size:11px;overflow:hidden;}
.t {text-align:right;}
td[colspan]{background:#eee;}
#total{border-top:2px solid #000;background:#ccc;text-align:right;}
.agent, .date, .version {font-size:0.9em;line-height:1.4em;}
</style>










<script src="js/sheetup.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[


function addRow(c1, c2, c3, finalRow) {
    var table = gid("result");
    var tbody = table.getElementsByTagName("tbody")[0],
        row = document.createElement("tr"),
        td1 = document.createElement("td"),
        td2 = document.createElement("td"),
        td3 = document.createElement("td");          
        if(finalRow)
            row.id = "total";         
        td1.innerHTML = c1;
        td2.innerHTML = c2;
        if(!finalRow)
            td2.className = "c";
        td3.innerHTML = c3;
        td3.className = "t";
        row.appendChild(td1);
        row.appendChild(td2);
        row.appendChild(td3);
        tbody.appendChild(row);         
}


   




var numRules = 100;

var stringOfa1000Rules = "";
for(i=0; i<numRules; i++) 
    stringOfa1000Rules+=".newrule{color:red;font-weight:bold;}";


var toCopy,   start,    stop,    counter = 0,    i,    tests = [],    codeCells,    timeCells,
    time,    html = "",    totalTime = 0,    strCode,    cache,    graph,	max=0,
    
    tests = [     
        {   
            action: "Create a "+numRules+" rules ",
            code: function() { 
                for(var i=0; i<numRules; i++) 
                    ss('.newrule{}');
            }
        }, 
        { 
            action: "Remove a "+numRules+" rules ",
            code: function() { 
                ss('newrule').remove();
                    
            }
        }, 
    
        { 
            action: "Add a "+numRules+" rules as a string",
            code: function() { 
                ss(stringOfa1000Rules);
                    
            }
        }, /*
        { 
            action: "Add a "+numRules+" rules as a stylesheet", //wow lots slower
            code: function() { 
                ss.fn.newSS(stringOfa1000Rules);
                    
            }
        },      */ 
        
        { 
            action: "Copy a rule "+numRules+" times",
            code: function() { 
				var toCopy = ss().eq(0);
                for(var i=0; i<numRules; i++) 
                    toCopy.copy(".copied"+i);  //the eq here will screw timing up -- use preAction
            }
        }, 
        { 
            action: "Init over a "+numRules+" rules",
            code: function() { 
                ss();
            }
        }, 
        { 
            preAction: function() { cache = ss(".copied"); },       /*cache as ss() object here with the rules inited !!!!!*/
            action: "Rename over a "+numRules+" rules", //is initing first, need a cache somewhere? perhaps a pre-action
            code: function() { 
                cache.each(function(i) {ss(this).rename('.renamed'+i);})
            }
        }, 
        { 
            action: "Select the 99th rule rule", 
            code: function() { 
                ss('.rename99');
            }
        }, 
        { 
            action: "Select the 90-99th rule (oh and 9)", 
            code: function() { 
                ss('.rename9'); 
            }
        }, 
        { 
			preAction: function() { cache = ss(".copied"); }, 
            action: "Add color:red to a "+numRules+" rules", //is initing first, need a cache somewhere? perhaps a pre-action
            code: function() { 
                cache.each(function(i) {ss(this).property("color","red");})
            }
        }, 
        { 
            action: "Add 5 styles to "+numRules+" rules", //is initing first, need a cache somewhere? perhaps a pre-action
            code: function() { 
                cache.each(function(i) {
                    ss(this).property({'color':'blue','margin':'10px','border':'4px','line-height':'1em','background':'black'}
                   
                );})
            }
        } 
		
		
		//remove all style properties bench...
		
		
		//each, eachStyle itterations bench...
		
		
    
    ];

window.onload = function() {  


    ss.fn.debug = false;
    codeCells   = getElementsByClassName("c"),
    timeCells   = getElementsByClassName("t");
    
    gid("date").innerHTML = new Date();    
    gid("agent").innerHTML = navigator.userAgent; 
    gid("version").innerHTML = ss.fn.version;
	
    toCopy = ss(".forcopy{color:red; font-size:10px; width:35px; height:20px; line-height:1em; margin:5px; padding:5px; border:solid 1px #000; float:left; display:inline;letter-spacing:0px;font-weight:100;}");

    //run code functions (perhaps this way will help evaluate both sides on test.htm?)

  
    for(i=0; i<tests.length; i++) {
        var test = tests[i];
        if(typeof test.preAction === "function")
            test.preAction()
            
        start = new Date();
        tests[i].code();
        stop =  new Date();
    
        time =  stop - start;
        totalTime += time;
        test.time = time;
        
        strCode = test.code.toString();
        strCode = strCode.substring(14, strCode.length-2);
        addRow(test.action, strCode, time);
		
		if(max<time)
			max = time;
    } 

    addRow("", "<strong>Total (ms)</strong>", totalTime, true);
	
	
		
   
        
		
    
	
    graph =    "http://chart.apis.google.com/chart?";
    graph +=   "cht=bhs&chd=t:";
    for(i=0; i<tests.length; i++)    
        graph += tests[i].time + ((i<tests.length-1)? "," : ""); //, extra ,
    graph +=   "&chs=400x340";  
    graph +=   "&chxl=0:|0|"+max+"|";
    graph +=   "1:";  
    for(i=0; i<tests.length; i++)     
        graph +=    "|"+tests[i].action;   //.match(/\w+/)[0];//1st word
    graph +=   "&chxt=x,y";  
    graph +=   "&chtt=Results+for+"+ (navigator.userAgent.match(/\w+/)[0])+ " - "+ numRules + " rules";  
    
    //gid("imgtest").src = graph;
};
 
//]]>

</script>



        <div id="runtime"></div>
        <!--<div class="forcopy">.forcopy</div>-->

        <div id="stresstestcontainer">
            
      
            <div id="charts">
            <h2>Charts</h2>
           <!-- http://code.google.com/apis/chart/#simple     js<br />-->
                
           
           
       

            <!--<img id="imgtest" alt="Test graph" src="http://chart.apis.google.com/chart?cht=bhs&chd=t:60,40,20&chs=200x130&chxl=0:|0|2000|1:|Webkit|Gecko|Trident&chxt=x,y&chtt=Copy+1000+rules" /></div>-->
                             
            
            <div class="agent">Agent: <span id="agent"></span></div>
            <div class="date">Date: <span id="date"></span></div>
            <div class="version">sheetUp Version: <span id="version"></span></div>
                   
            <div>
                <table id="result">
                    <thead><tr><td>Action</td><td>Code</td><td style="text-align:right;">Time Taken (ms)</td></tr></thead>                    
                    <tbody></tbody>
                </table>
            </div>
			<!--<img id="imgtest" alt="Test graph" src="" />   -->
			
			</div>   
        </div>        
    </div>
