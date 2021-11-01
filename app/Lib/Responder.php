<?php

namespace App\Lib;

use App\Lib\Crypt;
use App\Enums\ApiStatus;
use App\Enums\HttpStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Responder handles api responses message generation.
 * customizing the response in a common structure 
 * before sending it to the client
 */
class Responder 
{
    /**
     * @var int api status
     */        
    protected $api_status = 0;

    /**
     * @var int http status
     */    
    protected $http_status = 0;
    
    /**
     * @var array response data
     */
    protected $response_data = [];

    /**
     * @var array response data
     */
    protected $encrypt = false;

    /**
     * Construct, set properties
     * 
     * @param int $api_status
     * @param int $http_status
     * @param mixed $response_data
     * @param bool $should_encrypt
     */
    public function __construct(int $api_status, int $http_status, $response_data, bool $encrypt=false) 
    {
        $this->api_status       = $api_status;
        $this->http_status      = $http_status;
        $this->response_data    = $response_data;
        $this->encrypt          = $encrypt;
    }    

    /**
     * Generate common base response message
     * 
     * @return array
     */
    public function baseMessage()
    {
        return [
            'http_status'       => $this->http_status,
            'api_status'        => $this->api_status,
            'api_message'       => ApiStatus::$messages[$this->api_status] ?? ApiStatus::getKeyByValue($this->api_status),
            'api_data'          => $this->responseToArray($this->response_data),
        ];        
    }

    /**
     * Generate default response message
     * 
     * @return array
     */
    public function message()
    {
        return $this->baseMessage();
    }

    /**
     * Generate response message for exceptions
     * 
     * @param int $code // exception code
     * @param string $exception_msg // exception message
     * @param array $info // exception info data
     * @return array
     */
    public function exception(int $code=0, string $exception_msg='', array $info=[])
    {
        $message = $this->baseMessage();
        $message['exception'] = [
            'code'      => $code,
            'message'   => $exception_msg,
            'info'      => $info,
        ];
        return $message;
    }        

    /**
     * Recursively convert objects to arrays and encrypt relevant values
     * that shouldn't be visible in the public
     * (primary ids)
     *
     * @param mixed $data
     * @return array $data // the data in as array and encrypted 
     */
    private function responseToArray(&$data)
    {
        if($data instanceof Arrayable)
        {
            $data = $data->toArray();
        }

        if(!is_object($data) && !is_array($data))
        {
            return $data;
        }

        // convert each set of the data into array
        array_walk($data, __METHOD__);

        // encrypt each item in the data that should be encrypted
        array_walk($data, [Crypt::class, 'encryptParameter']);

        return $data;
    }
    
}
