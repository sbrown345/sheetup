//http://userjs.up.seesaa.net/js/bookmarklet.html#
if(typeof bookyStatus === "undefined") {   
    var bookyStatus = "waiting2ndclick";
    
    var bookyFunc1 = window.setTimeout(function() { 
        bookyStatus = "loading1";






        
    }, 200);
    
} else if (bookyStatus === "waiting2ndclick") {    
    window.clearTimeout(bookyFunc1);
    bookyStatus = "loading2";


    
    
}
void(0);

