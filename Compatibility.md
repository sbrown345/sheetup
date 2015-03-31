# Introduction #

This table is to try and summarise what is supported and what browser quirks need to be addressed.

http://www.quirksmode.org/dom/changess.html

# Details #
| | **IE5.5** | **IE6** | **IE7** | **IE8** | **Safari 3.1** | **Firefox** | **Opera 9.6** |
|:|:----------|:--------|:--------|:--------|:---------------|:------------|:--------------|
| td, tr split up|Yes|Yes|Yes|Yes|Yes|No|Yes|




# Quirks #
"padding-right-value" is stored in firefox instead of "padding-right" E.g. if the first rule of a sheet is a padding-right, it is saved as "padding-right-value"
```
ss(sheet.cssRules)[0].style[0]
```