/* -- Functions -- */
function showFeature(elem) {
  var item = jQuery(elem).parent();
  jQuery(elem).hide();
  jQuery(item).find("#arrow-up").show();
  jQuery(item).find(".field p").show();
}

function hideFeature(elem) {
  var item = jQuery(elem).parent();
  jQuery(elem).hide();
  jQuery(item).find("#arrow-down").show();
  jQuery(item).find(".field p").hide();
}

function organizeFeaturedArticles() {
  if(jQuery(window).width() < 1000) {
    var featuredTestimonyPositionElement = jQuery("#content-front > .field > .field-items > .field-item > p:nth-child(2)");
    var featuredBibleStudyPositionElement = jQuery("#content-front > .field > .field-items > .field-item > h2:eq(0)");
    var featuredVideoPositionElement = jQuery("#content-front > .field > .field-items > .field-item > h2:eq(1)");
    featuredTestimonyPositionElement.before("<div class='featured'><div class='item'>" + jQuery(".item:nth-child(1)").html() + "</div></div>");
    featuredBibleStudyPositionElement.before("<div class='featured'><div class='item'>" + jQuery(".item:nth-child(2)").html() + "</div></div>");
    featuredVideoPositionElement.before("<div class='featured'><div class='item'>" + jQuery(".item:nth-child(3)").html() + "</div></div>");
    jQuery(".featured .item").each(function() {
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

  // Controlling Mobile Menu Container
  jQuery("#mobile-menu-container").height(jQuery("#header").height());
  jQuery(window).resize( function() {
    jQuery("#mobile-menu-container").height(jQuery("#header").height());
    jQuery("#mobile-menu").css("height",(jQuery("#mobile-menu-container").height()/2)+"px");
  });

  // Scroll event
  jQuery(window).on("scroll", function(e) {
    if(jQuery(this).scrollTop() > jQuery("#mobile-language").height()) {
      jQuery("#mobile-menu").css({"position":"fixed", "height": (jQuery("#mobile-menu-container").height()/2)+"px", "top":"0%"});
    } else {
      jQuery("#mobile-menu").css({"position":"absolute", "height": (jQuery("#mobile-menu-container").height()/2)+"px", "top":"50%"});
    }
  });

});