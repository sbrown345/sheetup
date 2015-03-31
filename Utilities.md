# Introduction #




# Each #
This is the jQuery each function that applies a function to each element of the array. It defaults to the ss objects array of selected rules. The following code goes through each of the selected rules applying two styles to the rules and logging out to Firebug's console.

```
ss(".ruleobject").each(function(i, rule) {
   log("Index " + i + " Rule", rule);
   ss(this).property("color", "green");
   ss(this).property("text-decoration", "underline");        
});
    
```

Any array can be put it as the first argument. The following will output each element of the array.
```
var array  =  [1,2,3];
ss(".ruleobject").each(array, function(i, rule) {
   log(this);    
});

```

# Each Sheet #
A shortcut to operating on each of the selected sheets (`ss().sheets`.)
```
ss(".ruleobject").eachSheet(function(i, sheet) {
    log(sheet);
});
```

# Each Style #
With this we can iterate through each style in the list of rules. This could be useful for building a list of the current rules and their styles.

_i_: index, _rule_: rule object, _si_: style index, _name_: style name e.g. color and _value_: style value e.g. "red".
```
//log out all the info and set every style of every rule to "inherit"
ss().each(function(i, rule) {    
    ss.fn.eachStyle(rule, function(si, name, value) {
        console.log(i, si, name, value);
        ss(rule).property(name, "inherit");
    });    
});
```


# Debug #
The logging function uses Firebug's console.log function (Safari can also see these msgs.) The following two lines in ensures the debugging display is on and prints out the object for inspection in Firebug's console. The next one debugs at variouis points in the chain and adds a message on each one. Currently, there are also preset debugging messages saying generally what is going on internally.
```
ss.fn.debug = true;
ss().log();
ss().find("div").log("Divs selected: ").find("spans").log("Spans selected");
```