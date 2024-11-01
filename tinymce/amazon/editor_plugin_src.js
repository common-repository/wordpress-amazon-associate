/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Sofatware Foundation, either version 3 of the
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
(function() {
    tinymce.create('tinymce.plugins.amazonproductlink', {
        init : function(ed, url) {
            var t = this;
            // Register commands
            ed.addCommand('amazonproductlink', function(ui, val) {
                if( val == "amazon-product-link") {
                    ed.windowManager.open({
                        file : url + '/amazon.php',
                        width : 500,
                        height : 450,
                        inline : 1,
                        auto_focus : 0
                    }, {
                        plugin_url : url
                    });
                } else {
                    ed.windowManager.open({
                        file : url + '/' + val + '.php',
                        width : t._pluginWidth[val],
                        height : t._pluginHeight[val],
                        inline : 1,
                        auto_focus: 0
                    }, {
                        plugin_url : url
                    });
                }
            });

            // Register buttons
            ed.addButton('amazonproductlink', {
                title : 'insert Amazon Products/Widgets',
                cmd : 'amazonproductlink',
                image : url + '/img/amazon.gif'
            });

            /*
               * Load additional CSS
               */
            ed.onInit.add(function() {
                if (ed.settings.content_css !== false)
                {
                    dom = ed.windowManager.createInstance('tinymce.dom.DOMUtils', document);
                    dom.loadCSS(url + '/css/button.css');
                    ed.dom.loadCSS(url + '/css/button.css');
                }
            });

        },

        _pluginFunctions : {
            'amazon-product-link': 'Product Link',
            'amazon-carousel': 'Carousel Widget',
            'amazon-mp3-clips': 'MP3Clips Widget',
            'amazon-my-favorites': 'My Favorites Widget',
            'amazon-omakase': 'Omakase Widget',
            'amazon-product-cloud': 'Product Cloud Widget',
            'amazon-search': 'Search Widget'
        },

        _pluginHeight : {
            'amazon-carousel': '380',
            'amazon-mp3-clips': '380',
            'amazon-my-favorites': '400',
            'amazon-omakase': '500',
            'amazon-product-cloud': '480',
            'amazon-search': '440'
        },

        _pluginWidth : {
            'amazon-carousel': '840',
            'amazon-mp3-clips': '500',
            'amazon-my-favorites': '750',
            'amazon-omakase': '840',
            'amazon-product-cloud': '840',
            'amazon-search': '750'
        },

        getInfo : function() {
            return {
                longname : 'Amazon Product Links',
                author : 'MDBitz - Matthew Denton',
                authorurl : 'http://mdbitz.com',
                infourl : 'http://labs.mdbitz.com',
                version : '1.1'
            };
        },
                
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            var t = this, menu = t._cache.menu, c, ed = tinyMCE.activeEditor, each = tinymce.each;

            if (n != 'amazonproductlink')
            {
                return null;
            }

            c = cm.createSplitButton(n, {
                cmd:    '',
                scope : t,
                title : 'insert Amazon Product/Widgets'
            });

            c.onRenderMenu.add(function(c, m) {
                m.add({
                    'class': 'mceMenuItemTitle',
                    title:   'Amazon Products/Widgets'
                }).setDisabled(1);

                each(t._pluginFunctions, function(value, key) {
                    var o = {
                        icon : 0
                    }, mi;

                    o.onclick = function() {
                        ed.execCommand('amazonproductlink', true, key);
                    };

                    o.title = value;
                    mi = m.add(o);
                    menu[key] = mi;
                });

                t._selectMenu(ed);
            });

            return c;
        },

        /*
         * Cache references
         */
        _cache: {
            menu: {}
        },

        /**
         * Select an item menu based on its classname
         *
         * @since 1.0
         * @version 1.0
         * @param {Object} ed TinyMCE Editor reference
         */
        _selectMenu: function(ed){
            var fe  =  ed.selection.getNode(), each = tinymce.each, menu = this._cache.menu;

            each(this.shortcodes, function(value, key){
                if (typeof menu[key] == 'undefined' || !menu[key])
                {
                    return;
                }

                menu[key].setSelected(ed.dom.hasClass(fe, key));
            });
        }
    });

    // Register plugin
    tinymce.PluginManager.add('amazonproductlink', tinymce.plugins.amazonproductlink);
})();