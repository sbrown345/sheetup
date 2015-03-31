# Introduction #

This is simply a jQuery like shortcut to extending the core.


# ss.fn #
`ss.fn` is a shortcut to `ss.prototype`.
```
ss.fn.test = function(msg) {
   alert(msg); 
   return this;   //return the ss function so it's chainable
};

ss().test("Hellow World!");
```


# Operating on the selected rules #
This uses the internal `each()` function to operate on every selected rule. This function outputs the selector text of each rule.
```
    ss.fn.displaySelectorText = function() {
    
       return this.each(function() {    
          alert(this.selectorText);
       });   
    };
    ss("div").displaySelectorText();
```