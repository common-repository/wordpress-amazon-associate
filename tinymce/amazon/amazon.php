<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Insert Amazon Product Link</title>
        <script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.5.custom.min.js"></script>
        <script type="text/javascript" src="js/amazon.js"></script>
        <link rel="stylesheet" type="text/css" href="css/amazon.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.5.custom.css" />
    </head>
    <body >
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Insert Link</a></li>
                <li><a href="#tabs-2">Product Search</a></li>
            </ul>
            <div id="tabs-1">
                <div id="insert_panel" class="panel">
                    <table border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td><label for="ASIN">Product ASIN :</label></td>
                            <td><input type="text" id="ASIN" name="ASIN" style="width: 200px" /></td>
                        </tr>
                        <tr>
                            <td><label for="Locale">Override Locale :</label></td>
                            <td>
                                <select id="Locale" name="Locale">
                                    <option value="" selected>--</option>
                                    <option value="US" >United States</option>
                                    <option value="CA" >Canada</option>
                                    <option value="FR" >France</option>
                                    <option value="DE" >Germany</option>
                                    <option value="JP" >Japan</option>
                                    <option value="UK" >United Kingdom</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="LinkType ImageType">
                            <td><label for="Target">Link Target :</label></td>
                            <td>
                                <select id="Target" name="Target">
                                    <option value="_blank" selected>_blank</option>
                                    <option value="_parent">_parent</option>
                                    <option value="_self">_self</option>
                                    <option value="_top">_top</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="Type">Link Type :</label></td>
                            <td>
                                <select id="Type">
                                    <option value="Text" selected>Text</option>
                                    <option value="Enhanced">Enhanced</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="TextType">
                            <td><label for="LinkText">Display Text :</label></td>
                            <td><input type="text" id="LinkText" name="LinkText" style="width: 200px" /></td>
                        </tr>
                        <tr class="ImageType" style="display:none;">
                            <td><label for="DisplayImage">Image to Display :</label></td>
                            <td><div id="SelectImageArea"><input type="text" id="ProductImage" name="ProductImage" /></div></td>
                        </tr>
                        <tr class="ImageType" style="display:none;">
                            <td><label for="AltText">Alt Text :</label></td>
                            <td><input type="text" id="AltText" name="AltText" style="width: 200px" /></td>
                        </tr>
                        <tr class="TextType ImageType EnhancedType">
                            <td><label for="Container">Container :</label></td>
                            <td><input type="text" id="Container" name="Container" style="width: 200px" /></td>
                        </tr>
                        <tr class="TextType ImageType EnhancedType">
                            <td><label for="ContainerClass">Container Class :</label></td>
                            <td><input type="text" id="ContainerClass" name="ContainerClass" style="width: 200px" /></td>
                        </tr>
                        <tr class="ImageType" style="display:none;">
                            <td><label for="ShortCode">Render Image as ShortCode :</label></td>
                            <td><input type="checkbox" id="ShortCode" name="ShortCode" /></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="newWindow">Open Link in New Window :</label></td>
                            <td><input type="checkbox" id="newWindow" name="newWindow" checked/></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="showBorder">Show Border :</label></td>
                            <td><input type="checkbox" id="showBorder" name="showBorder" checked/></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="largerImage">Use Larger Image :</label></td>
                            <td><input type="checkbox" id="largerImage" name="largerImage" checked/></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="price">Price Options :</label></td>
                            <td>
                                <select id="price">
                                    <option value="All" selected>Show All Prices</option>
                                    <option value="New">Show New Prices Only</option>
                                    <option value="Hide">Hide Prices</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="backgroundColor">Background Color :</label></td>
                            <td><input type="text" id="backgroundColor" name="backgroundColor" style="width: 100px" value="FFFFFF" /></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="textColor">Text Color :</label></td>
                            <td><input type="text" id="textColor" name="textColor" style="width: 100px" value="000000" /></td>
                        </tr>
                        <tr class="EnhancedType" style="display:none;">
                            <td><label for="linkColor">Link Color :</label></td>
                            <td><input type="text" id="linkColor" name="linkColor" style="width: 100px" value="0000FF" /></td>
                        </tr>
                    </table>
                    <div><small>* Please note that links will be automatically configured with your associate id</small></div>
                    <div class="mceActionPanel">
                        <input type="button" id="insert" name="insert" value="{#insert}" onclick="AmazonProductDialog.insert();" />
                        <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                    </div>
                </div>
            </div>
            <div id="tabs-2">
                <div id="search_panel" class="panel">
                    <table border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td><label for="Keywords">Keywords :</label></td>
                            <td><input type="text" id="Keywords" name="Keywords" style="width: 200px" onkeypress="if (event.keyCode == 13) AmazonProductDialog.doProductSearch();"/></td>
                        </tr>
                        <tr>
                            <td><label for="SearchIndex">Search Index :</label></td>
                            <td>
                                <select id="SearchIndex">
                                    <option value="All" selected>All</option>
                                    <option value="Apparel">Apparel</option>
                                    <option value="Automotive">Automotive</option>
                                    <option value="Baby">Baby</option>
                                    <option value="Beauty">Beauty</option>
                                    <option value="Blended">Blended</option>
                                    <option value="Books" >Books</option>
                                    <option value="Classical">Classical</option>
                                    <option value="DigitalMusic">Digital Music</option>
                                    <option value="MP3Downloads">MP3 Downloads</option>
                                    <option value="DVD">DVD</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="HealthPersonalCare">Health Personal Care</option>
                                    <option value="HomeGarden">Home Garden</option>
                                    <option value="Industrial">Industrial</option>
                                    <option value="Jewelry">Jewelry</option>
                                    <option value="KindleStore">Kindle Store</option>
                                    <option value="Kitchen">Kitchen</option>
                                    <option value="Magazines">Magazines</option>
                                    <option value="Merchants">Merchants</option>
                                    <option value="Miscellaneous">Miscellaneous</option>
                                    <option value="Music">Music</option>
                                    <option value="MusicalInstruments">Musical Instruments</option>
                                    <option value="MusicTracks">Music Tracks</option>
                                    <option value="OfficeProducts">Office Products</option>
                                    <option value="OutdoorLiving">Outdoor Living</option>
                                    <option value="PCHardware">PC Hardware</option>
                                    <option value="PetSupplies">Pet Supplies</option>
                                    <option value="Photo">Photo</option>
                                    <option value="Shoes">Shoes</option>
                                    <option value="Software">Software</option>
                                    <option value="SportingGoods">Sporting Goods</option>
                                    <option value="Tools">Tools</option>
                                    <option value="Toys">Toys</option>
                                    <option value="UnboxVideo">Unbox Video</option>
                                    <option value="VHS">VHS</option>
                                    <option value="Video">Video</option>
                                    <option value="VideoGames">Video Games</option>
                                    <option value="Watches">Watches</option>
                                    <option value="Wireless">Wireless</option>
                                    <option value="WirelessAccessories">Wireless Accessories</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="mceActionPanel">
                        <input class="updateButton" type="button" id="search" name="search" value="Search Amazon" onclick="AmazonProductDialog.doProductSearch();"/>
                    </div>
                </div>
                <hr/>
                <div id="SearchResults">

                </div>
            </div>
        </div>

    </body>
</html>
