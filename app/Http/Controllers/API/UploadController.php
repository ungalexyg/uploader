<?php

namespace App\Http\Controllers\API;


// use App\Models\User;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Services\Kaltura\Kaltura;
use App\Validators\UploadValidator;
use App\Http\Controllers\BaseController;


/**
 * Upload controller
 */
class UploadController extends BaseController
{

    /**
     * @var App\Repositories\UserRepository
     */
    private $uploader;


    /**
     * Construct, inject dependencies
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->uploader = new Kaltura(); 
    }
    
    /**
     * Upload file
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {   
        $input = $request->all();

        # validation  
        $this->validate([
            'validator' => UploadValidator::class,
            'action'    => 'upload',
            'validate'  => $input,
            'refs'      => [], //optional, extra ref data
        ]);    
        
        if(!$request->file()) 
        {
            return $this->response(
                $this->api_status::FILE_POST_UPLOAD_FAILED,
                $this->http_status::HTTP_OK,['input' => $input]
            );          
        }

        # local upload  
        $uploadedFile       = $request->file('file');
        $fileName           = time().'_'.$request->file->getClientOriginalName();
        $fileStoragePath    = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $filePath           = storage_path('/app/public/uploads/' . $fileName);

        # kaltura upload
        $kalturaResponse = $this->uploader->upload([
           'filepath' => $filePath,
        ]);

        # response
        return $this->response(
            $this->api_status::FILE_POST_UPLOAD_SUCCESS,
            $this->http_status::HTTP_OK,
            [
                'kalturaResponse'   => $kalturaResponse,
                'fileName'          => $fileName, 
                'filePath'          => $filePath, 
                'input'             => $input
            ]
        );          
    }      


    /**
     * Show user - get single user object
     * 
     * Extra, sample method just to demonstrate the api flow
     * 
     * The passed $user_id should be encrypted as given in the search response
     * e.g: /api/users/dmlvSDM2dTRML3M9
     * the id's can be encrypted and decrypted in the console
     * $ cd path/to/project
     * $ php artisan crypt:encrypt 1 // dmlvSDM2dTRML3M9
     * $ php artisan crypt:decrypt dmlvSDM2dTRML3M9 // 1
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param int $user_id
     * @return \Illuminate\Http\Response
     */
    // public function show(Request $request, int $user_id)
    // {   
    //     $input = $request->all();

    //     # validation        
    //     $input['id'] = $user_id; // add for validation        
    //     $this->validate([
    //         'validator' => UserValidator::class,
    //         'action'    => 'show',
    //         'validate'  => $input,
    //         'refs'      => [], //optional, extra ref data
    //     ]);    

    //     // # query
    //     $user = $this->userRepo->show($user_id, $input);

    //     // # response
    //     return $this->response(
    //         $this->api_status::USER_GET_SUCCESS,
    //         $this->http_status::HTTP_OK,
    //         [ 'user' => $user ]
    //     );        
    // }  

   
}
