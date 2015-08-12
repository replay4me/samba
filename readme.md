[![Build Status](https://travis-ci.org/eduardostuart/samba.svg)](https://travis-ci.org/eduardostuart/samba)

# Samba Vídeos

`More info: http://dev.sambatech.com/`

## Installation

***Composer***

Update your `composer.json` file to include this package as a dependency

```
"replay4me/samba":"dev-master"
```

**Service Providers***

Register the Samba service provider by adding it to the providers array in the `app/config/app.php`

```
'Eduardostuart\Samba\SambaServiceProvider',
```

***Aliases***

Alias the Samba facade by adding it to the aliases array in the `app/config/app.php`

```
'Samba' => 'Eduardostuart\Samba\Facades\SambaFacade',
```

***Config Publish***
```
php artisan config:publish eduardostuart/samba
```


## Usage

***Upload file***

*Optional Parameter:*


`mediaType: VIDEO or AUDIO (default: VIDEO)`


```
try
{

    print_r( Samba::upload()->send(
        array(
            'projectId' => $projectId,
            'file' => $myFile // Input::get('file')
        )
    )->body() );

}catch( CouldNotUploadException $e )
{
    echo 'Could not upload file :(';

}catch( InvalidFileUploadException $e )
{
    echo 'Ops! Invalid file';
}
```


***Create new project***

```
try
{
    print_r( Samba::projects()->create(

        array(
            'name' => 'Project name',
            'description' => 'My awesome project'
        )

    )->body() );

}catch(CouldNotCreateProjectException $e)
{
    echo 'Ops! Could not create project';
}
```

***Show projects***

```
try
{

    print_r( Samba::projects()->show()->body() );

}catch(WrongResponseException $e )
{
    echo 'There was an error...';
}
```

***Get a specific project***

```
try
{

    $projectId = 1234;

    print_r( Samba::projects()->show( $projectId )->body() );

}catch(WrongResponseException $e )
{
    echo 'There was an error...';
}
```

***Show a project medias***

```
try
{

    $projectId = 1234;

    print_r( Samba::medias()->show($projectId)->body() );

}catch(MediaNotFoundException $e )
{
    echo 'Media not found';
}
```

***Show a specific media**

```
try
{

    $projectId = 1234;
    $mediaId   = 'abcdefghij';

    print_r( Samba::medias()->show( $projectId , $mediaId )->body() );

}catch(MediaNotFoundException $e )
{
    echo 'Media not found';
}
```

***Remove a specific media***

```
try
{
    $projectId = 1234;
    $mediaId   = 'abcdefghij';

    var_dump( Samba::medias()->remove( $projectId , $mediaId )->body() );

}catch(MediaNotFoundException $e )
{
    echo 'Media not found';
}
```

***Show all categories***

```
try
{
    $projectId = 1234;

    var_dump( Samba::categories()->show( $projectId )->body() );

}catch(WrongResponseException $e )
{
    echo 'There was an error...';
}
```

***Get a category***

```
try
{
    $categoryId = 5555;
    $projectId  = 1234;

    var_dump( Samba::categories()->show( $projectId , $categoryId )->body() );

}catch(WrongResponseException $e )
{
    echo 'There was an error...';
}
```

***Create a category***

```
try
{
    $parentId = 1234; // or null..

    var_dump( Samba::categories()->create( $projectId , 'My super Category' , $parentId )->body() );

}catch(CouldNotCreateCategoryException $e )
{
    echo 'Ops! There was an error...';
}
```
