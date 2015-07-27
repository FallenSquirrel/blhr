
function gallerySlider(selector) {

    jQuery(selector).each(function(index, element) {

      var gallerySlider = jQuery(element);

      if(!gallerySlider.hasClass('gallerySlider')) {
        gallerySlider.addClass('gallerySlider');
      }

      var slider = gallerySlider.find('.slider');
      var sliderHeight = slider.find('.tile').innerHeight();
      var tiles = gallerySlider.find('.tile');
      var left   = gallerySlider.find('.previous');
      var right  = gallerySlider.find('.next');
      gallerySlider.css('height', sliderHeight + 'px');

      if(tiles.length > 0) {
        var of = jQuery(tiles.get(0)).outerWidth(true);
        var i  = 0;
        tiles.each( function () {
          var me  = jQuery(this);
          me.css('position', 'absolute')
            .css('left', of*i++)
            .css('top', 0);
        });
      }

      if(tiles.length > 4) {

        tiles.last().css('left', 0 - of);

        right.click( function () {

          tiles.stop(true, true);

          var update = function () {
            var min = 0;
            var tomove = null;
            tiles.each( function () {
              var cur = jQuery(this);
              var pos = cur.position();
              min = Math.min(min, pos.left);
              if (min == pos.left) {
                tomove = cur;
              }
            });
            if (min <= 0 && tomove) {
              var max = 0;
              tiles.each( function () {
                max = Math.max(max, jQuery(this).position().left);
              });
              tomove.css('left', max + of);
            }
          };

          update();

          tiles.animate({left: '-=' + of + 'px'});
        });

        left.click( function () {
          tiles.stop(true, true);

          var update = function () {
            var max = 0;
            var tomove = null;
            tiles.each( function () {
              var cur = jQuery(this);
              var pos = cur.position();
              max = Math.max(max, pos.left);
              if (max == pos.left) {
                tomove = cur;
              }
            });
            if (max >= slider.width() && tomove) {
              var min = 0;
              tiles.each( function () {
                min = Math.min(min, jQuery(this).position().left);
              });
              tomove.css('left', min - of);
            }
          };
          update();

          tiles.animate({left: '+=' + of + 'px'});
        });
      } else {
        left.hide();
        right.hide();
      }
    });
}
