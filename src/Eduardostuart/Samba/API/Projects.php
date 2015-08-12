<?php namespace Eduardostuart\Samba\API;


use Eduardostuart\Samba\API\APIBase;
use Eduardostuart\Samba\API\CouldNotCreateProjectException;

class Projects extends APIBase {

    public function __construct( $config )
    {
        $this->config = $config;
    }

    /**
     * Returns a collection of projects or a single project
     * specified by the id parameter
     *
     * @param  $id int
     * @return json
     */
    public function show( $id = null )
    {
        $requestMethod = 'projects';

        if( $id !== null )
        {
            $requestMethod = 'projects/' . $id;
        }

        return $this->get( $requestMethod );
    }


    public function create( $data )
    {

        $newProject = $this->postJSON('projects', $data );

        try
        {

            $this->checkJSONResponse( $newProject->body );

        }catch( WrongResponseException $e )
        {
            throw new CouldNotCreateProjectException(  $e->getMessage() );
        }


        return $newProject;
    }


}