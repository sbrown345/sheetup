# Introduction #

All functions that are not intended for real use can be documented here.


# Animate #
This function simply increments a property over a given period of time. It can be chained to do multiple animations on a css rule at a time. The following moves a blue box for a second by incrementing the `left` and `top` properties by 1 on each frame.




```
<style type="text/css">
   .moving     {position:absolute;top:0px;left:0px;background:blue;color:white;}
</style>

<div class="moving">.moving</div>

<script type="text/javascript">
   ss(".moving")
       .animate("left", 1, 1000)
       .animate("top", 1, 1000);
</script>
```