<?php
/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
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

/**
 * WPAA Quick Links Module
 *
 * This file contains the class WPAA_Module_QuickLinks
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Quick Links Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_QuickLinks extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-quick-links";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-quick-links";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $options_lvl = "manage_options";

    /**
     * Module Options
     * @var Array
     */
    protected $options = array();

    /**
     * Constructor
     * @param string $parent_hook
     * @param string $version
     * @param string $last_updated
     */
    function __construct( $parent_hook, $version, $last_updated ) {
        parent::__construct();
        $this->parent_hook = $parent_hook;
        $this->version = $version;
        $this->last_updated = $last_updated;
        add_action('add_meta_boxes', array(&$this, 'add_meta_boxes') );
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        //add_submenu_page($this->parent_hook, "Quick Links", "Quick Links", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * add editor Meta Boxes
     */
    public function add_meta_boxes() {
        add_meta_box( 'wpaa_quick_link', __( 'Amazon Quick Links', 'wpaa' ),
                array( &$this, 'quickLinksForm'), 'post', 'side', 'default' );
        add_meta_box( 'wpaa_quick_link', __( 'Amazon Quick Links', 'wpaa' ),
                array( &$this, 'quickLinksForm'), 'page', 'side', 'default' );
    }

    public function quickLinksForm() {
        global $wpaa;
        $content = "";
        $content = '<label>' . __('Search Term:', 'wpaa') . '</label>';
        $content .= $this->textinput( "WPAA-SearchTerm", "" );
        $content .= "<br/>";
        $content .= '<label>' . __('Search Index:', 'wpaa') . '</label><br/>';
        $content .= $this->select( "WPAA-SearchIndex", AmazonProduct_SearchIndex::SupportedSearchIndexes(), "" );

        $content .= '<input type="button" style="float:right" class="button-secondary" value="Search" onclick="WPAAdoProductSearch();" />';
        $content .= '<div style="clear:both;"></div>';
        $content .= "<strong>" . __('Search Results:', 'wpaa') . '</strong><br/>';
        $content .= '<div id="WPAA-SearchResults"></div>';
        echo $content;
?>
<script type="text/javascript">
    var WPAAProduts = null;

    function WPAAdoProductLink( id ) {
        var content_prefix = '[amazon_link id="' + WPAAProducts[id].ASIN + '" target="_blank" ]';
        var content = WPAAProducts[id].ItemAttributes.Title;
        var content_suffix = "[/amazon_link]";
        if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
            var selected_txt = tinyMCE.get("content").selection.getContent({format : 'text'});
            if( selected_txt != "" ) {
                content = selected_txt;
            }
            tinyMCE.execCommand('mceInsertContent', false, content_prefix + content + content_suffix );
            tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
        } else {
            var selected_txt = (!!document.getSelection) ? document.getSelection() :
	       (!!window.getSelection)   ? window.getSelection() :
	       document.selection.createRange().text;
            if( selected_txt != "" ) {
                content = selected_txt;
            }
            send_to_editor( content_prefix + content + content_suffix );
        }
        return false;
    }

    function WPAAdoProductEnhanced( id ) {
        var content = '[amazon_enhanced asin="' + WPAAProducts[id].ASIN + '" /]';
        if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
            tinyMCE.execCommand('mceInsertContent', false, content );
            tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
        } else {
            send_to_editor( content );
        }
        return false;
    }

    function WPAAdoProductImage( id) {
        var content_prefix = '[amazon_image id="' + WPAAProducts[id].ASIN + '" link="true" target="_blank" size="medium" ]';
        var content = WPAAProducts[id].ItemAttributes.Title;
        var content_suffix = "[/amazon_image]";

        if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
            var selected_txt = tinyMCE.get("content").selection.getContent({format : 'text'});
            if( selected_txt != "" ) {
                content = selected_txt;
            }
            tinyMCE.execCommand('mceInsertContent', false, content_prefix + content + content_suffix );
            tinyMCE.execInstanceCommand("mce_editor_0", "mceFocus");
        } else {
            var selected_txt = (!!document.getSelection) ? document.getSelection() :
	       (!!window.getSelection)   ? window.getSelection() :
	       document.selection.createRange().text;
            if( selected_txt != "" ) {
                content = selected_txt;
            }
            send_to_editor( content_prefix + content + content_suffix );
        }
        return false;
    }

    function WPAAdoProductSearch( ) {
        var Keywords = jQuery("#WPAA-SearchTerm").val();
        var SearchIndex = jQuery("#WPAA-SearchIndex").val();
        var date=new Date();
        jQuery.ajax({
            url: "<?php echo $wpaa->getPluginPath("servlet/index.php")?>",
            type: 'POST',
            dataType: 'jsonp',
            data: 'Action=ItemSearch&SearchIndex=' + SearchIndex + '&Keywords=' + Keywords + '&Random=' + date.getTime(),
            success: function(data) {
                if( data.IsValid == "True" ) {
                    WPAAProducts = data.Items;
                    var html_txt = '<table cellspacing="0" cellpadding="0" style="border: 1px solid #DFDFDF; border-collapse:collapse;" >';
                    jQuery.each(data.Items, function(i,item){
                        var hasImage = true;
                        var row_txt = '<tr><td style="border: 1px solid #DFDFDF;">';
                        // Add Product Info
                        row_txt += '<div style="padding:3px 2px; margin:0 auto;">';
                        if( 'SmallImage' in item ) {
                            row_txt += '<img src="' + item.SmallImage.URL + '" /><br/>';
                        } else {
                           hasImage = false;
                        }
                        row_txt += '</div></td><td style="border: 1px solid #DFDFDF;"><div style="padding:3px 2px; 3px; 0px;">';
                        row_txt += "<strong>" + item.ItemAttributes.Title + "</strong><br/>";
                        // append buttons
                        row_txt += '<input style="float:right;" type="button" class="button-secondary" value="Insert Link" onclick="WPAAdoProductLink( ' + i + ' );" />';
                        row_txt += '<div style="clear:both;"></div>';
                        if( hasImage ) {
                            row_txt += '<input style="float:right;" type="button" class="button-secondary" value="Insert Image" onclick="WPAAdoProductImage( ' + i + ' );" />'
                            row_txt += '<div style="clear:both;"></div>';
                        }
                        row_txt += '<input style="float:right;" type="button" class="button-secondary" value="Insert Enhanced Link" onclick="WPAAdoProductEnhanced( ' + i + ' );" />';
                        row_txt += '<div style="clear:both;"></div>';
                        row_txt += "</div></td></tr>";
                        html_txt += row_txt;
                    });
                    html_txt += '</table>';
                    jQuery( "#WPAA-SearchResults" ).html(  html_txt );
                } else {
                    jQuery( "#WPAA-SearchResults" ).html( '<div>No Results found for submitted Search, please try again with different criteria.</div>' );
                }
            }
        });
    }
</script>
<?php
    }
}