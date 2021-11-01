<?php

namespace App\Services\Interfaces;


/**
 * Uploader interface
 * 
 * sample interface for application's file uploads usage
 */
interface UploaderInterface 
{
    /**
     * Upload file
     *
     * @param array $input
     * @return mixed
     */
    public function upload(array $input);
}