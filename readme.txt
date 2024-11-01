=== WordPress-Amazon-Associate ===
Contributors: mdbitz
Donate Link: http://labs.mdbitz.com/donate/
Tags: amazon, associate, affiliate, carousel, widget, filter, search, short code, ip2nation, localization, omakase, my favorites, mp3 clips, multi-user, multi-author, product cloud
Requires at least: 3.2.1
Tested up to: 3.4.1
Stable tag: trunk

Quickly and easily monetize your website with links and widgets from the web's top Affiliate Program,
Amazon Associates.

== Description ==

The WPAA plugin enables you to monetize your website through the use of Amazon's
Affiliate Program. By entering your amazon associate id for Amazon's supported
locales you will earn referral fees for all products users purchase through
your website. The Plugin features tinyMCE editor support for searching and
inserting of amazon products and images into your content, content replacement
of static links with your associate tag, and support for inserting Amazon
Widgets through WordPress ShortCode, tinyMCE editor controls, Widget Admin,
or PHP code.

This plugin fully supports amazon product localization to supported markets:
Canada (CA), China (CN), Germany (DE), Spain (ES), France (FR), Italy (IT), Japan (JP), United Kingdom (GB), and
the Unites States (US).<br>

The [WordPress Amazon Associate](http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/?utm_source=wordpress&utm_medium=plugin-readme&utm_campaign=plugin)
plugin is designed to be your all inclusive source for enriching you website
with Amazon Products and Widgets embedded with your unique Amazon Associate Tag.
Below is a brief overview of the supported features if you have any questions
concerning using or features of the plugin than please visit the [Support Forums](http://forums.mdbitz.com/).

**Key Features**

1. **Amazon Widget Support** <br>
  *Carousel*<br>
  *MP3 Clips*<br>
  *My Favorites*<br>
  *Omakase*<br>
  *Product Cloud*<br>
  *Search*<br>

1. **Amazon Product Linking**

1. **Amazon Product Link Associate Tag filtering & update with rel="nofollow"**

1. **Amazon Product Preview**

1. **New Product Template Support**

1. **Amazon Link & Widget Geo-Localization**

1. **Multi-Author Support**

1. **Amazon Product Advertising API Caching**

1. **Complete Administrative control**

1. **MPMU Compatible**

== Installation ==

1. Upload the `wordpress-amazon-associate` folder and all it's contents to the `/wp-content/plugins/` directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Access the Plugin Settings by clicking the *WP - Amazon* menu option
1. Enter your Amazon Associate Ids
1. Enter your Amazon Web Services Access and Secret Keys
1. Optionally Configure Multi-Author, Link Filtering and Product Preview settings
1. Install the ip2nation database if you wish to support Geo Localization, by selecting the *WP - Amazon* > *ip2nation* menu option
1. Configure the Plugin Cache by visiting the *WP - Amazon* > *Cache* menu option
1. Configure available Widgets by accessing the *WP - Amazon* > *Widgets* menu option
1. Insert Products and Widgets into your website through your template, page/post content or the *Widget* admin screen in WordPress

== Frequently Asked Questions ==

= How can I report a bug? request help? request a feature? =

If you find a bug in the WordPress Amazon Associate plugin then please let me
know by emailing it to [matt@mdbitz.com](mailto:matt@mdbitz.com) or posting the
issue in the [Support Forums](http://forums.mdbitz.com/). You can also
report it through my [trac project](http://trac.mdbitz.com/WordPressAmazonAssociate/)
using the login credential of "user" with password "guest". Another way you can
reach me is through my [website](http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/?utm_source=wordpress&utm_medium=plugin-readme&utm_campaign=plugin)

= Do I need to configure the Amazon Web Service Keys =

No, however by not inputing a valid Amazon Web Service credential you will not be able to
insert amazon product links and images through ShortCode, the content editor's
tinyMCE control or the Quick Links Module.

= Does this plugin support Multi-Author websites? =

Yes! As of version 1.4 of the plugin we have included a Multi-User module that
if enabled allows authors to set their Amazon Associate Ids on the users profile
page. Product links in page/post content will then be tagged with the author's
associate ids, and if not set will default to the ids configured on
the *WP - Amazon * > *Settings* page.

Version 2.0 and later of the plugin enable sites administrators to define a percentage
of links where the administrator's associate id will be used instead of the author's
associate id.

= What is Link Localization? =

Link Localization is the generation of a product link that is localized to the
users version of Amazon. To give a quick example if you have your default locale
set to United States and a visitor of your website is from France then they would
be presented with a link to the amazon.fr website instead of amazon.com. This
is an optional feature that makes use of the free [ip2nation](http://ip2nation.com)
database. To make things as easy as possible the WPAA plugin includes the ability
to detect if you have ip2nation installed and if not install it for you.

= Can I choose which locales to support? =

Yes, not everyone will want to support link localization for all of Amazon's
Locales. This is why we have built in the ability to disable locales you don't
want to support. If a visitor from a disabled locale visits your website they
will be presented with a product link localized to your default locale.

= Why is Product Preview not working for my website? =

At this time there is a confirmed bug with the Amazon Product Preview code
that in some wordpress themes the previews do not occur. This error is due to
the Amazon script including it's own version of jQuery into the page causing a
conflict. To resolve the issue an optional jQuery.noConflict call to remap
jQuery is included if selected by the user on the admin screen. If product
preview still does not function for your website review your page source to see
if additional jQuery versions are loaded, if so they need to be set to
noConflict.<br>
Also at this time product preview is only supported for 1 locale at a time. We
are in the process of reviewing the code to see if this can be overwritten to
allow for product previews of all locales instead.

= My website currently uses other plugins for displaying Amazon Widgets, How can I switch to your plugin without rewriting my existing content? =

In version 1.1 we introduced a new compliance module to the plugin. This enables you to
make WPAA compliant with the ShortCode used in various other WordPress plugins for
rendering Amazon Widgets.  For the full list of compliant plugins visit
WP - Amazon > Compliance in your WordPress Admin pages. From this page you can also import
your Amazon Associate Tags/Ids from the Amazon Link and Amazon Link Localizer plugins.

= Does Wordpress Amazon Associate support I18n localization? =

Yes, we have built the plugin to support localization, and have provided a
wpaa.pot file in the languages folder of the plugin. If you have a translation
for the plugin please send the po/mo files to
[matt@mdbitz.com](mailto:matt@mdbitz.com) and I can incorporate it into the
project for other users.

== Screenshots ==

1. Amazon Carousel Widget

2. Amazon MP3 Clips Widget

3. Amazon My Favorites Widget

4. Amazon Search Widget

5. Amazon Omakase Widget

8. Amazon Product Preview example

6. WordPress Amazon Widget Panel Control

13. Page/Post Quick Links Component

9. Page/Post editor TinyMCE plugin to insert amazon product links/widgets

7. WordPress Amazon Associate Settings Panel

10. WordPress Amazon Associate - Compliance Panel

11. WordPress Amazon Associate - ip2nation Panel

12. WordPress Amazon Associate - Cache Panel

== Changelog ==

The full project changelogs can be found at [http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/changelog](http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/changelog/?utm_source=wordpress&utm_medium=plugin-readme&utm_campaign=plugin)

= 2.0.0 = 09/01/2012 =
* Basic Template Support and Administration
* ip2nation update logic fix
* Enhanced Messages to direct users on how to resolve validation errors

= 1.8.0 = 05/03/2012 =
* Support for Italy (IT) Locale
* Support for China (CN) Locale
* Support for Spain (ES) Locale
* Fix to Omakase Widget Color options
* Enhanced Validation to display error if validation fails to assist users with getting WPAA configured and functional

= 1.7.4 - 08/18/2011 =
* Removal of activate / deactivate hooks as per newly communicated [plugin guidelines](http://labs.mdbitz.com/2011/08/the-hidden-plugin-guidelines-all-wordpress-plugin-developers-should-know/)
* Restrition of Preview Servlet to logged in users with edit capability
* Tag and Entity Stripping of container, container_class and container_style attributes within preview serlvet to remove vulnerability to xss attacks

= 1.7.3 - 08/05/2011 =
* Updated Passive Tracking of versions in use

= 1.7.2 - 07/20/2011 =
* Added check to Enhanced add to confirm product exists for Geo-Localization if not defaults to primary locale
* Static Amazon Product links updated with rel="nofollow" automatically

= 1.7.1 - 07/16/2011 =
* Content Viewer Module - Update to check if wp_get_current_user exists to resolve WordPress issue

= 1.7.0 - 07/15/2011 =
* Multi-Author - Support Admin for x% of Author links
* Multi-Author - Product Preview - Support of Author Associate ID
* Plugin Compatibility - WordTwit - Fixed naming of fancybox script
* Plugin Compatibility - wp_tables_reloaded - Increased Filter priority
* Geo-Localization - Updated APaPi to return error when asin not found in locale
* Quick Links - HTML Editor text selection support
* Admin - Code refactor of messages, code reuse, options, tracking
* Admin - Migrated widget management to own sub-page
* Admin - Disable plugin features if AWS credentials not configured
* ip2nation - uninstall option
* Cache Module - clear cache option
* Content Viewer Module - Ability for admin to view content as designated locale
* Widgets - Support of Widget Styling via container, container_class and container_style

= 1.6.1 - 06/25/2011 =
* WordPress MultiSite Fix : Change admin capabilities to manage_options to enable plugin administration to site administrators

= 1.6.0 - 05/18/2011 =
* Amazon Enhanced - support for container and container_class properties
* tinyMCE controls updated to enalbe container and container_class for enhanced links
* preg_match_all fix - additional naming usage in plugin
* Associate Filter update - updated match logic to only pick up valid amazon links
* Static Link Geo Localization - updated Associate Filter logic so that if geo localization is enabled static links will be localized if they exist in user's locale

= 1.5.4 - 05/11/2011 =
* Widget Fix - extraction of before/after args
* preg_match_all - pre version 5.2.2 compatibility update

= 1.5.3 - 05/10/2011 =
* Refactor bug fix correction to return instead of echo to fix link output to top of content

= 1.5.2 - 05/09/2011 =
* Fixed author associate id usage on Amazon Products/Enhanced Ads
* Added alt & title support to Amazon Product Image Shortcodes
* Added title support to Amazon Product Link Shortcodes
* Refactored ShortCodeHandler to reuse AmazonProduct functions

= 1.5.1 - 04/28/2011 =
* Author level users now have access to the TinyMCE interface to create widgets/links
* Fixed Associate Filter logic so that multiple links in page to same url would not be double tagged.

= 1.5.0 - 03/01/2011 =
* Support for Amazon Product Cloud Widget
* Support for Amazon Enhanced Display Ads
* Amazon Product Links support for rel attribute (defaults to nofollow)
* Bug with Quick Links unable to insert images corrected
* Amazon Product Links and Images updated with container and container_class attributes for additioanl flexibility in styling links
* Cache logic updated to check for changes in associate id and updating if needed
* TinyMCE editor updated with display of price and links to Amazon, thanks Sean Malone for sharing your changes to the plugin

= 1.4.1 - 12/28/2010 =
* Quick Links update - included logic for inserting links when in HTML editor using send_to_editor
* Added class optional attribute to Product Images ShortCode to allow for alignment

= 1.4.0 - 12/11/2010 =
* Product Caching - introduced new Cache module to store product information in local db to minimize calls to Amazon Product API.
* Multi-User Support - enabled ability to have user specific associate tags so that authors get credit for links in their content.
* 2 Step Quick Links - new post/page sidebar component that enables users to search and insert links/images in 2 steps.
* Associate Tag imports - ability to import associate tag settings from Amazon Link and Amazon Affiliate Link Localizer plugins.
* Code cleanup - removal of PHP Notices caused by the plugin.

= 1.3.1 - 12/03/2010 =
* Bug Fix to MP3Clips widget's shortcode options

= 1.3.0 - 12/03/2010 =
* Support for Amazon Omakase (Leave it to us) Widget
* tinyMCE support for inserting Widget ShortCode
* filter removal of 'shortcode_unautop' to correct empty content bug
* Admin Panels updated with Social Network links
* Widget Geo Localization support
* Fixed label styling of Widget controls

= 1.2.3 - 11/26/2010 =
* Corrected default ShortCode Arguments for Amazon Widgets. Attributes were getting  removed by the WordPress shortcode_atts method as they were not in the default array of attributes. Thanks to *Ty Lee* for identifying this bug.

= 1.2.2 - 11/24/2010 =
* Admin Support for Italy and China Associate Tags
* Inline links to the amazon associate website for all locales
* Static Link Filtering support for China and Italy Locales

= 1.2.1 - 11/22/2010 =
* Optimization to ip2nation check - only queries ip2nation for latest version when a user is on the WP-Amazon > ip2nation admin screen

= 1.2.0 - 11/20/2010 =
* Support for Associate Tags for all Amazon Locales
* Link localization support through utilizing ip2nation database
* ip2nation support module to install/update ip2nation database
* enhanced filter logic to replace static links with localized associate tags
* Bug Fix for obtaining product links in Japan Locale

= 1.1.0 - 11/14/2010 =
* Ability to preview Widgets within the Appearance > Widget page
* I18n Language localization support 
* Enhanced Access Key Validation
* Plugin Compliance support - enable compatability with ShortCode from other Amazon Widget plugins
* Bug Fixes to My Favorites and Search plugins

= 1.0.2 - 11/10/2010 =
* Optional jQuery noConflict wrapper for Amazon Product Preview to fix Amazon script conflicts in some theme/plugin combinations.

= 1.0.1 - 11/09/2010 =
* Updated default settings to comply with WordPress guidelines

= 1.0 - 11/07/2010 =
* Support for Amazon Widgets
* Support for Associate Tag Filter
* Support for Amazon Product Preview
* Support for Amazon Product Links and Images

== Supported Amazon Widgets/Links ==
<br>
= Carousel =

* `<?php AmazonWidget::Carousel( $options ); ?>`
* `[amazon_carousel]`

= MP3 Clips =

* `<?php AmazonWidget::MP3Clips( $options ); ?>`
* `[amazon_mp3_clips]`

= My Favorites =

* `<?php AmazonWidget::MyFavorites( $options ); ?>`
* `[amazon_my_favorites]`

= Omakase (Leave it to Us) =

* `<?php AmazonWidget::Omakase( $options ); ?>`
* `[amazon_omakase]`

= Product Cloud =

* `<?php AmazonWidget::ProductCloud( $options ); ?>`
* `[amazon_product_cloud]`

= Search =

* `<?php AmazonWidget::Search( $options ); ?>`
* `[amazon_search]`

= Template =

* `[amazon_template template="1" id="0451463471" ]Content that will display if template not found, inactive or error during rendering[/amazon_template]
* `[amazon_template template="Basic Ad" type="ASIN List" id="0451463471,0756407125]Content[/amazon_template]`

= Product Link =

* `<?php AmazonProduct::link( array( "content"=>"link text", "id" => "0345518705" ) ); ?>`
* `[amazon_link id="0345518705"]link text[/amazon_link]`

= Product Image =

* `<?php AmazonProduct::image( array( "content" => "link text", "id" => "0345518705, "size" => "medium", "link" => true ) ); ?>`
* `[amazon_image id="0345518705" link="true"]alt text[/amazon_image]`

= Enhanced Ad =

* `<?php AmazonProduct::enhanced( array( "asin" => "0345518705" ) ); ?>`
* `[amazon_enhanced asin="0345518705" ]`
