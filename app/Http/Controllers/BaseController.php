<?php

namespace App\Http\Controllers;

use App\Lib\Responder;
use App\Enums\ApiStatus;
use App\Enums\HttpStatus;
use App\Exceptions\Gates\GateException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as CoreController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Base controller 
 * initiate controllers common functionality  
 */
class BaseController extends CoreController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * API status reference  
     */
    protected $api_status;

    /**
     * HTTP status reference 
     */    
    protected $http_status;

    /**
     * Construct, ref statuses
     */
    public function __construct() {
        
        $this->api_status = ApiStatus::class;
        
        $this->http_status = HttpStatus::class;
    }

    /**
     * Controller Gates interceptor
     * 
     * $gates = 
     * [
     *      [
     *          'model' => User::class, // model registered with policy
     *          'action'=> 'list', // action method on the policy
     *          'refs'  => $refs, // extra ref data to validate in the policy  
     *          'throw' => GateDeniedUserList::class, // throw exception on failure
     *      ]
     * ]
     * 
     * @param array $gates // array with gates configs
     * @throws GateException
     * @return bool
     */
    protected function gate(array $gate)
    {
        $refs = $gate['refs'] ?? [];
        // $entity = $gate['entity'] ?? false;
        $attrs = [
            $gate['model'],
            $refs,
            ($gate['throw'] ?? true)
        ];
     
        $result = Gate::denies($gate['action'], $attrs);
        
        return $result;
    }


    /**
     * Execute validation on a given validation settings
     * 
     * $validation = [
     *      'validator' => TransactionValidator::class, // validator class
     *      'action'    => 'create', // validation action
     *      'validate'  => $validate, // the data to validate, based on validation ruler
     *      'refs' => [] // optional, extra rf data to be used in custom rules
     * ]
     * 
     * @param array $validation // array with validation config
     * @throws ValidationException
     * @return self
     */
    protected function validate(array $validation) 
    {
        // $validator  =  (new $validation['validator']);
        $validator  = app()->make($validation['validator']);
        $action     = $validation['action'];
        $validate   = $validation['validate'];
        $refs       = $validation['refs'] ?? [];

        // try {
        //     $validator->setAction($action)->setData($refs)->validateArray($validate);
        // } catch(\Exception $e) {
        //     $r = [
        //         'File' => $e->getTrace()[0]['file'],
        //         'Line' => $e->getTrace()[0]['line'],
        //         'Class' => $e->getTrace()[1]['class'],
        //         'Method' => $e->getTrace()[1]['function']                
        //     ];
        //     dd($r);
        // }
        $validator->setAction($action)->setData($refs)->validateArray($validate);

        
        
        return $this;
    }


    /**
     * Controller success messages responder
     *
     * @param int $api_status
     * @param int $http_status
     * @param array $response_data 
     * @param bool $encrypt
     * @return mixed
     */
    public function response(int $api_status, int $http_status, $response_data, bool $encrypt=false)
    {
        $responder = new Responder($api_status, $http_status, $response_data, $encrypt);
        return $responder->message(); 
    }    
}
