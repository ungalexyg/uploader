<?php


namespace App\Exceptions\Gates;

use App\Enums\ApiStatus;
use App\Enums\HttpStatus;


/**
 * Gate Exception 
 */
class GateDeniedUserUpdate extends BaseGateException
{
    /**
     * @var int $api_status_case // specific api status case for this gate exception
     */
    protected $api_status_case = ApiStatus::USER_PUT_DENIED;    
}
