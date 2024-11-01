<?php
/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
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
 * Abstract
 *
 * This file contains the class AmazonProduct_Abstract
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Abstract defines the base class utilized by all
 * Amazon Product Objects
 *
 * @package com.mdbitz.amazon.product
 */
abstract class AmazonProduct_Abstract {

    /**
     * @var array Object Values
     */
    protected $_values = array();

    /**
     * Constructor
     *
     * @param string $xml XML Representation of Object
     */
    public function __construct( $xml = null ) {
        if( ! is_null( $xml ) ) {
            $this->parseXML( $xml );
        }
    }

    /**
     * magic method to return non public properties
     *
     * @see     get
     * @param   mixed $property
     * @return  mixed
     */
    public function __get( $property ) {
        return $this->get( $property );
    }

    /**
     * get specifed property
     *
     * @param mixed $property
     * @return mixed
     */
    public function get( $property ) {
        if (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
            return null;
        }
    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set( $property, $value ) {
        $this->set( $property, $value );
    }

    /**
     * set property to specified value
     *
     * @param mixed $property
     * @param mixed $value
     * @return void
     */
    public function set($property, $value) {
        $this->_values[$property] = $value;
    }

    /**
     * magic method used for method overloading
     *
     * @param string $method        name of the method
     * @param array $args           method arguments
     * @return mixed                the return value of the given method
     */
    public function __call($method, $arguments) {
        if( count($arguments) == 0 ) {
            return $this->get( $method );
        } else if( count( $arguments ) == 1 ) {
            return $this->set( $method, $arguments[0] );
        }
        throw new AmazonProduct_Exception( sprintf('Unknown method %s::%s', get_class($this), $method));
    }

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            $this->processNode( $item );
        }
    }

    /**
     * return JSON representation of Object
     * @return String
     */
    public function toJSON( ) {
        $json_strings = array();
        foreach( $this->_values as $key => $value ) {
            if ( is_string( $value ) ) {
                $json_strings[] = '"' . $key. '":"' . str_replace(array("\r", "\r\n", "\n"), '', nl2br(htmlspecialchars($value))) . '"';
            } else {
                if( method_exists( $value, "toJSON" ) ) {
                    $json_strings[] = '"' . $key . '": ' . $value->toJSON();
                } else {
                    $json_array = array();
                    foreach( $value as $obj_key => $obj_value ) {
                        if( is_string( $obj_value) ) {
                            $json_array[] = '"'. str_replace(array("\r", "\r\n", "\n"), '', nl2br(htmlspecialchars($obj_value))) . '"';
                        } else {
                            $json_array[] = $obj_value->toJSON();
                        }
                    }
                    $json_strings[] = '"' . $key . '" : [ ' . implode( ' , ', $json_array ) . ' ]';
                }
            }
        }
        return "{ " . implode( " , ", $json_strings ) . " } ";
    }

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function processNode( $node ) {
        if( $node->nodeName != "#text" ) {
            if (array_key_exists($node->nodeName, $this->_values)) {
                $object = $this->get( $node->nodeName );
                if( is_array( $object ) ) {
                    $object[] = $node->nodeValue;
                    $this->set( $node->nodeName, $object );
                } else {
                    $objects = array();
                    $objects[] = $object;
                    $objects[] = $node->nodeValue;
                    $this->set( $node->nodeName, $objects );
                }
            } else {
                $this->set( $node->nodeName, $node->nodeValue );
            }
        }
    }

}