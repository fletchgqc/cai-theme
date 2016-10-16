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
drupal_add_css(drupal_get_path('theme', 'cai_2012') . '/css/front-page-desktop.css');
drupal_add_css(drupal_get_path('theme', 'cai_2012') . '/css/front-page-mobile.css');
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

  <?php if (true): ?>

    <div id="featured">
      <div class="item">
        <h2 class="heading"><?php print t('Featured Testimony'); ?></h2>
        <img src="/<?php print $directory ?>/images/arrow-up.png" alt="See less" class="arrow arrow-up" />
        <img src="/<?php print $directory ?>/images/arrow-down.png" alt="See more" class="arrow arrow-down" />
        <?php
          $number = 1;
          $featured_testimony = nodequeue_load_back($number);
          $teaser_view = node_view($featured_testimony, 'teaser');
          print render($teaser_view);
        ?>
      </div><!-- item -->
      <div class="item">
        <h2 class="heading"><?php print t('Featured Bible Study'); ?></h2>
        <img src="/<?php print $directory ?>/images/arrow-up.png" alt="See less" class="arrow arrow-up" />
        <img src="/<?php print $directory ?>/images/arrow-down.png" alt="See more" class="arrow arrow-down" />
        <?php
          $number = 3;
          $featured_bible_study = nodequeue_load_back($number);
          $teaser_view = node_view($featured_bible_study, 'teaser');
          print render($teaser_view);
        ?>
      </div><!-- item -->
      <div class="item featured-video">
        <h2 class="heading"><?php print t('Featured Video'); ?></h2>
        <img src="/<?php print $directory ?>/images/arrow-up.png" alt="See less" class="arrow arrow-up" />
        <img src="/<?php print $directory ?>/images/arrow-down.png" alt="See more" class="arrow arrow-down" />
        <?php
          $number = 4;
          $featured_video = nodequeue_load_back($number);
          $teaser_view = node_view($featured_video, 'teaser');
          print render($teaser_view);
        ?>
      </div><!-- item -->
    </div>

    <div id="content-front"<?php print $content_attributes; ?> class="content">
      <div id="flags-box">
        <img alt="<?php print t('Flags representing the countries where Christian Assemblies International exists'); ?>" src="/files/images/cai/cai-flags.png" id="flags" 
        usemap="#map-cai-flags" />
        <map name="map-cai-flags" id="map-cai-flags">
          <area shape="rect" coords="140,1,200,37" alt="Australia" href="/" title="English" />
          <area shape="rect" coords="206,17,268,53" alt="USA" href="/"  title="English"/>
          <area shape="rect" coords="256,56,316,90" alt="France" href="/fr" title="Français" />
          <area shape="rect" coords="271,98,332,132" alt="Germany" href="/de" title="Deutsch" />
          <area shape="rect" coords="280,139,344,173" alt="Switzerland" href="/de" title="Deutsch" />
          <area shape="rect" coords="262,181,339,217" alt="Poland" href="/pl" title="Polski" />
          <area shape="rect" coords="256,224,332,257" alt="Russia" href="/ru"title="Русский язык" />
          <area shape="rect" coords="247,263,307,299" alt="South Africa" href="/" title="English" />
          <area shape="rect" coords="178,280,245,314" alt="Sweden" href="/sv" title="Svensk" />
          <area shape="rect" coords="30,264,98,298" alt="Spain" href="/es" title="Español" />
          <area shape="rect" coords="8,224,86,255" alt="Italy" href="/it" title="Italiano" />
          <area shape="rect" coords="2,179,76,214" alt="Austria" href="/de" title="Deutsch" />
          <area shape="rect" coords="0,140,60,174" alt="Netherlands" href="/nl" title="Nederlands" />
          <area shape="rect" coords="5,99,68,133" alt="New Zealand" href="/"  title="English" />
          <area shape="rect" coords="22,56,84,91" alt="Canada" href="/"  title="English" />
          <area shape="rect" coords="69,16,135,53" alt="Great Britain" href="/"  title="English" />
          <area shape="rect" coords="99,277,169,313" alt="Greece" href="/el" title="ελληνικά" />
        </map>
        <div id="associated-churches">
          <p><?php print t('Associated Churches'); ?></p>
          <!-- print Uster flag image without link due to 1335.com no longer online -->
          <img alt="<?php print t('Flag of Ulster'); ?>" src="/files/images/flags/ulster-flag.png"/>
          <!-- original code <a href="http://www.1335.com/"><img alt="<?php print t('Flag of Ulster'); ?>" src="/files/images/flags/ulster-flag.png"/></a> -->
          <a href="<?php print cai_2012_get_malawi_url(); ?>"><img alt="<?php print t('Flag of Malawi'); ?>" src="/files/images/flags/malawi-flag.png"/></a>
          <a href="http://rcichurch.webnode.com/"><img alt="<?php print t('Flag of Pakistan'); ?>" src="/files/images/flags/pakistan-flag.png"/></a>
        </div>
      </div>
  <?php else: ?>
    <div class="content"<?php print $content_attributes; ?>>
  <?php
    endif;
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    print render($content);
  ?>
    </div>

  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>