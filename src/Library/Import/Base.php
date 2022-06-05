<?php

namespace App\Library\Import;

/**
 * Class Base
 * @package App\Library\Export
 */
abstract class Base
{
    /** @var string */
    protected $resource;

    /** @var array */
    protected $data = [];

    /**
     * Base constructor.
     * @param string $resource
     */
    public function __construct(string $resource) {        
        $this->resource = $resource;
    }

    /**
     * Return the resource path
     * @return string
     */
    public function getResource(): string {
        return $this->resource;
    }

    
    public function getData(): array {
        return $this->data;
    }

    
    protected function loadXML(string $xml) {
        if (!self::isValid($xml)) {
            throw new \Exception('Given content is not a valid xml');
        }

        // Load the xml string
        $data = simplexml_load_string($xml, 'SimpleXMLElement',LIBXML_NOCDATA);

        if ($data === false) {
            $errors = [];
            foreach(libxml_get_errors() as $error) {
                $errors[] = $error->message;
            }

            throw new \Exception('Failed to load XML, Errors: ' . json_encode($errors));
        }

        foreach ($data as $row) {
            // Set the data to be used
            $this->data[] = $this->sanitizeNodes($row);
        }
    }
    
    private function sanitizeNodes($data): ?array
    {
        if ($data instanceof \SimpleXMLElement and $data->count() === 0) {
            return null;
        }

        $data = (array) $data;
        foreach ($data as &$value) {
            if (is_array($value) or $value instanceof \SimpleXMLElement) {
                $value = $this->sanitizeNodes($value);
            }
        }        
        return $data;
    }

    public static function isValid(string $xmlContents): bool {
        if (trim($xmlContents) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($xmlContents);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }
}
