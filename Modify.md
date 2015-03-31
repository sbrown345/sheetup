# Introduction #

This section explains how to manipulate the selected stylesheets using functions such as `remove()` and `property()`.

# Modifying Rules #

## Add ##
Add a rule.

Currently only takes one rule at a time. To add multiple rules add a new stylesheet with `newSS()`.
```
ss().add(".green{color:green}");
ss().add(".green{color:green}", false);  //do not add rule to current selection
ss().add(".green{color:green} #anotherstyle{background:black;}", false);
```


## Remove ##
Removes all selected rules from the stylesheet.
```
ss(".green").remove();
```

## Get rule text ##
Return selected rules as text.
```
ss("div").text();
/*
Returns:
div { } 
div span { } 
div span a { text-decoration: none; } 
*/
```

## Set rule text ##
```
ss("span").text("color: yellow;   background: black;");
```

# Modifying Properties #

## Property ##
Return a property value as text:
```
ss(".green").property('font-weight');
```

Set a single or multiple properties of the selected rules like so:
```
ss(".green").property("background-color: red;");

ss(".green").property({'font-weight': 'bold', 'float': 'right'});


//remove single or list of properties
ss(".green").removeProperty('background-color');
ss(".green").removeProperty(['font-weight', 'float;]});

```




## getComputedStyle ##
This is the same as passing an element into the `ss()` function.
```
var elem = document.getElementById("testDiv");
ss().getComputedStyle(elem);       //return a computed rules object
ss().getComputedStyle(elem).color; //returns the computed colour of the object
```

## getRulesAsArray ##
Returns an associative array of the properties in the selected rules. If there are multiple rules with the same selector name the first one will be overwriten.
```
ss("moving").getRulesAsArray();
```



## getProperties ##
todo








## Copy styles ##
```
ss(".rule1").copyStyles(["color", "border"], ".rule2"); //copies select styles to .rule2
ss(".rule1").copyStyles(".rule2");                      //copies all styles to .rule2
```






# Shortcuts #
## Copy ##
Copies the first selected rule into a new rule with the specified new selector.
```
ss().copy(".greenAndRed");
```
## Rename ##
Renames the first selected rule with the specified new selector.
```
ss().rename(".greenAndRed");
```