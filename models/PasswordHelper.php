<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * PasswordHelper is the model behind password encryption/decryption
 *
 *
 */
class PasswordHelper extends Model
{
    const SALT = '28b206548469ce62182048fd9cf91760';
    const ENCODE_KEY = 'xtre1s23we4';
    
    /**
      * function to encode data
      * 
      * @param string $string string
      * 
      * @return string encoded data
      * 
      */
    public static function safe_b64encode($string) { 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
        
    /**
      * function to decode data
      * 
      * @param string $string string
      * 
      * @return string decoded data
      * 
      */
    public static function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod = strlen($data) % 4;
        if ($mod) {
           $data .= substr('====', $mod);
        }
        return base64_decode($data);
    }
    
    /**
     * function to encode data
     * 
     * @param string $value string to be encoded
     * 
     * @return string encode data
     * 
     */
    public static function encode($value){  
       $key = PasswordHelper::check_keylength();
        if (!$value) {
            return false;
        }
        $text = $value;
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
        return trim(PasswordHelper::safe_b64encode($crypttext)); 
    }
    
    /**
     * function to decode data
     * 
     * @param string $value string to be decoded
     * 
     * @return string decoded data
     * 
     */
    public static function decode($value){ 
        $key = PasswordHelper::check_keylength();
        if (!$value) {
            return false;
        }
        $crypttext = PasswordHelper::safe_b64decode($value); 
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

    /**
     * The function to check code length
     *
     * @return datatype String  .
    */
    public static function check_keylength()
    {
        $key = self::ENCODE_KEY;
        if (strlen($key) > 32) return false;
        // set sizes
        $sizes = array(16,24,32);
        // loop through sizes and pad key
        foreach ($sizes as $s) {
            while(strlen($key) < $s) $key = $key."\0";
            if(strlen($key) == $s) break; // finish if the key matches a size
        }
        return $key;
    }
  
}
