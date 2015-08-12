<?php namespace Eduardostuart\Samba;

use Config;
use Eduardostuart\Samba\API\SambaClassNotFoundException;

class Samba {

    protected $config;

    public function __construct( $config = array() )
    {
        $this->config = array(
            'api_url'      => Config::get('samba::api_url'),
            'api_version'  => Config::get('samba::api_version'),
            'access_token' => Config::get('samba::access_token'),
            'app_id'       => Config::get('samba::app_id'),
        );
    }


    public function __call( $method, $args = array() )
    {

        $className = 'Eduardostuart\\Samba\\API\\' . ucfirst( $method );

        if( class_exists( $className ) )
        {
            return ( new $className( $this->config ) );
        }else
        {
            throw new SambaClassNotFoundException('Unable to load ' . $className );
        }

    }

}