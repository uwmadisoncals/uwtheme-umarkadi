# Change Log

## [1.0.0-beta.3] - 2017-01-05

### Added

* Added option to include bio in the staff listing page element
* Added option to specify a header field when using Group of Links page element in 2- and 3-column layout boxes
* Added new options Latest Posts page element
    * Display post featured image
    * Choose custom post types
    * Select individual posts
    * Select multiple post categories
* Adds function that sets *UW-Madison* at end of page title; can be overridden in child theme

### Changed

* Unbundles jQuery2 from main.js and properly registers it in place of the default Wordpress jQuery1. jQuery is also now loaded in No Conflict mode in line with Wordpress conventions. (Note: sites with custom JS code that assumed jQuery was *not* in No Conflict mode will have breaking JS. This is likely rare since properly written JS for Wordpress should always assume No Conflict mode.) Child themes can deregister the theme's jQuery and register the default one. 
* Now includes post types in archive queries
* No longer applies -webkit-font-smoothing: antialised to serif fonts
* Strips *Archive*, *Tag*, *Category* etc from archive titles
* Displays featured image on single post if there is not a custom content template
* Sets a max-width on single posts without sidebars
* Locks theme on 6.2.x version of Foundation
* Removes h1 format option from the WYSIWYG editor
* Wraps additional theme functions in if !function_exists() checks so child themes can override them as needed
* Updates Slick JS carousel code to improve accessibility
* Add accessibility improvements to image carousel page element
* Add various other accessibility improvements to theme
* Add various minor styling adjustments


### Fixed

* Display logic for quote page element
* Applies ACF Pro patch that fixes bug with preserving the collapsed/uncollapsed state of ACF panels
* Add child theme acf-json directory to ACF load paths
* Fixes Windows incompatible date format in event page lement (thanks Isaac Evavold!)
* Fixes some color contrast issues where color combinations fell below recommended rations for WCAG AA standards
* Fixes bug in native Wordpress search that caused searches to fail if a site was using non-default table prefixes
* Adds IE9 and under polyfill for classList
* Fixes some bugs in the dynamic mobile menu behavior


## [1.0.0-beta.2] - 2016-10-31

### Added

* Added empty partial template at end of footer to allow child theme to add additional footer content
* Added the Group of Links page element to all Page Builder layout areas with proper styling according to layout area
* Added ability to include excerpt in Latest Posts page element
* Added option in Text Block page element to style the content in a "uw-content-box" (i.e. with red bottom border and white background)
* Enhanced theme documentation in README, CONTRIBUTING and CHANGELOG docs, as well as some starter Wiki pages
* Added URL custom field to Wordpress posts that allows pulling in/linking to external URLs
* Adds Pinterst and Flickr as social media options in the Customizer


### Changed

* Updated ACF Pro to 5.4.8
* The crest in the header is in its own template partial allowing a child theme to override
* Dropdown menus in main menus will now only show two levels deep; deeper child menus will not render
* Page Builder page element choices are now arranged alphabetically
* Refactored JS for main menu such that the mobile collapse breakpoint is now set dynamicaly based on the number of main menu items
* improved presentation of Documents

### Fixed

* Test and warn for existence of ACF Pro and UW events plugins installed separate from theme
* Add ability to unset a footer menu
* Fixed menu dropdown bug where dropdowns did not clear correctly when selecting new dropdown
* Fixed mismatch between Customizer default colors and header.php default colors that caused confusion upon initial theme configuration
* fixed various color styling issues 
* fixed various accessibility issues identified when running the AMP tool
* fixed layout issue on smaller screen sizes when using the Image Carousel page element on a page
* fixed issues with long text in the hero inset box


## [1.0.0-beta.1] - 2016-10-17

* First tagged release