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
      $country_items = field_get_items('node', $node, 'field_country');
      $country = $country_items[0]['value'];
    ?>
    <img src="/<?php print "$directory/images/contact-us/" . strtolower($country); ?>.gif" alt="Flag of <?php print ucfirst(strtolower($country)); ?>"/>
    <p id="contact-email"><?php print l('<img src="/'. $directory . '/images/contact-us/email.png" alt="Contact us via email"/>' . t('Contact any city via email'), 'contact', array('html' => true));?></p>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
      print views_embed_view('contact_addresses_in_country', 'block_1', $country);
    ?>
  </div>
  
  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
