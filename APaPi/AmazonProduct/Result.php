<?php
/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AmazonProductAPI. If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Result
 *
 * This file contains the class AmazonProduct_Result
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct Result Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>code</li>
 *   <li>data</li>
 *   <li>Server</li>
 *   <li>Date</li>
 *   <li>Content-Type</li>
 *   <li>Connection</li>
 *   <li>Status</li>
 *   <li>X-Powered-By</li>
 *   <li>ETag</li>
 *   <li>X-Served-From</li>
 *   <li>X-Runtime</li>
 *   <li>Content-Length</li>
 *   <li>Location</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Result extends AmazonProduct_Abstract implements IteratorAggregate {

    /**
     * @var string response code
     */
    protected $_code = null;

    /**
     * @var array response data
     */
    protected $_data = null;

    /**
     * @var AmazonProduct_Request request
     */
    protected $_request = null;

    /**
     * @var string response headers
     */
    protected $_headers = null;

    /**
     * Constructor initializes {@link $_code} {@link $_data} {@link $_headers}
     *
     * @param string $code response code
     * @param array $data array of Quote Objects
     * @param AmazonProduct_Request $request underlying request
     */
    public function __construct( $code = null, $data = null, $request = null ) {
        $this->_code = $code;
        $this->_data = $data;
        $this->_request = $request;
        $this->parseXML( $this->_data );
    }

    /**
     * get Item Iterator
     * @return AmazonProduct_Iterator
     */
    public function getIterator() {
        return new AmazonProduct_Iterator($this);
    }

    /**
     * Return the specified property
     *
     * @param mixed $property     The property to return
     * @return mixed
     */
    public function get( $property ) {
        switch( $property ) {
            case 'code':
                return $this->_code;
                break;
            case 'data':
                return $this->_data;
                break;
            case 'request':
                return $this->_request;
                break;
            default:
                return parent::get( $property );
                break;
        }
    }

    /**
     * sets the specified property
     *
     * @param mixed $property The property to set
     * @param mixed $value value of property
     * @return void
     */
    public function set( $property, $value ) {
        switch( $property ) {
            case 'code':
                $this->_code = $value;
                break;
            case 'data':
                $this->_data = $value;
                break;
            default:
                parent::set( $property, $value );
                break;
        }
    }

    /**
     * Process the raw xml data
     *
     * @param String $xml XML Data String
     */
    public function parseXML( $xml ) {
        $items = array();
        $errors = array();
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xml);
        $x = $xmlDoc->documentElement;
       if(     $x->nodeName == "Errors" ||
               $x->nodeName == "ItemLookupErrorResponse" ||
               $x->nodeName == "BrowseNodeLookupErrorResponse")
       {
            $this->set( "IsValid", "False" );
            foreach( $x->childNodes as $node ) {
                $errors[] = new AmazonProduct_Error( $node );
            }
        } else {
            foreach ($x->childNodes AS $node) {
                switch( $node->nodeName ) {
                    case "Items":
                    case "BrowseNodes":
                        foreach( $node->childNodes as $child ) {
                            if( $child->nodeName == "Item" ) {
                                $items[] = new AmazonProduct_Item($child);
                            } else if ( $child->nodeName == "BrowseNode" ) {
                                $this->set( $child->nodeName, new AmazonProduct_BrowseNode( $child ) );
                            } else if( $child->nodeName != "Request") {
                                $this->processNode( $child );
                            } else {
                                foreach( $child->childNodes as $requestNode ) {
                                    switch( $requestNode->nodeName ) {
                                        case "IsValid":
                                            $this->set( "IsValid", $requestNode->nodeValue );
                                            break;
                                        case "Errors":
                                            foreach( $requestNode->childNodes as $errorNode ) {
                                                $errors[] = new AmazonProduct_Error( $errorNode );
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        }
        $this->set( "Items", $items );
        if( count($errors) > 0 ) {
			$this->set( "IsValid", "False" );
            $this->set( "Errors", $errors );
        }
    }

    /**
     * is request successfull
     * @return boolean
     */
    public function isSuccess() {
        if( "2" == substr( $this->_code, 0, 1 ) && $this->IsValid == "True" ) {
            return true;
        } else {
            return false;
        }
    }

}