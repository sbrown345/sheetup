//original load simple script
//javascript:tEdPath='http://localhost/ted/';var%20scr=document.createElement('script');scr.setAttribute('src','http://localhost/ted/ted2.js');document.getElementsByTagName('head')[0].appendChild(scr);void(0);



//http://www.moxleystratton.com/article/javascript/bookmarklets/compiler
//http://userjs.up.seesaa.net/js/bookmarklet.html
//new double click one

var bookyDefaults = "Firebug, jQuery";

function loadScript(url, callback) {
    url = typeof url === "undefined" ? 'http://localhost/booky/bookywooky.js' : url;
    var scr=document.createElement('script');
    scr.setAttribute('src', url);
    document.getElementsByTagName('head')[0].appendChild(scr);
}
if(typeof bookyStatus === 'undefined') {   
    var bookyStatus = 'waiting2ndclick';
    
    var bookyFunc1 = window.setTimeout(function() { 
        bookyStatus = 'loading1';
        loadScript('http://localhost/booky/bookywooky.js');
        
    }, 200);
    
} else if (bookyStatus === 'waiting2ndclick') {    
    window.clearTimeout(bookyFunc1);
    bookyStatus = 'loading2';
    loadScript('http://localhost/booky/bookywooky.js');    
    
} else {alert('Loaded already');}
void(0);


//could it see what keys are pressed.......e.g. on 2nd click could check if control is presed