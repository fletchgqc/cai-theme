<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
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
      
      // get path to pdf sheet to link to it
      if ($page) {
        // categories are stored as A1,A2,B,C,D,NI1,NI2,DW1,DW2
        // so we just grab the first letter for the sheet reference
        $category_items = field_get_items('node', $node, 'field_category');
        $category = strtolower($category_items[0]['value']);
        
        if (strlen($category) > 1 && ($category[1] === 'i' || $category[1] === 'w')) {
          $category_letter = $category[1];
        } else {
          $category_letter = $category[0];
        }
        
        $country_code = $node->language;
        if ($country_code === 'en') {
          $country_code = 'au';
        }
  
        // format the theme sheet number to be a 4-digit number, even if it begins with zeros
        $sheet_number_items = field_get_items('node', $node, 'field_sheet_number');
        $sheet_number = sprintf("%04u", $sheet_number_items[0]['value']);
        $pdf_link = file_stream_wrapper_get_instance_by_uri(file_build_uri("/theme-sheets/$language/$category/s{$category_letter}{$sheet_number}{$country_code}.pdf"))->realpath();
        $pdf_link = file_create_url(file_build_uri("/theme-sheets/$language/$category/s{$category_letter}{$sheet_number}{$country_code}.pdf"));
  
        // apply the correct id to the PDF div, depending on whether a user has ticked the "start content below PDF link" box
        $content_below_pdf_link_items = field_get_items('node', $node, 'field_content_below_pdf_link');
        $content_below_pdf_link = $content_below_pdf_link_items[0]['value'];
        $pdf_link_id = $content_below_pdf_link == 1 ? "standalone-pdf-link" : "pdf-link";
        
    ?>  
    <div id="<?php print $pdf_link_id ?>"><a href="<?php print $pdf_link ?>" id="pdf-img-link"><img src="/files/images/icons/pdficon_small.gif" alt="PDF icon"/></a><a href="<?php print $pdf_link ?>"><?php print t('Printable PDF Version'); ?></a></div>
    <?php
	    }
      
      print render($content);
    ?>
  </div>
  <?php
  if ($page) {
    print render($content['links']);
    
    // Get taxonomy tags that this node is tagged with. Taxonomy vocabularies are treated like fields.
  	$terms = field_view_field('node', $node, 'taxonomy_vocabulary_3');
  	foreach ($terms['#items'] as $item) {
      $term = $item['taxonomy_term']; ?>
		<h3 id="related-content"><?php print t('Other Bible Studies About @theme', array('@theme' => $term->name)); ?></h3>
		<?php print views_embed_view('ordered_taxonomy_term', 'block', $term->tid, $node->nid);
	  }
  }
  
  print render($content['comments']);
  ?>
  
</div>
