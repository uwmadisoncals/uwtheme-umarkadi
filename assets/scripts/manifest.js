var whatInput = require ('what-input');

// Foundation core javascipt
var foundation =       require( 'foundation-core'),
fdtnUtilBox =          require( 'foundation-util-box'),
fdtnUtilKeyboard =     require( 'foundation-util-keyboard'),
fdtnUtilMediaQuery =   require( 'foundation-util-mediaquery'),
// fdtnUtilMotion =       require( 'foundation-util-motion'),
fdtnUtilNest =         require( 'foundation-util-nest'),
fdtnUtilTimer =        require( 'foundation-util-timer'),
fdtnUtilTouch =        require( 'foundation-util-touch'),
fdtnUtilTriggers =     require( 'foundation-util-triggers'),

// Foundation plugins
// fdtnAbide =            require( 'foundation-abide'),
fdtnAccordion =        require( 'foundation-accordion'),
fdtnAccordionMenu =    require( 'foundation-accordion-menu'),
fdtnDrilldown =        require( 'foundation-drilldown'),
fdtnDropdown =         require( 'foundation-dropdown'),
fdtnDropdownMenu =     require( 'foundation-dropdown-menu'),
fdtnEqualizer =        require( 'foundation-equalizer'),
// fdtnInterchange =      require( 'foundation-interchange'),
// fdtnMagellan =         require( 'foundation-magellan'),
fdtnOffcanvas =        require( 'foundation-offcanvas'),
// fdtnOrbit =            require( 'foundation-orbit'),
fdtnResponsiveMenu   = require( 'foundation-responsive-menu'),
fdtnResponsiveToggle = require( 'foundation-responsive-toggle'),
fdtnReveal =           require( 'foundation-reveal'),
// fdtnSlider =           require( 'foundation-slider'),
// fdtnSticky =           require( 'foundation-sticky'),
fdtnTabs =             require( 'foundation-tabs'),
// fdtnTooltip =          require( 'foundation-tooltip'),
fdtnToggler =          require( 'foundation-toggler');

var uw_nav_menu = require ('./_uw-nav-menu');
var uw_search_input_dom_switch = require ('./_uw-search-input-dom-switch');

jQuery.noConflict(); // put jQuery in no conflict mode
(function($) {
  $(document).foundation();
})(jQuery);
