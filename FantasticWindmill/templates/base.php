<?php
// We first include a couple of user-defined functions that our template
// files will use
include_once("user-defined.php");
require_once("code-processing.php");
?>
<!DOCTYPE html>
<html lang="en-us">
<?php
$body = $page->dom->getElementsByTagName("body")->item(0);
$heading1 = $page->dom->getElementsByTagName("h1")->item(0);

// Show page heading 1 as level 2
if ($heading1)
{
  $heading = $heading1->C14N();
  $heading = preg_replace("/\\bh1\\b/", "h2", $heading);
  $heading1->parentNode->removeChild($heading1);
}
$content = demote_headers(get_inner_html($body));
$content = insert_code_snippets($content);
$content = resolve_javadoc($content);
?>

  <?php include("header.php"); ?>

  <body>
  
  <div id="wrapper">		
    <main>
    <div id="content">
    <div class="innertube">
      <?php echo $heading; ?>
      <?php echo $content; ?>
    </div>
    </div>
    </main>


    <nav id="nav">
    <div class="innertube">
    <?php include("sidebar.php"); ?>
    </div>
    </nav>
    

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  // tracker methods like "setCustomDimension" should be called before "trackPageView"
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//leduotang.ca/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '4']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

</div>
</body>
</html>