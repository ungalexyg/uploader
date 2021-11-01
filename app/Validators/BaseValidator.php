<?php
namespace App\Validators;

use App\Validators\Traits\HasRuler;
use App\Validators\Traits\CommonValidations;
use App\Validators\Traits\ValidationMethods;
// use App\Validators\Traits\ValidationHelpers;

/**
 * Base validator class
 */
abstract class BaseValidator
{
    /**
     * Validation traits
     */
    // use ValidationMethods, ValidationHelpers, HasRuler, CommonValidations;
    use ValidationMethods, HasRuler, CommonValidations;

    /**
     * @var string validation failure general message
     */    
    protected $message = '';

    /**
     * @var int validation fail code
     */    
    protected $code = 0;

    /**
     * @var array validation fail info
     */    
    protected $info = [];    

    /**
     * @var bool exception report flag
     */    
    protected $report = false;    
    
    /**
     * @var array exceptions ref array for validations failures
     */    
    protected $exceptions = [];        
    
}
