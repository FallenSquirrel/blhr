/**
 * the Utils class handles all general utils
 *
 * @author Christian Schätzle
 */
var Utils = {

  /**
   * init function Utils
   *
   * @author Christian Schätzle
   */
  init: function() {
    
  },

  /**
   * splits an given string by given delimiter and returns the two parts as an array
   *
   * @param delimiter string delimiter of string
   * @param string    string string which should be formed to an array
   *
   * @return cleanedArray array new array
   *
   * @author Christian Schätzle
   */
  explode: function(delimiter, string) {
    var array = string.split(delimiter);
    var cleanedArray = new Array();
    var counter = 0;

    for(var i = 0; i < array.length; i++) {
      var cleaned = array[i].replace (/^\s+/, '').replace (/\s+$/, '');
      cleaned = cleaned.replace (new RegExp(delimiter, "i"), '');
      if(cleaned != '') {
        cleanedArray[counter] = cleaned;
        counter++;
      }
    }
    return cleanedArray;
  },

  in_array: function(item,arr) {
    for(p=0;p<arr.length;p++) if (item == arr[p]) return true;
    return false;
  },

  /**
   * sorts a json object by the transfered field
   *
   * @param objs  json json object
   * @param field string name of field to be sorted
   *
   * @author Christian Schätzle
   */
  sort_json: function(objs, field) {
    var arr = new Array();
    jQuery.each(objs, function(id, obj) {
      arr.push(obj);
    });

    return arr.sort(function(a,b) { return a[field] > b[field];});
  },

  /**
   * shows the ajax load icon
   *
   * @author Christian Schätzle
   */
  showAjaxLoadIcon: function() {
    jQuery('.generalAjaxLoader').css({
        top:  Utils.getPageScroll()[1] + (Utils.getPageHeight() / 4),
        left: Utils.getPageWidth()/2
      }).show();
  },

  /**
   * hides the ajax load icon
   *
   * @author Christian Schätzle
   */
  hideAjaxLoadIcon: function() {
    jQuery('.generalAjaxLoader').hide();
  },

  /**
   * gets the page scroll size
   *
   * @author Christian Schätzle
   */
  getPageScroll: function() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {   // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }
    return new Array(xScroll,yScroll);
  },

  /**
   * gets the page height
   *
   * @author Christian Schätzle
   */
  getPageHeight: function() {
    var windowHeight;
    if (self.innerHeight) { // all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }
    return windowHeight;
  },

  /**
   * gets the page width
   *
   * @author Christian Schätzle
   */
  getPageWidth: function() {
    if (window.innerWidth) {
      return window.innerWidth;
    } else if (document.body && document.body.offsetWidth) {
      return document.body.offsetWidth;
    } else {
      return 600;
    }
  },

  waitABit: function(prmSec) {
    prmSec *= 1000;
    var eDate = null;
    var eMsec = 0;
    var sDate = new Date();
    var sMsec = sDate.getTime();

    do {
      eDate = new Date();
      eMsec = eDate.getTime();
    } while ((eMsec-sMsec)<prmSec);
  }

};