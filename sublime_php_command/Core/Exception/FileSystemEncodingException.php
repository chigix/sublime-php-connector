<?php

namespace Chigi\Sublime\Exception;

use Exception;

/**
 * Thrown when the fileSystemEnoding is incorrect.<br/>
 * The Checking Condition is if a file was surely found upon the given fileSystemEncoding.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class FileSystemEncodingException extends Exception
{
    
    /**
     * Constructor.
     *
     * @param string $enc The encoding specificed in sublime settings.
     */
    public function __construct($enc = null)
    {
        if (is_null($enc)) {
            $enc = \Chigi\Sublime\Settings\Environment::getInstance()->getFileSystemEncoding();
        }
        parent::__construct(sprintf('"%s" isn\'t current filesystem encoding, please specific another right.', $enc));
    }
}
