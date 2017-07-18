# Change Log

## [1.0.0] - 2017-05-17

### Deprecated

* A new hero content element has been added to the theme. The original hero element will continue to work but will be removed from the theme with version 1.1.0, which will not release before July 1, 2017. A very noticeable *ALERT* box and message will appear when editing pages with the legacy hero content fields. Use the new hero content fields as instructed to reset your pages' hero content.

### Fixed

* Rewrote auto excerpt function to work in PHP 5.4
* All hero images will now be 100% width of the browser window
* Fixed bug with URL field in factuly/staff extra fields 

## [1.0.0-beta.4] - 2017-05-05

### Deprecated

* A new hero content element has been added to the theme. The original hero element will continue to work but will be removed from the theme with version 1.1.0, which will not release before July 1, 2017. A very noticeable *ALERT* box and message will appear when editing pages with the legacy hero content fields. Use the new hero content fields as instructed to reset your pages' hero content.
* Removed content-parts/content-search.php, which was not being used. ([!127](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/127))
* Removed faculty/staff permalink. This was named '/staff' (e.g. yoursite.wisc.edu/staff). Sites must flush permalinks for this to take effect ([!135](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/135))

### Development process changes

* After beta-v3 releases, we switched to making all merge requests against the upstream dev branch. Going forward, all new changes (except bug fixes/hotfixes) will be merged into dev instead of master. New version releases will occur when we merge the dev branch into master. This will mean dev is always the most bleeding edge version of the theme, while master is the latest stable release.

### Added

* New hero carousel options: ([!106](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/106))
    * The hero can include one or more content panels. If more than one panel is entered, the hero area will become a carousel.
    * Each panel can contain either a: 
        * standalone image
        * an image with a headline set manually that can optionally link to a URL
        * an image with a headline fed from a page or post that will link to the page or post
        * an image with an inset box that features an optional image and excerpt text that can link to a page or post or ad hoc URL
* New faculty/staff post type options:
    * Added *LinkedIn* field to Faculty/staff post type ([!107](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/107))
    * Added an *Extra fields* feature to faculty/staff custom posts that allows you to enter an unlimited number of arbitrary data elements, each of which has a label, value and optional URL that the value will link to. ([!140](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/140))
    * Added ability to control size of photos in faculty/staff listings, or to not use photos at all ([!119](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/119))
* Added feedback email link to footer for accessibility and other questions. This address can be set in the Customizer or, otherwise, will use the site admin email address as set in *Dashboard > Settings > General* ([!109](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/109))
* Added ability to define a custom 404 error page in the Customizer. Also added a `[uw-search-input]` shortcode that can be used in a custom 404 page to render your site's search form. ([!126](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/126))
* Added support for oEmbed Kaltura videos ([!88](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/88))
* Added ability to set class name and/or id on a page layout row ([!86](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/86))
* Added option to add caption when using the Image page element ([!96](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/96) [!101](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/101))
* Added action hooks in to allow greater flexibility for child themes to customize the header and footer areas. ([!105](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/105)) Specifically: 
    * `uw_after_body_open_tag`
    * `uw_after_header`
    * `uw_after_menus_inside`
    * `uw_after_menus_outside`
    * `uw_before_footer`
    * `uw_inside_footer`
    * `uw_after_footer`
* `content-search-wp.php` now supports adding a custom search template partial in child themes ([!123](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/123))


### Changed

* *Latest Posts* element is now labeled *Posts Listing* to better reflect its function ([!137](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/137))
* Restyled *Posts Listing* element ([!87](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/87))
* Posts Listing individual posts option can now add any kind of post or page ([!151](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/151))
* Link styling now uses *text-decoration: underline* instead of *border-bottom* ([!77](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/77))
* Removed author bylines from post index lists and single views ([!90](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/90))
* Improved ARIA attribute implementation in menus and footer elements ([!78](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/78) [!99](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/99) [!132](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/132))
* Updated Advanced Custom Fields Pro plugin that is embedded in theme to 5.5.7 ([!92](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/92))
* Removed video title/info from embedded Youtube videos ([!93](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/93))
* Improved whitespace padding around UW content box element ([!118](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/118))
* `<button>` elements now take on same style as `.uw-button` class ([!120](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/120))
* The Page Builder custom fields now only apply to pages that use the default template or no template. This change allows child themes to define custom templates. ([!98](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/98))
* Foundation front-end framework was upgraded to 6.3.1. Developers who have previously cloned the project should run `npm update foundation-sites` to update Foundation. ([!100](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/100))
* Moved the Google Analytics code to the `<head>` ([!136](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/136))


### Fixed

* Fixed sort order for Latest Posts element (now named *Posts Listing*). ([!87](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/87))
* IE11 dynamic mobile menu breakpoint javascript error ([!80](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/80))
* Removed stray whitespace margin between page body and footer ([!102](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/102))
* Fixed error in breacrumbs markup ([!83](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/83))
* Fixed duplicate HTML IDs bug in SVG con implementation ([!81](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/81))
* Fixed various color contrast issues ([!84](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/84) [!104](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/104) [!124](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/124) [!150](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/150))
* Fixed clearing layout issues with various page elements ([!89](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/89))
* Fixed header white space styling bug ([!94](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/94))
* Don't exclude `package.json` from git archive ([!95](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/95))
* Fixed page converter tool bulk convert bug ([!97](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/97))
* The events element now uses PHP's `date()` function instead of `strftime()` to provide better support in Windows ([!122](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/122))
* Added support for password-protected pages ([!146](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/146))
* Fixed issue that was preventing gravity forms with conditional logic from displaying ([!113](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/113))
* Fixed spacing issue between inline images and buleted lists ([!134](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/134))
* Fixed minibar alignment issue in three-column layouts ([!148](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/148))
* New print styling now wraps long URLs ([!147](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/147))


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
* Added meta tag which forces browsers out of Internet Explorer compatibility mode ([!132](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/132))


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
* Page Builder pages will now auto-generate a page excerpt unless an excerpt already exists ([!143](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/143)) 


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