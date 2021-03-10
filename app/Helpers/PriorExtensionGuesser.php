<?php


namespace LaravelMetronic\Helpers;

use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

/**
 * Provides a best-guess mapping of mime type to file extension.
 */
class PriorExtensionGuesser extends MimeTypeExtensionGuesser
{
    /**
     * Addition to pretty old map of mime types and their default extensions.
     *
     * @see http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
     */
    protected $defaultExtensions = array(
        'text/xml' => 'xml',
    );

}