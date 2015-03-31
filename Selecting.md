# Introduction #

How to select stylesheet rules for the other functions to use.


# Find #
```
ss().find(".class");             //all rules with selector text containing ".class"
ss().find(".class").find("span");//narrow the last line's result to ones containing "span"
ss().find(/class/);              //Rules whose text matches the regular expression /class/.

//searches any rules with   term1 term2 and term3 in e.g.  div.term1 span.term2 #term3
//selects whole words only e.g. span won't match span.class
ss().find("--term1 term2 term3"); 
```


# slice #
Narrow the selected rules to a particular index or indicies. The following will only select the second rule and the one after will return the third, fourth and fifth rules.
```
ss().slice(1);
ss().slice(2, 4); 


ss().eq(1); //get the first element
ss().eq(-1); //get the last element

```



# push #
Add more rules to the selection. Works with any array of rules.
```
ss("div.subtitle").push(".title");
var titles = ss("div.title");
ss("h1").push(titles);
```

## merge ##
## unique ##


# getAffectingRules #
We can select rules according to which styles affect them.
```
ss(document.getElementById("header")).getAffectingRules();
ss(document.getElementById("header")); //shortcut
```