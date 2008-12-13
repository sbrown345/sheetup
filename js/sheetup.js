/**
 * sheetUp - A Dynamic Stylesheet Library
 * http://code.google.com/p/sheetup
 * 
 * MIT LICENSE
 * 
 * Date: 30th September 2008
 *
 * @projectDescription A library heavily influenced by jQuery to manipulate DOM style sheets.
 * Tested with IE5.5-8, FF3, Opera 9.5, Safari 3.1, Chrome
 *
 * @author Simon Brown
 *
 * @id ss
 * @param {selector} Select rules for manipulation.
 * @param {context}  Only select rules from this style sheet.
 *	 
 * @return {ss} Returns the same sheetUp object for chaining.
 *
 * Usage is similar to jQuery
 * @example ss(".classToSelect").property("color:red"); 
 *
 *
 * Thanks to:
 * http://weblogs.asp.net/diaaarfan/archive/2008/08/15/chaining-methods-used-in-javascript-animations.aspx
 * http://www.howtocreate.co.uk/tutorials/javascript/domstylesheets
 * http://www.quirksmode.org/dom/w3c_css.html
 
 General Structure:
 
 init
    addrules from stylesheets 
    find (filter rules added from sss)
    
 internal
    each
    
 modify
    add/delete rules
        copy/rename rules    
    add/edit/delete properties  
    
 stylesheets
    new
    enable/disable
    delete   
    
 experimental
    animate
    
    
"opt" = blatant place to optimise
    
*/
 

 
 
 
/****************************/
/* BASIC OBJECT AND SETUP   */
/****************************/
(function(){


var undefined,
    _ss, //self
    isCssFile = /.*\.css$/i, //no query string support
    isRule = /[ \w.0-9~#:*-|\[\]$^\n\f\r\t]+\{[;\w:_()=.%\t\n\f\r\ \\"'#,-]*\}/gi,   // try [^\s] at start  so it doest match white space in front  //@media does not support and doesnt support comments inside the {} ((why not just add \ and * as supported?  @import?
              //needs a bit of housekeeping                                                               

    ss = window.ss = window.sheetUp = function(selector, context, findSelector) { 
        return new ss.fn.init(selector, context, findSelector);  
    };

ss.ds = document.styleSheets;




ss.fn = ss.prototype = {  
  
length:         null,       //no. of currently selected rules
findSelector:   "",         //the selector last used e.g. "#header .contact"
prevObject:     null,
sheets:         [],         //selected stylesheets
version:        "0.1.2", 
debug:          true,
ignore:         [],         //sheets to ignore during rule selection


/****************************/
/* INIT                     */
/****************************/

//works out what kind of variable it receives and does the appropriate thing  
init: function(selector, context, findSelector) {   

    //if we have a null or nothing passed it it uses the default stylesheet
    _ss = this;//this will conflict with other ones..perhaps use arguments.callee in each()?
    this.length = 0;
    
    //clean up just incase it is reiniting as part of a chain  e.g property("color","red").init()
    this.removeAllRules();    
    
    //for pushStack, handle the previous findSelector()   
    if(typeof findSelector !== "undefined") {
        this.findSelector = findSelector; //it is creating a new object from the search
    }        

    //handle context
    if(typeof context !== "undefined") {
        if(typeof context === "string") {
            context = this.getSheet(context);            
        }                
        
        if(context.cssRules || context.rules) {
            this.sheets = [context];
        }
            
        //else array of sheets - probably passed in from pushStack
        else if (context[0]) {
            if(context[0].cssRules || context[0].rules) {
                this.sheets = context;    
            }
        }
        
        this.log("Context sheet: ", context); 
    }
    
    
    
    
    //Handle no selector
    if (typeof selector === "undefined") { 
        this.log("Init:\tno selector");  
        //if(this.sheets.length === 0)
         //   this.initAllSheets();     //perhaps should be put above            
            
        return this.initAllRules();
        //return this; //perhaps it should return an empty object instead, but returning everything makes a nice shortcut to select all
    }

    //RegExp
    else if(selector.compile && selector.exec) {
        this.log("Init:\tregexp: ", selector);      
           
        this.initAllRules();                                                                  
        return this.find(selector);
    }         

    // Handle stylesheet
    //else if(true) this.log(selector)
    else if ( selector.cssRules || selector.rules ) {
        this.log("Init:\tstylesheet: ", selector);
        //clear other stylesheets and set this           
        this.sheets = [selector];        
        return this.initRules(this.getRulesFromSheet(selector), selector); //only init rules from that stylesheet         
    }   
    
    //Add a rule or search for rules
    else if ( typeof selector === "string" ) {      
        //add a class to the stylesheet           
        if(isRule.test(selector)) {
            if(!this.sheets.length) //unless there aren't any sheets selected already initalise them all (perhaps do if(context) instead?)
                this.initAllSheets(); 
                
            return this.addMultiple(selector, context);     
              
        //test if a new css file to be added    
        } else if(isCssFile.test(selector)) {
            return this.newSS(selector);
            
        } else {                   
            this.log("Init:\tselector string: ", selector);   
            
            //use default ss if it's a init string 
            this.initAllRules();  
            return this.find(selector);            
        }
    }
    
    
    //HTML Element
    else if ( selector.nodeType ) {
        this.log("Init:\tHTML elem");
        
        if(!this.sheets.length) //init all sheets and then rules if there is no context sheets
            this.initAllSheets();                 
        this.initAllRules();
        
        return this.getAffectingRules(selector);
        //return this.getComputedStyle(selector); //or getAffectingRules???             
    }
    
    
    
    //Object, Rules list or random    
    else if ( typeof selector === "object" ) {     
           
        if(selector.length) {
            if(selector[0].cssText || selector[0].selectorText ) {
                this.log("Init:\trules", selector);
                return this.initRules(selector); ////////////////HOPEFULLY NOT NEEDING @IMPORT RULES COS THEY WONT WORK FOR IE HERE   
            }   
        }    
            
        if(selector.selectorText) {
            //this.log("Init:\tstyle rule");     
            this.initAllSheets();   
            this.length = 1;
            this[0] = selector; 
            return this;
        }    
                
        else {
            this.log("Init:\twth is this?", selector);
        }
    }       
    
    return this;            
},






//revert obj to the previous selection
end: function () {            

    if(this.prevObject) {     
        return this.prevObject;/// || ss;
    }
    
    this.log("End:\tno previous object");
    return this;
},    




/****************************/
/* SELECT                   */
/****************************/    


/*
merge: function (query)  {},
grep: function (query)   {},
filter: function (query) {}, filter by style property/value
*/

//filter out the rules array, sets this[]
//add extensible selectors?
find: function (query) { 

    var originalLength = this.length,            
        newRules = [], 
        i = 0,
        findSelector = query,
        words;    
     
    //convert any string queries into regexp    
    if(typeof query === "string") {  
        query = this.trim(query);    
    
        //automake FOLLOWS BY regexp
        if(/--.*/.test(query)) { 
            query = this.regExpEscape(query);   
            query = ".*"+query.substring(4).split(" ").join("\\b.*\\b[^.|#]{1}")+"\\b.*"; //div div would match div .div      /.*\bwas\b.*\b[^.|#]{1}red\b.*/.test("was #red")   - still does matches .divSSS tho
            query = new RegExp(query, "i");
        }         
       
        //automake OR regexp    (very simplified - can match wrong things)
        else if( /\|\|.*/.test(query) ) { 
            words = query.substring(2).split("|");            
            for(i=0; i<words.length; i++) {
                words[i] = this.regExpEscape(this.trim(words[i]));
            }
            
            query = "\\b"+words.join("\\b|");

            query = new RegExp(query, "i");
                
        }        
    }    
    
    if(typeof query === "string") {
        query = this.regExpEscape(query);   
        query = new RegExp(query, "i");
    }
      
    //if the rule tests ok, add it to the list of rules
    for (i=0; i<originalLength; i++) {              
        if( query.test(this[i].selectorText) ) { 
            newRules.push( this[i] );       
        }
    }
    
    //now we have a bunch of rules we can push it on the stack and return it    
    this.log("Find:\t", query);   
    this.log("New rules: ", newRules.length);
    return this.pushStack(newRules, findSelector);
},

// Thanks jquery again:
// Take an array of elements and push it onto the stack
// (returning the new matched element set)
pushStack: function( newRules , findSelector) {
	// Build a new jQuery matched element set
	var ret = ss( newRules, this.sheets.slice(), findSelector ); //pass along the sheets and selectorText as well to form the new object    
    
	// Add the old object onto the stack (as a reference)
	ret.prevObject = this;

	// Return the newly-formed element set
	return ret;
},

//opt- check out jquery
//selects rules by index
//what about eq(-1)?
slice: function(s, e) {
    if(arguments.length == 1) e = s;    
           
    var rules = [], i = s, len = e - s;    
    for(i; i<=len; i++) {
        rules.push(this[i]);
    }
    
    return this.pushStack(rules);               
},   

//internal
eq: function(i) {
    if(i<0) {
        //if negative
        return this.eq(this.length + i);
    
    } else if (i>=0 && i < this.length) {
        this[0] = this[i];           
        
        for(var p=1;p<this.length;p++) {
            delete this[p];            
        }
        this.length = 1;                       
        return this;
    }
    
    this.log("Eq: i is an invalid index: ", i);
    return this;
},   

//filter rules out according to some thing... 
filter: function(func) {
    
    //default filter function
    if(typeof func !== "function") {
        func = function() {
            //if theres one argument it'll be the property of a rule, if say it is colour it'll return ones with jsut colur
            
            
            //if theres another string arg it'll be the value of the style
        
        }
    }
    
    return this.each(function() {
        //...
    });
},

//add an array of rules to the object
push: function(rules) {

    if(typeof rules === "string")
        rules = ss(rules);

    for(var i=0; i<rules.length; i++) {
        this[this.length++] = rules[i];  
    }    
        
    return this;
},

//todo
unique: function( ret ) {
    return ret;
},
merge: function(s) {
    return this.push(s).unique();
},

/****************************/
/* RULES                    */
/****************************/    

/* INIT RULES OBJECT        */
//adds an array of rules onto the end of the object
//works with import rules
initRules: function(rules, parentSS) {

    var r, rule, sheet, i;
    //OK this is easy for IE because we can just make this.sheets.push()    
    if(parentSS) {//ie @imports   
        if(parentSS.imports) {  
            if(parentSS.imports.length) { 
                for(i=0; i<parentSS.imports.length; i++) { 
                    //if a file tries to import the file that imported itself, it does not display any rules in the IE stylesheet object
                    if(!this.sheetSelected(parentSS.imports[i].href)) {//gota test if its already been added                      
                        sheet = parentSS.imports[i];
                        this.sheets.push(sheet);
                        this.initRules(this.getRulesFromSheet(sheet), sheet); //only init rules form that stylesheet                
                    }
                }
            }
        }
    }           
    for(r=0; r<rules.length; r++) {
        rule = rules[r];
        
        /*if import rule - not in IE*/
        if(rule.href) { //could use        if (rule.type === 3)
        
            if(!this.sheetSelected(rule.href)) {//gota test if its already been added
                //this.log("Adding imported sheet:\t", rule.href);
                sheet = rule.styleSheet;
                this.sheets.push(sheet);   
                this.initRules(this.getRulesFromSheet(sheet), sheet); //only init rules form that stylesheet   
            }         
                
         } else {
            //if(!/^#Firebug/.test(rule.selectorText)) //ignore all firebug rules  (whole ss ignored now - should be safe to remove)         
            this[this.length++] = rule;
         }
    }    
    return this;    
},

/* INIT ALL RULES           */
initAllRules: function() {  //this is only called from this.init()  so if there's been a context find  a sheet has already been added and will only add rules from that one
    var i;
    //reset      
    this.length = 0;     
    if(this.sheets.length === 0) //if there is no stylesheet context, init all the sheets
        this.initAllSheets();
        

    //for each sheet add the rules
    for(i=0; i<this.sheets.length; i++) {    
                     
        this.initRules(this.getRulesFromSheet(this.sheets[i]), this.sheets[i]); //init rules from the sheet                 
    } 
        
    return this;
},

//make self reference all ss.ds  (what about imports...)
initAllSheets: function() { //DOES NOT CATCH EXTERNAL SECURTY PROBLEMS.... LIKE initAllRules DOES - may just need to test...
    this.sheets = [];    
           
    for(var i=0; i<ss.ds.length; i++) { //each() doesn't seem to work here
 
        if(/firebug-lite\.css/i.test(ss.ds[i].href)) {
            continue;
        }
        //test if editable, discard if not
        try {
       
            ss.ds[i].cssRules;                      
        } catch(e) {
            _ss.log("Error", e);
            _ss.log(ss.ds[i]); 
            continue;            
        }
        
        if(!this.ignoreSheet(ss.ds[i])) {
            this.sheets.push(ss.ds[i]);    
        }
    }    
    
    return this;
    
},
//ignores sheets on ss.fn.ignore list on default action of selecting all sheets
ignoreSheet: function(s) {
    for(var i=0; i<ss.fn.ignore.length; i++) {
       this.log(ss.fn.ignore[i], s)
        if(ss.fn.ignore[i] === s)
            return true;
    }
    return false;
},

/*        
getArrayOfRules: function (obj) {
    var ruleArray = [];          
     
    var cssRules = this.getRulesFromSheet(obj);
     
    for (i=0; i<cssRules.length; i++)   
        ruleArray.push(cssRules[i]);  
                
    return ruleArray;
},
*/    

/* RETURN THE RULES OBJECT FROM A STYLESHEET  */
getRulesFromSheet: function (obj) {        
    //if a stylesheet passed in
    if(obj.cssRules)
        return obj.cssRules;
    else if (obj.rules)        
        return obj.rules;

    //if rules array
    try {
        if( obj[0].cssText || obj[0].selectorText )
            return obj;            
        else //else use the default ss
            return  this.defaultRules();
    
    } catch(e) {}     
    
    return this.log("getRulesFromSheet: Bad sheet: ", obj);
},






/****************************/
/* MODIFY                   */
/****************************/    

addMultiple: function (rules, addToSelection) {
    if(typeof addToSelection === "undefined") addToSelection = true;    
    var i, arr = rules.match(isRule);        
    this.log("addMultiple: add new rule(s): ", arr);    
    
    for(i = 0; i<arr.length; i++) 
        this.add(arr[i], addToSelection);
        
    return this;
},

//clean up with reg exp
//needs big tidy up
add: function (ruleName, addToSelection) {     
    //whether the new rule will be added to the selection - default: will be added
    addToSelection = (typeof addToSelection === "undefined" || addToSelection) ? true : false;
  
    var firstI, lastI, selector, properties, i,
        insertSheet = this.sheets[0],//always this sheet?
        insertPos = this.getRulesFromSheet(insertSheet).length, //perhaps add arg so could be put in any position
        newRule;
    
    if (insertSheet.insertRule) {      
        this.log("add:\tinsertRule");
        if(ruleName.indexOf("{") + ruleName.indexOf("}") == -2) //opera fix
            ruleName+=' { }';

        insertSheet.insertRule(ruleName, insertPos); //wow, isn't it easier for moz
      
        newRule = this.getRuleByIndex(insertSheet, insertPos);

     } else {
     
        this.log("add:\taddRule");
        ruleName = this.trim(ruleName);
        
        firstI = ruleName.indexOf("{"); //fix with regexp
        lastI  = ruleName.length;
        
        //incase an empty rule does not have {}
        
        
        selector    =  (ruleName.indexOf("{") == -1)   ? ruleName  : ruleName.substr(0, firstI);
        properties  =  (firstI+1 == lastI)             ? ""        : ruleName.substring(firstI+1, lastI-1);


        //if empty rule 
        if(properties.length===0) {        
            this.log("Empty properties");
            insertSheet.addRule(selector, null, insertPos); ////////////////////////adds it before so it gets overwritten!!!
            
        } else {    
            properties = this.trim(properties).split(";");
            //have to go thru adding the properties seperately
            for(i=0;i<properties.length;i++) {
                if(properties[i] != "") {
                    insertSheet.addRule(selector, properties[i], insertPos); //safari seems to make a new rule each time
                }    
            }
        }
        newRule = this.getRuleByIndex(insertSheet, insertPos);
        
    }

    this.log("add:\t",newRule);
    if(newRule.selectorText && addToSelection) {
        this.log("Adding new rule to selection", this);
        //add rule to the ss() selection
        this.addRule(newRule);
    }   

    return this;
},

//internal functions for add()
addRule: function (rule) {
    this[this.length++] = rule;
    return this;
},
getRuleByIndex: function(sheet, index) {
    return this.getRulesFromSheet(sheet)[index];
},

/* REMOVE SELECTED RULES    */
remove: function () {          
    //remove selected rules from sheet
    this.each(function(y, rule) { 
        _ss.removeRule(rule);        
    });
    
    //remove all those rules referenced in self
    this.removeAllRules(); 
    
    this.length = 0;
    return this;
},

//internal use only for above function, does not fix this.length
removeRule: function(rule) {
    //this.log("removeRule: ", rule);
    var SheetAndIndex = this.getRuleIndex(rule),
        sheet = SheetAndIndex[0],
        ruleIndex = SheetAndIndex[1];
    
    if(sheet) {    
        if(sheet.deleteRule) 
            sheet.deleteRule(ruleIndex);    //ff
        else if (sheet.removeRule) 
            sheet.removeRule(ruleIndex);    //ie
   }

},

//not all browsers support rule.parentStyleSheet
//opt - if it does, only search thru that one

getRuleIndex: function(rule) {   //perhaps need to reference the rule index somewhere
    var sheet, cssRules, s, i;

    for(s=0; s<this.sheets.length; s++) { 
    
        sheet = this.sheets[s];
        cssRules = this.getRulesFromSheet(sheet);
        
        for (i=0; i<cssRules.length; i++) {
            if(cssRules[i] == rule) { 
                return [sheet, i];   
            }
        }                      
    }        
    return false;
}, 

/* MANIPULATE RULES         */  

//copies the first one in the selection to a new rule 
copy: function(newSelector) { //copy the this[0] rule to a new and reinit   
    this.eq(0);
      
    if(this.length) { 
        var ruleText = this.text();
        ruleText = newSelector + " " + ruleText.substr(ruleText.indexOf("{"));      
        this.add(ruleText);        
    }
            
    return this;//.end();
},

//rename the first one in the selection to:
rename: function(newSelector) {//can't change selector
    if(this.length) {
        this.copy(newSelector);              
        ss(this[0]).remove(); 
    }
    return this;
},

//should extend the property() function
disable: function(selector, toggle) {return this;},

/* PROPERTIES               */
//check out jquerys curCSS function
//find style rules from current this.... store in this.styleRules array
property: function(property, value, increment) { //get set property

    if(this.length<1) {
        this.log("Property: No rules selected to set styles in");
        return this;
    }

    var newStyles, rule, styleName, camelCase, s;
    
    if(typeof value === "undefined") {
    
        if(typeof property === "object") {
            newStyles = property;
            this.log("Set many styles: ", newStyles);                
        } else {
        
            this.log("Get the property ", property);
            if(this.length) {                            
                return this[0].style[this.camelCase(property)];
                //return this[0].style[property];
            }
            return false;
        }    
    } else {
        //setup an array with a single style in it
        this.log("Set property "+ property +" with " + value);
        newStyles = {};
        newStyles[property] = value;
    }    
    
    //for each rule the styles are going to be applied to
    this.each(function(i) {
        rule = this;
        styleName = this.style[i];  

        if(newStyles) {
            for(s in newStyles) {                        
                if(rule.style.setProperty) {      //opt                        
                    if(increment)
                        newStyles[s] = _ss.incrementValue(rule.style.getPropertyValue(s), value);                        
                    rule.style.setProperty(s, newStyles[s], null);   
                                         
                } else {                 
                    camelCase = _ss.camelCase(s); //hoverEd doesn't work with the camel case one, why was it needed again?
                    if(camelCase == "float") camelCase = "styleFloat";
                    else if (camelCase == "opacity") {camelCase = "filter"; newStyles[s] = "alpha(opacity="+(newStyles[s]*100)+");";} //need some way of extending property() to make these if statements clearer and extendable
                    
                    if(increment)                      
                        newStyles[s] = _ss.incrementValue(rule.style.getPropertyValue(s), value);
                        
                    rule.style[camelCase] = newStyles[s]; //ie
                }   
            }            
        }        
        // return rule.style[styleName];//??         
    });                  
    //if contains value... (and or proeprty)
    //... 
    return this;
},

removeProperty: function(props) { //removeProperty - perhaps property: should be style:
    props = typeof props === "string" ? [props] : props;
    return this.each(function() {       
        for(var i=0; i<props.length; i++) {        
       
            if(this.style.removeProperty) {
                this.style.removeProperty(props[i]); 
                             
            } else {             
                var style = _ss.camelCase(props[i].toLowerCase());
                if(style == "float") style = "styleFloat";
                this.style[style] = "";
            }            
        }    
    });    
},

camelCase: function(t) {
    return t.replace(/\-(\w)/g, function(all, letter){return letter.toUpperCase();});  //ty jQuery
},

incrementValue: function(value, incr) {
    //parse value and unit
    var n = parseFloat(value),     
        unit = value.substring((""+n).length);   
    
    //if % increment
    if(incr.toString().indexOf("%")>0)
        return n + (n * (parseFloat(incr)/100) ) + unit;

    //normal
    return (n + incr) + unit;        
    
    
    //colour
    //...
},

disableProperty: function(selector, toggle) {},

//split up the css text instead of looking thru .styles rules
getRulesAsArray: function(camel) {
    var arr = {}, cssText, pair, textPairs, i, len, camelArr = {};
    
    this.each(function() {    
        
        if(this.style.cssText)
            cssText = this.style.cssText;
        else if(this.cssText)
            cssText = this.cssText;        
        else
            return;
        
        textPairs = cssText.split(";");

        for(i=0, len=textPairs.length; i < len; i++) {
            pair = textPairs[i].split(":");
                        
            if(pair[0] && pair [1] && _ss.checkStyle(pair[0]))
                arr[_ss.trim( pair[0] )] = _ss.trim( pair[1] );
        }
    });
    
    //return key names as camelCase    
    if(camel) {            
        for(prop in arr)       
            camelArr[ss.fn.camelCase((prop+"").toLowerCase())] = arr[prop];    

        return camelArr;
    }
    
    
    return arr; 
},

//to tidy out annoying styles e..g -moz and webkit (todo: may want to keep these though?)
checkStyle: function(p) {
    if( /moz-|ltr-source|rtl-source|-webkit-/.test(p) ) //strip mozilla ones (what about opacity though, and could clear webkit ones out too)
        return false;     
    return true;
},

//args[0]=ruleText      alow rule object tooo....
//args[1]=
copyStyles: function() {    
    var styles = this.getRulesAsArray();
    this.log("copyStyles", styles);
    
    //copy all properties
    if(arguments.length==1) {
        this.log("Copy all styles to ", arguments[0]);
        
        //WHAT IF IT DOES EXIST????? dont want to make a new rule!!!!!!!!!!!
        if(!this.ruleExists())  //if does not exist
            ss(this.sheets[0]).add(arguments[0]);
        
        ss().find( arguments[0] ).property(styles);
    }
    /*
    else if(arguments.length==2) {
        //filter styles
        var listOfStylesToCopy = arguments[0];
        
        for(s in styles) { //every style            
            this.log(s);
            //if not in list of styles to copy
            if(s in listOfStylesToCopy)
                this.log("hmmf")
            
        }
    
    
        ss().find( arguments[1] ).property(styles);
    }*/    
    return this;
},

ruleExists: function(selectorText) {
    //trim each word in the selectorText
    /*var bits = selectorText.split(" ");
    for(bits in bits)
        bits = _ss.trim(bits)*/    
    return false;
},
    
//copy styles in rules list to an element
//copyToElement: function(elem) {},       //bit out of project scope - it returns an array already

getCascadedStyles: function(elem, property) {},

//get rules as text
//args: true- get whole sheet, string- change rule text
//tidy with regexp
text: function(arg) {   
    var output = "", cssText, start, end, i, rulesToRemove, r; 
    
    //set text
    if(typeof arg === "string") {
        rulesToRemove = [];
        this.each(function() {
            rulesToRemove.push(this);            
            cssText = ss(this).text();        
            start = cssText.substr(0, cssText.indexOf("{") + 1 );    //fix with regexp
            end   = cssText.substr(   cssText.lastIndexOf("}") );  
            _ss.add(start + arg + end);
            
        });
        //and remove any ones changed
        for(r in rulesToRemove)
            this.remove(r);

        return this;            
    }
    
    //get selected sheets as text
    else if(arg === true) { //Does not work with imported sheets...
        this.eachSheet(function() {
        
            if(this.cssText) {//ie
                output += this.cssText; //hmmmpff, is there any way of getting original text? (ajax :S)
            } else if (this.ownerNode) {
                for(i=0; i<this.ownerNode.childNodes.length; i++)  
                    output += this.ownerNode.childNodes[i].textContent;        //does work for both <link> and <styles>?        
            } else {
                this.log("text() error: May be imported style sheet, text output not supported yet"); //Either fix with ajax or reading cssText of each rule    
            }
        });
    }
    
    else {
        //get the selected rules as text
        this.each(function() {         
            if(this.cssText)                    
                output+=this.cssText+"\n";
            else
                output+=this.selectorText + "{" + this.style.cssText + "}\n";            
        });
    }
    
    return output;     
},

//returns selector text for first rule
selectorText: function() {
    if(this.length>0)
        return this[0].selectorText;        
    return this;
},    
    
getComputedStyle: function(elem, property) {
    //works on single style
    if (document.defaultView && document.defaultView.getComputedStyle)         
        return document.defaultView.getComputedStyle(elem, null);   
    else if (elem.currentStyle) 
        return elem.currentStyle;
    else 
        return elem.style;
},    
    
//look at nodetype, id, class - filter any rulse
//select rules by which ones affect an element
//needs fixing
getAffectingRules: function(elem) { //test on :hover, :active etc
    //major flaw in this way of doing it: what about things that are inherited like color? - not specifically said 
    //also only the nodeName should be case sensitive
    var selector = "";
    //we need to be able to add selections together for this
    if(elem.id)
        selector += "\\#"+elem.id+"\\b|";
    if(this.trim(elem.className) !== "")        
        selector += "\\."+elem.className.split(" ").join("\\b|\.") + "|"; 
    if(elem.nodeName)
        //selector += "|(?<![a-zA-Z0-9\-\._])"+elem.nodeName+"(?![a-zA-Z0-9\-_])"; //js doesn't support this
        selector += /*"|(?<![a-zA-Z0-9\-\._])"+*/ elem.nodeName+"(?![a-zA-Z0-9\-_])"; //js doesn't support ?<!        (?<![a-zA-Z0-9\-\._])nodeName(?![a-zA-Z0-9\-_])
  
    selector = RegExp(selector, "i");
    
    return this.find(selector); 
    //return this.find("-- #lots, div"); //this could get complicated cos a class may be named .div
},


/****************************/
/* STYLE SHEET SWITCHING    */
/****************************/

//gota tidy up!
//creates new SS on the document and sets it as the local thing
newSS: function(cssText, title) {
    this.log("New stylesheet, ", cssText);
    
    //mainly used for @import rules where we want to add a ss without reinitialising it
    var init = (typeof title === "boolean" && title) ? false : true,
        cssNode, 
        head = document.getElementsByTagName("head")[0],
        href = isCssFile.test(cssText),
        i;
        
    cssText =   typeof cssText ===   "string" ? cssText  : ""; //should fix a safari bug too
    title =     typeof title ===     "string" ? title    : "Sheet_"+ss.ds.length;

    //if its already been added return it as a selection
    if(href) {
        for(i=0; i<ss.ds.length; i++) { 
            if(RegExp(".*"+cssText+"$","i").test(ss.ds[i].href)) {
                return this.init(ss.ds[i]);
            }
        }
    }
 
    //perhaps take a stylesheet object too
    //...    
  
    //create style sheet with the new rules if something has changed ??   

    //if we have IE    
    if(document.createStyleSheet) {   
        if(href)
            document.createStyleSheet(cssText); //add sheet by URL 
        else
            document.createStyleSheet().cssText = cssText;  //add css text as sheet
         
        cssNode = ss.ds[ss.ds.length-1];
        cssNode.title = title;          
          
        if(init)   
            return this.init(cssNode);//is this behaviour consistent?
     
    //it isn't IE   
    } else if (href) {  //add a link element if its a url
    
        //http://www.hunlock.com/blogs/Howto_Dynamically_Insert_Javascript_And_CSS - thanks Patrick Hunlock       
   
        cssNode = document.createElement('link');
        cssNode.type = 'text/css';
        cssNode.rel =  'stylesheet';
        cssNode.href = cssText;
        cssNode.media= 'screen';        
        head.appendChild(cssNode);
        
        cssNode = cssNode.sheet;        

        //major annoyince here - fails for ff
        //can i have some timeout function that resumes where it is now or something :?
        //or perhaps return false here, and do something
        //perhaps closures might elp http://ajaxian.com/archives/secrets-of-the-javascript-ninja-a-sneak-peak-for-ajaxians
            
           
        //can i have an onload event or something?
            
        return this; //quick  fix for now
            
        //if(init) return this.newSSTimeout().init(cssNode);//is this behaviour consistent?
        
    } else { //add stylesheet with css text    
        cssNode = document.createElement('style');
        cssNode.type  = 'text/css';
        cssNode.media = 'screen';
        cssNode.rel   = 'stylesheet';
        cssNode.title = title;
        head.appendChild(cssNode);
        cssNode.appendChild(document.createTextNode(cssText));
        cssNode = cssNode.sheet;        
        
        return this; //quick fix for now        
        //if(init) return this.init(cssNode);             
    } 
    //add stylesheet and add rules - rather that reinitialising the whole object with the new ss   
   
    this.sheets[this.sheets.length] = cssNode;
    return this.initRules(this.getRulesFromSheet(cssNode));    
},

//fix the moz access newly added ss bug
newSSTimeout: function() {
//http://blog.jcoglan.com/2007/10/30/asynchronous-function-chaining-in-javascript/
//http://dev.jquery.com/view/trunk/plugins/ajaxQueue/jquery.ajaxQueue.js



//http://www.learningjquery.com/2007/01/effect-delay-trick THIS LOOKS PROMISING

//http://blog.mythin.net/file_download/5    - look at jqueries queue - looks most promoising
    return this;
},

//test if a sheet has been added already to the ss object
sheetSelected: function(filename) {  
    var selected = false; 
    this.eachSheet(function() {
        if(typeof this.href === "string") {             
            //if( RegExp(_ss.regExpEscape(filename)+"$").test(this.href) ) { // if files were named 3column.css, column.css  - column.css is at the end of 3column.css must not only look ane end but be /fileat end
            if( RegExp(filename+"$").test(this.href) ) { // if files were named 3column.css, column.css  - column.css is at the end of 3column.css must not only look ane end but be /fileat end
                this.log("sheetSelected: sheet is selected already: ", this);  
                selected = true;     
                return false;
            }   
        }       
    });
    return selected;
},

//switch the ss (untested)
switchSS: function (indextitle) {
    var i, d;
    //passed an index
    if(parseInt(indextitle) >= 0 && parseInt(indextitle) < this.sheets.length) {
        //disable all
        for (i = 0; i<this.sheets.length; i++)
            this.disableSS(indextitle);          
        //enable right one       
        this.enableSS(indextitle);                    
    }        
    
    //passed a title
    else if(typeof indextitle === "string") {        
        for (i = 0; i< this.sheets.length; i++) {               
            if (this.sheets[i].getAttribute('title') == indextitle) {
                
                //disable all
                for (d=0; d<this.sheets.length; d++) {
                    this.disableSS(indextitle);   
                }
                    
                this.enableSS(i);                            
                
                break;
            }
        }
    }
    return this;
},
enableSS: function (i) {
    this.sheets[i].disabled = false;  
    return this;    
},    
disableSS: function (i) {
    this.sheets[i].disabled = true;   
    return this;
},
toggleSS: function (i) {
    this.sheets[i].disabled = !this.sheets[i].disabled;   
    return this;
},

//delete a stylesheet
removeSS: function(sheet) {
    var sheetToRemove, i;    
    
    //if nothing set delete the first selected stylesheet
    if(typeof sheet === "undefined")
        sheetToRemove = this.sheets[0];
    
    //if a number delete the corresponding one in the ss.ds array
    else if(typeof sheet === "number")
        sheetToRemove = ss.ds[sheet];
        
    //else delete by a title in the ss.ds array
    else if(typeof sheet === "string"){           
        for(i=0;i<ss.ds.length;i++) {            
            if(ss.ds[i].title+"" == sheet+"")
                sheetToRemove = ss.ds[i];            
        }        
    }     
    
    if(sheetToRemove.cssRules || sheetToRemove.rules) { 
        if (sheetToRemove.ownerNode)
            sheetToRemove.ownerNode.parentNode.removeChild(sheetToRemove.ownerNode);
        if (sheetToRemove.owningElement)//ie
            sheetToRemove.owningElement.parentNode.removeChild(sheetToRemove.owningElement);
    }
    return this;
},

//find and return sheet by title
getSheet: function(title) {
    for(var i=0;i<ss.ds.length;i++) {            
        if(ss.ds[i].title+"" == title)
            return ss.ds[i];      
    }
    return false;    
},

appendMedium: function (med) {
    if(this.sheets[0].media.appendMedium) {//ff
        this.sheets[0].media.appendMedium(med);
        
    } else if (typeof this.sheets[0].media === "string") {
        this.sheets[0].media = this.sheets[0].media + ", " + med;//what about if it is already there...   
    }    
    return this;
},

deleteMedium: function (med) {
    //if(typeof arguments[0] === "object") //if array
    //    return this.each(arguments[0], function(){_ss.deleteMedium(this)});  

    if(this.sheets[0].media.deleteMedium) {//ff
        this.sheets[0].media.deleteMedium(med);    
    }    
    else if (typeof this.sheets[0].media === "string")
        this.sheets[0].media = this.sheets[0].media.replace(this.regExpEscape(med, "ig"), ""); //g - quick fix for it posibly being there twice

    return this;    
},

//ie returns screen as default, others null as default
medium: function (i) {
    //shortuct to add sheet
    if(typeof arguments[0] === "string")
        return this.appendMedium(arguments[0]);    
        
    if(typeof arguments[0] === "object") {//if array
        this.each(arguments[0], function(){ _ss.appendMedium(this);});
        return this;
    }

    var media, m, arr = [];
    
    //get all into an array 
    if (typeof this.sheets[0].media === "string") {//ie stores it as a string
        media = this.trim(this.sheets[0].media);
        return media.split(",");
    }

    for(m=0; m<this.sheets[0].media.length; m++ ) 
        arr.push(this.sheets[0].media.item(m)); 
    
    //return single
    //if(typeof i == "number") return arr[i]; 
    
    return arr;     
},

//shortcut to accessing this.sheets[]
s: function(i) {
    i = typeof i === "undefined" ? 0 : i;
    return this.sheets[i];
},



/****************************/
/* INTERNAL                 */
/****************************/        
//thanks jquery 
each: function(object, callback) { //cut down on all the for()s in the rest of the funcs using return.each etc..

	if(typeof object === "function") {callback = object; object = this; }			
	var name, i = 0, length = object.length, value;	
	
	if ( length == undefined ) {
		for ( name in object )
			if ( callback.call( object[ name ], name, object[ name ] ) === false )
				break;
	} 
	else
		for ( value = object[0];
			i < length && callback.call( value, i, value, this ) !== false; value = object[++i] ){}		

	return object;
},

eachSheet: function(callback) {    
    return this.each(this.sheets, callback);
},    
    
    
//goes thru each style of each rule
//modified from jqueries each function
eachStyle: function(rule, callback) {	
	var name, s=0, length = rule.style.length, value, styles;

   /* if(rule.style.getProperty) {      //opt   
        
        for ( value = rule.style[0];
		    s < length && callback.call( value, s, value,  rule.style.getPropertyValue(rule.style[s]) ) !== false; value = rule.style[++s] ){}		
                             
    } else {  */       
    
        styles = ss(rule).getRulesAsArray();  
	    //console.log(styles);  
	    for ( name in styles ) {	        
		    if ( callback.call( styles[ name ], ++s, name, styles[ name ] ) === false )
			    break;
	    }
                  
    //} 
},

/*
//following removed because this does the same:
ss().each(function(i, rule) {    
    ss.fn.eachStyle(rule, function(si, name, value) {
        console.log(si, name, value)
    });    
});

*/

//goes thru each style of each rule
//modified from jqueries each function
eachProperty: function(object) {
	if(typeof object === "function") {callback = object; object = this; }			
	var name, i = 0, r, s, length, value, style, numRules = object.length;		
	
	//for each rule
	for(r=0; r<numRules; r++) {	
    	rule = object[r];    	
    		
    	
    	length = rule.style.length;
    	s=0;
    	for ( value = rule.style[0];
			s < length && callback.call( value, i++, rule, s, value, rule.style.getPropertyValue(rule.style[s]) ) !== false; value = rule.style[++s] ){}		
	
	}	
},

//internal
removeAllRules: function() {
    if(this.length>0) {
        this.eq(0);
        delete this[0];
    }
    return this;
},



/****************************/
/* PSUEDO    SHORTCUTS      */
/****************************/   
//just idea - automake a hover state??
hover: function(v)          {return this.copy(":hover", v);}, //copyes a rule into a :hover function for the first :hover


/****************************/
/* TEST                     */
/****************************/      

//MAKE AS PLUGIN
//very basic test animates 1 property - can only do pixel values
animate: function(property, value, time, callback) {
    this.eq(0);//restrict it to first rule    
    var fps = 30,
    frameTime = 1000 / fps,
        
    anm = setInterval(function() {        
        _ss.property(property, value, true);
        
    }, frameTime);


    //stop the animation
    setTimeout(function() {
        clearTimeout(anm);
        
        if(typeof callback === "function") callback();
        
    }, time + 100);

    return this;        
},    


//copy styles in rules list to an element
/*copyToElement: function(elem) {},        

getCascadedStyles: function(elem, property) {
},    */

/****************************/
/* UTILS                    */
/****************************/  
//ty http://lists.evolt.org/pipermail/javascript/2004-May/007112.html
trim: function( text ) {
	//return (text || "").replace( /^\s+|\s+$/g, "" ); ie5.5 doesn't like this one from jquery	
	var
         r=/^\s+|\s+$/,
         a=text.split(/\n/g),
         i=a.length;
     while(i-->0)
         a[i]=a[i].replace(r,'');
     return a.join('\n');
	
},

//console.log the object at a part of the chain
log: function(m1, m2) {
    if(this.debug) {			
        try {			   	        
            if(arguments.length > 1) console.log("~\t",  m1, m2);	 
            else if (arguments.length > 0) console.log("~\t",  m1);  
            else console.log("~\t", this); 
        }catch(e){}
    }
    return this;       
},

//returns a list of the selected rules selector text
selectorList: function() {
    var output = "";
    this.each(function() {
        output += this.selectorText+"\n";
    });
    return output;
},

//need to have one to go back to start


//escape reg exp, thanks Simon Willison:
//http://simonwillison.net/2006/Jan/20/escape/
regExpEscape:  function(text) {
  if (!arguments.callee.sRE) {
    var specials = [
      '/', '.', '*', '+', '?', '|',
      '(', ')', '[', ']', '{', '}', '\\'
    ];
    arguments.callee.sRE = new RegExp( '(\\' + specials.join('|\\') + ')', 'g' );
  }
  return text.replace(arguments.callee.sRE, '\\$1');
}



};//EO ss.prototype


//ty jQuery !!
ss.prototype.init.prototype = ss.prototype;
 
})();