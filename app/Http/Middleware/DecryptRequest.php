<?php
/**
 * middleware to decrypt id's in request
 */

namespace App\Http\Middleware;

use Closure;
use App\Lib\Crypt;


/**
 * Decrypt Request
 */
class DecryptRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        ######################################
        # Handle URL parameters (GET)
        ######################################

        // get route parameters
        $url_parameters = $request->route()->parameters();

        // replacing all parameters with decrypted values
        foreach ($url_parameters as $key => $value) 
        {
            // checking if field requires decryption
            if (Crypt::isEncryptParameter($key)) {

                // decrypt the parameter
                $value = intval(Crypt::decrypt($value));

                // replacing the decrypted parameter
                $request->route()->setParameter($key, $value);
            }
        }

        ######################################
        # Handle BODY parameters (POST/PUT)
        ######################################

        $body_parameters = $request->all();

        // replacing parameters with decrypted values
        array_walk_recursive($body_parameters, [Crypt::class, 'decryptParameter']);

        $request->merge($body_parameters);

        return $next($request);
    }
}
