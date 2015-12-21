<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <div class="submitted">
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    
      require_once drupal_get_path('module', 'contact') .'/contact.pages.inc';
      print drupal_render(drupal_get_form('contact_site_form'));
    ?>
    <hr class="divider" />
    <p><img src="/files/images/cai/contact-us.gif" usemap="#map" alt="" class="standalone-image" /></p> <p><map name="map"> <area shape="rect" coords="303,2,417,109" alt="Australia" href="/contact-us/australia" /> <area shape="rect" coords="427,31,526,98" alt="USA" href="/contact-us/usa" /> <area shape="rect" coords="487,104,626,152" alt="France" href="/contact-us/france" /> <area shape="rect" coords="510,159,701,212" alt="Deutschland" href="/contact-us/germany" /> <area shape="rect" coords="527,222,698,271" alt="Schweiz / Suisse" href="/contact-us/switzerland" /> <area shape="rect" coords="509,282,669,328" alt="Polska" href="/contact-us/poland" /> <area shape="rect" coords="489,342,663,389" alt="Pоссия" href="/contact-us/russia" /> <area shape="rect" coords="469,399,608,468" alt="South Africa" href="/contact-us/south-africa" /> <area shape="rect" coords="376,403,463,493" alt="Sverige" href="/contact-us/sweden" /> <area shape="rect" coords="183,399,275,471" alt="España" href="/contact-us/spain" /> <area shape="rect" coords="78,337,224,389" alt="Italia" href="/contact-us/italy" /> <area shape="rect" coords="13,283,203,326" alt="Österreich" href="/contact-us/austria" /> <area shape="rect" coords="1,226,185,271" alt="Nederland" href="/contact-us/netherlands" /> <area shape="rect" coords="15,160,204,207" alt="New Zealand" href="/contact-us/new-zealand" /> <area shape="rect" coords="62,109,224,147" alt="Canada" href="/contact-us/canada" /> <area shape="rect" coords="140,26,292,100" alt="United Kingdom" href="/contact-us/united-kingdom" /> <area shape="rect" coords="285,405,366,491" alt="Ελλάδα" href="/contact-us/greece" /> <area shape="rect" coords="140,26,292,100" href="/contact-us/united-kingdom" alt="United Kingdom" /></map></p>
  </div>

  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
