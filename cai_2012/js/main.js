/* -- Constants -- */
var MIN_DESKTOP_WIDTH = 1000;

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
      featuredTestimonyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems(jQuery(".item:nth-child(1)")) + "</div></div>");
      featuredBibleStudyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems(jQuery(".item:nth-child(2)")) + "</div></div>");
      featuredVideoPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems(jQuery(".item:nth-child(3)")) + "</div></div>");
    }
  }
}

function treatedFeaturedItems(element) {
  var clonedElement = jQuery(element).clone(); // cloning to not affect the desktop version
  jQuery(clonedElement).find("span.element-invisible").remove(); // It was expanding the document width so I had to remove it.
  var firstHeaderHtml = jQuery(clonedElement).children("h2.heading").detach().wrap("<div>").parent().html();
  var arrowUp = jQuery(clonedElement).children("#arrow-up").detach().wrap("<div>").parent().html();
  var arrowDown = jQuery(clonedElement).children("#arrow-down").detach().wrap("<div>").parent().html();
  var secondHeaderHtml = jQuery(clonedElement).find("div.node h2").addClass("heading2").detach().wrap("<div>").parent().html();
  var imageLeft = jQuery(clonedElement).find("div.node img.image-left").parent().detach().wrap("<div>").parent().html();
  var rest = jQuery(clonedElement).find("div.node").detach().wrap("<div>").parent().html();
  return (imageLeft!==undefined?imageLeft:"") + firstHeaderHtml + secondHeaderHtml + arrowUp + arrowDown + rest;
}

function getValueFromOptionList(optionText, selectElement) {
  var value = "";
  jQuery("#"+selectElement+" > option").each(function() {
    if(jQuery(this).text() == optionText) {
      value = jQuery(this).val();
      return false; // only way to break .each()
    }
  });
  return value;
}

function toggleLanguageSelection() {
  jQuery("#language-select-list-button").hide();
  if(isMobile()) {
    jQuery("#language-select-form").hide();
    jQuery("#language-select-list").hide();
  } else {
    jQuery("#language-select-form").show();
    jQuery("#language-select-list").show();
  }
}

function isMobile() {
  var windowSize = jQuery(window).width();
  return windowSize < MIN_DESKTOP_WIDTH;
}

function resetUiTooltips() {
  $(".page").click();
  $(".ui-tooltip").css({"display":"none","width":"300px"});
}

/* -- Events -- */
jQuery(document).ready(function(){
  organizeFeaturedArticles();

  jQuery(".element-invisible").remove();

  // Creating language menu with jquery mobile
  $("#language-select-list").selectmenu();
  $("#language-select-list-button").css("width","100%");
  $("#language-select-list-button > .ui-selectmenu-text").on("DOMSubtreeModified",function(){
    var text = $(this).text();
    if(text!="") {
      document.location.href=getValueFromOptionList(text,"language-select-list");
    }
  });
  toggleLanguageSelection();

  // Language Button click event
  jQuery('#mobile-language').click(function(e) {
    if(jQuery("#language-select-form").css("display") == "none") {
      jQuery("#language-select-form").show();
      jQuery("#language-select-list-button").show();
      jQuery("#language-select-list-button").click();
    } else {
      jQuery("#language-select-form").hide();
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
    $("#ui-tooltip-mobile").hide();
  });

  jQuery("cite.bibleref").click(function(e){
    if(isMobile()) {
      e.stopPropagation();
      var text = $(this).attr("oldtitle");
      $("#ui-tooltip-mobile").text(text);
      $("#ui-tooltip-mobile").show();
    }
  });

  // Setting Menu Container height
  // This setInterval is a workaround due to the fact that if the banner-mobile img is not totally loaded, the #header's height wouldn't be calculated
  var bannerMobileDelayHandler = setInterval(function() {
    if(document.getElementById("banner-mobile").complete) {
      jQuery("#mobile-menu-container").height(jQuery("#header").height());
      clearInterval(bannerMobileDelayHandler);
    }
  }, 500);

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
    toggleLanguageSelection();
    resetUiTooltips();
  });

});