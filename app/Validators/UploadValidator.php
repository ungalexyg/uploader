<?php
namespace App\Validators;


use App\Validators\Rulers\UploadRuler;
use App\Exceptions\Validators\ValidationFailedUpload;



/**
 * Upload Validator
 */
class UploadValidator extends BaseValidator
{
    /**
     * @var array exceptions ref array for validations exceptions
     */    
    protected $exceptions = [
        

        'upload'    => ValidationFailedUpload::class,        

        /* -------------------------------------   
        other dedicated validation exceptions can be assigned below.
        each exception will response proper validation error with relevant status
        e.g registration cases that can get dedicated exception 
        /* ------------------------------------- */    

        // 'register_email'            => ValidationFailedUserRegisterEmail::class,
        // 'register_email_resend'     => ValidationFailedUserRegisterEmailResend::class,
        // 'register_email_confirm'    => ValidationFailedUserRegisterEmailConfirm::class,
        // 'register_password'         => ValidationFailedUserRegisterPassword::class,
        // 'register_phone'            => ValidationFailedUserRegisterPhone::class,
        // 'register_phone_confirm'    => ValidationFailedUserRegisterPhone2FAConfirm::class,
        
        // // reset password
        // 'reset_password_request'    => ValidationFailedUserResetPasswordRequest::class,
        // 'reset_password_update'     => ValidationFailedUserResetPasswordUpdate::class,
    ];        


    /**
     * Injecting Validator Ruler
     *
     * @param UploadRuler $ruler
     */
    public function __construct(UploadRuler $ruler)
    {
        $this->ruler = $ruler;
    }
}
