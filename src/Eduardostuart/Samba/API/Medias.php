<?php namespace Eduardostuart\Samba\API;

use Eduardostuart\Samba\API\APIBase;
use Eduardostuart\Samba\API\ProjectNotFoundException;

class Medias extends APIBase {

    public function __construct( $config )
    {
        $this->config = $config;
    }


    public function show( $projectId , $mediaId = null , array $params = array() )
    {

        $method = 'medias';

        if( $mediaId !== null )
        {
            $method = $method . '/' . $mediaId;
        }

        $result = $this->get( $method ,
            array_merge(
                array(
                    'pid' => $projectId
                ) ,
                $params
            )
        );

        try
        {
            $this->checkJSONResponse( $result->body );

        }catch( WrongResponseException $e )
        {
            throw new MediaNotFoundException( $e->getMessage() );
        }

        return $result;
    }

    public function set( $projectId , $mediaId , array $params = array() )
    {

        $result = $this->putJSON( 'medias/'.$mediaId . '?pid=' . $projectId , $params );

        try
        {
            $this->checkJSONResponse( $result->body );

        }catch( WrongResponseException $e )
        {
            throw new MediaNotFoundException( $e->getMessage() );
        }

        return $result;
    }

    public function remove( $projectId , $mediaId )
    {

        $result = $this->delete( 'medias/' . $mediaId ,
            array(
                'pid' => $projectId
            )
        );

        try
        {

            $this->checkJSONResponse( $result->body );

        }catch( WrongResponseException $e )
        {
            throw new MediaNotFoundException( $e->getMessage() );
        }

        return $result;
    }


}