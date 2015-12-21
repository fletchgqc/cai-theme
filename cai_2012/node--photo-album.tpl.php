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
 
drupal_add_css($directory . '/smoothgallery/css/jd.gallery.css');
drupal_add_js($directory . '/smoothgallery/scripts/mootools.v1.11.js');
drupal_add_js($directory . '/smoothgallery/scripts/jd.gallery.js');
drupal_add_js($directory . '/smoothgallery/scripts/custom.js');
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
    ?>  
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td>
          <div id="myCarousel" class="jdGallery" style="visibility:hidden">
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="myGallery" style="display: none;" >           
          <?php
            // the number of photos is assumed to be equal to the number of info captions added
            $photo_info_items = field_get_items('node', $node, 'field_photo_info');
            $photo_count = count($photo_info_items);
            $path_items = field_get_items('node', $node, 'field_path');
            $album_path = "/files/images/photo-albums/" . $path_items[0]['safe_value'];
            for ($i = 0; $i < $photo_count; $i++) {
              // normally safe_value would be used but that renders ' as "&039;", and the semicolon affects the result of the explode() function
              $photo_details = explode(";", $photo_info_items[$i]['value']);
              $count_photo_details = count($photo_details);

              $description = trim($photo_details[0]); // main caption of the photo
              $location = $count_photo_details > 1 ? trim($photo_details[1]) : '';
              $date = $count_photo_details > 2 ? trim($photo_details[2]) : ''; ?>
              <div class="imageElement">
                <h3><?php print $description ?></h3>
                <p><?php 
                  // build a nicely formatted string containing whatever location and date information is available.
                  $img_info = "";
                  $img_info .= $location;
                  if (!empty($location) && !empty($date)) {
                    $img_info .= " - ";
                  }
                  $img_info .= "$date";
                  print $img_info;
                  print "<!-- fc1 image info: " . $img_info . " -->";
                ?></p>

                <a href="javascript:togglePause()" title="pause/play slideshow" class="open"></a><?php // pause function ?>
                <img src="<?php print $album_path . '/pic_' . ($i + 1) . '.jpg' ?>" class="full" alt="<?php print $description ?>"/>
                <img src="<?php print $album_path . '/thumbnails/pic_' . ($i + 1) . '-thumb.jpg' ?>" class="thumbnail" alt="<?php print $description ?>"/>
              </div>
      <?php } ?>  
          </div> 
        </td>
      </tr>  
    </table>
    <div class="pause"><?php print t('Click on picture to pause and resume') ?></div>
  </div>
  
  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
