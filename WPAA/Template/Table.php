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
 * WordPress Admin Table for Template Management
 *
 * This file contains the class WPAA_Template_Table
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.WPAA.Template
 */



/*************************** LOAD THE BASE CLASS *******************************/
if(!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * WPAA_Template_Table extends the core WP_List_Table to display
 * and give common editable functionality for Templates
 *
 * @package com.mdbitz.wordpress.amazon_associate.WPAA.Template
 */
class WPAA_Template_Table extends WP_List_Table {

    /**
     * Constructor
     */
    function __construct() {
        global $status, $page;

        //Set parent defaults
        parent::__construct( array(
                'singular'  => 'template',     //singular name of the listed records
                'plural'    => 'templates',    //plural name of the listed records
                'ajax'      => false        //does this table support ajax?
                ) );

    }

    /**
     * Define how columns should be rendered if no column definition is defined.
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     */
    function column_default($item, $column_name) {
        switch($column_name) {
            case 'DESCRIPTION':
                return $item[$column_name];
            case 'ACTIVE':
                if( $item[$column_name] == "1" ) {
                    return "Yes";
                } else {
                    return "<strong>No</strong>";
                }
            default:
                return print_r($item,true); //Troubleshooting
        }
    }

    /**
     * Define how to render the Name Column
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_NAME($item) {

        $active_link = '';
        // create active/inactivate link display details
        if( $item['ACTIVE'] == "1" ) {
            $active_link = sprintf('<a href="?page=%s&action=%s&ID=%s">Disable</a>', $_REQUEST['page'], 'disable', $item['ID'] );
        } else {
            $active_link = sprintf('<a href="?page=%s&action=%s&ID=%s">Enable</a>', $_REQUEST['page'], 'enable', $item['ID'] );
        }

        //TODO - Handle Edit function as Ajax load to edit location

        //Define Actions
        $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&ID=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
                'enable'      => $active_link,
                'delete'    => sprintf('<a href="?page=%s&action=%s&ID=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID'])
        );

        //Create Display
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
                $item['NAME'],
                $item['ID'],
                $this->row_actions($actions)
        );
    }

    /**
     * Define CheckBox Column
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                $this->_args['singular'],
                $item['ID']
        );
    }

    /**
     * Define Table Columns
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     */
    function get_columns() {
        $columns = array(
                'cb'        => '<input type="checkbox" />',
                'NAME'     => 'Template Name',
                'DESCRIPTION'    => 'Description',
                'ACTIVE'  => 'is Active?'
        );
        return $columns;
    }

    /**
     * Define Sortable Columns
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     */
    function get_sortable_columns() {
        $sortable_columns = array(
                'NAME'     => array('NAME',true),
                'ACTIVE'    => array('ACTIVE',false)
        );
        return $sortable_columns;
    }


    /**
     * Define Bulk Actions
     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     */
    function get_bulk_actions() {
        $actions = array(
                'delete'    => 'Delete',
                'enable'	=> 'Enable',
                'disable' 	=> 'Disable'
        );
        return $actions;
    }

    /**
     * Get Data
     */
    protected function getTableData() {
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'NAME';
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc';
        return WPAA_Template::getTemplates( $orderby, $order );
    }

    /**
     * Obtain and Prepare Data for display
     *
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     */
    function prepare_items() {

        // Setup Column definitions
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        // Query Data
        $data = $this->getTableData();

        // Setup/Configure Pagination
        $per_page = 5;
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $this->set_pagination_args(
                array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil($total_items/$per_page)
                )
        );

        // show only selected page data
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;

    }

} // WPAA_Template_Table