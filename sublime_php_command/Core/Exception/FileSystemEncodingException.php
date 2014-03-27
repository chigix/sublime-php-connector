<?php

namespace Chigi\Sublime\Exception;

use Chigi\Sublime\Settings\Environment;

/**
 * Thrown when a file was not found
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class FileSystemEncodingException extends \Exception
{
    
    /**
     * Constructor.
     *
     * @param string $enc The encoding specificed in sublime settings.
     */
    public function __construct($enc)
    {
        parent::__construct(sprintf('"%s" isn\'t current filesystem encoding, please specific another right.', $enc));
    }
}
