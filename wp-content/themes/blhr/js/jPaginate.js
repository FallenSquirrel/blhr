// jPaginate Plugin for jQuery - Version 0.3
// by Angel Grablev for Enavu Web Development network (enavu.com)
// Dual license under MIT and GPL :) enjoy
/*

Heavily modified and improved by MK

*/
(function($) {
  $.fn.jPaginate = function(options) {
    var defaults = {
        items: 4,
        next: "Next",
        previous: "Previous",
        active: "active",
        pagination_class: "pagination",
        minimize: false,
        nav_items: 6,
        position: "after",
        equal: false,
        offset: 50
      };
    var options = $.extend(defaults, options);

    return this.each(function() {
      var obj = $(this);
      var show_per_page = options.items;
      var number_of_items = obj.children().size();
      var number_of_pages = Math.ceil(number_of_items/show_per_page);
      if(number_of_pages < 2) return;
      var array_of_elements = [];
      var numP = 0;
      var nexP = show_per_page;

      var height = 0;
      var max_height = 0;

      for (i=1;i<=number_of_pages;i++) {
        array_of_elements[i] = obj.children().slice(numP, nexP);

        if (options.equal) {
          obj.children().slice(numP, nexP).each(function(){
            height += $(this).outerHeight();
          });
          if (height > max_height) max_height = height;
          height = 0;
        }

        numP += show_per_page;
        nexP += show_per_page;
      }
      if (options.equal) {
        max_height += options.offset;
        obj.css({"height":max_height});
      }

      showPage(1);
      createPagination(1);
      //show selected page
      function showPage(page) {
          obj.children().hide();
          array_of_elements[page].show();
      }

      // create the navigation for the pagination
      function createPagination(curr) {
        var start, items = "", end, nav = "";
        start = "<div class='"+options.pagination_class+"-container clearfix'><ul class='"+options.pagination_class+"'>";
        var previous = "<li><a class='"+options.pagination_class+"-previous' href='#'>"+options.previous+"</a></li>";
        var next = "<li><a class='"+options.pagination_class+"-next' href='#'>"+options.next+"</a></li>";
        var previous_inactive = previous;
        var next_inactive = next;
        end = "</ul></div>"
        var after = number_of_pages - options.after + 1;
        var pagi_range = paginationCalculator(curr);
        for (var i=1;i<=number_of_pages;i++) {
          items += '<li><a href="#" class="'+options.pagination_class+'-goto'+(i==1 ? " active" : "")+'" data-page="'+i+'">'+i+'</a></li>';
        }

        if (curr != 1 && curr != number_of_pages) {
          nav = start + previous + items + next + end;
        } else if (number_of_pages == 1) {
          nav = start + previous_inactive + items + next_inactive + end;
        } else if (curr == number_of_pages){
          nav = start + previous + items + next_inactive + end;
        } else if (curr == 1) {
          nav = start + previous_inactive + items + next + end;
        }

        if (options.position == "before") {
          obj.before(nav);
        } else if (options.position == "after") {
          obj.after(nav);
        } else {
          obj.after(nav);
          obj.before(nav)
        }
      }

      function paginationCalculator(curr)  {
        var half = Math.floor(options.nav_items/2);
        var upper_limit = number_of_pages - options.nav_items;
        var start = curr > half ? Math.max( Math.min(curr - half, upper_limit), 0 ) : 0;
        var end = curr > half?Math.min(curr + half + (options.nav_items % 2), number_of_pages):Math.min(options.nav_items, number_of_pages);
        return {start:start, end:end};
      }

      var objnavigation = obj.siblings('.'+options.pagination_class+'-container');
      // handle click on pagination
      $("."+options.pagination_class+"-goto",objnavigation).on("click", function(e){
        e.preventDefault();
        objnavigation.find(".active").removeClass("active");
        $(this).addClass("active");
        showPage($(this).data("page"));
      });
      $("."+options.pagination_class+"-next",objnavigation).on("click", function(e) {
        e.preventDefault();
        var newcurr = parseInt(objnavigation.find(".active").data("page")) + 1;
        if(newcurr > number_of_pages) return;
        objnavigation.find(".active").removeClass("active");
        objnavigation.find("[data-page="+newcurr+"]").addClass("active");
        showPage(newcurr);
      });
      $("."+options.pagination_class+"-previous",objnavigation).on("click", function(e) {
        e.preventDefault();
        var newcurr = parseInt(objnavigation.find(".active").data("page")) - 1;
        if(newcurr < 1) return;
        objnavigation.find(".active").removeClass("active");
        objnavigation.find("[data-page="+newcurr+"]").addClass("active");
        showPage(newcurr);
      });
    });
  };
})(jQuery);