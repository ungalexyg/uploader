<?php
namespace App\Validators\Traits;

use Illuminate\Http\Request;
use App\Exceptions\ValidationException;
use \Illuminate\Support\Facades\Validator;
use App\Exceptions\Validators\BaseValidationException;


/**
 * Validation methods trait
 * custom validation methods that perform actual validation
 * in different contexts
 */
trait ValidationMethods
{

    /**
     * Perform validation on Request instance
     *
     * @param Request $request
     * @throws ValidationException
     * @return void
     */
    public function validateRequest(Request $request)
    {
        $data = $request->all();

        $this->validateArray($data);
    }


    /**
     * Perform validation on array
     *
     * @param array $data
     * @throws ValidationException
     * @return void
     */
    public function validateArray(array $data)
    {
        $rules =  $this->getRules();

        $messages = $this->getMessages();

        $validator = Validator::make($data, $rules, $messages);
        // dd([
        //     '__METHOD__' => __METHOD__, 
        //     '$rules' => $rules,
        //     '$data' => $data, 
        //     '$messages' => $messages, 
        // ]);  

        if($validator->fails())
        {               
            $this->fail($this->message, $this->code, $validator->errors()->toArray());
        }
    }


    /**
     * Perform validation with Validator instance & return the outcome
     *
     * @param array $input
     * @param array $rules
     * @param array $messages
     * @return Validator object
     */
    public function validator($input, $rules=null, $messages=null)
    {
        $rules = (is_null($rules) ? $this->getRules() : $rules);

        $messages = (is_null($messages) ? $this->getMessages() : $messages);

        return Validator::make($input, $rules, $messages);
    }


    /**
     * Handle a failed validation
     *
     * @param string $message
     * @param int $code
     * @param mixed $info // defines if exception should be reported   
     * @param bool $report if Exception should be logged
     * @throws BaseValidationException
     * @return void
     */
    protected function fail(string $message='', int $code=0, array $info=[], bool $report=false)
    {
        $validation_exception = $this->exceptions[$this->ruler->action] ?? false;

        if($validation_exception) 
        {
            // throw new ValidationException($message, $code, $info, $report);
            throw (new $validation_exception($message, $code, $info, $report));    
        }

        // default validation exception
        throw new BaseValidationException($message, $code, $info, $report);
    }

}
