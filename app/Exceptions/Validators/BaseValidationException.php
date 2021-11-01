<?php


namespace App\Exceptions\Validators;

use App\Lib\Responder;
use App\Exceptions\BaseException;
use App\Enums\ApiStatus;
use App\Enums\HttpStatus;


/**
 * Base Validation Exception 
 */
class BaseValidationException extends BaseException
{
    /**
     * @var int $http_status // http status for validation failure 
     */
    protected $http_status = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var int $api_status // general api status for validation failure  
     */
    protected $api_status = ApiStatus::API_VALIDATION_FAILED;    

    /**
     * @var int $api_status_case // api status for specific validation failure case
     */
    protected $api_status_case = ApiStatus::API_VALIDATION_FAILED; 

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $exception_message  = !empty($this->message) 
                              ? $this->message 
                              : ApiStatus::getKeyByValue($this->api_status_case);

        $response = (new Responder(
            $this->api_status, 
            $this->http_status,
            [],  
        ))->exception(
            $this->api_status_case, 
            $exception_message, 
            $this->info
        ); 

        return response()->json($response, $this->http_status);        
    }    

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    // public function report()
    // {
    //     //
    // }   
}
