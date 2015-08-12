<?php namespace Eduardostuart\Samba\API;


// Samba Exception
class SambaClassNotFoundException extends \UnexpectedValueException {}
class WrongResponseException extends \OutOfBoundsException {}

// Projects Exception
class CouldNotCreateProjectException extends \RuntimeException { }
class ProjectAlreadyExistsException extends \RuntimeException {}
class ProjectNameRequiredException extends \UnexpectedValueException {}
class ProjectNotFoundException extends \OutOfBoundsException {}

class InvalidFileUploadException extends \UnexpectedValueException{}
class CouldNotUploadException extends \UnexpectedValueException{}

class ResponseNotFoundException extends \OutOfBoundsException{}

class MediaNotFoundException extends \OutOfBoundsException{}


class CategoryNotFoundException extends \OutOfBoundsException{}
class CouldNotCreateCategoryException extends \RuntimeException { }