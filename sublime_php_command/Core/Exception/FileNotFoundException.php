<?php

namespace Chigi\Sublime\Exception;

/**
 * Thrown when a file was not found
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class FileNotFoundException extends FileException
{
    /**
     * Constructor.
     *
     * @param string $path The path to the file that was not found
     */
    public function __construct($path)
    {
        parent::__construct(sprintf('The file "%s" does not exist', Environment::getInstance()->getFileSystemEncoding()));
    }
}
