<?php
namespace App\Library\Import;

class Import extends Base implements ImportInterface{
    /**
     * Check if file exist locally
     * @return bool
     */
    public function exist(): bool {
        return file_exists($this->getResource());
    }
    
    public function load(): self {
        $this->parse();
        return $this;
    }

    public function parse(){
        $contents = file_get_contents($this->getResource());
        if (empty($contents)) {
            throw new \Exception('Empty contents');
        }

        $this->loadXML($contents);

        return $this;
    }

}

?>