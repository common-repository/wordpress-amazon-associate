<?php
/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
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
 * Base MDBitz Widget
 *
 * This file contains the class Widget_MDBitz_Base
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.MDBitz
 */

/**
 * Widget_MDBitz_Base is an extension of the WP_Widget with form input methods
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_MDBitz_Base extends WP_Widget {

    /**
     * returns HTML checkbox input
     *
     * @param String $id input id and name
     * @param String $value is checked
     * @param string $etc additional input parameters
     * @return String
     */
    public function checkbox($id, $value = false, $etc = "") {
        return '<input class="checkbox" ' . $etc . ' type="checkbox" value="True" id="' . $this->get_field_id($id) . '" name="' . $this->get_field_name($id) . '" ' . ( ($value == true) ? "checked" : "" ) . ' />';
    }

    /**
     * returns HTML checkbox input with label
     *
     * @param String $id input id and name
     * @param String $value is checked
     * @param string $etc additional input parameters
     * @return String
     */
    public function checkboxWithLabel( $label, $id, $value = false, $etc = "") {
        return $this->checkbox( $id, $value, $etc ) . '<label for="' . $this->get_field_id($id) . '" >' . $label .'</label><br/>';
    }

    /**
     * returns HTML text input
     *
     * @param String $id input id and name
     * @param String $value input value
     * @param string $etc additional input parameters
     * @return String
     */
    public function textinput($id, $value, $etc = "") {
        return '<input class="widefat" ' . $etc . ' type="text" id="' . $this->get_field_id($id) . '" name="' . $this->get_field_name($id) . '" size="30" value="' . $value . '"/>';
    }

    /**
     * returns HTML text input with label
     *
     * @param String $id input id and name
     * @param String $value input value
     * @param string $etc additional input parameters
     * @return String
     */
    public function textinputWithLabel( $label, $id, $value, $etc = "") {
        return '<label for="' . $this->get_field_id($id) . '" >' . $label . $this->textinput( $id, $value, $etc ) . '</label>';
    }

    /**
     * returns HTML select input
     *
     * @param String $id input id and name
     * @param array $options Array of Options
     * @param String $selected value selected option value
     * @param string $etc additional input parameters
     * @return String
     */
    public function select($id, $options, $selected_value, $etc = "") {
        $output_txt = '<select class="widefat" ' . $etc . ' name="' . $this->get_field_name($id) . '" id="' . $this->get_field_id($id) . '">';
        foreach ($options as $option_value => $option_text) {
            $selected_txt = '';
            if ($selected_value == $option_value) {
                $selected_txt = ' SELECTED';
            }
            if ($option_text == '') {
                $option_text = $option_value;
            }
            $output_txt .= '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
        }
        $output_txt .= '</select>';
        return $output_txt;
    }

    /**
     * returns HTML select input with label
     *
     * @param string $id input id and name
     * @param array $options Array of Options
     * @param string $selected value selected option value
     * @param string $etc additional input parameters
     * @return string
     */
    public function selectWithLabel( $label, $id, $options, $selected_value, $etc = "") {
        return '<label for="' . $this->get_field_id($id) . '" >' . $label . $this->select($id, $options, $selected_value, $etc) . '</label>';
    }

    /**
     * strip_tags property only if exists else return empty string
     * @param array $instance
     * @param string $property
     * @return string
     */
    public function get_strip_tags( $instance, $property ) {
        if( isset($instance[$property] ) ) {
            return strip_tags($instance[$property]);
        } else {
            return "";
        }
    }

    /**
     * esc_attr property only if exists else return empty string
     * @param array $instance
     * @param string $property
     * @return string
     */
    public function get_esc_attr( $instance, $property ) {
        if( isset($instance[$property] ) ) {
            return esc_attr($instance[$property]);
        } else {
            return "";
        }
    }

} // class Widget_MDBitz_Base