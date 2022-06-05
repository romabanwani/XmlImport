<?php

namespace App\Library\Export;

/**
 * Class Base
 * @package App\Library\Export
 */
abstract class Base
{
    const DEFAULT_STORAGE_FILE = "data.csv";
    protected $storage;

    /**
     * Base constructor.
     * @param string $resource
     */
    public function __construct(string $storage) {        
        $this->storage = $storage;
    }

    /**
     * Return the resource path
     * @return string
     */
    public function getStorage(): string {        
        return $this->storage;
    }
    public function purge(): void {       
        @unlink($this->outputPath());
    }

    public function outputPath(): string {
        return $_ENV['STORAGE_PATH'] . DIRECTORY_SEPARATOR . self::DEFAULT_STORAGE_FILE;
    }
}

?>