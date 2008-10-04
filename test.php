<?php 
    $title = "Test";
	$id = "test";
    @include_once "inc/header.php"; 
    
    $head = "";
?>
<!--<h1>Inconsistenceis (e..g padding-left-value rather than padding-left) can(probably) be fixed by using the cssText rather than the actual functions (i think this might benchmarked faster anyway)</h1>-->
<!--<p>Put in bad data and test how it handles them...</p>-->
<style type="text/css">
/*Main styles*/

/*Table*/
td {padding:0 7px;}
th  {padding:0 7px; } /* ie adds td, th as two rules */
tr{border-bottom:1px solid #ddd;}
tr:hover{background:#eeeeee;}
table{border-collapse:collapse;}
thead {background:#ccc;font-weight:bold;}
th {text-align:left;font-weight:normal;font-family:monospace;}
.bad {color:Red;font-weight:bold;}
.good {color:Green;font-weight:bold;}
td[colspan]{background:#eee;}
</style>


<style type="text/css" title="TestSheet">
/*Main styles*/
.test .or{padding-top: 10px;}

</style>


<style type="text/css">
/*Main styles*/
.a3rd #sheet test{}

</style>









<script src="js/sheetup.js" type="text/javascript"></script>
<script type="text/javascript">
//<![CDATA[

ss.fn.ignore = [document.styleSheets[0]];


libDEBUG = true;


window.onload = function() {   
    //Todo 1)eval both sides,    2)sub titles, 3)descriptions
    
    
    //get an array of the code to run
    var testCodeBits = document.getElementsByTagName("th"),
        exectedCells = getElementsByClassName("e", "td"),
        resultCells  = getElementsByClassName("r", "td"),
        output,
        i,
        tests = testCodeBits.length, //35 has a bug in ie??????
        passed=0;
    
    
    for(i=0; i<tests; i++) {
        var output = eval(testCodeBits[i].innerHTML);        
        resultCells[i].innerHTML =   output;
        if(output == eval(exectedCells[i].innerHTML)) {
            resultCells[i].className = " good";
            passed++;
        } else {
            resultCells[i].className = " bad";
        }
        
        if(resultCells[i].innerHTML == "undefined")
             resultCells[i].style.color = "#ccc";
        
    }
    
    gid("tests").innerHTML = testCodeBits.length;
    gid("passed").innerHTML = passed;
    if(gid("passed").innerHTML == testCodeBits.length) ;
        
};

//]]>

</script>



<div id="testcontainer" class="test">

<p>Just a basic test that executes the code in the test column and checks the result 
against the expected column. It is calibrated for Firefox 3, because browsers handle the rules so differently   
their output can be different.</p>
<p>Tested in: Firefox 3.0</p>    

<table>
<thead id="affectedRulesTest"><tr><td>Test</td>                                         <td>Expected</td>               <td>Result</td></tr></thead>
<tbody> 
    <tr><td colspan="3">Init</td></tr>
    <tr><th>ss().init().length;</th>                                                    <td class="e">12</td>           <td class="r"></td></tr>
    <tr><th>ss().length;</th>                                                           <td class="e">12</td>           <td class="r"></td></tr>
    <tr><th>ss().sheets.length;</th>                                                    <td class="e">3</td>            <td class="r"></td></tr>
    <tr><th>ss(".newrule1{} .newrule2{background:red;}", true).length; //true does not do antyyhing ehre...</th><td class="e">2</td>            <td class="r"></td></tr>    
    <tr><th>ss(".newrule3{} .newrule4{background:red;}", true).selectorText();</th>     <td class="e">".newrule3"</td>  <td class="r"></td></tr>
    
    <tr><th>ss().length;</th>                                                           <td class="e">16</td>           <td class="r"></td></tr>
    <tr><th>ss("td").length;</th>                                                       <td class="e">2</td>            <td class="r"></td></tr>
    <tr><th>ss(/td/).length;</th>                                                       <td class="e">2</td>            <td class="r"></td></tr>

    <tr><th>(ss.ds === document.styleSheets) </th>                                      <td class="e">true</td>         <td class="r"></td></tr>
    <tr><th>var sheet = ss.fn.getSheet("TestSheet"); ss(sheet).length;</th>                                                   <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss(sheet.rules || sheet.cssRules)[0].style[0]</th>                    <td class="e">"padding-top"</td>  <td class="r"></td></tr>
    
    <tr><th>ss(".newrule5{}", "TestSheet").length; </th>                                   <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss(".newrule6{}", "TestSheet"); ss(".newrule6", "TestSheet").length;</th>   <td class="e">1</td>            <td class="r"></td></tr>

    
    <tr><th>ss(gid("testcontainer")).length;</th>                                       <td class="e">1</td>          <td class="r"></td></tr>
    

    





    <tr><th>//ss("css/ext.css").length;</th>                                                <td class="e"></td>            <td class="r"></td></tr>
    <tr><th>//ss("css/ext.css").length; //select it now</th>                                <td class="e"></td>            <td class="r"></td></tr>


  
  
  
  
    
    <tr><td colspan="3">Selecting</td></tr>

    <tr><th>ss().slice(0).length;</th>                                                     <td class="e">1</td>            <td class="r"></td></tr>
   <tr><th>ss().slice(0).selectorText().toLowerCase();</th>                               <td class="e">"td"</td>           <td class="r"></td></tr>

	
	<tr><th>ss().slice(0).length</th>													<td class="e">1</td><td class="r"></td></tr>
  	<tr><th>ss().slice(0, 4).length</th>												<td class="e">5</td><td class="r"></td></tr>
   
	
	
	<tr><th>ss().getAffectingRules(gid("affectedRulesTest")).selectorText().toLowerCase();</th><td class="e">"thead"</td><td class="r"></td></tr>
    <tr><th>ss().find("--.test .or").length;</th>                                       <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss().find("||thead   |  table").length;</th>                                <td class="e">2</td>            <td class="r"></td></tr>
    <tr><th>ss().find(/\.test.*\.or/).length;</th>                                      <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss().find("test").find("or").length;</th>                                   <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss().find("test").findSelector;</th>                                        <td class="e">"test"</td>       <td class="r"></td></tr>
    
    <tr><th>ss(ss.ds[0]).find("test").length;</th>                                      <td class="e">0</td>          <td class="r"></td></tr>
    <tr><th>ss(undefined, [ss.ds[1], ss.ds[2]] ).find("test").length;</th>              <td class="e">1</td>          <td class="r"></td></tr>
    
    <tr><th>ss("thead").push("table").length;</th>                                      <td class="e">2</td>          <td class="r"></td></tr>
    
    <tr><th>ss("thead").push(ss("table")).length;</th>                                  <td class="e">2</td>          <td class="r"></td></tr>
       
    <tr><th>//merge</th>                                                                <td class="e"></td>          <td class="r"></td></tr>
      
    
    
    <tr><td colspan="3">Stylesheets</td></tr> 
    <tr><th>//ss().newSS(".newrule7{}.newrrule8{}", "NewSheetTitle");</th>              <td class="e"></td>            <td class="r"></td></tr>
    <tr><th>//ss().newSS("css/test.css");</th>                                              <td class="e"></td>            <td class="r"></td></tr>
    <tr><th>//ss().newSS("css/test.css");</th>                                              <td class="e"></td>            <td class="r"></td></tr>
    
    <tr><th>//ss(ss.ds[0]).removeSS();</th>                                             <td class="e"></td>             <td class="r"></td></tr>
    <tr><th>//ss("NewSheetTitle").removeSS();</th>                                      <td class="e"></td>             <td class="r"></td></tr>
    <tr><th>//ss().removeSS(3);</th>                                                    <td class="e"></td>             <td class="r"></td></tr>
    
    
    <tr><th>//ss().switchSS(1);</th>                                                    <td class="e"></td>             <td class="r"></td></tr>
    <tr><th>//ss().switchSS("title");</th>                                              <td class="e"></td>             <td class="r"></td></tr>
    <!-- toggle, enable ,disable... -->
    
    <tr><th>ss().medium("screen").medium()[0];</th>                                     <td class="e">"screen"</td>       <td class="r"></td></tr>
    <tr><th>ss().medium(["handheld", "print"]).medium()[2];</th>                        <td class="e">"print"</td>        <td class="r"></td></tr>   
    <tr><th>ss().deleteMedium("print").medium().length;</th>                            <td class="e">2</td>     <td class="r"></td></tr>
    
    
    
    
    
    
    <tr><td colspan="3">Chaining</td></tr>
    <tr><th>ss("th").length;</th>                                                       <td class="e">3</td>            <td class="r"></td></tr>
    <tr><th>ss("th").find("thead").length;</th>                                         <td class="e">1</td>            <td class="r"></td></tr>
     <tr><th>ss("th").find("thead").end().length;</th>                                  <td class="e">3</td>            <td class="r"></td></tr>
    
    
    
    
    
    
    
    <tr><td colspan="3">Manipulation</td></tr>
    
    <tr><th>ss().add(".newrule9{}").length; </th>                                       <td class="e">"19"</td>           <td class="r"></td></tr>
    <tr><th>ss(".newrule9").remove().length; </th>                                      <td class="e">0</td>            <td class="r"></td></tr>
    <tr><th>ss().length; </th>                                                          <td class="e">18</td>           <td class="r"></td></tr>
    <tr><th>ss().add(".newrule9{color:red;}", false).length; </th>                      <td class="e">18</td>           <td class="r"></td></tr>
    
    <tr><th>/blue/.test(ss(".newrule9").text().indexOf("blue"));</th>                   <td class="e">false</td>        <td class="r"></td></tr>
    <tr><th>ss(".newrule9").text("color:red"); /red/.test(ss(".newrule9").text());</th> <td class="e">true</td>         <td class="r"></td></tr>
    <tr><th>/blue/.test(ss(".newrule9").text());</th>                                   <td class="e">false</td>         <td class="r"></td></tr>

    <tr><th>ss(".newrule9").property("color", "green").property("color");</th>          <td class="e">"green"||"#008000"</td>        <td class="r"></td></tr>
    <tr><th>ss(".newrule9").property({"padding": "10px", "font-size": "12px"}).property("padding");</th><td class="e">"10px 10px 10px 10px"||"10px"</td><td class="r"></td></tr>
    <tr><th>ss(".newrule9").property("font-size");</th>                                 <td class="e">"12px"</td>         <td class="r"></td></tr>

    <!-- function to get rule array, remove all rules, then add them in again -->
    
      
    <tr><th>ss(".newrule9").getRulesAsArray().color;</th>                               <td class="e">"green"</td>        <td class="r"></td></tr>


    <tr><th>ss(".newrule9").copy(".newrule11");     ss(".newrule11").length;</th>       <td class="e">1</td>            <td class="r"></td></tr>
    <tr><th>ss(".newrule11").rename(".newrule10");  ss(".newrule10").length;</th>       <td class="e">1</td>            <td class="r"></td></tr>
    
    
    <tr><th>ss(".newrule9").property("opacity", "0.5").property("opacity")</th>                               <td class="e">0.5</td>          <td class="r"></td></tr>




    <tr><th>ss().incrementValue("10px",1);</th>                                         <td class="e">"11px"</td>         <td class="r"></td></tr>
    <tr><th>ss().incrementValue("10px",-1);</th>                                        <td class="e">"9px"</td>          <td class="r"></td></tr>
    
    
    
    
    
    
    <tr><td colspan="3">Utils       </td></tr>
    <tr><th>var rules = 0; ss().each(function(){rules++;}); rules;</th>                 <td class="e">20</td>           <td class="r"></td></tr>
    <tr><th>var sheets = 0; ss().eachSheet(function(){sheets++;}); sheets;</th>         <td class="e">3</td>            <td class="r"></td></tr>
  
    <tr><th>ss.fn.debug = false; ss.fn.debug</th>                                       <td class="e">false</td>        <td class="r"></td></tr>
    <tr><th>ss.fn.debug = true;  ss.fn.debug</th>                                       <td class="e">true</td>         <td class="r"></td></tr>
    
    
    


    
    <tr><td colspan="3">Extend       </td></tr>
    <tr><th>ss.fn.countRules = function()
            {
             var rules=0;
             this.each(function(){
              rules++; 
             });

              return rules;
            }; 
            ss().countRules();</th>                                                     <td class="e">20</td>           <td class="r"></td></tr>
     
     
     
     
     
     
    <tr><td colspan="3">@import       </td></tr>
    <tr><th>//ss().newSS("@import 'css/import3cross.css';", "ImportTest");</th>             <td class="e"></td>         <td class="r"></td></tr>
    <tr><th>//ss().deleteSS("ImportTest");    //does it remove imported sheets too?.. from this[]</th><td class="e"></td>         <td class="r"></td></tr>


    <tr id="total" style="border-top:2px solid #000;background:#ccc"><td><strong>Total</strong></td><td id="tests"></td><td id="passed"></td></tr>




</tbody>
</table>
           
</div>        




<?php @include_once "inc/footer.php"; ?>