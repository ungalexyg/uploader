<?php


namespace App\Exceptions\Gates;

use App\Lib\Responder;
use App\Exceptions\BaseException;
use App\Enums\ApiStatus;
use App\Enums\HttpStatus;


/**
 * Base Gate Exception 
 */
class BaseGateException extends BaseException
{
    /**
     * @var int $http_status̀ // default gates exception http status 
     */
    protected $http_status = HttpStatus::HTTP_FORBIDDEN;

    /**
     * @var int $api_status // general api status for gates exception 
     */
    protected $api_status = ApiStatus::API_GATE_DENIED;    

    /**
     * @var int $api_status_gate_exception // api status for specific gate exception
     */
    protected $api_status_case = ApiStatus::API_GATE_DENIED; 

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
