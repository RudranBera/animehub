If you are wanting to block something like POP up ads or something coming from a website you are showing in an IFRAME - it's fairly easy.

Make a framefilter.php and javascriptfilter.php which your iframe points to. You can modify it to meet your needs such as the onload blah blah and etc. But as/is - it's been working fine for me for quite a while. Hope it helps.

Replace your standard IFRAME HTML with this:

    <IFRAME SRC="http://www.yourdomainhere.com/framefilter.php?furl=http://www.domainname.com" WIDTH=1000 HEIGHT=500>
If you can see this, your browser doesn't 
understand IFRAMES. However, we'll still 
<A HREF="http://www.domainname.com">link</A> 
you to the page.
</IFRAME>
Framefilter.php

        <?php

//Get the raw html.
$furl=trim($_GET["furl"]);
$raw = file_get_contents($furl);

$mydomain="http://www.animelab.netlify.app/";

//Kill anoying popups.
$raw=str_replace("alert(","isNull(",$raw);
$raw=str_replace("window.open","isNull",$raw);
$raw=str_replace("prompt(","isNull(",$raw);
$raw=str_replace("Confirm: (","isNull(",$raw);

//Modify the javascript links so they go though a filter.
$raw=str_replace("script type=\"text/javascript\" src=\"","script type=\"text/javascript\" src=\"".$mydomain."javascriptfilter.php?jurl=",$raw);
$raw=str_replace("script src=","script src=".$mydomain."javascriptfilter.php?jurl=",$raw);

//Or kill js files
//$raw=str_replace(".js",".off",$raw);

//Put in a base domain tag so images, flash and css are certain to work.
$replacethis="<head>";
$replacestring="<head><base href='".$furl."/'>";
$raw=str_replace($replacethis,$replacestring,$raw);

//Echo the website html to the iframe.
echo $raw;

?>