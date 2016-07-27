  <div id="ui-tooltip-mobile"></div>

  <div id="mobile-menu-container">
    <a href="/" id="mobile-logo"></a>
    <div id="mobile-language">
      <?php $img_url = "/".$directory."/images/CAI-Mobil-Language-Button_".strtoupper($language->language).".png"; ?>
      <img class="header-button" src="<?php print $img_url; ?>" />
    </div>
    <div id="mobile-menu">
      <img class="header-button" src="/<?php print $directory ?>/images/CAI-Mobil-Menu-Button.png" />
    </div>
  </div>

  <nav class="offcanvas transition">
    <?php if ($main_menu): ?>
      <div id="primary" class="clear-block">
        <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links', 'inline', 'clearfix')))); ?>
      </div>
    <?php endif; ?>
  </nav>

  <div id="page" class="page transition">

    <div id="header"><div class="section clearfix">
      <div id="logo-title">
        <a href="<?php print url(); ?>">
          <img src="/<?php print $directory ?>/images/banner-image.png" alt="Christian Assemblies International Banner" id="banner" />
          <img src="/<?php print $directory ?>/images/banner-image-mobile.jpg" alt="Christian Assemblies International Banner" id="banner-mobile" />
        </a>
      </div> <!-- /logo-title -->
                       
      <?php print render($page['header']); ?>
      
      <div id="contact-globe"><a href="<?php print cai_2012_get_contact_us_url(); ?>"><img alt="<?php print t('Globe'); ?>" src="/<?php print $directory ?>/images/globe.png"/> <span><?php print t('Contact Us') ?></span></a></div>
      
      <div id="banner-forms">
        <div id="language-select-form">
          <form action="" method="post">
            <div>
              <select id="language-select-list" onchange="document.location.href=this.options[this.selectedIndex].value;">
                <?php
                  if (isset($node)) {
                    $translations = cai_2012_get_translation_links($node);
                      foreach ($translations as $translation) { ?>
                        <option value="<?php print $translation['href'] ?>"<?php if ($language->language === $translation['lang_code']) print ' selected="selected"'?>><?php print $translation['native'] ?></option>                            
                  <?php } 
                } ?>
              </select>
            </div>
          </form>
          <img id="current-lang-flag" src="/<?php print $directory ?>/images/language-flags/<?php print $language->language ?>.gif" alt="Flag representing active language"/>
        </div>
  
        <?php if (!empty($search_box)): ?>
          <div id="search-box"><?php
            $block = module_invoke('search', 'block_view', 'search');
            print render($block); 
          // print $search_box; 
          ?></div>
        <?php endif; ?>
      </div>
      
     <div id="musicbutton">
	<script type="text/javascript">
	<!--
	function popup(mylink, windowname)
	{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
   	href=mylink;
	else
   	href=mylink.href;
   	window.open(href, windowname, "width=400,height=600,scrollbars=0,status=0,toolbar=0");
   	return false;
	}
	//-->
	</script>
     <a href="/files/music/mp3/music.html" onclick="return popup(this, 'music')"><img src="/<?php print $directory ?>/images/notes-play.png" alt="Play music" id="music" /></a>
      </div> <!-- /music button -->

      <div id="topnav">
        <?php if ($main_menu): ?>
          <div id="primary" class="clear-block">
            <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links', 'inline', 'clearfix')))); ?>
          </div>
        <?php endif; ?>
      </div>
      
    </div></div> <!-- /.section, /#header -->
    
    <div id="container" class="clearfix">
      <?php if ($secondary_menu): ?>
        <div id="sidebar-left" class="clear-block">
           <?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'left-menu', 'class' => array('links', 'inline', 'clearfix')))); ?>
        </div>
      <?php elseif ($page['sidebar_first']): 
        // Contact us menu ?>
        <div id="sidebar-left" class="clear-block">
          <?php print render($page['sidebar_first']); ?>
        </div> 
      <?php endif; ?>

      
      <div id="main">
        <?php print $messages; ?>

        <div id="content" class="column clearfix"><div class="section">
          <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
          <a id="main-content"></a>
          <?php print render($title_prefix); ?>
          <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
          <?php print render($title_suffix); ?>
          <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          <?php print render($page['content']); ?>
          <?php print $feed_icons; ?>
        </div></div> <!-- /.section, /#content -->
  
        <?php if ($page['sidebar_second']): ?>
          <div id="sidebar-second" class="column sidebar"><div class="section">
            <?php print render($page['sidebar_second']); ?>
          </div></div> <!-- /.section, /#sidebar-second -->
        <?php endif; ?>
  
      </div> <!-- /#main -->
      
    </div> <!-- /container -->
    
    <div id="footer-wrapper">
      <div id="footer"><div class="section">
        <?php print render($page['footer']); ?>
      </div></div> <!-- /.section, /#footer -->
    </div>

  </div> <!-- /#page -->