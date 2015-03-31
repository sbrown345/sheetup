# Introduction #

sheetUp provides a few functions for removing and adding new stylesheets.

# Add/Remove Stylesheets #
## newSS ##
A string containing css rules will be added to the document as a stylesheet object.
```
ss().newSS(".newss1{color:red;background:#ddd;}   .newss2  {font-style:italic}")
ss().newSS(".newss1{}", "Style sheet title"); //Give it a title

ss().newSS("cssfile.css"); //External sheet
ss("cssfile.css");         //or simply
```
Due to a work around needed with adding a new stylesheet in Mozilla this does not return itself for now. One work around is this:
```
ss("ext.css");                             //load file
setTimeout( function(){ss("ext.css")}, 1); //now accessible: select rules in ext.css

```
The second argument will only select the stylesheet because it has already been added to the page.


~~If you add a stylesheet, it and its rules will be selected ready for manipulation.~~




## removeSS ##
Remove a stylesheet from the DOM.
```
ss(document.styleSheets[1]).removeSS();  //select the first stylesheet, then remove it
ss().removeSS("title");                  //remove stylesheets with that have that title
ss().removeSS(1);                        //remove document.styleSheets[1]
```





# Toggling #

## switchSS ##
Disable all other stylesheets while enabling a select one, either by it's index in the `document.styleSheets` array or by its title.
```
ss().switchSS(1);  
ss().switchSS("title");                 
```
This function uses the following functions:
```
enableSS(0);   //enable the first selected stylesheet
disableSS(0);  //disable the first selected stylesheet
toggleSS(0);   //toggle whether a stylesheet is enabled or disabled
```



# Mediums #
For using mediums such as "screen" and "print" there are a few helper functions. They help on the objects first selected stylesheet.
```
ss().appendMedium("screen");        //append the medium screen to the first stylesheet
ss().deleteMedium("print");         //delete the medium print form the first stylesheet
ss().medium();                      //return an array of the mediums
ss().medium()[1];                   //return the second medium of the array
ss().medium("print");               //add print
ss().medium(["handheld", "print"]); //add print and handheld
```

# Other #

Get sheet by title -- returns first stylesheet from document.styleSheets with that title.
```
ss().getSheet("title");
```

Ignore stylesheets on the page with:
```
ss.fn.ignore = [ss.ds[0], ss.ds[1]];
```
Now these two are ignored by default but it is possible to access them by explicitly using them in context. e.g. `ss(".class", ss.ds[0]`

Note #Firebug rules are ignored.

Todo: allow passing of stylesheet objects in.