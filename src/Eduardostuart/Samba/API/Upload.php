<?php namespace Eduardostuart\Samba\API;

use Eduardostuart\Samba\API\APIBase;
use Eduardostuart\Samba\API\Response;
use Eduardostuart\Samba\API\InvalidFileUploadException;
use Eduardostuart\Samba\API\CouldNotUploadException;
use \CurlFile;

class Upload extends APIBase {


    public function __construct( $config )
    {
        $this->config = $config;
    }

    protected function createMediaRequest( $projectId, $mediaType = 'VIDEO' )
    {
        $mediaRequestResponse = $this->postJSON('medias?pid=' . $projectId,
            array(
                'qualifier' => $mediaType
            )
        );

        return $mediaRequestResponse->body();
    }

    public function send( array $params = array() )
    {

        extract(
            array_merge(
                array(
                    'projectId' => null,
                    'file' => null,
                    'mediaType' => 'VIDEO'
                ),
                $params
            )
        );

        if( !$file->isValid() )
        {
            throw new InvalidFileUploadException('Invalid file');
        }

        $mediaRequest = $this->createMediaRequest( $projectId, $mediaType );


        if( !isset( $mediaRequest->id ) )
        {
            throw new CouldNotUploadException('Invalid Media Request Id');
        }

        $mediaRequestUrl = $mediaRequest->uploadUrl;

        $curlFile = new CurlFile( $file->getRealPath() , $file->getMimeType() , $file->getClientOriginalName() );

        $sendedRequest = $this->request( 'post' , $mediaRequestUrl ,
            array(
                'file' => $curlFile
            ),
            array(
                CURLOPT_NOPROGRESS => false
            )
        );

        if( $sendedRequest->code != 201 )
        {
            throw new CouldNotUploadException('Could not upload file');
        }

        return $sendedRequest;
    }

}