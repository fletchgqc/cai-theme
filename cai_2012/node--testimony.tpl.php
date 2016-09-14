<?php
  /* preparation - for page or teaser display  */
  // get author's name and location details from the node
  $first_name_items = field_get_items('node', $node, 'field_author_first_name');
  $first_name = $first_name_items[0]['safe_value'];
  $l10n_first_name_items = field_get_items('node', $node, 'field_l10n_author_first_name');
  $l10n_first_name = $l10n_first_name_items[0]['safe_value'];
  $qualifications_items = field_get_items('node', $node, 'field_author_qualification');
  $qualifications = $qualifications_items[0]['safe_value'];
  $city_items =  field_get_items('node', $node, 'field_author_city');
  $city = $city_items[0]['safe_value'];
  $country_items = field_get_items('node', $node, 'field_author_country');
  $country = $country_items[0]['safe_value'];
  // author's native language - used in searching for videos
  $author_native_language_items = field_get_items('node', $node, 'field_author_native_language');
  $author_language = $author_native_language_items[0]['safe_value'];

  // Media (images, video) relating to this testimony is named after the English node ID.
  if (empty($node->tnid)) {
    // tnid is blank when there are no translations, so use the nid.
    $media_name = $node->nid;
  } else {
    $media_name = $node->tnid;
  }

  // build author's name, qualifications, location as formatted string
  // if a localized name was entered, use that
  if ($l10n_first_name) {
    $author_details = $l10n_first_name;
  } else {
    $author_details = $first_name;
  }

  if (!empty($qualifications)) {
    $author_details .= ", $qualifications";
  }
  // to temporarily remove the location the following lines have to be commented out
  if (!empty($country)) {
    $author_details .= " - ";
  }
  if (!empty($city)) {
    $author_details .= "$city, ";
   }
  if (!empty($country)) {
    $author_details .= "$country";
   }

  //if only the city should not be mentioned as location, the following lines can be used
  //if (!empty($country)) {
  //$author_details .= " - $country";
  //}
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page):
      // print title and video image if applicable. The reason for some of the strange separation of
      // tags/angle-brackets over lines is so that a space is not created by the line break ?>
      <h2<?php print $title_attributes; ?>
        ><a href="<?php print $node_url; ?>"><?php
          print $title;
          if (!empty($html5_video)) {
            ?><img class="video-icon" alt="video icon" src="/<?php print $directory ?>/images/video-icon.png" height="20" width="16" title="<?php print t('Video available') ?>"/><!-- video icon thanks to Shubham Mishra --><?php
          }
        ?></a
      ></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php if (!$page) { ?>
      <a href="<?php print $node_url ?>"><img src="/files/images/testimonies/<?php print $media_name ?>-thumb.jpg" alt="<?php print t('Photo of @name', array('@name' => $first_name)); ?>" width="100" class="image-left" /></a>
    <?php } ?>
    <p class="testimony-author"><?php print $author_details ?></p>
    <?php if ($page) {
      drupal_add_css(path_to_theme() . '/css/testimony.css');

      $video_markup = cai_2012_vimeo_video($node);
      if (empty($video_markup)) {
        // Second param is whether to preload video, i.e. if teaser don't preload because there are heaps on one page
        $video_markup = cai_2012_html5_video($node, $page);
      }
      print $video_markup;
    ?>

      <div class="testimony-pics">
        <img src="/files/images/testimonies/<?php print $media_name ?>-1.jpg" alt="<?php print t('Photo of @name', array('@name' => $first_name)); ?>" width="300" class="first"/>
        <?php // add any additional photos (maximum 8)
        for ($i = 2; $i < 10; $i++) {
          // look for images according to naming convention and insert them, until one is not found
          $next_photo = "/files/images/testimonies/" . $media_name . "-" . $i . ".jpg";
          if (file_exists($next_photo)) { ?>
            <img src="<?php print $next_photo ?>" alt="Photo of <?php print $first_name ?>" width="300"/>
    <?php } else {
            // photo not found - no more photos exist
            break;
          }
        } ?>
      </div>
  <?php
    } // end if ($page)
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>
  <?php
  if ($page) {
    print render($content['links']);

      // Get taxonomy tags that this node is tagged with. Taxonomy vocabularies are treated like fields.
      $terms = field_view_field('node', $node, 'taxonomy_vocabulary_2');
      foreach ($terms['#items'] as $item) {
        $term = $item['taxonomy_term']; ?>
      <h3 id="related-content"><?php print t('Other Testimonies About @theme', array('@theme' => $term->name)); ?></h3>
      <?php print views_embed_view('ordered_taxonomy_term', 'block', $term->tid, $node->nid);
    }
  }

  print render($content['comments']);
  ?>

</div>
