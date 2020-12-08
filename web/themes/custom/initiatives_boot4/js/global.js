/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.initiatives_boot4 = {
    attach: function (context, settings) { 


      $('.order-first',context).once('sidebar').each(function(){
        var m = window.location.search.indexOf("at_activities");
        var n = window.location.search.indexOf("focus_areas");
        var o = window.location.search.indexOf("state");
        if(m > -1 || n > -1 || o > -1  ) {
         
            if($('#block-yoursearch .searchIntro').hasClass('homeShow')) $('.searchIntro').removeClass('homeShow');
        

          }
        else {
        
          if(!$('#block-yoursearch .searchIntro').hasClass('homeShow')) $('.searchIntro').addClass('homeShow');
        }



      }
      );
     

      $('.view-display-id-page_1',context).once('view-solr-search-content').each(function(){
        var m = window.location.search.indexOf("at_activities");
        var n = window.location.search.indexOf("focus_areas");
        var o = window.location.search.indexOf("state");
        if(m > -1 || n > -1 || o > -1  ) {
            if ($('.view-header').hasClass('homeShow'))$('.view-header').removeClass('homeShow');
            if ($('.view-content.row').hasClass('hideRow'))$('.view-content.row').removeClass('hideRow');
            if ($('nav').hasClass('hideRow'))$('nav').removeClass('hideRow');
            if ($('.searchJump').hasClass('searchJump'))$('.view-header').removeClass('searchJump');
            if($('#sidebar_first').hasClass('facetShow')) $('#sidebar_first').removeClass('facetShow');

          }
        else {
          if(!$('.view-header').hasClass('homeShow'))$('.view-header').addClass('homeShow');
          if(!$('.searchJump').hasClass('homeShow'))$('.searchJump').addClass('homeShow');
          if(!$('.view-content.row').hasClass('hideRow'))$('.view-content.row').addClass('hideRow');
          if(!$('.view-content.row').hasClass('hideRow'))$('.view-content.row').addClass('hideRow');
          if(!$('nav').hasClass('hideRow'))$('nav').addClass('hideRow');
          if(!$('#sidebar_first').hasClass('facetShow')) $('#sidebar_first').addClass('facetShow');
        }



      }
      );
    }
  };
 
})(jQuery, Drupal);
