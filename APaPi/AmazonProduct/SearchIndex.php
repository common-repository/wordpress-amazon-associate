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
 * AmazonProduct_SearchIndex
 *
 * This file contains the class AmazonProduct_SearchIndex
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_SearchIndex defines the search index options supported by
 * the Amazon Product Advertising API
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_SearchIndex implements AmazonProduct_iValidConstant {

    /**
     *  All
     */
    const ALL = "All";

    /**
     *  Apparel
     */
    const APPAREL = "Apparel";

    /**
     *  Automotive
     */
    const AUTOMOTIVE = "Automotive";

    /**
     *  Baby
     */
    const BABY = "Baby";

    /**
     *  Beauty
     */
    const BEAUTY = "Beauty";

    /**
     *  Blended
     */
    const BLENDED = "Blended";

    /**
     *  Books
     */
    const BOOKS = "Books";

    /**
     *  Classical
     */
    const CLASSICAL = "Classical";

    /**
     *  DigitalMusic
     */
    const DIGITAL_MUSIC = "DigitalMusic";

    /**
     *  Grocery
     */
    const GROCERY = "Grocery";

    /**
     *  MP3Downloads
     */
    const MP3DOWNLOADS = "MP3Downloads";

    /**
     *  DVD
     */
    const DVD = "DVD";

    /**
     *  Electronics
     */
    const ELECTRONICS = "Electronics";

    /**
     *  HealthPersonalCare
     */
    const HEALTH_PERSONAL_CARE = "HealthPersonalCare";

    /**
     *  HomeGarden
     */
    const HOME_GARDEN = "HomeGarden";

    /**
     *  Industrial
     */
    const INDUSTRIAL = "Industrial";

    /**
     *  Jewelry
     */
    const JEWELRY = "Jewelry";

    /**
     *  KindleStore
     */
    const KINDLE_STORE = "KindleStore";

    /**
     *  Kitchen
     */
    const KITCHEN = "Kitchen";

    /**
     *  Magazines
     */
    const MAGAZINES = "Magazines";

    /**
     *  Merchants
     */
    const MERCHANTS = "Merchants";

    /**
     *  Miscellaneous
     */
    const MISCELLANEOUS = "Miscellaneous";

    /**
     *  Music
     */
    const MUSIC = "Music";

    /**
     *  MusicalInstruments
     */
    const MUSICAL_INSTRUMENTS = "MusicalInstruments";

    /**
     *  MusicTracks
     */
    const MUSIC_TRACKS = "MusicTracks";

    /**
     *  OfficeProducts
     */
    const OFFICE_PRODUCTS = "OfficeProducts";

    /**
     *  OutdoorLiving
     */
    const OUTDOOR_LIVING = "OutdoorLiving";

    /**
     *  PCHardware
     */
    const PC_HARDWARE = "PCHardware";

    /**
     *  PetSupplies
     */
    const PET_SUPPLIES = "PetSupplies";

    /**
     *  Photo
     */
    const PHOTO = "Photo";

    /**
     *  Shoes
     */
    const SHOES = "Shoes";

    /**
     *  Software
     */
    const SOFTWARE = "Software";

    /**
     *  SportingGoods
     */
    const SPORTING_GOODS = "SportingGoods";

    /**
     *  Tools
     */
    const TOOLS = "Tools";

    /**
     *  Toys
     */
    const TOYS = "Toys";

    /**
     *  UnboxVideo
     */
    const UNBOX_VIDEO = "UnboxVideo";

    /**
     *  VHS
     */
    const VHS = "VHS";

    /**
     *  Video
     */
    const VIDEO = "Video";

    /**
     *  VideoGames
     */
    const VIDEO_GAMES = "VideoGames";

    /**
     *  Watches
     */
    const WATCHES = "Watches";

    /**
     *  Wireless
     */
    const WIRELESS = "Wireless";

    /**
     *  WirelessAccessories
     */
    const WIRELESS_ACCESSORIES = "WirelessAccessories";

    /**
     * is String a Valid Search Index Constant
     *
     * @param obj value to test
     * @return boolean
     */
    public static function  isValid( $obj ) {
        if( $obj == self::ALL || $obj == self::APPAREL ||
                $obj == self::AUTOMOTIVE || $obj == self::BABY ||
                $obj == self::BEAUTY || $obj == self::BLENDED ||
                $obj == self::BOOKS || $obj == self::CLASSICAL ||
                $obj == self::DIGITAL_MUSIC || $obj == self::DVD ||
                $obj == self::ELECTRONICS || $obj == self::GROCERY ||
                $obj == self::HEALTH_PERSONAL_CARE ||
                $obj == self::HOME_GARDEN ||
                $obj == self::INDUSTRIAL || $obj == self::JEWELRY ||
                $obj == self::KINDLE_STORE || $obj == self::KITCHEN ||
                $obj == self::MAGAZINES || $obj == self::MERCHANTS ||
                $obj == self::MISCELLANEOUS || $obj == self::MP3DOWNLOADS ||
                $obj == self::MUSIC || $obj == self::MUSICAL_INSTRUMENTS ||
                $obj == self::MUSIC_TRACKS || $obj == self::OFFICE_PRODUCTS ||
                $obj == self::OUTDOOR_LIVING || $obj == self::PC_HARDWARE ||
                $obj == self::PET_SUPPLIES || $obj == self::PHOTO ||
                $obj == self::SHOES || $obj == self::SOFTWARE ||
                $obj == self::SPORTING_GOODS || $obj == self::TOOLS ||
                $obj == self::TOYS || $obj == self::UNBOX_VIDEO ||
                $obj == self::VHS || $obj == self::VIDEO ||
                $obj == self::VIDEO_GAMES || $obj == self::WATCHES ||
                $obj == self::WIRELESS || $obj == self::WIRELESS_ACCESSORIES
                ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get associative array of Supported Locales
     * @return array
     */
    public static function SupportedSearchIndexes() {
        $indexes = array();
        $indexes[self::ALL] = "All";
        $indexes[self::APPAREL] = "Apparel";
        $indexes[self::AUTOMOTIVE] = "Automotive";
        $indexes[self::BABY] = "Baby";
        $indexes[self::BLENDED] = "Blended";
        $indexes[self::BOOKS] = "Books";
        $indexes[self::CLASSICAL] = "Classical";
        $indexes[self::DIGITAL_MUSIC] = "Digital Music";
        $indexes[self::DVD] = "DVD";
        $indexes[self::ELECTRONICS] = "Electronics";
        $indexes[self::GROCERY] = "Grocery";
        $indexes[self::HEALTH_PERSONAL_CARE] = "Health Personal Care";
        $indexes[self::HOME_GARDEN] = "Home Garden";
        $indexes[self::INDUSTRIAL] = "Industrial";
        $indexes[self::JEWELRY] = "Jewelry";
        $indexes[self::KINDLE_STORE] = "Kindle Store";
        $indexes[self::KITCHEN] = "Kitchen";
        $indexes[self::MAGAZINES] = "Magazines";
        $indexes[self::MERCHANTS] = "Merchants";
        $indexes[self::MISCELLANEOUS] = "Miscellaneous";
        $indexes[self::MP3DOWNLOADS] = "MP3 Downloads";
        $indexes[self::MUSIC] = "Music";
        $indexes[self::MUSICAL_INSTRUMENTS] = "Musical Instruments";
        $indexes[self::MUSIC_TRACKS] = "Music Tracks";
        $indexes[self::OFFICE_PRODUCTS] = "Office Products";
        $indexes[self::OUTDOOR_LIVING] = "Outdoor Living";
        $indexes[self::PC_HARDWARE] = "PC Hardware";
        $indexes[self::PET_SUPPLIES] = "PET Supplies";
        $indexes[self::PHOTO] = "Photo";
        $indexes[self::SHOES] = "Shoes";
        $indexes[self::SOFTWARE] = "Software";
        $indexes[self::SPORTING_GOODS] = "Sporting Goods";
        $indexes[self::TOOLS] = "Tools";
        $indexes[self::TOYS] = "Toys";
        $indexes[self::UNBOX_VIDEO] = "Unbox Video";
        $indexes[self::VHS] = "VHS";
        $indexes[self::VIDEO] = "Video";
        $indexes[self::VIDEO_GAMES] = "Video Games";
        $indexes[self::WATCHES] = "Watches";
        $indexes[self::WIRELESS] = "Wireless";
        $indexes[self::WIRELESS_ACCESSORIES] = "Wireless Accessories";
        return $indexes;
    }

}