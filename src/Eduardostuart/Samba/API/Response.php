<?php namespace Eduardostuart\Samba\API;

use Eduardostuart\Samba\API\JSONUtil;
use Eduardostuart\Samba\API\ResponseNotFoundException;

class Response {

    public $info;

    public $body;

    public $code = 0;

    public function __construct( $info , $body )
    {
        $this->info = $info;
        $this->body = $body;

        if( isset( $this->info['http_code'] ) )
        {
            $this->code = $this->info['http_code'];
        }
    }

    public function __call( $method , $args )
    {
        if( preg_match('/^(to)(json)/i', $method , $matches ) )
        {
            return call_user_func_array( array( $this , 'convertTo' ), array( $matches[2] ) );
        }
    }

    public function body()
    {

        if( is_array( $this->body ) )
        {
            return (object) $this->body;
        }

        if( JSONUtil::isValid( $this->body ) )
        {
            return json_decode( $this->body );
        }

        return $this->body;
    }

    public function info()
    {
        return (object) $this->info;
    }

    private function convertTo( $type )
    {
        switch( strtolower( $type ) )
        {
            case 'json':

                if( JSONUtil::isValid( $this->body ) )
                {
                    return $this->body;
                }

                return @json_encode($this->body);
            default:
                return $this->body;
        }
    }

}