<?php
/*
 * copyright (c) 2011 MDBitz - Matthew John Denton - mdbitz.com
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
 * Request
 *
 * This file contains the class AmazonProduct_Request
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Request defines the request object that specifies
 * the search parameters.
 *
 * <b>Properties</b>
 * <ul>
 *   <li>ItemPage</li>
 *   <li>Operation</li>
 *   <li>ResponseGroup</li>
 *   <li>SearchIndex</li>
 *   <li>Title</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Request implements AmazonProduct_iValid {

    /**
     * uri
     */
    private $_uri = "/onca/xml";

    /**
     * @var array Object Parameters
     */
    private $_params = array();

    /**
     * @var String Secret Key
     */
    private $_secret_key = null;

    /**
     * @var String Secret Key
     */
    private $_domain = "com";

    /**
     * Constructor
     *
     */
    public function __construct( ) {
        $this->set( "Version", "2011-08-01" );
        $this->set( "Service", "AWSECommerceService" );
        $this->set( "ItemPage", 1 );
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
        if ( $property == "domain" ) {
            return $this->_domain;
        } else if (array_key_exists($property, $this->_params)) {
            return $this->_params[$property];
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
        if( $property == "secret_key" ) {
            $this->_secret_key = $value;
        } else if( $property == "domain" ) {
            $this->_domain = $value;
        } else {
            $this->_params[$property] = $value;
        }
    }

    /**
     * generate the Request's URL
     *
     */
    private function getUrl( ) {
        // sort parameters
        ksort($this->_params);

        // clean parameters
        $clean_params = array();
        foreach( $this->_params as $param=>$value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $clean_params[] = $param . "=" . $value;
        }

        // create query string
        $query_string = implode( "&", $clean_params );

        // create signature
        $signing_string = "GET\n" . $this->_domain . "\n" . $this->_uri . "\n" . $query_string;
        $signature = base64_encode(hash_hmac("sha256", $signing_string, $this->_secret_key, True) );
        $signature = str_replace("%7E", "~", rawurlencode($signature));

        // return query
        return "http://" . $this->_host . $this->_domain . $this->_uri . "?" . $query_string . "&Signature=" . $signature;

    }

    /*
     * perform the http request
     *
     */
     public function execute( $time = null) {
        // set common parameters
        //if( $time == null ) {
            $this->set( "Timestamp", gmdate("Y-m-d\TH:i:s\Z") );
        /*} else {
            $this->set( "Timestamp", $time );
        }*/
        // execute request
        $ch = $this->generateCURL( $this->getUrl( ) );
        $data = curl_exec( $ch );
        $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        $result = new AmazonProduct_Result( $code, $data, $this );
        /*
         *  logic to validate time of server 
		 */
        /*if( $time == null && !$result->isSuccess() ) {
            if( $result->Errors[0]->Code == "RequestExpired" ) {
                $time = $this->get_remote_gmt_time();
                if( $time != null ) {
                    return $this->execute( $time );
                }
            }
        }*/
        return $result;
    }

    protected function get_remote_gmt_time() {
        $timercvd = $this->query_time_server( 'nist1-ny.ustiming.org', 37);
        if (!$timercvd[1]) { # if no error from query_time_server
            $timevalue = bin2hex ($timercvd[0]);
            $timevalue = abs (HexDec('7fffffff') - HexDec($timevalue) - HexDec('7fffffff')) ;
            $tmestamp = $timevalue - 2208988800; # convert to UNIX epoch time stamp
            $datum = date("Y-m-d\TH:i:s\Z",$tmestamp);// - date("Z",$tmestamp)); /* incl time zone offset */
            return $datum;
        }
        return null;
    }

    /*
     * Query a time server
     * (C) 1999-09-29, Ralf D. Kloth (QRQ.software) <ralf at qrq.de>
     */
    protected function query_time_server ($timeserver, $socket) {
        $fp = fsockopen($timeserver,$socket,$err,$errstr,5);

        # parameters: server, socket, error code, error text, timeout
        if ($fp) {
            fputs($fp,"\n");
            while ($line = fgets($fp)) $timevalue .= $line;
            fclose($fp);
        }
        else {
            $timevalue = " ";
        }

        $ret = array();
        $ret[] = $timevalue;
        $ret[] = $err;     # error code
        $ret[] = $errstr;  # error text
        return($ret);
    }

    /**
     * generate cURL get request
     * @param $url
     * @return object cURL Handler
     */
    protected function generateCURL( $url ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: APaPi - PHP Wrapper Library for Amazon Product API', 'Accept: application/xml', 'Content-Type: application/xml' ) );
        return $ch;
    }



    /**
     * is this a valid Request
     *
     * @return boolean
     */
    public function isValid() {
        if( AmazonProduct_Operation::isValid($this->Operation) ) {
            switch( $this->Operation ) {
                case AmazonProduct_Operation::ITEM_SEARCH :
                    if( ! AmazonProduct_SearchIndex::isValid( $this->SearchIndex ) ) {
                        return false;
                    }
                break;
                case AmazonProduct_Operation::ITEM_LOOKUP :
                    if( ! AmazonProduct_IdType::isValid( $this->IdType ) ) {
                        return false;
                    }
                break;
                case AmazonProduct_Operation::SIMILARITY_LOOKUP :
                    if( ! is_null($this->SimilarityType) && ! AmazonProduct_SimilarityType::isValid( $this->SimilarityType ) ) {
                        return false;
                    }
                break;
            }
            return true;
        } else {
            return false;
        }
    }

}