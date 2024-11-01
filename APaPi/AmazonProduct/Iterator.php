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
 * Iterator
 *
 * This file contains the class AmazonProduct_Iterator
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Iterator is sued to iterate through all results
 * returned by a query to the Amazon Product Advertising API
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Iterator implements Iterator {

    /**
     * @var array
     */
    private $_items = array();

    /**
     * @var int
     */
    private $_index = 1;

    /**
     * @var int
     */
    private $_total_results = 0;

    /**
     * @var AmazonProduct_Request
     */
    private $_request = null;

    /**
     * Constructor
     *
     * @param AmazonProduct_Result $result Amazon Product Result
     */
    public function __construct( $result ) {
        $this->_request = $result->request; // init request object
        if( is_int( intval( $result->TotalResults ) ) ) {
            $this->_total_results = intval($result->TotalResults); // set total item results
            $item_index = ( intval($this->_request->ItemPage) - 1 ) * 10 + 1;
        } else {
            $this->_total_results = count( $result->Items );
            $item_index = 1;
        }
        $this->_index = $item_index; // init current index
        foreach( $result->Items as $item ) { // load objects into results array
            $this->_items[$item_index] = $item;
            $item_index ++;
        }
    }

    /**
     * Reset the Iterator to first item
     */
    public function rewind() {
        $this->index = 1;
    }

    /**
     * return the current indexed item
     * @return AmazonProduct_Item
     */
    public function current() {
        if( $this->valid() ) {
            if( ! isset( $this->_items[ $this->_index ] ) ) {
                $this->loadItems();
            }
            return $this->_items[ $this->_index ];
        } else {
            return false;
        }

    }

    /**
     * return the current index key
     * @return int
     */
    public function key() {
        return $this->_index;
    }

    /**
     * get next item
     * @return mixed AmazonProduct_Item if has next or false;
     */
    public function next() {
        $this->_index ++;
        if( $this->valid() ) {
            return $this->current();
        } else {
            return false;
        }
    }

    /**
     * is the item a valid item
     * @return boolean
     */
    public function valid() {
        if( $this->_index >= 0 && $this->_index <= $this->_total_results ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * load Unloaded Items
     */
    private function loadItems() {
        $page = ceil( $this->_index / 10 );
        $this->_request->set( "ItemPage", $page );
        $response = $this->_request->execute();
        $item_index = ($page - 1) * 10 + 1;
        foreach( $response->Items as $item ) { // load objects into results array
            $this->_items[$item_index] = $item;
            $item_index ++;
        }
    }

}
?>
