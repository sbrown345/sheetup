# Introduction #

Shortcuts to useful DOM functions.


# Shortcuts #

## Access document.styleSheets ##
`ss.ds` points to document.styleSheets.
```
console.log(ss.ds);
```
## Access ss().sheets ##
Access the selected stylesheets for that ss() object.
```
ss().s();  //access ss().sheets[0];
ss().s(3); //access ss().sheets[3]; 
```

## Selector Text ##
Access the first selected rules selectorText
```
ss().selectorText();
```


## getSheet(title) ##

Get a sheet in the `document.styleSheets` array.

```
var ss = ss().getSheet("myTitle");
```