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
      $name_items = field_get_items('node', $node, 'field_name');
      if ($name_items) print $name_items[0]['value'] . '<br/>';
      
      $po_box_line_items = field_get_items('node', $node, 'field_po_box_line');
      if ($po_box_line_items) print $po_box_line_items[0]['safe_value'] . '<br/>';
      
      $line_2_items = field_get_items('node', $node, 'field_line_2');
      if ($line_2_items) print $line_2_items[0]['safe_value'] . '<br/>';
      
      $line_3_items = field_get_items('node', $node, 'field_line_3');
      if ($line_3_items) print $line_3_items[0]['safe_value'] . '<br/>';
      
      $country_items = field_get_items('node', $node, 'field_country');
      print strtoupper(t($country_items[0]['value'])) . '<br/>';
                                                                   
      $phone_number_items = field_get_items('node', $node, 'field_phone_number');
      if ($phone_number_items) print t('Phone: ') . $phone_number_items[0]['safe_value'] . '<br/>';
    ?>
  </div>

  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
