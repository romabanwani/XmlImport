<?php
namespace App\Library\Export;

class Export extends Base{
    /**
     * Check if file exist locally
     * @return bool
     */
    // public function exist(): bool {
    //     return file_exists($this->getResource());
    // }
    
    public function write(array $data): self {
        $this->exporttocsv($data);
        return $this;
    }

    public function exporttocsv($data){
        $this->purge(); // Clear the storage if already exist, we can make it configurable
        $file = fopen($this->outputPath(), "a");
        $first = reset($data);
        fputcsv($file, array_keys($first));
        foreach ($data as $row) {
            fputcsv($file, $row);
        }       

        fclose($file);
    } 

}

?>