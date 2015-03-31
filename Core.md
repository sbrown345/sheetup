# Introduction #

The `ss()` core function accepts a variety of diferent arguments that ditermine the initial action. It is an object storing an array references all the selected rules.


# Arguments #

## None ##
```
ss();
```

The default action will be to select all the rules in all the stylesheets.


## Regexp ##
```
ss(/.class/);
```

If we add a Regular Expression as an argument sheetUp will find any rules whose selector text match the Regexp.


## String ##
A string can cause sheetUp to function in two seperate ways.

### Selector ###
```
ss(".class");
```

> The first will be similar to the Regexp, it will find rules that contain the string in thier selector text. The above will select any rules with .class in their selector text, for instance `#container .class` will be selected as will `.classTable`. They will selected for future manipulation.


### Stylesheet Context ###
A shortcut for searching a particular stylesheet.
```
var stylesheet = document.styleSheets[2];
ss(".selector", stylesheet);          //only look within the 3rd stylesheet
ss(".selector", [ss.ds[0], ss.ds[2]]);//only look within the 1st and 4th stylesheets
ss(undefined, [  ss.ds[0], ss.ds[2]]);//select all rules from 1st and 4th stylesheets
ss(".selector", "title");             //get stylesheet by title
ss
```



### New Rule ###
```
ss("body{font-size:200%;}");
```

This argument will add a new rule `body{font-size:200%;`} to the main stylesheet.


## Stylesheet ##
```
ss(document.styleSheets[1]);
```

The above function only selects all rules from a certain stylesheet, in this example the second stylesheet. It completely ignores rules from other stylesheets. Any rules added after would be added to this selected sheet.

## Rules Object ##
```
ss(document.styleSheets[0].rules || document.styleSheets[0].cssRules);
```

In this instance it selects all the rules from a CSSRuleList object.

## DOM Element ##
```
ss(document.getElementById("testDiv"));
```

Not yet implemented.


# find() #
The core function uses find() to narrow rule searches. The following two would return the same results:

```
ss(".classToFind");
ss().find(".classToFind");
```



# init() #
The main `ss()` actually returns the `init()` function. It can be called to reinit the sheetUp object during a chain operation.

# end() #
This function reverses the selection to a previous find state.


```
//select all 'span' rules and then select everything again
ss().find("span").end();

//select all 'div' rules, and then search in that result for 
//'span' rules, then revert the selection back to 'div'
ss().find("div").find("span").end();

```