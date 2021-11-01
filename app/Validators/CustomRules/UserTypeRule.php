<?php
namespace App\Validators\CustomRules;

// use App\Enums\UserTypes;


/**
 * User Type Rule
 */
class UserTypeRule extends BaseCustomRule
{
    /**
     * Custom validation
     *
     * @param string $attribute
     * @param string $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        # demo custom rule

        return false;

        // $user_types = UserTypes::getValues();

        // $valid = in_array($value, $user_types);

        // if($valid) 
        // {
        //     return true;
        // }

        // $this->message = "Invalid user type";

        // return false;
    }
}
