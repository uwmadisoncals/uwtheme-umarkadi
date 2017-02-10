(function ($) {

  function add_searchform_to_access() {
    if(window.matchMedia('(max-width: 500px)').matches && $('.uw-nav-menu > ul li.uw-search-list-item').length < 1){
      $(".uw-nav-menu:not(.uw-nav-menu-secondary) > ul").prepend('<li class="page_item uw-search-list-item"></li>');
      $("header .uw-search-form").detach().prependTo(".uw-nav-menu > ul li.uw-search-list-item");
    } else if(window.matchMedia('(min-width: 500px)').matches && $('.uw-nav-menu > ul li.uw-search-list-item').length > 0){
      $(".uw-nav-menu .uw-search-form").detach().prependTo(".uw-header-search");
      $('.uw-nav-menu > ul li.uw-search-list-item').remove();
    }
  }

  //a little responsiveness
  if($('#uw-main-nav').length > 0){
    //On load
    add_searchform_to_access();

    //On resize
    $(window).resize(function() {
      add_searchform_to_access();
    });
  }

})(jQuery);
