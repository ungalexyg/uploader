<?php
namespace App\Validators\Rulers;

use App\Enums\UserTypes;
use App\Enums\ValidationAction;

/**
 * Upload validation ruler
 * defines validation rules per field in the request 
 */
class UploadRuler extends BaseRuler
{
    /**
     * Base validation rules
     * the base rules which the actual rules will be generated from.
     *
     * @var array
     */
    protected $base_rules = [

        /**
         * 'upload' rules set
         */
        'upload' => [
            'file' => 'bail|required|mimes:mov,mp4,flv',
            // 'file' => 'bail|required|mimes:mp4',
        ],        


        /* ----------------------------------------
         * Examples of other validations rules sets that can be implemented below
         * per action, given fields & including custom validation rules
          ---------------------------------------- */
 
    ];


    /**
     * Add custom adjustments
     *
     * @return array
     */
    // protected function customRules()
    // {
    //     // e.g: ...
    //     // $this->rules['transaction_id'][] = 'in:' . ($this->data['transaction_id'] ?? false); 

    //     return $this->rules;
    // }

}