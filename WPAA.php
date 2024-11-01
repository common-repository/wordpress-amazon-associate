<?php
/*
 * copyright (c) 2010,2011,2012 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * WordPress Amazon Associate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress Amazon Associate.
 * If not, see <http://www.gnu.org/licenses/>.
*/

// load APaPi
require_once( plugin_dir_path(__FILE__) . 'APaPi/AmazonProductAPI.php' );
spl_autoload_register(array('AmazonProductAPI', 'autoload'));

// load Classes
require_once plugin_dir_path(__FILE__) . 'MDBitz/Plugin.php';

/**
 * WPAA
 *
 * This file contains the class WPAA
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * WordPress Amazon Associate Plugin
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class WPAA extends MDBitz_Plugin {

    /**
     * @var string $path WordPress Amazon Associate root directory
     */
    private static $_path;

    /**
     * ip2nation
     */
    const MODULE_IP2NATION = 'ip2nation';

    /**
     * compliance
     */
    const MODULE_COMPLIANCE = 'compliance';

    /**
     * multi user
     */
    const MODULE_MULTI_USER = 'multi user';

    /**
     * cache
     */
    const MODULE_CACHE = 'Cache';

    /**
     * quick links
     */
    const MODULE_QUICK_LINKS = 'Quick Links';

    /**
     * Amazon Banners
     */
    const MODULE_AMAZON_BANNER = 'Amazon Banners';

    /**
     * Amazon Widgets
     */
    const MODULE_AMAZON_WIDGETS = 'Amazon Widgets';

    /**
     * Templates
     */
    const MODULE_TEMPLATE = 'WPAA Templates';

    /**
     * SourceCode Handler
     * @var WPAA_ShortCodeHandler
     */
    protected $scHandler = null;

    /**
     * Plugin Modules
     * @var array
     */
    protected $modules = array();

    /**
     * Amazon Associate Ids
     * @var Array
     */
    protected $our_associate_tags = array(
        "US" => "wp-amazon-associate-20",
        "UK" => "wp-amazon-associate-21",
        "CA" => "wp-amazon-associate01-20",
        "CN" => "wp-amazon-associate-23",
        "DE" => "wp-amazon-associate02-21",
        "FR" => "wp-amazon-associate08-21",
        "IT" => "wp-amazon-associate04-21",
        "JP" => "wp-amazon-associate-22",
        "ES" => "wp-amazon-associate07-21"
    );

    /**
     * Amazon Associate Ids
     * @var Array
     */
    protected $associate_tags = array();

    /**
     * Associate Tags option name
     * @var string
     */
    protected $tags_options_name = "wordpress-amazon-associate-tags";

    /**
     * Amazon Enabled Locales
     * @var Array
     */
    protected $enabled_locales = array(
        "US" => true,
        "UK" => true,
        "CA" => true,
        "CN" => true,
        "DE" => true,
        "FR" => true,
        "JP" => true,
        "IT" => true,
        "ES" => true
    );

    /**
     * Amazon Enabled Locales
     * @var Array
     */
    public $locale_o = array(
        "US" => 1,
        "UK" => 2,
        "CA" => 15,
        "CN" => 28,
        "DE" => 3,
        "FR" => 8,
        "IT" => 29,
        "JP" => 9,
        "ES" => 7   // TODO need locale
    );

    /**
     * Enabled locales option name
     * @var String
     */
    protected $locales_options_name = "wordpress-amazon-associate-locales";

    /**
     * Configuration Page Hook
     * @var String
     */
    protected $config_hook = "wordpress-amazon-associate-config";

    /**
     * Configuration Option Name
     * @var String
     */
    protected $config_options_name = "wordpress-amazon-associate-config";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $config_options_lvl = "manage_options";

    /**
     * Plugin Options
     * @var Array
     */
    protected $options = array(
                "Locale" => AmazonProduct_Locale::US,
                "LocaleByGeoIP" => false,
                "AccessKey" => null,
                "SecretKey" => null,
                "AssociateSupport" => "1",
                "AdminSupport" => "0",
                "ProductPreview" => false,
                "ProductPreviewNoConflict" => false,
                "FilterAssociateTag" => false,
                "MultiUser" => false,
                "AWSValid" => null,
                "Version" => null,
                "CVEnabled" => false,
                "CVLocale" => ""
        );

    /**
     * Admin Messages
     * @var string
     */
    protected $message = '';

    /**
     * Plugin Version
     * @var String
     */
    protected $version = '';

    /**
     * Plugin Last Updated
     * @var String
     */
    protected $last_updated = '';

    /**
     * Constructor
     */
    function __construct( $plugin_version, $plugin_update_date ) {
        parent::__construct();
        $this->version = $plugin_version;
        $this->last_updated = $plugin_update_date;
        add_action('admin_head', array(&$this, 'doPageHead'));
        add_action('admin_print_scripts', array(&$this, 'doPageScripts'));
        add_action('admin_print_styles', array(&$this, 'doPageStyles'));
        add_action('admin_init', array(&$this, 'saveSettings'));
        add_action('init', array(&$this, 'init'));
        $this->loadOptions();
        $this->loadModules();
        $this->upgrade();
        // init I18n
        load_plugin_textdomain('wpaa', false, dirname( plugin_basename(__FILE__) ) . '/languages');
    }

    /**
     * Load Plugin Modules
     */
    public function loadModules() {
        // init Multi User Support
        if( $this->options['MultiUser'] ) {
            // init multi user module
            $this->modules[self::MODULE_MULTI_USER] = new WPAA_Module_MultiUser( $this->config_hook, $this->version, $this->last_updated );
        }
        // init Widget module
        $this->modules[self::MODULE_AMAZON_WIDGETS] = new WPAA_Module_Widget( $this->config_hook, $this->version, $this->last_updated );
        // init Compliance module
        $this->modules[self::MODULE_COMPLIANCE] = new WPAA_Module_Compliance( $this->config_hook, $this->version, $this->last_updated );
        //init Amazon Banner
        //$this->modules[self::MODULE_AMAZON_BANNER] = new WPAA_Module_Banner( $this->config_hook, $this->version, $this->last_updated );
        // init ip2nation module
        $this->modules[self::MODULE_IP2NATION] = new WPAA_Module_IP2Nation( $this->config_hook, $this->version, $this->last_updated );
        //init Cache module
        $this->modules[self::MODULE_CACHE] = new WPAA_Module_Cache( $this->config_hook, $this->version, $this->last_updated );
        //init Template Module
        $this->modules[self::MODULE_TEMPLATE] = new WPAA_Module_Template( $this->config_hook, $this->version, $this->last_updated );
        if( $this->isValidCredentials() ) { // load if Valid Credentials
            // init Quick Links module
            $this->modules[self::MODULE_QUICK_LINKS] = new WPAA_Module_QuickLinks( $this->config_hook, $this->version, $this->last_updated );
        }
        // init ShortCode Handler
        $this->scHandler = new WPAA_ShortCodeHandler($this->modules[self::MODULE_COMPLIANCE]->getCompliantShortCodeMappings());
    }

    /**
     * get Plugin Module by name
     * @param Name $name
     * @return MDBitz_Plugin
     */
    public function getModule( $name ) {
        return $this->modules[$name];
    }

    /**
     * WordPress init hook
     */
    public function init() {
        //init tinymce Amazon Plugin
        if (current_user_can('edit_posts') &&
                ( get_user_option('rich_editing') == 'true' )) {
            add_filter("mce_external_plugins", array(&$this,"register_amazon_tinymce_plugin"));
            add_filter('mce_buttons', array(&$this,'register_amazon_button'));
        }
        // add amazon filter if enabled
        if( $this->options['FilterAssociateTag'] === true ) {
            add_filter('the_content', array(&$this,'filter_amazon_associate_tag'), 25);
            add_filter('comment_text', array(&$this,'filter_amazon_associate_tag'), 25);
        }
        // add amazon rel="nofilter" filter
        add_filter('the_content', array(&$this, 'filter_rel_nofollow'), 20 );
        // insert product preview code if enabled
        if( $this->options['ProductPreview'] === true ) {
            add_action('wp_footer', array(&$this, 'append_product_preview'));
        }
        // WordPress Bug #15600
        remove_filter('the_content', 'shortcode_unautop');
    }

    /**
     * Append Product Preview Code to wp_footer content
     */
    public function append_product_preview() {
        global $post;
        $author_id = null;
        if( !is_null( $post ) && isset( $post->post_author ) ) {
            $author_id = $post->post_author;
        }
        $content = "";
        $content .=  '<script type="text/javascript" src="http://www.assoc-amazon.com/s/link-enhancer?tag=' . $this->getAssociateId( $this->getGeoLocale(), $author_id ) . '&o=' . $this->locale_o[$this->getGeoLocale()] . '"></script>';
        $content .= '<noscript><img src="http://www.assoc-amazon.com/s/noscript?tag=' . $this->getAssociateId( $this->getGeoLocale(), $author_id ) . '" alt="" /></noscript>';
        if( $this->options['ProductPreviewNoConflict'] === true ) {
            $content = '<script type="text/javascript">var dom = {};dom.query = jQuery.noConflict(true);</script>' . $content . '<script type="text/javascript">$=dom.query;</script>';
        }
        echo $content;
    }

    /**
     * Filter content and add rel="nofollow" to Amazon Links
     * 
     * @param string $content 
     * @return string
     */
    public function filter_rel_nofollow($content) {
        preg_match_all('~<a.*>~isU',$content,$matches);
        for ( $i = 0; $i <= sizeof($matches[0]) - 1; $i++){
            if ( !preg_match( '~nofollow~is', $matches[0][$i])
                    && (preg_match('~http://www.amazon.~', $matches[0][$i]) )){
                $result = trim($matches[0][$i],">");
                $result .= ' rel="nofollow">';
                $content = str_replace($matches[0][$i], $result, $content);
            }
        }
        return $content;
    }

    /**
     * Filter and replace Amazon Associate Id used in static links
     *
     * @param string $content
     * @return string
     */
    public function filter_amazon_associate_tag($content) {
        //Match http://www.amazon & http://amazon.
        $regexs = array('|<a.*?href=[""\'](?P<url>http://www\.amazon\..*?)[""\'].*?>.*?</a>|i',
            '|<a.*?href=[""\'](?P<url>http://amazon\..*?)[""\'].*?>.*?</a>|i');
        //iterate over Regular Expressions
        foreach( $regexs as $regex ) {
            preg_match_all($regex, $content, $matches, PREG_PATTERN_ORDER);
            $filtered_matches = array_unique($matches['url']);
            foreach ($filtered_matches as $key => $match) {
                $orig_str = $match;
                $new_str = $orig_str;
                if( $this->modules[self::MODULE_IP2NATION]->isInstalled() && $this->options['LocaleByGeoIP'] ) {
                    $new_str = $this->localize_static_tag( $new_str );
                }
                $new_str = $this->replace_associate_tag( $new_str );
                if( $orig_str != $new_str ) {
                    $content = str_replace($orig_str, $new_str, $content);
                }
            }
        }
        return $content;
    }

    /**
     * Are AWS Credentials Valid
     * @return boolan
     */
    public function isValidCredentials() {
        if( is_null($this->options['AWSValid']) ) {
            return $this->validateCredentials();
        } else {
            return $this->options['AWSValid'];
        }
    }

     /**
     * Validate AWS Credentials
     * @return boolean
     */
    public function validateCredentials() {
        if( ! empty($this->options['AccessKey']) && ! empty($this->options['SecretKey'])) {

            $api = $this->getAPI();
            $result = null;
            switch( $this->getGeoLocale() ) {
                case 'US':
                    $result = $api->browseNodeLookup("1000");
                    break;
                case "UK":
                    $result = $api->browseNodeLookup("1025612");
                    break;
                case "CA":
                    $result = $api->browseNodeLookup("927726");
                    break;
                case "CN":
                    $result = $api->browseNodeLookup("658390051");
                    break;
                case "DE":
                    $result = $api->browseNodeLookup("541686");
                    break;
                case "ES":
                    $result = $api->browseNodeLookup("599364031");
                    break;
                case "FR":
                    $result = $api->browseNodeLookup("468256");
                    break;
                case "IT":
                    $result = $api->browseNodeLookup("411663031");
                    break;
                case "JP":
                    $result = $api->browseNodeLookup("465610");
                    break;
            }
            if( $result != null && $result->isSuccess() ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Localize Static Tags
     * @param String $orig_str Amazon Product URL
     * @return String localized link
     */
    public function localize_static_tag( $orig_str ) {
            $locale = $this->getGeoLocale();
            $new_str = $orig_str;
            $replacement = 'amazon.com';
            switch ( $locale ) {
                    case "US" :
                            $replacement = 'amazon.com';
                            break;
                    case "UK" :
                            $replacement = 'amazon.co.uk';
                            break;
                    case "DE" :
                            $replacement = "amazon.de";
                            break;
                    case "CA" :
                            $replacement = "amazon.ca";
                            break;
                    case "JP" :
                            $replacement = "amazon.co.jp";
                            break;
                    case "FR" :
                            $replacement = "amazon.fr";
                            break;
                    case "CN" :
                            $replacement = "amazon.cn";
                            break;
                    case "IT" :
                            $replacement = "amazon.it";
                            break;
                    case "ES" :
                            $replacement = "amazon.es";
                            break;
            }
            $new_str = str_replace( 'amazon.com', $replacement, $new_str );
            $new_str = str_replace( 'amazon.co.uk', $replacement, $new_str );
            $new_str = str_replace( 'amazon.co.jp', $replacement, $new_str );
            $new_str = str_replace( 'amazon.de', $replacement, $new_str );
            $new_str = str_replace( 'amazon.ca', $replacement, $new_str );
            $new_str = str_replace( 'amazon.fr', $replacement, $new_str );
            $new_str = str_replace( 'amazon.cn', $replacement, $new_str );
            $new_str = str_replace( 'amazon.it', $replacement, $new_str );
            $new_str = str_replace( 'amazon.es', $replacement, $new_str );
            $handle   = curl_init($new_str);
            if (false === $handle) {
                    return $orig_str;
            }
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_NOBODY, true);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);
            if($httpCode == 404 || $httpCode == 405) {
                    return $orig_str;
            } else {
                    return $new_str;
            }
    }

    /**
     * Replace Amazon Associate Id in content
     *
     * @param string $orig_str
     * @return string
     */
    public function replace_associate_tag( $orig_str ) {
        global $post;
        $locale = $this->getLocale();
        if( strpos( $orig_str, "amazon.com" ) !== false ) {
            $locale = "US";
        } else if( strpos( $orig_str, "amazon.co.uk" ) !== false ) {
            $locale = "UK";
        } else if( strpos( $orig_str, "amazon.fr" ) !== false ) {
            $locale = "FR";
        } else if( strpos( $orig_str, "amazon.de" ) !== false ) {
            $locale = "DE";
        } else if( strpos( $orig_str, "amazon.co.jp" ) !== false ) {
            $locale = "JP";
        } else if( strpos( $orig_str, "amazon.ca" ) !== false ) {
            $locale = "CA";
        } else if( strpos( $orig_str, "amazon.cn" ) !== false ) {
            $locale = "CN";
        } else if( strpos( $orig_str, "amazon.it" ) !== false ) {
            $locale = "IT";
        } else if( strpos( $orig_str, "amazon.es" ) !== false ) {
            $locale = "ES";
        }
        $new_str = "";
        $tag_regex = "|.*?tag=(?P<aid>.*?)(&*)?$|i";
        $pos = strpos($orig_str, "tag=");
        if ($pos === false) { // no Associate Tag so append
            if (strpos($orig_str, "?") === false) {
                $new_str = $orig_str . "?tag=" . $this->getAssociateId($locale, $post->post_author);
            } else {
                $new_str = $orig_str . "&tag=" . $this->getAssociateId($locale, $post->post_author);
            }
        } else { // associate tag so replace
            preg_match($tag_regex, $orig_str, $tagMatch);
            $new_str = str_replace($tagMatch[1], $this->getAssociateId($locale, $post->post_author), $orig_str);
        }

        return $new_str;
    }

    /**
     * Register Amazon Button
     * @param array $buttons
     * @return array
     */
    public function register_amazon_button($buttons) {
        array_push($buttons, "seperator", "amazonproductlink");
        return $buttons;
    }

    /**
     * Load the TinyMCE plugin :: editor_plugin.js
     * @param array $plugin_array
     * @return array
     */
    public function register_amazon_tinymce_plugin($plugin_array) {
        $url = get_bloginfo('wpurl') . '/' . PLUGINDIR . '/wordpress-amazon-associate/tinymce/amazon/editor_plugin.js.php';
        $params = "?product=" . $this->isValidCredentials();
        $widgetModule = $this->getModule(self::MODULE_AMAZON_WIDGETS);
        if( $widgetModule->isEnabled( 'AmazonCarouselWidget' ) ) {
            $params .= "&carousel=true";
        }
        if( $widgetModule->isEnabled( 'AmazonMyFavoritesWidget') ) {
            $params .= "&my-favorites=true";
        }
        if( $widgetModule->isEnabled( 'AmazonMP3ClipsWidget') ) {
            $params .= "&mp3-clips=true";
        }
        if( $widgetModule->isEnabled( 'AmazonOmakaseWidget') ) {
            $params .= "&omakase=true";
        }
        if( $widgetModule->isEnabled( 'AmazonProductCloudWidget') ) {
            $params .= "&product-cloud=true";
        }
        if( $widgetModule->isEnabled( 'AmazonSearchWidget') ) {
            $params .= "&search=true";
        }
        $plugin_array['amazonproductlink'] = $url . $params;
        return $plugin_array;
    }

    /**
     * get configured instance of AmazonProductAPI
     * @return AmazonProductAPI
     */
    public function getAPI( $locale = null ) {
        $apapi = new AmazonProductAPI();
        $locale = $this->getGeoLocale( $locale );
        $apapi->setLocale( $locale );
        global $post;
        $author_id = null;
        if( !is_null( $post ) && isset( $post->post_author ) ) {
            $author_id = $post->post_author;
        }
        $apapi->setAssociateId($this->getAssociateId( $locale, $author_id ));
        $apapi->setAccessKey($this->options['AccessKey']);
        $apapi->setSecretKey($this->options['SecretKey']);
        return $apapi;
    }

    /**
     * get AssociateId
     * @return string
     */
    public function getAssociateId( $locale = null, $author_id = null ) {

        // Get Geo Locale if enabled
        $locale = $this->getGeoLocale($locale);

        $associate_id = "";
        if( $author_id != null && $this->options['MultiUser'] ) {
           $associate_id = $this->getModule( self::MODULE_MULTI_USER )->getUserAssociateId( $author_id, $locale);
        }

        if( empty($associate_id) ) {
            // user entered Associate Tag
            $associate_id = $this->associate_tags[$locale];
        }

        // Check if should use our associate tag
        if( empty( $associate_id ) ) {
            // no associate tag
            return $this->our_associate_tags[$locale];
        } else {
            // set to our Associate Tag if enabled
            $supportThreshold = intval($this->options['AssociateSupport']);
            if ($supportThreshold != 0) {
                if (rand(1, 100) <= $supportThreshold) {
                    return $this->our_associate_tags[$locale];
                }
            }
            // set to Admin Associate Tag if enabled
            $supportThreshold = intval($this->options['AdminSupport']);
            if( $supportThreshold != 0 ) {
                if( rand(1,100) <= $supportThreshold ) {
                    return $this->associate_tags[$locale];
                }
            }
        }

        return $associate_id;
    }



    /**
     * get Array of Enabled Locales
     * @param String $locale Amazon Locale
     * @return boolean
     */
    public function getEnabledLocales( $empty = false ) {
        $locales = array();
        if( $empty ) {
            $locales[""] = "";
        }
        foreach( $this->enabled_locales as $locale => $flag ) {
            if( $flag ) {
                $locales[$locale] = $locale;
            }
        }
        return $locales;
    }

    /**
     * is Locale Enabled
     * @param String $locale Amazon Locale
     * @return boolean
     */
    public function isLocaleEnabled( $locale ) {
        if( $this->enabled_locales[$locale] === false ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * get Locale by IP
     * @return string
     */
    public function getGeoLocale( $locale = null) {
        if( is_null( $locale ) || empty( $locale ) ) {
            // Admin Localization
            if( function_exists('wp_get_current_user') && function_exists('current_user_can') ) {
                if ( current_user_can('manage_options') ) {
                    if( $this->options['CVEnabled'] && $this->options['CVLocale'] != '' ) {
                        return $this->options['CVLocale'];
                    }
                }
            }
            // Get Geo Locale if enabled
            if(  $this->modules[self::MODULE_IP2NATION]->isInstalled() && $this->options['LocaleByGeoIP'] ) {
                $locale = $this->modules[self::MODULE_IP2NATION]->getGeoLocale();
                // Set to default locale if not supported
                if( $this->enabled_locales[$locale] === false ) {
                    $locale = $this->getLocale();
                }
            } else {
                $locale = $this->getLocale();
            }
        }
        return $locale;
    }

    /**
     * get Settings Locale
     * @return string
     */
    public function getLocale() {
        return $this->options['Locale'];
    }

    /**
     * get cache handler
     * @return WPAA_CacheHandler
     */
    public function getCacheHandler() {
        return $this->modules[self::MODULE_CACHE]->getCacheHandler();
    }

    /**
     * get Associate Tags
     * @return array
     */
    public function getAssociateTags() {
        return $this->associate_tags;
    }

    /**
     * Save Associate tags
     */
    public function saveAssociateTags( $tags ) {
        update_option($this->tags_options_name, $tags );
    }

    /**
     * Save Plugin Settings
     */
    public function saveSettings() {
        if( isset( $_POST["wpaa_config_edit"]) && isset( $_POST["wpaa-config-meta-nonce"] ) ) {

            $wpaa_edit = $_POST["wpaa_config_edit"];
            $nonce = $_POST['wpaa-config-meta-nonce'];
            if ( !empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-config-meta-nonce')) {

                //update AccessKey
                if (isset($_POST['AccessKey'])) {
                    $this->options['AccessKey'] = $_POST['AccessKey'];
                }
                //update SecretKey
                if (isset($_POST['SecretKey'])) {
                    $this->options['SecretKey'] = $_POST['SecretKey'];
                }

                //update Locale
                if (isset($_POST['Locale'])) {
                    $this->options['Locale'] = $_POST['Locale'];
                }
                //update LocaleByGeoIP
                if (isset($_POST['LocaleByGeoIP'])) {
                    $this->options['LocaleByGeoIP'] = true;
                } else {
                    $this->options['LocaleByGeoIP'] = false;
                }
                //update AssociateSupport
                if (isset($_POST['AssociateSupport'])) {
                    $this->options['AssociateSupport'] = $_POST['AssociateSupport'];
                }
                //update AdminSupport
                if (isset($_POST['AdminSupport'])) {
                    $this->options['AdminSupport'] = $_POST['AdminSupport'];
                }
                //update ProductPreview
                if (isset($_POST['ProductPreview'])) {
                    $this->options['ProductPreview'] = true;
                } else {
                    $this->options['ProductPreview'] = false;
                }
                //update ProductPreviewNoConflict
                if (isset($_POST['ProductPreviewNoConflict'])) {
                    $this->options['ProductPreviewNoConflict'] = true;
                } else {
                    $this->options['ProductPreviewNoConflict'] = false;
                }
                //update FilterAssociateTag
                if (isset($_POST['FilterAssociateTag'])) {
                    $this->options['FilterAssociateTag'] = true;
                } else {
                    $this->options['FilterAssociateTag'] = false;
                }
                //update MultiUser
                if (isset($_POST['MultiUser'])) {
                    $this->options['MultiUser'] = true;
                } else {
                    $this->options['MultiUser'] = false;
                }
                // update CVEnabled
                if (isset($_POST['CVEnabled'])) {
                    $this->options['CVEnabled'] = true;
                } else {
                    $this->options['CVEnabled'] = false;
                }
                // update CVLocale
                if (isset($_POST['CVLocale'])) {
                    $this->options['CVLocale'] = $_POST['CVLocale'];
                }
                // Validate Credentials
                $this->options['AWSValid'] = $this->validateCredentials();
                update_option($this->config_options_name, $this->options);

                // update Assoicate Tags
                if (isset($_POST['AssociateTag-US'])) {
                    $this->associate_tags['US'] = $_POST['AssociateTag-US'];
                }
                if (isset($_POST['AssociateTag-DE'])) {
                    $this->associate_tags['DE'] = $_POST['AssociateTag-DE'];
                }
                if (isset($_POST['AssociateTag-CA'])) {
                    $this->associate_tags['CA'] = $_POST['AssociateTag-CA'];
                }
                if (isset($_POST['AssociateTag-CN'])) {
                    $this->associate_tags['CN'] = $_POST['AssociateTag-CN'];
                }
                if (isset($_POST['AssociateTag-FR'])) {
                    $this->associate_tags['FR'] = $_POST['AssociateTag-FR'];
                }
                if (isset($_POST['AssociateTag-IT'])) {
                    $this->associate_tags['IT'] = $_POST['AssociateTag-IT'];
                }
                if (isset($_POST['AssociateTag-JP'])) {
                    $this->associate_tags['JP'] = $_POST['AssociateTag-JP'];
                }
                if (isset($_POST['AssociateTag-UK'])) {
                    $this->associate_tags['UK'] = $_POST['AssociateTag-UK'];
                }
                if (isset($_POST['AssociateTag-ES'])) {
                    $this->associate_tags['ES'] = $_POST['AssociateTag-ES'];
                }
                update_option($this->tags_options_name, $this->associate_tags );

                // update enabled Locales
                if (isset($_POST['Locale-US'])) {
                    $this->enabled_locales['US'] = true;
                } else {
                    $this->enabled_locales['US'] = false;
                }
                if (isset($_POST['Locale-DE'])) {
                    $this->enabled_locales['DE'] = true;
                } else {
                    $this->enabled_locales['DE'] = false;
                }
                if (isset($_POST['Locale-CA'])) {
                    $this->enabled_locales['CA'] = true;
                } else {
                    $this->enabled_locales['CA'] = false;
                }
                if (isset($_POST['Locale-CN'])) {
                    $this->enabled_locales['CN'] = true;
                } else {
                    $this->enabled_locales['CN'] = false;
                }
                if (isset($_POST['Locale-FR'])) {
                    $this->enabled_locales['FR'] = true;
                } else {
                    $this->enabled_locales['FR'] = false;
                }
                if (isset($_POST['Locale-JP'])) {
                    $this->enabled_locales['JP'] = true;
                } else {
                    $this->enabled_locales['JP'] = false;
                }
                if (isset($_POST['Locale-UK'])) {
                    $this->enabled_locales['UK'] = true;
                } else {
                    $this->enabled_locales['UK'] = false;
                }
                if (isset($_POST['Locale-CA'])) {
                    $this->enabled_locales['CA'] = true;
                } else {
                    $this->enabled_locales['CA'] = false;
                }
                if (isset($_POST['Locale-IT'])) {
                    $this->enabled_locales['IT'] = true;
                } else {
                    $this->enabled_locales['IT'] = false;
                }
                if (isset($_POST['Locale-ES'])) {
                    $this->enabled_locales['ES'] = true;
                } else {
                    $this->enabled_locales['ES'] = false;
                }
                update_option($this->locales_options_name, $this->enabled_locales );

                $this->message = __("<strong>Success:</strong> Settings successfully updated.", "wpaa");
            }
        }
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_menu_page("WP - Amazon", "WP - Amazon", $this->config_options_lvl, $this->config_hook, array(&$this, 'doPage'));
        add_submenu_page($this->config_hook, "Settings", "Settings", $this->config_options_lvl, $this->config_hook, array(&$this, 'doPage'));

    }

    /**
     * load Plugin Options
     */
    private function loadOptions() {
        //load Associate tags
        $tag_options = get_option( $this->tags_options_name );
        $this->associate_tags = $this->our_associate_tags;
        if( $tag_options !== false ) {
            foreach ($tag_options as $key => $value) {
                if( ! empty( $value ) ) {
                    $this->associate_tags[$key] = $value;
                }
            }
        }

        // load Enabled Locales
        $locale_options = get_option( $this->locales_options_name );
        if( $locale_options !== false ) {
            foreach ($locale_options as $key => $value) {
                $this->enabled_locales[$key] = $value;
            }
        }

        // load Options
        $saved_options = get_option( $this->config_options_name );
        if( $saved_options !== false ) {
            foreach ($saved_options as $key => $value) {
                $this->options[$key] = $value;
            }
        }

    }

    /**
     * Version Upgrade :: update plugin options
     */
    private function upgrade() {

        // removal of AssociateId  :: Version < 1.1 Upgrade
        if( isset( $this->options["AssociateId"] ) ) {
            $this->associate_tags[$this->options["Locale"]] = $this->options["AssociateId"];
            unset( $this->options["AssociateId"] );
            update_option($this->config_options_name, $this->options);
            update_option($this->tags_options_name, $this->associate_tags);
        }

        // migration of Widgets Enabled :: Version < 1.7.0 Upgrade
        if( isset( $this->options['AmazonCarouselWidget'])) {
            $this->modules[self::MODULE_AMAZON_WIDGETS]->updateSettings( $this->options );
            unset( $this->options['AmazonCarouselWidget'] );
            unset( $this->options['AmazonMyFavoritesWidget'] );
            unset( $this->options['AmazonMP3ClipsWidget'] );
            unset( $this->options['AmazonSearchWidget'] );
            unset( $this->options['AmazonOmakaseWidget'] );
            unset( $this->options['AmazonProductCloudWidget'] );
            update_option($this->config_options_name, $this->options );
        }

        // update AWSValid with current settings :: Version < 1.7.0 Upgrade
        if( is_null( $this->options['AWSValid'] ) ) {
            $this->options['AWSValid'] = $this->validateCredentials();
            update_option($this->config_options_name, $this->options );
        }

        // update Saved Version plugin
        if( is_null( $this->options['Version'] ) || $this->options['Version'] != $this->version ) {
            $old_version = $this->options['Version'];
            $this->options['Version'] = $this->version;
            update_option($this->config_options_name, $this->options);
        }
    }

    /**
     * Get the path to a file within the plugin
     *
     * @param string
     * @return string
     */
    public function getPluginPath( $url) {
        return plugins_url($url, __FILE__);
    }

    /**
     * Output Admin Page header scripts
     */
    public function doPageHead() {
        if (isset($_GET['page']) && $_GET['page'] == $this->config_hook) {
            wp_enqueue_script('jquery');
        }
    }

    /**
     * Output Config Page Styles
     */
    function doPageStyles() {
        if (isset($_GET['page']) && $_GET['page'] == $this->config_hook) {
            wp_enqueue_style('dashboard');
            wp_enqueue_style('thickbox');
            wp_enqueue_style('global');
            wp_enqueue_style('wp-admin');
            wp_enqueue_style('wpaa-admin-css', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/css/admin.css');
        } else if( is_admin() ) {
            wp_enqueue_style('thickbox');
            wp_enqueue_style('fancybox', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/js/fancybox/jquery.fancybox-1.3.4.css' );
            wp_enqueue_style('wpaa-widget-css', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/css/widget.css');
        }
    }

    /**
     * Output Page Scripts
     */
    function doPageScripts() {
        if (isset($_GET['page']) && $_GET['page'] == $this->config_hook) {
            wp_enqueue_script('postbox');
            wp_enqueue_script('dashboard');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');
        } else if( is_admin() ){
            wp_enqueue_script('thickbox');
            wp_enqueue_script('fancybox', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/js/fancybox/jquery.fancybox-1.3.4.js' );
        }
    }

    /**
     * output Main Settings Page
     */
    public function doPage() {
        // output message if set
        if( ! empty( $this->message ) ) {
            echo '<div class="updated fade">' . $this->message . '</div>';
        }
        if( ! $this->isValidCredentials() ) {
            echo '<div class="error">' . __('<strong>Warning</strong>: Quick Links and Product Searches are disabled. To enable please enter your valid AWS Access and Secret Keys', 'wpaa' ) . '</div>';
        }
        ?>
<div class="wrap">
    <h2>WordPress Amazon Associate: <?php _e('Settings', 'wpaa'); ?></h2>
    <div class="postbox-container" style="width:500px;" >
        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <form action="<?php echo admin_url('admin.php?page=' . $this->config_hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_config_edit" type="hidden" name="wpaa_config_edit" />
                    <input type="hidden" name="wpaa-config-meta-nonce" value="<?php echo wp_create_nonce('wpaa-config-meta-nonce') ?>" />
                            <?php
                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><th>' . __('Primary', 'wpaa') . '</th><th>' . __('Amazon Locale', 'wpaa') . '</th><th>' . __('Associate Tag', 'wpaa') . '</th><th>' . __( 'Active', 'wpaa') . '</th></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "US", (($this->options['Locale'] == "US" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_us.gif') . '" />&nbsp;<a href="https://affiliate-program.amazon.com/" target="_blank">' . __('United States', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-US', $this->associate_tags['US'] == $this->our_associate_tags['US'] ? "" : $this->associate_tags['US']) . '</td><td>' . $this->checkbox( 'Locale-US', $this->enabled_locales['US'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "CA", (($this->options['Locale'] == "CA" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_ca.gif') . '" />&nbsp;<a href="https://associates.amazon.ca/" target="_blank">' . __('Canada', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-CA', $this->associate_tags['CA'] == $this->our_associate_tags['CA'] ? "" : $this->associate_tags['CA']) . '</td><td>' . $this->checkbox( 'Locale-CA', $this->enabled_locales['CA'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "CN", (($this->options['Locale'] == "CN" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_cn.gif') . '" />&nbsp;<a href="https://associates.amazon.cn//" target="_blank">' . __('China', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-CN', $this->associate_tags['CN'] == $this->our_associate_tags['CN'] ? "" : $this->associate_tags['CN']) . '</td><td>' . $this->checkbox( 'Locale-CN', $this->enabled_locales['CN'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "DE", (($this->options['Locale'] == "DE" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_de.gif') . '" />&nbsp;<a href="https://partnernet.amazon.de/" target="_blank">' . __('Germany', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-DE', $this->associate_tags['DE'] == $this->our_associate_tags['DE'] ? "" : $this->associate_tags['DE']) . '</td><td>' . $this->checkbox( 'Locale-DE', $this->enabled_locales['DE'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "ES", (($this->options['Locale'] == "ES" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_es.gif') . '" />&nbsp;<a href="https://afiliados.amazon.es/" target="_blank">' . __('Spain', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-ES', $this->associate_tags['ES'] == $this->our_associate_tags['ES'] ? "" : $this->associate_tags['ES']) . '</td><td>' . $this->checkbox( 'Locale-ES', $this->enabled_locales['ES'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "FR", (($this->options['Locale'] == "FR" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_fr.gif') . '" />&nbsp;<a href="https://partenaires.amazon.fr/" target="_blank">' . __('France', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-FR', $this->associate_tags['FR'] == $this->our_associate_tags['FR'] ? "" : $this->associate_tags['FR']) . '</td><td>' . $this->checkbox( 'Locale-FR', $this->enabled_locales['FR'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "IT", (($this->options['Locale'] == "IT" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_it.gif') . '" />&nbsp;<a href="https://programma-affiliazione.amazon.it/" target="_blank">' . __('Italy', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-IT', $this->associate_tags['IT'] == $this->our_associate_tags['IT'] ? "" : $this->associate_tags['IT']) . '</td><td>' . $this->checkbox( 'Locale-IT', $this->enabled_locales['IT'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "JP", (($this->options['Locale'] == "JP" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_jp.gif') . '" />&nbsp;<a href="https://affiliate.amazon.co.jp/" target="_blank">' . __('Japan', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-JP', $this->associate_tags['JP'] == $this->our_associate_tags['JP'] ? "" : $this->associate_tags['JP']) . '</td><td>' . $this->checkbox( 'Locale-JP', $this->enabled_locales['JP'] ) . '</td></tr>';
                            $content .= '<tr><td>' . $this->radio( "Locale", "UK", (($this->options['Locale'] == "UK" )? true: false) ) . '</td><td><img width="18" height="11" src="' . $this->getPluginPath( '/imgs/flag_uk.gif') . '" />&nbsp;<a href="https://affiliate-program.amazon.co.uk/" target="_blank">' . __('United Kingdom', 'wpaa') . '</a></td><td>' . $this->textinput( 'AssociateTag-UK', $this->associate_tags['UK'] == $this->our_associate_tags['UK'] ? "" : $this->associate_tags['UK']) . '</td><td>' . $this->checkbox( 'Locale-UK', $this->enabled_locales['UK'] ) . '</td></tr>';
                            $content .= '</table><br/>';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td width="350"><strong>' . __("Enable Geo Localization?", "wpaa") . '</strong></td><td>';
                            if( $this->modules[self::MODULE_IP2NATION]->isInstalled() ) {
                                $content .= $this->checkbox( 'LocaleByGeoIP', $this->options['LocaleByGeoIP'] );
                            } else {
                                $content .=  '<small><a href="' . admin_url('admin.php?page=' . $this->modules[self::MODULE_IP2NATION]->getHook() ) . '">ip2nation</a> ' . __('is required for Geo Localization', 'wpaa') . "</small>";
                            }
                            $content .= '</td></tr>'; $content .= '</table>';
                            $content .= '<strong>' . __('Support Us, use our Associate id for', 'wpaa') . $this->select("AssociateSupport", array("0" =>"0", "5"=>"5", "10"=>"10", "15"=>"15", "20"=>"20", "25"=>"25","30"=>"30", "40"=>"40", "50"=>"50"), $this->options["AssociateSupport"]) . '% ' . __('of links', 'wpaa') . '</strong>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings', 'wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '<p>' . __('Not an Amazon Associate?','wpaa') . '<br/>' . __('Join today by visiting the amazon associate website for your desired locale by clicking the above locale names','wpaa') . '</p>';
                            $content .= '</div>';
                            $this->postbox("amazon_associate_settings", __("Amazon Associate Settings",'wpaa'), $content);

                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Access Key:','wpaa') . '</strong></td><td>' . $this->textinput("AccessKey", $this->options["AccessKey"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Secret Key:','wpaa') . '</strong></td><td>' . $this->textinput("SecretKey", $this->options["SecretKey"]) . '</td></tr>';
                            $content .= '<tr><td><input class="button-primary" type="button" name="validate" value="' . __('Validate Credentials','wpaa') . ' &raquo;" onclick="validateAccess();" /></td><td><div id="accessMessage" style="display:none"></div></td></tr>';
                            $content .= '<tr><td colspan="2"><div id="accessError" style="display:none"></div></td></tr>';
                            $content .= '</table>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= "<p>" . __("Don't have an Amazon Web Services account?",'wpaa') . "<br/>" . __('Sign-up for your free account today at','wpaa') . ' <a href="http://aws.amazon.com//" target="_blank">http://aws.amazon.com/</a></p>';
                            $content .= '</div>';
                            $this->postbox("amazon_web_service_settings", __("Amazon Web Services Settings",'wpaa'), $content);

                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Enable Author Specific Assoicate Tags?','wpaa') . '</strong></td><td>' . $this->checkbox( 'MultiUser', $this->options['MultiUser'] ) . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<strong>' . __('Use Admin Associate Id for ', 'wpaa') . $this->select("AdminSupport", array("0" =>"0", "5"=>"5", "10"=>"10", "15"=>"15", "20"=>"20", "25"=>"25","30"=>"30", "40"=>"40", "50"=>"50"), $this->options["AdminSupport"]) . '% ' . __('of Author Links', 'wpaa') . '</strong>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '</div>';
                            $this->postbox("amazon_multi_author_settings", __("Multi-Author Website Settings",'wpaa'), $content);

                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Enable Product Previews:','wpaa') . '</strong></td><td>' . $this->checkbox("ProductPreview", $this->options["ProductPreview"]) . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<p><small>' . __('* Please note that this feature may not work on all themes, this is a bug with the amazon code itself as a fix for some theme/plugin combinations check this box.','wpaa') . $this->checkbox("ProductPreviewNoConflict", $this->options["ProductPreviewNoConflict"]) . __(' If checked jQuery will be remapped to a new object prior to inserting the amazon code than remapped to $ after.','wpaa') . '</small></p>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings &raquo;','wpaa') . '" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '<p>' . __('The Amazon Product Preview enhances your site content by adding product preview popups to qualified amazon links. Full information can be found on the','wpaa') . ' <a href="https://affiliate-program.amazon.com/gp/associates/network/build-links/previews/main.html" target="_blank">' . __('Amazon Associate Website','wpaa') . '</a>.</p>';
                            $content .= '</div>';
                            $this->postbox("amazon_product_preview_settings", __("Amazon Product Preview Settings",'wpaa'), $content);

                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Enable Associate Filter:','wpaa') . '</strong></td><td>' . $this->checkbox("FilterAssociateTag", $this->options["FilterAssociateTag"]) . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= "<p>" . __('The Associate Filter will enable replacement of static Amazon links Associate Tags with your specified associate id.','wpaa') . "</p>";
                            $content .= '</div>';
                            $this->postbox("amazon_associate_filter_settings", __("Amazon Associate Filter Settings",'wpaa'), $content);

                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Enable Locale Viewing for Administrators:','wpaa') . '</strong></td><td>' . $this->checkbox("CVEnabled", $this->options["CVEnabled"]) . '</td></tr>';
                            $lOptions = array( " " => "" );
                            foreach( $this->enabled_locales as $localeKey => $localeValue ) {
                                if( $localeValue ) {
                                    $lOptions[$localeKey] = $localeKey;
                                }
                            }
                            $content .= '<tr><td><strong>' . __('Locale to view content as:','wpaa') . '</strong></td><td>' . $this->select("CVLocale", $lOptions, $this->options['CVLocale'] ) . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= "<p>" . __('This option allows administrators to view the website content with links localized to a specific Amazon Locale for verification of content displayed to website visitors from different geographic locations.','wpaa') . "</p>";
                            $content .= '</div>';
                            $this->postbox("amazon_associate_content_viewer_settings", __("Admin Localization Settings",'wpaa'), $content);
                            ?>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function validateAccess() {
            var locale = jQuery("input[name=Locale]:checked").val();
            var accessKey = encodeURIComponent(jQuery("#AccessKey").val());
            var secretKey = encodeURIComponent(jQuery("#SecretKey").val());
            jQuery.ajax({
                url: '<?php echo plugins_url('/servlet/index.php', __FILE__); ?>',
                type: 'POST',
                dataType: 'json',
                data: 'Action=ValidateAccess&Locale=' + locale + '&AccessKey=' + accessKey + '&SecretKey=' + secretKey,
                success: function(data) {
                    if( data.IsValid == "True" ) {
                        jQuery( "#accessMessage" ).html( '<span style="color:green;" >Valid</span>' );
                        jQuery( "#accessError" ).hide();
                    } else {
                        var errorString = '<b>Code:</b> ' + data.Errors[0].Code + '<br/><br/><b>Message:</b><br/>' + data.Errors[0].Message;
                        if( data.Errors[0].Code == 'InternalError' ) {
                            errorString += '<br/><br/>You may not have accepted the API Agreement please sign-in to the <a href="https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html" target="_blank">Amazon Product Advertising API</a> and then re-validate.';
                        } else if ( data.Errors[0].Code == 'InvalidClientTokenId' ) {
                            errorString += "<br/><br/>Amazon has rejected your AWS Access Key, please confirm your access and secret key are correct and that they don't contain extra spaces";
                        }
			jQuery( "#accessError" ).html( '<p>' + errorString + '</p>' ).show();
                        jQuery( "#accessMessage" ).html( '<span style="color:red;" >InValid</span>' );
                    }
                    jQuery( "#accessMessage" ).show();
                }
            });
        }

        validateAccess();
    </script>
<?php
        $this->doAdminSideBar('plugin-admin');
?>
</div>
        <?php
    }

    /**
     * simple autoload function
     * returns true if the class was loaded, otherwise false
     *
     * <code>
     * // register the class auto loader
     * spl_autoload_register( array('WPAA', 'autoload') );
     * </code>
     *
     * @param string $classname Name of Class to be loaded
     * @return boolean
     */
    public static function autoload($className) {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return false;
        }
        $class = self::getPath() . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($class)) {
            require $class;
            return true;
        }
        return false;
    }

    /**
     * Get the root path to WordPress Amazon Associate Plugin
     *
     * @return string
     */
    public static function getPath() {
        if (!self::$_path) {
            self::$_path = dirname(__FILE__);
        }
        return self::$_path;
    }

}