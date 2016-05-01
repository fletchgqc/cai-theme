/* -- Constants -- */
var MIN_DESKTOP_WIDTH = 1000;

/* -- Functions -- */
function showFeature(elem) {
  var item = jQuery(elem).parent();
  jQuery(elem).hide();
  jQuery(item).find("#arrow-up").show();
  var text = jQuery(item).find(".field p");
  if(jQuery(item).find(".content .image-left").length == 0) {
    var itemHeight = jQuery(item).height();
    var textHeight = jQuery(text).height();
    var textPadding = parseInt(jQuery(text).css("padding").replace("px",""));
    var pHeight = textHeight + 2*textPadding;
    jQuery(text).css("top",itemHeight+"px");
    jQuery(text).css("position","absolute");
    jQuery(item).css("height", (itemHeight+pHeight)+"px");
  }
  jQuery(text).show();
}

function hideFeature(elem) {
  var item = jQuery(elem).parent();
  jQuery(elem).hide();
  jQuery(item).find("#arrow-down").show();
  var text = jQuery(item).find(".field p");
  if(jQuery(item).find(".content .image-left").length == 0) {
    var itemHeight = jQuery(item).height();
    var textHeight = jQuery(text).height();
    var textPadding = parseInt(jQuery(text).css("padding").replace("px",""));
    var pHeight = textHeight + 2*textPadding;
    jQuery(text).css("top","0px");
    jQuery(text).css("position","absolute");
    jQuery(item).css("height", (itemHeight-pHeight)+"px");
  }
  jQuery(text).hide();
}

function organizeFeaturedArticles() {
  var windowSize = jQuery(window).width();
  var hasMobileFeaturedItems = jQuery(".mobileFeatured").length;
  if(hasMobileFeaturedItems) {
    if(windowSize < MIN_DESKTOP_WIDTH) {
      jQuery(".mobileFeatured").each(function(){jQuery(this).css("display","block")});
    } else {
      jQuery(".mobileFeatured").each(function(){jQuery(this).css("display","none")});
    }
  } else {
    if(windowSize < MIN_DESKTOP_WIDTH) {
      var featuredTestimonyPositionElement = jQuery("#content-front > .field > .field-items > .field-item > p:nth-child(2)");
      var featuredBibleStudyPositionElement = jQuery("#content-front > .field > .field-items > .field-item > h2:eq(0)");
      var featuredVideoPositionElement = jQuery("#content-front > .field > .field-items > .field-item > h2:eq(1)");
      featuredTestimonyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + jQuery(".item:nth-child(1)").html() + "</div></div>");
      featuredBibleStudyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + jQuery(".item:nth-child(2)").html() + "</div></div>");
      featuredVideoPositionElement.before("<div class='mobileFeatured'><div class='item'>" + jQuery(".item:nth-child(3)").html() + "</div></div>");
      jQuery(".mobileFeatured .item").each(function() {
        //jQuery(this).click();

        // Workaround to fix css problem
        // It won't be needed anymore since the idea is to have image for all the featured articles!! TODO: delete this code after confirmation!
        var ele = jQuery(this).find("img.image-left");
        if(ele.length == 0) {
          jQuery(this).find(".heading").css("left", "10px");
          jQuery(this).find(".node h2").css("left", "0px");
        }
      });
    }
  }
}

/* -- Events -- */
jQuery(document).ready(function(){
  organizeFeaturedArticles();

  // Language Button click event
  jQuery('#mobile-language').click(function(e) {
    if(jQuery("#language-select-form").css("display") == "none") {
      jQuery("#language-select-form").css("display", "block");
    } else {
      jQuery("#language-select-form").css("display", "none");
    }
  });

  // Menu Button click event
  jQuery('#mobile-menu').click(function (e) {
    jQuery('body').toggleClass('active');
    e.preventDefault();
  });

  // Page click event
  jQuery(".page").click(function() {
    if(jQuery("body").hasClass("active")) {
      jQuery("body").toggleClass("active");
    }
  });

  // Setting Menu Container height
  jQuery("#mobile-menu-container").height(jQuery("#header").height());

  // Scroll event - NOT NECESSARY RIGHT NOW
  /*jQuery(window).on("scroll", function(e) {
    if(jQuery(this).scrollTop() > jQuery("#mobile-language").height()) {
      jQuery("#mobile-menu").css({"position":"fixed", "height": (jQuery("#mobile-menu-container").height()/2)+"px", "top":"0%"});
    } else {
      jQuery("#mobile-menu").css({"position":"absolute", "height": (jQuery("#mobile-menu-container").height()/2)+"px", "top":"50%"});
    }
  });*/

  // Controlling resize events
  jQuery(window).resize( function() {
    jQuery("#mobile-menu-container").height(jQuery("#header").height());
    jQuery("#mobile-menu").css("height",(jQuery("#mobile-menu-container").height()/2)+"px");
    organizeFeaturedArticles();
  });

});