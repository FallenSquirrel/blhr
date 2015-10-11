jQuery(document).ready(function(){

    // tabbed widgets
    jQuery(".widget-container .title-tab").on("click", function(e) {
        e.preventDefault();
        var parentContainer = jQuery(this).parents(".widget-container");
        parentContainer.find(".tab-content").hide();
        parentContainer.find(".tab-content[refid="+jQuery(this).attr("ref")+"]").show();
        parentContainer.find(".title-tab").removeClass("active");
        jQuery(this).addClass("active");
    });

    // other tabs
    jQuery(".tab-container .tab").on("click",function(e) {
        e.preventDefault();
        var parentContainer = jQuery(this).parents(".tab-container");
        parentContainer.find(".tab-content").hide();
        parentContainer.find(".tab-content[refid="+jQuery(this).attr("ref")+"]").show();
        parentContainer.find(".tab").removeClass("active");
        jQuery(this).addClass("active");
    });

    jQuery("a[rel='colorbox']").colorbox({
        maxWidth: '1000px', maxHeight: '620px', title: function() { return jQuery(this).next(".wp-caption-text").text(); }
    //}).addClass('img-magnify');
    });

    jQuery("a.img-magnify").each(function(){
        jQuery(this).append('<img class="magnifier" src="/wp-content/themes/blhr/img/icon-magnifier.png" />');
    });

  jQuery('[data-jspagination]').jPaginate({items:12,next:'weiter',previous:'zurück',pagination_class: 'jspagination-navigation'});

    // initialize button class
    //Button.init();
});

var General = {
    initTabs: function() {
        jQuery('.std-tab-container').tabs({ active: 0 });
    }
};