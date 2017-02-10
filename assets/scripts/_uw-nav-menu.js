var uw_utils = require ('./_uw-utilities.js');

uw_utils.ready(function() {

  var initMenuButton = function() {
    uw_menu_button.addEventListener("click", function(e) {
      uw_menu.classList.toggle("uw-is-visible");
      uw_utils.toggleBooleanAttr(uw_menu,"aria-hidden");
      uw_utils.toggleBooleanAttr(this,"aria-expanded");
      return false;
    });
  };

  var initDropdowns = function() {
    // Bind click event to toggle child menu and its related attributes
    // Also hides any siblings child menus that may be open
    var dropdown_buttons = document.querySelectorAll(".uw-dropdown > a");

    if (dropdown_buttons.length == 0) {
      return;
    }

    [].forEach.call(dropdown_buttons, function(el) {
      el.addEventListener("click", function(e) {
        e.preventDefault();
        var parent = this.parentNode,
            parent_siblings = uw_utils.getSiblings(parent),
            child_menu = parent.querySelector('.uw-child-menu');

        parent.classList.toggle("uw-is-active");
        uw_utils.toggleBooleanAttr(this,"aria-expanded");
        uw_utils.toggleBooleanAttr(child_menu,"aria-hidden");

        [].forEach.call(parent_siblings, function(el) {
          if (el.classList.contains("uw-dropdown")) {
            el.classList.remove("uw-is-active");
            el.querySelector("a:first-child").setAttribute("aria-expanded",false);
            el.querySelector(".uw-child-menu").setAttribute("aria-hidden",true);
          };
        });
      });
    });
  };


  // our main menu items
  var main_nav_items = document.querySelectorAll("#uw-main-nav > li");

  var calcMainMenuWidth = function() {
    var main_nav_width = 0;

    [].forEach.call(main_nav_items, function(el){
      main_nav_width = main_nav_width + parseInt(window.getComputedStyle(el).width, 10);
    });

    var add_width = 32; // add 2rem for out padding

    if ( supportsGetComputedStyleWidth === undefined)
      supportsGetComputedStyleWidth = testGetComputedWidth();

    // if not full getComputedStyle support:
    // - Add more width for padding in between menu items;
    //   each item has 15.2px left and right padding
    //   except the first has 0 left and the last has 0 right padding
    if ( !supportsGetComputedStyleWidth ) {
      add_width = parseInt( add_width + ( ( (main_nav_items.length*2)-2 ) * 15.2), 10 );
    }
    
    main_nav_width = main_nav_width + add_width;

    return main_nav_width;
  };

  // a hack method for detecting IE11 and lack of full support
  // for getComputedStyle widths
  var testGetComputedWidth = function() {

    var test_el = document.getElementById("test-get-computed-style-width");

    if ( !test_el ) {
      test_el = document.createElement('div');
      test_el.setAttribute("id","test-get-computed-style-width");
      document.body.appendChild(test_el);
    }

    if ( parseInt(window.getComputedStyle(test_el).width, 10) < 100 ) {
      return false;
    } else {
      return true;
    }
  };

  var uwMobileMenuResize = function() {

    // init windowWidth to 0 to force our dynamic menu recalculations
    if ("undefined" == typeof windowWidth) {
      windowWidth = 0;
    }

    // only act if width resized
    if ( windowWidth != window.innerWidth ) {

      windowWidth = window.innerWidth;

      var min_mobile_breakpoint = 500,
          menu_width = calcMainMenuWidth();

      // calculate menu width if it's visible
      if (uw_menu.classList.contains("uw-is-visible")) {
        if (window.innerWidth < menu_width || window.innerWidth < min_mobile_breakpoint) {
          uw_menu_button.classList.add("uw-is-visible");
          uw_menu_button.setAttribute("aria-expanded",false);
          uw_menu.classList.remove("uw-horizontal");
          uw_menu.classList.add("uw-stacked");
          uw_menu.classList.remove("uw-is-visible");
          uw_menu.setAttribute("aria-hidden",true);
        }
        uw_menu.classList.remove("uw-hidden");
      } else {

        if (window.innerWidth > min_mobile_breakpoint) {

          // render menu in non-mobile state but hidden,
          // and calculate its width
          uw_menu.classList.add("uw-hidden","uw-is-visible","uw-horizontal");
          uw_menu.classList.remove("uw-stacked");
          menu_width = calcMainMenuWidth();

          // if our menu will fit, unhide it and hide the mobile button
          if (window.innerWidth > menu_width) {
            uw_menu.classList.remove("uw-hidden");
            uw_menu.setAttribute("aria-hidden",false);
            uw_menu_button.classList.remove("uw-is-visible");
            uw_menu_button.setAttribute("aria-expanded",true);

          // restore the mobile menu and button classes
          } else {
            uw_menu.classList.remove("uw-is-visible","uw-hidden","uw-horizontal");
            uw_menu.classList.add("uw-stacked");
          }
        } else {
          uw_menu.classList.remove("uw-horizontal");
          uw_menu.classList.add("uw-stacked");
        }
      }
    }

  };

  // on page load
  var uw_menu_buttons = document.querySelectorAll(".uw-mobile-menu-button-bar"),
      uw_menu = document.getElementById("uw-top-menus"),
      windowWidth,
      supportsGetComputedStyleWidth;

  if (uw_menu_buttons.length > 0) {
    var uw_menu_button = uw_menu_buttons[0];
    initMenuButton();
  }

  if (uw_menu) {
    initDropdowns();
    uwMobileMenuResize();

    // run again to workaround iOS Safari delay in setting window.innerWidth
    window.setTimeout(function(){
      uwMobileMenuResize();
    }, 150);

    // bind on resize
    window.addEventListener("resize", uwMobileMenuResize);
  }

});




