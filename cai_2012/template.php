<?php
function cai_2012_contact_map_page() {
  require_once drupal_get_path('module', 'contact') .'/contact.pages.inc';
  $result = drupal_render(drupal_get_form('contact_site_form'));
  $result .= '<hr class="divider" />';
  // note: it doesn't make sense to manually maintain the link maps in every language. Since they're there, we've left them,
  // but when the map changes (i.e. a country is added) we create the internationalised map in this function and supply it from here.  
  // i.e. do this, but with internationalised links:
  // $result .= '<p><img src="/files/images/cai/contact-us.gif" usemap="#map" alt="" class="standalone-image" /></p> <p><map name="map"> <area shape="rect" coords="303,2,417,109" alt="Australia" href="/contact-us/australia" /> <area shape="rect" coords="427,31,526,98" alt="USA" href="/contact-us/usa" /> <area shape="rect" coords="487,104,626,152" alt="France" href="/contact-us/france" /> <area shape="rect" coords="510,159,701,212" alt="Deutschland" href="/contact-us/germany" /> <area shape="rect" coords="527,222,698,271" alt="Schweiz / Suisse" href="/contact-us/switzerland" /> <area shape="rect" coords="509,282,669,328" alt="Polska" href="/contact-us/poland" /> <area shape="rect" coords="489,342,663,389" alt="P?????" href="/contact-us/russia" /> <area shape="rect" coords="469,399,608,468" alt="South Africa" href="/contact-us/south-africa" /> <area shape="rect" coords="376,403,463,493" alt="Sverige" href="/contact-us/sweden" /> <area shape="rect" coords="183,399,275,471" alt="España" href="/contact-us/spain" /> <area shape="rect" coords="78,337,224,389" alt="Italia" href="/contact-us/italy" /> <area shape="rect" coords="13,283,203,326" alt="Österreich" href="/contact-us/austria" /> <area shape="rect" coords="1,226,185,271" alt="Nederland" href="/contact-us/netherlands" /> <area shape="rect" coords="15,160,204,207" alt="New Zealand" href="/contact-us/new-zealand" /> <area shape="rect" coords="62,109,224,147" alt="Canada" href="/contact-us/canada" /> <area shape="rect" coords="140,26,292,100" alt="United Kingdom" href="/contact-us/united-kingdom" /> <area shape="rect" coords="285,405,366,491" alt="????da" href="/contact-us/greece" /> <area shape="rect" coords="140,26,292,100" href="/contact-us/united-kingdom" alt="United Kingdom" /></map></p>';
  return $result;
}

/**
 * Give the banner menu (contact us menu) the id "left-menu" so it's styled like the secondary links menu
 */ 
function cai_2012_menu_tree__menu_banner_menu($variables){
  return '<ul id="left-menu">' . $variables['tree'] . '</ul>';
}

/*
 *  Preprocess page.tpl.php to inject the $search_box variable back into D7.
 *  http://drupal.stackexchange.com/questions/10282/how-can-i-insert-search-box-in-page-tpl 
 */
function cai_2012_preprocess_page(&$variables){
  $search_form = drupal_get_form('search_form');
  $variables['search_box'] = drupal_render($search_form);
}

function cai_2012_get_malawi_url() {
  return cai_2012_get_url(2033);
}

function cai_2012_get_contact_us_url() {
  return cai_2012_get_url(2164);
}
                                        
/*
 * Get the url to this node in the current language
 *  
 * $nid_en - the nid of the target node in English 
 */  
function cai_2012_get_url($nid_en) {
  global $language;
  $lang_code = $language->language;
  $nid_local = $nid_en;
  $url = '/';
  if ($lang_code == 'en') {
    $url .= drupal_get_path_alias("node/$nid_local", $lang_code);
  } else {
    $translations = translation_node_get_translations($nid_en);
    if (array_key_exists($lang_code, $translations)) {
      $nid_local = $translations[$lang_code]->nid;
      $url .= "$lang_code/";
      $url .= drupal_get_path_alias("node/$nid_local", $lang_code);
    } else {
      $url = '#';
    }
  }
  return $url;
}

function cai_2012_get_translation_links($node) {
  // by iterating $active_languages instead of $translations we maintain the correct order of the languages
  $results = array();
                                                                                        
  $active_languages = language_list();
  
  if ($translations = translation_node_get_translations($node->tnid)) {
    foreach ($active_languages as $lang_code => $language) {
      if (isset($translations[$lang_code])) {
        $system_path = 'node/' . $translations[$lang_code]->nid;
        
        if ($lang_code === 'en') {
          $href = "/" . drupal_get_path_alias($system_path, $lang_code);
        } else {
          $href = "/$lang_code/" . drupal_get_path_alias($system_path, $lang_code);
        }
        $links = array('lang_code' => $lang_code,
                       'native' => $language->native,
                       'href' => $href);
        $results[] = $links;
      }
    }
  } else {
    // there are no translations of this page
    global $language;
    $lang_code = $language->language;
    if ($lang_code === 'en') {
      $href = "/" . drupal_get_path_alias();
    } else {
      $href = "/$lang_code/" . drupal_get_path_alias();
    }
    $links = array('lang_code' => $lang_code,
                   'native' => $language->native,
                   'href' => $href);
    $results[] = $links;
  }
  
  return $results;  
}

function cai_2012_form_search_block_form_alter(&$form, &$form_state) {
    unset($form['search_block_form']['#title']);
}

function cai_2012_preprocess_search_result(&$variables) {
  // Remove user name and modification date from search results
  // Removing just the user name is documented here, deemed too complicated http://data.agaric.com/preprocess-from-module-removing-content-author-from-drupal-7-search-results
  $variables['info'] = '';
}

/**
 * Removes the "homepage" field on the comments form
 */ 
function cai_2012_form_comment_node_testimony_form_alter(&$form, &$form_state) {
  $form['author']['homepage']['#access'] = FALSE;
}


/**
 * The old code to get an HTML5 video with Video.js. Not in use but worth keeping because it supported multiple <track> (subtitle) elements.
 * If flowplayer one day supports these, we could re-utilise the code.
 */
function cai_2012_html5_video($node, $preload = true) {
  $markup = '';

  $mp4_items = field_get_items('node', $node, 'field_mp4');
  $mp4_url = $mp4_items ? file_create_url($mp4_items[0]['uri']) : false;
  $thumbnail_items = field_get_items('node', $node, 'field_video_thumbnail');
  $thumbnail_markup = $thumbnail_items ? ' poster="' . file_create_url($thumbnail_items[0]['uri']) . '"': '';
  

  // For each language:
  //  If there is no video set yet, set the mp4 video (note it will get set in code above if there is a video in the current language)
  //  If there are subtitles, add them as an option
  $active_languages = language_list();
  $subtitles_markup = '';
  if (($node->tnid) && $translations = translation_node_get_translations($node->tnid)) {
    foreach ($active_languages as $lang_code => $language) {
      if (isset($translations[$lang_code])) {
        $tnode = node_load($translations[$lang_code]->nid);

        if (!$mp4_items) {
          $mp4_items = field_get_items('node', $tnode, 'field_mp4');
          $mp4_url = $mp4_items ? file_create_url($mp4_items[0]['uri']) : false;
        }
        $subtitles_items = field_get_items('node', $tnode, 'field_video_subtitles');
        if ($subtitles_items) {
          $subtitles_markup .= '<track kind="subtitles" srclang="' . $tnode->language . '"' .
              ' src="' . file_create_url($subtitles_items[0]['uri']) . '" label="' . $language->native . '"';
          if ($node->language == $tnode->language) {
            $subtitles_markup .= ' default';
          }
          $subtitles_markup .= '/>' . "\n";
        }
      }
    }
  }

  if ($mp4_url) {
    $videojs_path = libraries_get_path('video-js') . '/';
    drupal_add_css($videojs_path . 'video-js.css');  
    drupal_add_js($videojs_path .  'video.js', array('scope' => 'header', 'group' => JS_LIBRARY));
    drupal_add_js('_V_.options.flash.swf = "/' . $videojs_path . 'video-js.swf";', array('type' => 'inline', 'scope' => 'header', 'group' => JS_LIBRARY));

	$parameters = drupal_get_query_parameters();
	$autoplay = isset($parameters['autoplay']) ? ' autoplay' : '';

    $markup = '<video id="videoplayer" class="video-js vjs-default-skin vjs-big-play-centered" width="640" height="356"' . $thumbnail_markup . $autoplay
      . ' preload="' . ($preload ? 'auto' : 'none') . '" controls="controls" data-setup="{}">' . "\n";
    $markup .=  '<source src="' . $mp4_url . '" type="video/mp4"/>' . "\n";
    $markup .= $subtitles_markup;
    $markup .= '</video>';
    $markup .= '<hr class="testimony-video-divider"/>';
  }
  
  return $markup;
}

/**
 * Returns markup for the video thumbnail with play button and autoplay=true in the link.
 */
function cai_2012_get_video_thumbnail_teaser_markup($node, $node_url) {
	$link_markup = '';
    $thumbnail_items = field_get_items('node', $node, 'field_video_thumbnail');
    if ($thumbnail_items) {
	    $thumbnail_markup = '<img src="' . file_create_url($thumbnail_items[0]['uri']) . '" alt="' . t('video thumbnail') . '" class="video-thumbnail-teaser">';
	    $link_markup = '<a href="' . $node_url . '?autoplay=true">' . $thumbnail_markup . '</a>';
    }
    return $link_markup;
}


/*
 * Equivalent of taxonomy_term_count_nodes under D6.
 * Copied with modifications from http://api.drupal.org/api/drupal/modules!taxonomy!taxonomy.module/function/taxonomy_term_count_nodes/6#comment-28529
 */  
function cai_2012_taxonomy_term_count_nodes($tid) {
  static $count;
 
  if (isset($count[$tid])) {
    return $count[$tid];
  }
 
  $query = db_select('taxonomy_index', 't');
  $query->condition('tid', $tid, '=');
  $query->addExpression('COUNT(*)', 'count_nodes');

  $count[$tid] = $query->execute()->fetchField();
 
  return $count[$tid];
}





/***************** UNUSED **********************/
/*
 * Returns the markup to display the image in the teaser of this node. If the node has a video thumbnail, presumably the node has video.
 * So this function returns markup for the video thumbnail with play button and autoplay=true in the link. Otherwise, returns the standard
 * testimony image markup.
 */
function cai_2012_get_teaser_image_markup($node) {
}


/**
 * Return the code required to show an HTML5 video. If there is no HTML5 video it returns an empty string.
 */
function cai_2012_html5_video_flowplayer($node, $preload = true) {
  $markup = '';
  $subtitles_markup = '';

  $mp4_items = field_get_items('node', $node, 'field_mp4');
  $mp4_url = $mp4_items ? file_create_url($mp4_items[0]['uri']) : false;
  $thumbnail_items = field_get_items('node', $node, 'field_video_thumbnail');
  $thumbnail_markup = $thumbnail_items ? ' poster="' . file_create_url($thumbnail_items[0]['uri']) . '"': '';

  if (!$mp4_items) {
    // No video for our language. Look for one in other languages, stopping at first one found.
    // Since the languages are more or less in order of importance, (eg. English first), this is appropriate.
    $active_languages = language_list();
    if (($node->tnid) && $translations = translation_node_get_translations($node->tnid)) {
      // Translations exist for this node
      foreach ($active_languages as $lang_code => $language) {
        if (isset($translations[$lang_code])) {
          // A translation exists for this language. Get translated node.
          $tnode = node_load($translations[$lang_code]->nid);
          $mp4_items = field_get_items('node', $tnode, 'field_mp4');
          if ($mp4_items) {
            // Video exists! Take the URL and stop looping.
            $mp4_url = file_create_url($mp4_items[0]['uri']);
            break;
          }
        }
      }
    }
    if ($mp4_items) {
      // Since we are using a video in another language, look for subtitle in our language
      $subtitles_items = field_get_items('node', $node, 'field_video_subtitles');
      if ($subtitles_items) {
        $subtitles_markup = '<track kind="subtitles" srclang="' . $node->language . '"' .
              ' src="' . file_create_url($subtitles_items[0]['uri']) . '" label="' . $node->language . '" default/>' . "\n";
      }
    }
  }

  if ($mp4_url) {
    $flowplayer_path = libraries_get_path('flowplayer') . '/';
    drupal_add_js($flowplayer_path .  'flowplayer.min.js', array('scope' => 'header', 'group' => JS_LIBRARY));
    drupal_add_css($flowplayer_path . 'functional.css');  
    $swf = '/' . $flowplayer_path . 'flowplayer.swf';

    $markup = '<div class="cai-video">';
    $markup .= '<div data-swf=' . $swf . ' class="flowplayer no-toggle">';
    $markup .= '<video preload="' . ($preload ? 'auto' : 'none') . '"' . $thumbnail_markup . '>' . "\n";
    $markup .=  '<source src="' . $mp4_url . '" type="video/mp4"/>' . "\n";
    $markup .= $subtitles_markup;
    $markup .= '</video>';
    $markup .= '</div>';
    $markup .= '</div>';
  }
  
  return $markup;
}
