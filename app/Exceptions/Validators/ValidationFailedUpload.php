<?php


namespace App\Exceptions\Validators;

use App\Enums\ApiStatus;
// use App\Enums\HttpStatus;


/**
 * Validation Exception 
 */
class ValidationFailedUpload extends BaseValidationException
{
    /**
     * @var int $api_status_case // specific api status case for this validation exception
     */
    protected $api_status_case = ApiStatus::FILE_POST_UPLOAD_INVALID;    
}
