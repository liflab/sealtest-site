<?php
// We first include a couple of user-defined functions that our template
// files will use
include_once("user-defined.php");
?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">

  <!-- Enable responsiveness on mobile devices-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="author" content="<?php echo $page->data["site"]["author"]; ?>" />
  <title><?php echo $page->data["title"]; ?> - <?php echo $page->data["site"]["name"]; ?></title>
  
  <!-- CSS -->
  <link rel="stylesheet" href="/css/syntax.css">
  <link rel="stylesheet" href="/css/screen.css">
  
  <!-- Syntax highlighting -->
  <link rel="stylesheet" href="/assets/js/styles/default.css" />
  <script src="/assets/js/highlight.pack.js"></script>
  <script>hljs.initHighlightingOnLoad();</script>

  <!-- RSS -->
  <!-- <link rel="alternate" type="application/rss+xml" title="RSS" href="/atom.xml"> -->
</head>