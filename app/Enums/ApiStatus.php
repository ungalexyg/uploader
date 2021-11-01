<?php
namespace App\Enums;

/**
 * API codes & messages, representing API statuses in responses
 */
class ApiStatus extends BaseEnum
{
    /**
     * ------------------------------------------------------------------
     * API Status Message Code 
     * ------------------------------------------------------------------
     * codes are from 0-9999 grouped by entity type
     * each group is sub-grouped according to the operation
     * 
     * - x000-x099 GET
     * - x100-x199 CREATE
     * - x200-x299 UPDATE
     * - x300-x399 DELETE
     * - x400-x499 ASSOCIATE
     * - x500-x599 VALIDATION
     * - x600-x999 TBD
     */

    /**
     *  1000-1999 COMMON 
     * (0-999 RESERVED FOR HTTP CODES /App/Enums/HttpStatus)
     */
    const API_REQUEST_NOT_IMPLEMENTED                   = 1000;
    const API_REQUEST_UNAUTHORIZED                      = 1001;
    const API_GATE_DENIED                               = 1002; // default gate denied status 
    const API_VALIDATION_FAILED                         = 1003;    
    const API_CONFIG_SUCCESS                            = 1004; // response enums, etc   

    /* ---------------------------------------------------------
    api upload statuses - for this example
    /* --------------------------------------------------------- */

    /**
     *  2000-2999 UPLOAD 
     */
    const FILE_POST_UPLOAD_SUCCESS                            = 2000;
    const FILE_POST_UPLOAD_INVALID                            = 2001;
    const FILE_POST_UPLOAD_FAILED                             = 2002;

    /* ---------------------------------------------------------
    more api user-actions statuses can be added here e.g: 
    /* --------------------------------------------------------- */

    // const USER_GET_LIST_SUCCESS                         = 2005;
    // const USER_GET_LIST_DENIED                          = 2006;
    // const USER_POST_STORE_SUCCESS                       = 2105;
    // const USER_POST_STORE_DENIED                        = 2106;
    // const USER_POST_STORE_INVALID                       = 2107;
    // const USER_PUT_UPDATE_SUCCESS                       = 2208;
    // const USER_PUT_UPDATE_DENIED                        = 2209;
    // const USER_PUT_UPDATE_INVALID                       = 2210;
    // const USER_DELETE_SUCCESS                           = 2300;
    

    /* ---------------------------------------------------------
    other api entities-actions can be added here ... 
    /* --------------------------------------------------------- */

    /**
     *  3000-3999 PRODUCTS
     */
    // const PRODUCT_GET_SHOW_SUCCESS                       = 3000;
    // const PRODUCT_GET_SHOW_DENIED                        = 3001;
    // const PRODUCT_GET_LIST_SUCCESS                       = 3002;
    // const PRODUCT_GET_LIST_DENIED                        = 3003;
    // const PRODUCT_POST_SUCCESS                           = 3100;
    // const PRODUCT_POST_DENIED                            = 3101;
    // const PRODUCT_POST_INVALID                           = 3102;
    // const PRODUCT_PUT_SUCCESS                            = 3200;
    // const PRODUCT_PUT_DENIED                             = 3201;
    // const PRODUCT_PUT_INVALID                            = 3202;



    /**
     * ------------------------------------------------------------------
     * API Status Message Text 
     * ------------------------------------------------------------------
     * Optional, custom API response text message based on the API status code.
     * The message responded along with the status code. 
     * If the status code has custom message set in the array below, 
     * it will use the constant name as the response message
     * 
     * e.g: 
     * $api_message = ApiStatus::$messages[$api_status] ?? ApiStatus::getKeyByValue($api_status);
     */
    public static $messages = [
        // self::API_REQUEST_NOT_IMPLEMENTED  => 'API_REQUEST_NOT_IMPLEMENTED' // default 
        // self::API_REQUEST_NOT_IMPLEMENTED  => 'the requested api method not implemented' // custom 
    ];
}
