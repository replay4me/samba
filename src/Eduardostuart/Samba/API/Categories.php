<?php namespace Eduardostuart\Samba\API;

use Eduardostuart\Samba\API\APIBase;
use Eduardostuart\Samba\API\CategoryNotFoundException;

class Categories extends APIBase {

    public function __construct( $config )
    {
        $this->config = $config;
    }

    public function show( $projectId , $id = null , $params = array() )
    {
        $requestMethod = 'categories';

        if( $id !== null )
        {
            $requestMethod .= '/' . $id;
        }

        $params = array_merge(
            array(
                'pid' => $projectId
            ),
            $params
        );

        return $this->get( $requestMethod , $params );
    }


    public function create( $projectId, $name , $parentId = null )
    {

        $newCategory = $this->postJSON( 'categories/?pid=' . $projectId,
            array(
                'name'   => $name,
                'parent' => $parentId
            )
        );

        try
        {

            $this->checkJSONResponse( $newCategory->body );

        }catch( WrongResponseException $e )
        {
            throw new CouldNotCreateCategoryException(  $e->getMessage() );
        }


        return $newCategory;
    }

}