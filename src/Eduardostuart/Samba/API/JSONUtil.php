<?php namespace Eduardostuart\Samba\API;

class JSONUtil {

    public static function isValid( $json )
    {
        @json_decode($json);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}