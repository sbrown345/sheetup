# Introduction #

sheetUp attempts to simplify the manipulation of DOM Stylesheets. It should only require a line of simple code to add/remove/edit a few rules of a DOM stylesheet.


# Getting Started #

## Adding a Rule ##
To have a quick test of sheetUp paste the following code into your webpage.
```
<script src="sheetup.js" type="text/javascript"></script>   
<script type="text/javascript"> 
   window.onload = function() {

      ss("body{font-size:200%;}");  

  
   };  
</script>
```

This will simply add the CSS rule `body{font-size:200%;`}

## Selecting Rules ##

The `ss()` is a chainable function so we can initialise it with a search string to select rules. For instance we may want to select all rules with `table` in their selector text. The following code will do just that.

```
   ss("table");
```

## Method Chaining ##

This isn't very useful at the moment but we can chain it with another function. This selects all the rules whose selectors contain `table` and changes all their border properties to `solid 1px #333`.

```
   ss("table").property("border", "solid 1px #333");
```

With method chaining we can quickly manipulate the DOM stylesheet in a bunch of ways. Here's a final example for this wiki section.

```
ss(".cssarray{}")                   //add new rule .cssarray
    .find(".cssarray")              //filter out the rule
    .property( {                    //set a load of styles on this rule
        "background":   "black", 
        "color":        "white",
        "padding":      "10px",
        "float":        "right"
    })
    .end()                          //reset the selection back to the start (select all rules)
    .add("pre")                     //add a new style pre{}
    .find("pre")                    //find it
    .property("color", "gray");     //and set a single property for it
    .end()                          //reinit and find #element rules
    .remove()                       //delete all rules with #element as their selector
```