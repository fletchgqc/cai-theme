(function ($) {
  /* -- Constants -- */
  var MIN_DESKTOP_WIDTH = 1000;

  /* -- Functions -- */
  function organizeFeaturedArticles() {
    var windowSize = $(window).width();
    var hasMobileFeaturedItems = $(".mobileFeatured").length;
    if(hasMobileFeaturedItems) {
      if(windowSize < MIN_DESKTOP_WIDTH) {
        $(".mobileFeatured").each(function(){$(this).css("display","block")});
      } else {
        $(".mobileFeatured").each(function(){$(this).css("display","none")});
      }
    } else {
      if(windowSize < MIN_DESKTOP_WIDTH) {
        var featuredTestimonyPositionElement = $("#content-front > .field > .field-items > .field-item > p:nth-child(2)");
        var featuredBibleStudyPositionElement = $("#content-front > .field > .field-items > .field-item > h2:eq(0)");
        var featuredVideoPositionElement = $("#content-front > .field > .field-items > .field-item > h2:eq(1)");
        featuredTestimonyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems($(".item:nth-child(1)")) + "</div></div>");
        featuredBibleStudyPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems($(".item:nth-child(2)")) + "</div></div>");
        featuredVideoPositionElement.before("<div class='mobileFeatured'><div class='item'>" + treatedFeaturedItems($(".item:nth-child(3)")) + "</div></div>");
      }
    }
  }

  function treatedFeaturedItems(element) {
    var clonedElement = $(element).clone(); // cloning to not affect the desktop version
    $(clonedElement).find("span.element-invisible").remove(); // It was expanding the document width so I had to remove it.
    var firstHeaderHtml = $(clonedElement).children("h2.heading").detach().wrap("<div>").parent().html();
    var arrowUp = $(clonedElement).children(".arrow-up").first().detach().wrap("<div>").parent().html();
    var arrowDown = $(clonedElement).children(".arrow-down").first().detach().wrap("<div>").parent().html();
    var secondHeaderHtml = $(clonedElement).find("div.node h2").addClass("heading2").detach().wrap("<div>").parent().html();
    var imageLeft = $(clonedElement).find("div.node img.image-left").parent().detach().wrap("<div>").parent().html();
    var rest = $(clonedElement).find("div.node").detach().wrap("<div>").parent().html();
    return (imageLeft!==undefined?imageLeft:"") + firstHeaderHtml + secondHeaderHtml + arrowUp + arrowDown + rest;
  }

  function getValueFromOptionList(optionText, selectElement) {
    var value = "";
    $("#"+selectElement+" > option").each(function() {
      if($(this).text() == optionText) {
        value = $(this).val();
        return false; // only way to break .each()
      }
    });
    return value;
  }

  function toggleLanguageSelection() {
    $("#language-select-list-button").hide();
    if(isMobile()) {
      $("#language-select-form").hide();
      $("#language-select-list").hide();
    } else {
      $("#language-select-form").show();
      $("#language-select-list").show();
    }
  }

  function isMobile() {
    var windowSize = $(window).width();
    return windowSize < MIN_DESKTOP_WIDTH;
  }

  function resetUiTooltips() {
    $(".page").click();
    $(".ui-tooltip").css({"display":"none","width":"300px"});
  }

  function wrapTables() {
    var tables = $("#content").find("table");
    var wraps = $(".mobile-table-wrap");
    if(tables.length > 0) {
      if(isMobile() && wraps.length == 0) {
        $(tables).wrap("<div class='mobile-table-wrap'></div>");
      } else if(!isMobile() && wraps.length > 0) {
        $(tables).unwrap();
      }
    }
  }

  function resizeVideoPlayer() {
    var videoPlayer = $("#videoplayer");
    if(isMobile() && videoPlayer.length > 0) {
      $(videoPlayer).height($(videoPlayer).width()/2);
    }
  }

  function addArrowListeners() {
    $(".arrow-up").click(function() {
      var parent = $(this).parent();
      $(this).hide();
      $(parent).find(".arrow-down").show();
      $(parent).find(".field p").hide();
    });
    $(".arrow-down").click(function() {
      var parent = $(this).parent();
      $(this).hide();
      $(parent).find(".arrow-up").show();
      $(parent).find(".field p").show();
    });
  }

  /* -- Events -- */
  $(document).ready(function(){
    $(".element-invisible").remove();
    organizeFeaturedArticles();
    addArrowListeners();
    wrapTables();
    setTimeout(resizeVideoPlayer, 500);

    // Creating language menu with $ mobile
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
    $('#mobile-language').click(function(e) {
      if($("#language-select-form").css("display") == "none") {
        $("#language-select-form").show();
        $("#language-select-list-button").show();
        $("#language-select-list-button").click();
      } else {
        $("#language-select-form").hide();
      }
    });

    // Menu Button click event
    $('#mobile-menu').click(function (e) {
      $('body').toggleClass('active');
      e.preventDefault();
    });

    // Page click event
    $(".page").click(function() {
      if($("body").hasClass("active")) {
        $("body").toggleClass("active");
      }
      $("#ui-tooltip-mobile").hide();
    });

    $("cite.bibleref").click(function(e){
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
        $("#mobile-menu-container").height($("#header").height());
        clearInterval(bannerMobileDelayHandler);
      }
    }, 500);

    // Controlling resize events
    $(window).resize( function() {
      $("#mobile-menu-container").height($("#header").height());
      $("#mobile-menu").css("height",($("#mobile-menu-container").height()/2)+"px");
      organizeFeaturedArticles();
      toggleLanguageSelection();
      resetUiTooltips();
      wrapTables();
      resizeVideoPlayer();
    });

  });

}(jQuery));