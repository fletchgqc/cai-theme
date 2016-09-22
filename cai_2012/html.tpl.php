<!doctype html>
<?php $html_attr = "lang=\"$language->language\" dir=\"$language->dir\" version=\"HTML+RDFa 1.0\" $rdf_namespaces"; ?>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" $html_attr> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" $html_attr> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" $html_attr> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php print $html_attr;?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <!-- aside element compatibility for old IE browsers -->
  <script>document.createElement('aside');</script>
  
<!--  <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
  <?php print $scripts; ?>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
