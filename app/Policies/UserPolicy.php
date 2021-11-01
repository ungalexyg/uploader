<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserTypes;
// use App\Models\Account;
use App\Exceptions\Gates\GateDeniedUserUpdate;


/**
 * User Policy
 */
class UserPolicy extends BasePolicy
{

    /**
     *  # POLICY BOILERPLATE
     * 
     * 
     * Determine whether the auth user can UPDATE a USER in regular mode (should be able to update only it's self)
     *
     * @param \App\Models\User $user
     * @param array $refs // policy validation refs
     * @param bool $throw // if it should throw exception on failure check
     * @throws GateDeniedUserUpdate
     * @return bool
     */
    public function update(User $user, array $refs=[], $throw=true)
    {

        return false;

        // $valid = false;
        
        // $user_id = $refs['user_id'] ?? false;
            
        // if($user_id) 
        // {
        //     // check if the given $user_id belongs to the authenticated user (to it's self)
        //     $valid = ($user->id == $user_id);
        // }   

        // if(!$valid && $throw) 
        // {
        //     throw (new GateDeniedUserUpdate);
        // }

        // return $valid;
    }      
}
