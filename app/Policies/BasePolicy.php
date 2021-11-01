<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


/**
 * Base Policy
 * 
 * Policy are classes that can handle permissions
 * 
 * 
 */
abstract class BasePolicy
{
    use HandlesAuthorization;
}
