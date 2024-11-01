<?php
/*
 * Copyright (C) 2010 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of AmazonProductAPI.
 *
 * AmazonProductAPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AmazonProductAPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AmazonProductAPI.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * AmazonProductAPI
 *
 * This file contains the class AmazonProductAPI
 *
 * @author Matthew Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * main class of the AmazonProductAPI
 *
 * <code>
 * require_once(dirname(__FILE__) . '/AmazonProductAPI.php');
 * //Register Auto Loader
 * spl_autoload_register(array('AmazonProductAPI', 'autoload'));
 *
 * $api = new AmazonProductAPI();
 * $api->setAccessKey( "key" );
 * $api->setSecretKey( "secret" );
 * 
 * $request = new AmazonProduct_Request();
 *
 * $request->Operation = AmazonProduct_Operation::SIMILARITY_LOOKUP;
 * $request->ItemId = "0765325942";
 * $request->ResponseGroup = AmazonProduct_ResponseGroup::MEDIUM;
 *
 * $result = $api->execute( $request );
 * foreach( $result->getIterator() as $item ) {
 *      print_r( $item );
 * }
 * </code>
 *
 * @package com.mdbitz.amazon.product
 */
final class AmazonProductAPI {

    /**
     *  Loose
     */
    const MODE_LOOSE  = "Loose";

    /**
     *  Strict
     */
    const MODE_STRICT = "Strict";

    /**
     * @var string $_mode Executable Mode
     */
    private $_mode = self::MODE_LOOSE;

    /**
     * @var string $path AmazonProduct root directory
     */
    private static $_path;

    /**
     * Amazon Access Public Key
     */
    private $_access_key;

    /**
     * Amazon Access Secret Key
     */
    private $_secret_key;

    /**
     * Amazon Associeates ID
     */
    private $_associate_id;

    /**
     * @var string $locale AmazonProduct Localization
     */
    private $_locale = "US";

    /**
     * Constructor
     */
    public function __construct( ) {

    }

    /**
     * set access key
     *
     * <code>
     * $api = new AmazonProductAPI();
     * $api->setAccessKey( "access-key" );
     * </code>
     *
     * @param string $key Access Key
     * @return void
     */
    public function setAccessKey( $key ) {
        $this->_access_key = $key;
    }

    /**
     * set Secret Access key
     *
     * <code>
     * $api = new AmazonProductAPI();
     * $api->setSecretKey( "secret-key" );
     * </code>
     *
     * @param string $key Secret Key
     * @return void
     */
    public function setSecretKey( $key ) {
        $this->_secret_key = $key;
    }

    /**
     * set locale
     *
     * <code>
     * $api = new AmazonProductAPI();
     * $api->setLocale( "US" );
     * </code>
     *
     * @param string $locale
     * @return void
     */
    public function setLocale( $locale ) {
        if( $this->_mode == self::MODE_STRICT
                && ! AmazonProduct_Locale::isValid( $locale )
        ) {
            throw new AmazonProduct_Exception( "Invalid Locale supplied" );
        }
        $this->_locale = $locale;
    }

    /**
     * set associates id
     *
     * <code>
     * $api = new AmazonProductAPI();
     * $api->setAssociateId( "associates-id" );
     * </code>
     *
     * @param string $associate_id Associates ID
     * @return void
     */
    public function setAssociateId( $associate_id ) {
        $this->_associate_id = $associate_id;
    }

    /**
     * set executable mode, If set to STRICT errors will be thrown if
     * constants and requests are not valid.
     *
     * <code>
     * $api = new AmazonProductAPI();
     * $api->setMode( AmazonProductAPI::STRICT );
     * </code>
     *
     * @param string $mode Executable Mode
     * @return void
     */
    public function setMode( $mode ) {
        $this->_mode = $mode;
    }

    /**
     * execute Amazon Product Advertising API request
     * @param AmazonProduct_Request $request Request Options and Settings
     */
    public function execute( $request) {
        if( empty($this->_access_key) || empty($this->_secret_key) ) {
            throw new AmazonProduct_Exception( "Access and/or Secret Key is not configured" );
        }
        if( ! is_null( $request ) && ( $request instanceof AmazonProduct_Request ) ) {
            $request->set( "AWSAccessKeyId", $this->_access_key );
            $request->set( "secret_key", $this->_secret_key );
            $request->set( "domain", AmazonProduct_Locale::getDomain( $this->_locale ) );
            if( $this->_associate_id != null ) {
                $request->set( "AssociateTag", $this->_associate_id );
            }
            if( $this->_mode == self::MODE_STRICT && !$request->isValid() ) {
                throw new AmazonProduct_Exception( "Invalid Amazon Product Request" );
            } else {
                return $request->execute();
            }
        } else {
            throw new AmazonProduct_Exception("Specified request can not be null and/or needs to be of type AmazonProduct_Request" );
        }
    }

/*
 * ItemLookup API Methods
 */

    /**
     * perform an item lookup of the specified id(s)
     *
     * @param mixed $id  ItemId(s) as array or comma dilimted string
     * @param String $id_type IdType
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @return AmazonProduct_Result
     */
    public function lookup( $id, $id_type, $response_group = null, $search_index = null ) {
        $request = new AmazonProduct_Request( );
        $request->Operation = AmazonProduct_Operation::ITEM_LOOKUP;
        if( $id != null ) {
            if( is_array( $id) ) {
                $request->ItemId = implode( ",", $id );
            } else {
                $request->ItemId = $id;
            }
        }
        $request->IdType = $id_type;
        if( $response_group != null ) {
            if( is_array( $response_group) ) {
                $request->ResponseGroup = implode( ",", $response_group );
            } else {
                $request->ResponseGroup = $response_group;
            }
        }
        if( $search_index != null ) {
            $request->SearchIndex = $search_index;
        }
        return $this->execute( $request );
    }

    /**
     * perform an item lookup of the specified ASIN(s)
     *
     * @param mixed $id ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @return AmazonProduct_Result
     */
    public function lookupByASIN( $id, $response_group = null ) {
        return $this->lookup( $id, AmazonProduct_IdType::ASIN, $response_group, null );
    }

    /**
     * perform an item lookup of the specified SKU(s)
     *
     * @param mixed $id ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @return AmazonProduct_Result
     */
    public function lookupBySKU( $id, $search_index, $response_group = null ) {
        return $this->lookup( $id, AmazonProduct_IdType::SKU, $response_group, $search_index );
    }

    /**
     * perform an item lookup of the specified UPC(s)
     *
     * @param mixed $id ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @return AmazonProduct_Result
     */
    public function lookupByUPC( $id, $search_index, $response_group = null ) {
        return $this->lookup( $id, AmazonProduct_IdType::UPC, $response_group, $search_index );
    }

    /**
     * perform an item lookup of the specified EAN(s)
     *
     * @param mixed $id ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @return AmazonProduct_Result
     */
    public function lookupByEAN( $id, $search_index, $response_group = null ) {
        return $this->lookup( $id, AmazonProduct_IdType::EAN, $response_group, $search_index );
    }

    /**
     * perform an item lookup of the specified ISBN(s)
     *
     * @param mixed $id ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $search_index  Search Index for ISBN, EAN, etc
     * @return AmazonProduct_Result
     */
    public function lookupByISBN( $id, $search_index, $response_group = null ) {
        return $this->lookup( $id, AmazonProduct_IdType::ISBN, $response_group, $search_index );
    }

/*
 * ItemSearch API Methods
 */

    /**
     * perform a product search based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param String $search_index  SearchIndex
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function search( $criteria, $search_index, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        $request = new AmazonProduct_Request( );
        $request->Operation = AmazonProduct_Operation::ITEM_SEARCH;
        foreach( $criteria as $key => $value ) {
            $request->set( $key, $value );
        }
        $request->SearchIndex = $search_index;
        if( $response_group != null ) {
            if( is_array( $response_group) ) {
                $request->ResponseGroup = implode( ",", $response_group );
            } else {
                $request->ResponseGroup = $response_group;
            }
        }
        if( $min_price != null ) {
            $request->MinimumPrice = $min_price;
        }
        if( $max_price != null ) {
            $request->MaximumPrice = $max_price;
        }
        if( $merchant != null ) {
            $request->MerchantId = $merchant;
        }
        return $this->execute( $request );
    }

    /**
     * perform a product search of All Products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchAll( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::ALL, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Apparel products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchApparel( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::APPAREL, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Automotive products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchAutomotive( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::AUTOMOTIVE, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Baby products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchBaby( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::BABY, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Beauty products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchBeauty( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::BEAUTY, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a blended search of products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchBlended( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::Blended, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of books based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchBooks( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::BOOKS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Classical based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchClassical( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::CLASSICAL, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Digital Music products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchDigitalMusic( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::DIGITAL_MUSIC, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of DVDs based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchDVD( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::DVD, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Electronic products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchElectronics( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::ELECTRONICS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of grocery products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchGrocery( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::GROCERY, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Health/Personal Care products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchHealthPersonalCare( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::HEALTH_PERSONAL_CARE, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Home & Garden products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchHomeGarden( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::HOME_GARDEN, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Industrial products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchIndustrial( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::INDUSTRIAL, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of jewelry products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchJewelry( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::JEWELRY, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of kitchen products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchKitchen( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::KITCHEN, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of magazines based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMagazines( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MAGAZINES, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a search of Merchants based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMerchants( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MERCHANTS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Miscellaneous products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMiscellaneous( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MISCELLANEOUS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of MP3 downloads based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMP3Downloads( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MP3DOWNLOADS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of music products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMusic( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MUSIC, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Musical Instruments based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMusicalInstruments( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MUSICAL_INSTRUMENTS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Music Tracks based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchMusicTracks( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::MUSIC_TRACKS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of office products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchOfficeProducts( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::OFFICE_PRODUCTS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of outdoor living products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchOutdoorLiving( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::OUTDOOR_LIVING, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of PC Hardware based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchPCHardware( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::PC_HARDWARE, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Pet Supplies based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchPetSupplies( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::PET_SUPPLIES, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of photography products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchPhoto( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::PHOTO, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of shoes based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchShoes( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::SHOES, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of software based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchSoftware( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::SOFTWARE, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of Sporting Goods based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchSportingGoods( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::SPORTING_GOODS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of tools based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchTools( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::TOOLS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of toys based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchToys( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::TOYS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of unboxed videos based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchUnboxVideo( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::UNBOX_VIDEO, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of VHS movies based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchVHS( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::VHS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of videos based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchVideo( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::VIDEO, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of video games based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchVideoGames( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::VIDEO_GAMES, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of watches based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchWatches( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::WATCHES, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of wireless products based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchWireless( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::WIRELESS, $response_group, $min_price, $max_price, $merchant );
    }

    /**
     * perform a product search of wireless accessories based on the inputed criteria
     *
     * @param array $criteria  Search Criteria as Associated Array
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param mixed $min_price MinimumPrice (float or int if int 125 = $1.25)
     * @param String $max_price MaximumPrice (float or int if int 125 = $1.25)
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function searchWirelessAccessories( $criteria, $response_group = null, $min_price = null, $max_price = null, $merchant = null ) {
        return $this->search( $criteria, AmazonProduct_SearchIndex::WIRELESS_ACCESSORIES, $response_group, $min_price, $max_price, $merchant );
    }

/*
 * SimilarityLookup API Methods
 */

    /**
     * perform a similarity lookup of the specified id(s)
     *
     * @param mixed $id  ItemId(s) as array or comma dilimted string
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @param String $type SimilarityType (Intersection, Random)
     * @param String $condition Condition (All, New, Collectible, Refurbished, Used )
     * @param String $merchant MerchantId (Amazon, All, Featured, ID of a merchant )
     * @return AmazonProduct_Result
     */
    public function similarityLookup( $id, $response_group = null, $type = AmazonProduct_SimilarityType::INTERSECTION, $condition = null, $merchant = null ) {
        $request = new AmazonProduct_Request( );
        $request->Operation = AmazonProduct_Operation::SIMILARITY_LOOKUP;
        if( $id != null ) {
            if( is_array( $id) ) {
                $request->ItemId = implode( ",", $id );
            } else {
                $request->ItemId = $id;
            }
        }
        if( $type != null ) {
            $request->SimilarityType = $type;
        }
        if( $condition != null ) {
            $request->Condition = $condition;
        }
        if( $merchant != null ) {
            $request->MerchantId = $merchant;
        }
        return $this->execute( $request );
    }

/*
 * BrowseNodeLookup API Methods
 */

    /**
     * perform a brose node lookup of the specified BrowseNodeId
     *
     * @param String $id BrowseNodeLookup
     * @param mixed $response_group Response Groups as array or comma dilimeted string
     * @return AmazonProduct_Result
     */
    public function browseNodeLookup( $id, $response_group = null ) {
        $request = new AmazonProduct_Request( );
        $request->Operation = AmazonProduct_Operation::BROWSE_NODE_LOOKUP;
        $request->BrowseNodeId = $id;
        if( $response_group != null ) {
            if( is_array( $response_group) ) {
                $request->ResponseGroup = implode( ",", $response_group );
            } else {
                $request->ResponseGroup = $response_group;
            }
        }
        return $this->execute( $request );
    }

/*
 * Utility Methods
 */

    /**
     * simple autoload function
     * returns true if the class was loaded, otherwise false
     *
     * <code>
     * // register the class auto loader
     * spl_autoload_register( array('AmazonProductAPI', 'autoload') );
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
     * Get the root path to Amazon Product API
     *
     * @return string
     */
    public static function getPath() {
        if ( ! self::$_path) {
            self::$_path = dirname(__FILE__);
        }
        return self::$_path;
    }

}