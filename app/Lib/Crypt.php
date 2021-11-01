<?php

namespace App\Lib;
// use Illuminate\Support\Facades\Crypt;

/**
 * Crypt - handle encryption tasks
 */
class Crypt 
{
    /**
     * Encrypt method
     * 
     * @var string
     */
    private static $encrypt_method = 'CAST5-CBC';


    /**
     * Encryption secret key
     * 
     * @var string
     */
    private static $secret_key;


    /**
     * Encryption secret IV
     * 
     * @var string
     */
    private static $secret_iv;    
    
    /**
     * Keys that should skip encryptions
     */
    private static $skip_encrypt_keys = [
    ];    


    /**
     * Load encryption keys
     * 
     * @return void
     */
    private static function load() 
    {
        if(is_null(self::$secret_key)) 
        {
            $secret_key = env('CRYPTO_KEY');
            $secret_iv = env('CRYPTO_IV');
            if(!$secret_key || !$secret_iv) throw new \Exception('Failed to load keys');     
            self::$secret_key = hash('sha256', $secret_key);
            self::$secret_iv = substr(hash('sha256', $secret_iv), 0, 8);            
        }
    }

    /**
     * Encrypt value
     * 
     * @param mixed $value
     * @return string
     */
    public static function encrypt($value) 
    {
        self::load(); 
        return base64_encode(openssl_encrypt($value, static::$encrypt_method, static::$secret_key, 0, static::$secret_iv));
    }

    /**
     * Decrypt value
     * 
     * @param string $value
     * @return string
     */    
    public static function decrypt($value) 
    {
        self::load(); 
        return openssl_decrypt(base64_decode($value), static::$encrypt_method, static::$secret_key, 0, static::$secret_iv);
    }     


    /**
     * Decrypt array of ids
     * 
     * @param string $ids
     * @return array // with decrypted ids
     */
    public static function decryptArray(array $ids) 
    {
        self::load(); 

        foreach($ids as $k => $id) 
        {
            $ids[$k] = intval(self::decrypt($id));
        }

        return $ids;
    }


    /**
     * Checks if the parameter inside a list should be handled with encryption 
     *
     * @param $key
     * @return boolean
     */
    public static function isEncryptParameter($key)
    {
        if(in_array($key, static::$skip_encrypt_keys)) 
        {
            return false;
        }

        return $key === 'id' || substr($key, -3) === '_id';
    }    


    /**
     * Encrypt parameter if it should be encrypted
     *
     * @param array &$item // reference item to encrypt
     * @param array $key // item key
     * @return void
     */
    public static function encryptParameter(&$item, $key)
    {   
        if(self::isEncryptParameter($key))
        {
            $item = self::encrypt($item);
        }
    }  

    /**
     * Decrypt parameter if it should be decrypted
     *
     * @param array &$item // reference item to encrypt
     * @param array $key // item key
     * @return void
     */
    public static function decryptParameter(&$item, $key)
    {   
        if(self::isEncryptParameter($key))
        {
            $item = self::decrypt($item);
        }
    }     
}
