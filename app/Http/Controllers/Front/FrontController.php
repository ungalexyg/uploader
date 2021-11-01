<?php

namespace App\Http\Controllers\Front;

// use Illuminate\Http\Request;
// use App\Enums\ValidationAction;
use App\Http\Controllers\BaseController;


/**
 * Front controller
 */
class FrontController extends BaseController
{

    /**
     * Construct, inject dependencies
     */
    public function __construct() 
    {
        parent::__construct();
    }
    

    /**
     * Load the front end
     */
    public function loadUploaderView()
    {   
        return view('uploader');
    } 
    
}
