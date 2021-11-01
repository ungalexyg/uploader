<?php

namespace App\Services\Kaltura;

// use Illuminate\Support\Facades\Http;
use Kaltura\Client\ApiException;
use Kaltura\Client\Enum\MediaType;
use Kaltura\Client\Type\MediaEntry;
use Kaltura\Client\Enum\SessionType;
use Kaltura\Client\Type\UploadToken;
use Kaltura\Client\Client as KalturaClient;
use App\Services\Interfaces\UploaderInterface;
use Kaltura\Client\Type\UploadedFileTokenResource;
use Kaltura\Client\Configuration as KalturaConfiguration;


/**
 * Kaltura Service Provider
 * 
 * This custom Service Provider, serves as client wrapper 
 * which handles Kaltura's service integration internally 
 * while decoupling it from the application 
 */
class Kaltura implements UploaderInterface
{
    /**
     * @var Kaltura\Client\Client as KalturaClient
     */    
    private $client;    

    
    /**
     * Construct, set properties
     * 
     * @param string $api_key
     * @param string $api_endpoint
     */
    public function __construct() 
    {
        $this->setClient();
    }    


    /**
     * Set the client
     * 
     * @return void
     */
    private function setClient() 
    {
        // the global config() helper access config files
        // in this case we access the services config
        // /config/services.php to get kaltura's keys for the client 
        $keys           = config('services.kaltura') ?? [];
        $secret         = $keys['secret'] ?? false;
        $user_id        = $keys['user_id'] ?? false;
        $partner_id     = $keys['partner_id'] ?? false;
        $service_url    = $keys['service_url'] ?? false;
        $ks             = $keys['ks'] ?? false; //given ks in the task page

        $config = new KalturaConfiguration();
        $config->setServiceUrl($service_url);

        // the $secret & $user_id wasn't available in this task, so the generateSession(); will generate invalid KS
        // I used the given KS in the task page 
        $client = new KalturaClient($config);        
        $generated_ks = $client->generateSession($secret, $user_id, SessionType::ADMIN, $partner_id);
                
        $client->setKS($ks);        

        $this->client = $client;
    }

    /**
     * Upload process
     * 
     * @param array $input
     * @return mixed
     */
    public function upload(array $input) 
    {
        $filePath = $input['filepath'];
        
        // 1) create upload token (uploadToken.add)
        $uploadToken = $this->addUploadToken();
        // dd(__METHOD__, $filePath, $uploadToken);

        // 2) process the upload with the upload token (uploadToken.upload)
        $this->processUpload($uploadToken->id, $filePath);

        // 3) create media entry 
        $mediaEntry = $this->addMediaEntry();

        // 4) associate media entry to uploaded resource
        $result = $this->associateMediaContent($mediaEntry->id, $uploadToken->id);

        // response
        return $result;
    }


    /**
     * Add upload token
     * (uploadToken.add)
     * 
     * UploadToken response sample
     * 
     *  {
     *       "id": "1_960a838bf71a7bac8ab178d1135301c5",
     *       "partnerId": 1726391,
     *       "userId": "candidate@kaltura.com",
     *       "status": 0,
     *       "createdAt": 1635717147,
     *       "updatedAt": 1635717147,
     *       "uploadUrl": "https://ny-upload.kaltura.com",
     *       "autoFinalize": false,
     *       "objectType": "KalturaUploadToken"
     *   } 
     * 
     * @return mixed
     * @throws Exception
     */
    private function addUploadToken() 
    {
        $uploadToken = new UploadToken();
        
        try {
            $populatedUploadToken =  $this->client->getUploadTokenService()->add($uploadToken);
            return $populatedUploadToken;
        } catch (\Exception $e) {
            $this->handleException($e);
        }        
    }


    /**
     * Process the upload
     * (uploadToken.upload)
     * 
     * Response sample 
     * 
     *   {
     *       "id": "1_960a838bf71a7bac8ab178d1135301c5",
     *       "partnerId": 1726391,
     *       "userId": "candidate@kaltura.com",
     *       "status": 2,
     *       "fileName": "sample-video.mov",
     *       "uploadedFileSize": "76786195",
     *       "createdAt": 1635717147,
     *       "updatedAt": 1635717582,
     *       "uploadUrl": "https://ny-upload.kaltura.com",
     *       "autoFinalize": false,
     *       "objectType": "KalturaUploadToken"
     *   }
     * 
     * @param string $uploadTokenId
     * @return mixed
     */
    private function processUpload(string $uploadTokenId, string $filePath) 
    {
        // $uploadTokenId = "1_960a838bf71a7bac8ab178d1135301c5"; // $uploadToken->id
        // $filePath = "/path/to/file";
        $resume = false;
        $finalChunk = true;
        $resumeAt = -1;
        try {
            return $this->client->getUploadTokenService()->upload($uploadTokenId, $filePath, $resume, $finalChunk, $resumeAt);
        } catch (\Exception $e) {  
            $this->handleException($e);
        }
    }


    /**
     * Create media entry
     * (media.add)
     * 
     * Response sample
     * 
     *   {
     *       "mediaType": 1,
     *       "sourceType": "6",
     *       "dataUrl": "https://cdnapisec.kaltura.com/p/1726391/sp/172639100/playManifest/entryId/1_iop0zgc9/format/url/protocol/https",
     *       "plays": 0,
     *       "views": 0,
     *       "duration": 0,
     *       "msDuration": 0,
     *       "id": "1_iop0zgc9",
     *       "name": "demo1",
     *       "partnerId": 1726391,
     *       "userId": "email@kaltura.com",
     *       "creatorId": "email@kaltura.com",
     *       "downloadUrl": "https://cdnapisec.kaltura.com/p/1726391/sp/172639100/playManifest/entryId/1_iop0zgc9/format/download/protocol/https/flavorParamIds/0",
     *       "thumbnailUrl": "https://cfvod.kaltura.com/p/1726391/sp/172639100/thumbnail/entry_id/1_iop0zgc9/version/0",
     *       ....  
     *   }
     */
    public function addMediaEntry() 
    {
        $entry = new MediaEntry();
        $entry->mediaType = MediaType::VIDEO;
      
        try {
            return $this->client->getMediaService()->add($entry);
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }


    /**
     * Associate uploaded file to media entry
     * (media.addContent)
     *  
     * Response sample
     * 
     *   {
     *       "mediaType": 1,
     *       "conversionQuality": 5601251,
     *       "sourceType": "1",
     *       "dataUrl": "https://cdnapisec.kaltura.com/p/1726391/sp/172639100/playManifest/entryId/1_iop0zgc9/format/url/protocol/https",
     *       "id": "1_iop0zgc9",
     *       "name": "demo1",
     *       "partnerId": 1726391,
     *       "userId": "email@kaltura.com",
     *       "creatorId": "email@kaltura.com",
     *       "createdAt": 1635718672,
     *       "updatedAt": 1635720215,
     *       "downloadUrl": "https://cdnapisec.kaltura.com/p/1726391/sp/172639100/playManifest/entryId/1_iop0zgc9/format/download/protocol/https/flavorParamIds/0",
     *       "thumbnailUrl": "https://cfvod.kaltura.com/p/1726391/sp/172639100/thumbnail/entry_id/1_iop0zgc9/version/0",
     *       ...
     *   }
     * 
     * @param string $entryId
     * @param string $uploadTokenId
     */
    public function associateMediaContent(string $entryId, string $uploadTokenId) 
    {
        $resource = new UploadedFileTokenResource();
        $resource->token = $uploadTokenId;
      
        try {
            return $this->client->getMediaService()->addContent($entryId, $resource);
        } catch (\Exception $e) {
            $this->handleException($e);
        }        
    }    


    /**
     * Custom exception handler
     */
    private function handleException(\Exception $e) 
    {
        echo $e->getMessage(); // in real app, this should be handled properly with log/monitoring/alerts, etc
    }

}
