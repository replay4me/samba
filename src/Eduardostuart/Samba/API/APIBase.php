<?php namespace Eduardostuart\Samba\API;

use Exception;
use Eduardostuart\Samba\API\JSONUtil;
use Eduardostuart\Samba\API\Response;
use Eduardostuart\Samba\API\WrongResponseException;

class APIBase {


    public $body;

    public $info;

    public $response;

    protected $config = array();

    private function buildURL( $method  , array $params = array() )
    {
        $url =  rtrim( $this->config['api_url'] , '/' );
        $url.=  '/' . $this->config['api_version'];
        $url.=  '/' . $method;

        if( preg_match('/\?/' , $url ) )
        {
            $url.= '&';
        }else
        {
            $url.= '?';
        }

        $url.=  http_build_query(
                    array_merge(
                        array('access_token' => $this->config['access_token'] ),
                        $params
                    )
                );

        return $url;
    }


    public function checkJSONResponse( $json )
    {
        if( !JSONUtil::isValid( $json ) )
        {
            throw new WrongResponseException('Invalid JSON');
        }

        $json = json_decode( $json );

        if( isset( $json->exception ) )
        {
            throw new WrongResponseException( $json->exception->message );
        }

        return $json;
    }


    private function buildQueryString( $url , array $params = array() )
    {

        if( sizeof( $params ) > 0 )
        {

            $queryString = http_build_query( $params );

            if( preg_match('/\?/', $url ) )
            {
                $url = $url . '&' . $queryString;
            }else
            {
                $url = $url . '?' . $queryString;
            }
        }

        return $url;
    }



    public function request( $type, $url , array $params = array() , array $properties = array() )
    {

        $params = array_filter( $params );

        $ch = curl_init();


        switch( strtolower($type) )
        {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params );
            break;
            case 'get':
                $url = $this->buildQueryString( $url , $params );
            break;
            case 'delete':
                $url = $this->buildQueryString( $url , $params );
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
            case 'update':
            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            break;
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_HEADER, false );
        curl_setopt($ch, CURLOPT_URL, $url );

        foreach( $properties as $propertyKey => $propertyValue )
        {
            curl_setopt( $ch , $propertyKey , $propertyValue );
        }

        $response = curl_exec( $ch );
        $info     = curl_getinfo( $ch );

        curl_close( $ch );

        return ( new Response( $info , $response ) );
    }

    public function __call( $method , $args )
    {
        if( preg_match('/^(get|post|update|delete)/i' , $method ) )
        {

            $url = $this->buildURL( $args[0] );

            $params = isset( $args[1] ) ? $args[1] : array();

            return $this->request( $method , $url , $params );
        }
    }

    public function postJSON( $method , array $params = array() )
    {
        $url  = $this->buildURL( $method );

        $data = json_encode( $params );

        return $this->request('post', $url , $params , array(
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                 'Content-Type: application/json',
                 'Content-Length: ' . strlen($data)
            )
        ));
    }

    public function putJSON( $method , array $params = array() )
    {
        $url  = $this->buildURL( $method );

        $data = json_encode( $params );

        return $this->request('put', $url , $params , array(
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                 'Content-Type: application/json',
                 'Content-Length: ' . strlen($data)
            )
        ));
    }

}