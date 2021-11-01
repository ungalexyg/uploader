<?php
namespace App\Validators\Rulers;

use App\Enums\UserTypes;
use App\Enums\ValidationAction;

/**
 * User Ruler - example validation ruler usage
 */
class UserRuler extends BaseRuler
{
    /**
     * Base validation rules
     * the base rules which the actual rules will be generated from.
     *
     * @var array
     */
    protected $base_rules = [

        /**
         * 'show' rules set
         */
        'show' => [
            'id' => 'bail|required|integer|exists:users,id',
        ],        


        /**
         * 'search' rules set
         */
        'search' => [
            'term' => 'bail|required|string|min:2',
        ],


        /* ----------------------------------------
         * Examples of other validations rules sets that can be implemented below
         * per action, given fields & including custom validation rules
          ---------------------------------------- */

        // /**
        //  * 'register_email' rules set
        //  * used when user init fresh registration process
        //  */
        // 'register_email' => [
        //     'email'                 => 'bail|required|string|max:191|email:rfc,dns|{{RegisterEmailRule}}',
        // ], 
        
        // /**
        //  * 'register_email_resend' rules set
        //  */
        // 'register_email_resend' => [
        //     'email'                 => 'bail|required|string|max:191|email:rfc,dns|{{RegisterEmailResendRule}}',
        // ],        

        // /**
        //  * 'register_email_confirm' rules set
        //  */
        // 'register_email_confirm' => [
        //     // used email_id, since the email will return encrypted from the confirmation link
        //     'email_id'              => 'bail|required|string|max:191|email:rfc|{{RegisterEmailConfirmRule}}',
        //     'token'                 => 'bail|required|exists:users,remember_token',
        // ],  
        
        // /**
        //  * 'register_password' rules set
        //  */
        // 'register_password' => [
        //     'user_id'               => 'bail|required|integer|{{RegisterPasswordRule}}',
        //     'password'              => 'bail|required|{{PasswordRule}}',
        // ],
        
        // /**
        //  * 'register_password' rules set
        //  */
        // 'register_phone' => [
        //     'user_id'               => 'bail|required|integer|{{RegisterPhoneRule}}',
        //     'phone'                 => 'bail|required|numeric|{{PhoneNumberRule}}',
        // ],
        
        // /**
        //  * 'register_password' rules set
        //  */
        // 'register_phone_confirm' => [
        //     'user_id'               => 'bail|required|integer|{{RegisterPhone2FARule}}',
        //     'otp'                   => 'bail|required|numeric|digits:6',
        // ],        

        // /**
        //  * 'reset_password_request' rules set
        //  */
        // 'reset_password_request' => [
        //     'email'                 => 'bail|required|string|max:191|email:rfc,dns|{{ResetPasswordRequestRule}}',
        // ],                

        // /**
        //  * 'reset_password_request' rules set
        //  */
        // 'reset_password_update' => [
        //     'email_id'              => 'bail|required|{{ResetPasswordRequestRule}}|{{ResetPasswordUpdateRule}}', //ResetPasswordRequestRule used in reset_password_update + reset_password_request 
        //     'token'                 => 'bail|required|exists:users,remember_token',
        //     'password'              => 'bail|required|{{PasswordRule}}',
        // ],         
                
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