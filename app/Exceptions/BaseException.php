<?php
namespace App\Exceptions;

use Exception as CoreException;
use App\Lib\Responder;
use App\Enums\ApiStatus;
use App\Enums\HttpStatus;


/**
 * Base Exception 
 */
class BaseException extends CoreException
{
    /**
     * @var string exception text message
     */    
    protected $message = '';

    /**
     * @var int exception message
     */    
    protected $code = 0;

    /**
     * @var array additional exception info
     */    
    protected $info = [];    

    /**
     * @var bool exception report flag
     */    
    protected $report = false;  

    /**
     * @var App\Enums\ApiStatus API status reference  
     */
    protected $api_statuses;

    /**
     * @var App\Enums\HttpStatus HTTP status reference 
     */    
    protected $http_statuses;

    /**
     * Construct, exception references 
     * 
     * @param string $message
     * @param int $code
     * @param mixed $info // defines if exception should be reported   
     * @param bool $report if Exception should be logged
     */
    public function __construct(string $message='', int $code=0, array $info=[], bool $report=false) 
    {
        // required parent core exceptions construct vars, required to initiate exception behavior
        // @see https://www.php.net/manual/en/class.exception.php
        parent::__construct($message, $code, (new \Exception()));

        // this attributes exists at the parent and it is overwritten here to be clear
        $this->message      = $message;
        $this->code         = $code;
        $this->info         = $info;
        $this->report       = $report;

        // custom api statuses references 
        $this->api_statuses   = ApiStatus::class;
        $this->http_statuses  = HttpStatus::class;
    } 
}