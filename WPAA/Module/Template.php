<?php
/*
 * copyright (c) 2012 MDBitz - Matthew John Denton - mdbitz.com
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
 * WPAA Templates Module
 *
 * This file contains the class WPAA_Module_Template
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Template Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_Template extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-template";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-template";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $options_lvl = "manage_options";

    /**
     * Module Options
     * @var Array
     */
    protected $options = array(
            'db-version' => "1.0"
    );

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
        add_action('admin_head', array(&$this, 'doPageHead'));
        add_action('admin_print_scripts', array(&$this, 'doPageScripts'));
        add_action('admin_print_styles', array(&$this, 'doPageStyles'));
        $this->loadOptions();
    }

    /**
     * Output Admin Page header scripts
     */
    public function doPageHead() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_script('jquery');
        }
    }

    /**
     * Output Config Page Styles
     */
    function doPageStyles() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_style('dashboard');
            wp_enqueue_style('thickbox');
            wp_enqueue_style('global');
            wp_enqueue_style('wp-admin');
            wp_enqueue_style('wpaa-admin-css', WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/css/admin.css');
        }
    }

    /**
     * Output Page Scripts
     */
    function doPageScripts() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_script('postbox');
            wp_enqueue_script('dashboard');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');
        }
    }

    /**
     * load Options
     */
    private function loadOptions() {
        $saved_options = get_option($this->options_name);
        $version = $this->options['db-version'];

        if ($saved_options !== false ) {
            foreach ($saved_options as $key => $value) {
                $this->options[$key] = $value;
            }
            if( $this->options['db-version'] == $version ) {
                return;
            }
        }

        // install/update db
        WPAA_Template::install();
        $this->options['db-version'] = $version;
        update_option($this->options_name, $this->options);
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_submenu_page($this->parent_hook, "Templates", "Templates", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * Process Actions
     */
    private function processActions() {
        $result = null;
        if( $_REQUEST['action'] == 'delete' ) {
            if( isset( $_REQUEST['template'] ) ) {
                $result = WPAA_Template::deleteTemplates( $_REQUEST['template'] );
            } else {
                $result = WPAA_Template::deleteTemplate( $_REQUEST['ID'] );
            }
            if( $result === false ) {
                $this->message = "We're sorry there was an error deleting the selected template(s).";
            } else {
                $this->message = "The Template(s) were deleted successfully.";
            }
        } else if ( $_REQUEST['action'] == 'save' ) {
            $result = WPAA_Template::modifyTemplate( $this->processDataForSave( $_REQUEST ) );
            if( $result === false ) {
                $this->message = "We're sorry there was an error creating/updating the template.";
            } else {
                $this->message = "You're Template was created/updated successfully.";
            }
        } else if ( $_REQUEST['action'] == 'enable' ) {
            if( isset( $_REQUEST['template'] ) ) {
                $result = WPAA_Template::enableTemplates( $_REQUEST['template'] );
            } else {
                $result = WPAA_Template::enableTemplate( $_REQUEST['ID'] );
            }
            if( $result === false ) {
                $this->message = "We're sorry there was an error enabling the template(s).";
            } else {
                $this->message = "The Template(s) were enabled successfully.";
            }
        } else if ( $_REQUEST['action'] == 'disable' ) {
            if( isset( $_REQUEST['template'] ) ) {
                $result = WPAA_Template::disableTemplates( $_REQUEST['template'] );
            } else {
                $result = WPAA_Template::disableTemplate( $_REQUEST['ID'] );
            }
            if( $result === false ) {
                $this->message = "We're sorry there was an error disabling the template(s).";
            } else {
                $this->message = "The Template(s) were disabled successfully.";
            }
        }
    }

    private function processDataForSave( $data ) {
        if( isset($data['ACTIVE']) ) {
            $data['ACTIVE'] = 1;
        } else {
            $data['ACTIVE'] = 0;
        }
        return $data;
    }

    /**
     * output Compliance Page
     */
    public function doPage() {
        global $wpaa;

        // process Actions
        $this->processActions();
        $action = $_REQUEST['action'];
        // Initialize Table
        if( $action != 'add' && $action != 'edit' ) {
            // Create Template Table instance
            $templateTable = new WPAA_Template_Table();
            $templateTable->prepare_items();
        }

        // output message if set
        if( ! empty( $this->message ) ) {
            echo '<div class="updated fade">' . $this->message . '</div>';
        }

        ?>
<div class="wrap">
    <h2>WordPress Amazon Associate: <?php _e('Template Manager', 'wpaa'); ?><a class="add-new-h2" href="<?php echo admin_url('admin.php?action=add&page=' . $this->hook ); ?>">Add New</a></h2>
    <?php if( $action != 'add' && $action != 'edit' ) { ?>
    <div class="postbox-container" width="600px">
        <form action="<?php echo admin_url('admin.php'); ?>" method="get" id="wpaa-conf">
                     <input value="<?php echo $this->hook; ?>" type="hidden" name="page" />
					<?php $templateTable->display(); ?>
        </form>
    </div>
    <?php 
    } else {

        $template = null;
        if( $action == 'edit' && $_REQUEST['ID'] != null ) {
            $template = WPAA_Template::getTemplate( $_REQUEST['ID'] );
        }
        
    ?>
    <div style="background:#EFEFEF;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
            <input value="save" type="hidden" name="action" />
            <input value="2" type="hidden" name="TYPE_ID" />
            <?php if( $action == 'edit' ) { echo '<input value="' . $template->ID . '" type="hidden" name="ID" />'; }?>
            <h2>
                <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                <span><?php
                if( $action == 'edit' ) {
                    echo 'Modify Template';
                } else {
                    echo 'Add New Template';
                }
                ?></span>
                <div style="clear:both;"><!--EMPTY--></div>
            </h2>
            <div>
                <strong>Name:</strong><br/>
                <input type="text" value="<?php if ($action == 'edit' ) { echo $template->NAME; } ?>" name="NAME" style="width:300px;">
            </div><br/>
            <div>
                <strong>Enabled:&nbsp;&nbsp;&nbsp;</strong>
                <?php
                    if ($action == 'edit' && $template->ACTIVE == '0' ) {
                        echo $this->checkbox( 'ACTIVE', false );
                    } else {
                        echo $this->checkbox( 'ACTIVE', true );
                    }
                ?>
            </div><br/>
            <div>
                <strong>Content:</strong><br/>
                <textarea name="CONTENT" id="CONTENT" rows="8" cols="100"><?php if ($action == 'edit' ) { echo $template->CONTENT; } ?></textarea>
            </div><br/>
            <div>
                <strong>Description:</strong><br/>
                <textarea name="DESCRIPTION" rows="3" cols="100"><?php if ($action == 'edit' ) { echo $template->DESCRIPTION; } ?></textarea>
            </div><br/>
            <div>
                <strong>CSS:</strong><br/>
                <textarea name="CSS" id="CSS" rows="6" cols="100"><?php if ($action == 'edit' ) { echo $template->CSS; } ?></textarea>
            </div><br/>
            <div style="float:left;">
                <label for="id">ASIN:</label><input type="text" name="asin" id="asin" value="0451463471" width="200px"/>
                <input type="button" value="Preview" name="template-preview" class="button-secondary" onclick="previewAmazonTemplate();"/>
            </div>
            <div style="float:right;">
                <input type="submit" value="Save Template" name="template_submit" class="button-primary" style="float:right;">
            </div>
            <div style="clear:both;"><!--EMPTY--></div>
            <br/>
        </form>
    </div>
    
    <script type="text/javascript">
        function previewAmazonTemplate( ) {
            var queryStr = '?widget=TemplatePreview' +
                '&width=500&height=400' +
                '&CONTENT=' + encodeURIComponent(jQuery( "#CONTENT" ).val()) +
                "&ID=" + jQuery( "#asin" ).val() +
                '&CSS=' + encodeURIComponent(jQuery( "#CSS" ).val());

            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Template Preview",
			'href'			: encodeURI( '<?php echo $wpaa->getPluginPath( '/servlet/preview.php'); ?>' + queryStr),
			'type'			: 'ajax'
		});
            return false;
        }
    </script>
    <?php } ?>
    <br style="clear:both;"/>
    <hr/>
    <div style="background:#EEEEEE;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <h2><?php _e('Template Guide', 'wpaa') ?></h2>
            <p>At this time the WordPress Amazon Associate (WPAA) Plugin does not support nesting of templtes or conditional statements (if,foreach,etc). We are currenlty reviewing the possibility of adding these features to the plugin in a later release. To output Product Content you need to insert <i>TAGS</i> into the template with the following format <i>%TAG%</i>. The full listing of currently supported tags can be found below. As a note the system will not render any templates that are marked as disabled.</p>
            <p>You can add products into your post/pages via the Template Widget or ShortCode.</p>
            <h3>ShortCode Format</h3>
            <p>Templates can be inserted into posts/pages for a single product at this time. You can specify the template by id or name. If desired you can pass a comma seperated list of product ASINs and the plugin will render a random product from the list.</p>
            <UL>
                <li><strong>Single Product: </strong>[amazon_template template="10" id="0451463471" ]Content that will display if template not found, inactive or error during rendering[/amazon_template]</li>
                <li><strong>Random Product: </strong>[amazon_template template="Basic Ad" type="ASIN List" id="0451463471,0756407125]Content[/amazon_template]</li>
            </UL>
            <h3>Supported Tags</h3>
            <table style="border-spacing:0;border-collapse:collapse;" >
                <tr>
                    <td style="padding: 0px 25px;">
                        <ul>
                            <li>%ASIN%</li>
                            <li>%TITLE%</li>
                            <li>%URL%</li>
                            <li>%PRICE%</li>
                            <li>%DESC_FULL%</li>
                            <li>%DESC_SHORT%</li>
                            <li>%ARTIST%</li>
                            <li>%AUTHOR%</li>
                        </ul>
                    </td>
                    <td style="padding: 0px 25px;">
                        <ul>
                            <li>%IMAGE%</li>
                            <li>%SMALL_IMAGE%</li>
                            <li>%LARGE_IMAGE%</li>
                            <li>%PRODUCT_GROUP%</li>
                            <li>%PUBLISH_DATE%</li>
                            <li>%RELEASE_DATE%</li>
                            <li>%MANUFACTURER%</li>
                            <li>%PUBLISHER</li>
                        </ul>
                    </td>
                    <td style="padding: 0px 25px;">
                        <ul>
                            <li>%EAN%</li>
                            <li>%STUDIO%</li>
                            <li>%LABEL%</li>
                            <li>%MPN%</li>
                            <li>%SKU%</li>
                            <li>%UPC%</li>
                        </ul>
                    </td>
                </tr>
            </table>
    </div>
</div>
        <?php
    }
}