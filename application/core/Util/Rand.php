<?php
namespace Core\Util;

use Exception;

class Math
{
    public static function getBytes($length)
    {
        if ($length <= 0) {
            return false;
        }
        $bytes = '';
        if (function_exists('openssl_random_pseudo_bytes')
            && (version_compare(PHP_VERSION, '5.3.4') >= 0
                || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
        ) {
            $bytes = openssl_random_pseudo_bytes($length, $usable);
            if (true === $usable) {
                return $bytes;
            }
        }
        if (function_exists('mcrypt_create_iv')
            && (version_compare(PHP_VERSION, '5.3.7') >= 0
                || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
        ) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false && strlen($bytes) === $length) {
                return $bytes;
            }
        }
        throw new Exception (
            'This PHP environment doesn\'t support secure random number generation. ' .
            'Please consider installing the OpenSSL and/or Mcrypt extensions'
        );
    }

}