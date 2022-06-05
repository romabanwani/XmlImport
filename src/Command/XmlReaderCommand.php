<?php

namespace App\Command;

use App\Library\Export\Export;
use App\Library\Import\Import;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class XmlReaderCommand extends Command
{
    protected static $defaultName = 'app:xmlimport';    
    protected static $defaultDescription = 'Read an XML file from local path or remote url.';

    /** @var array */
    protected $errors = [];

    /**
     * We configure here the required options for the command
     */
    protected function configure()
    {
        $this->addOption('source_file',null,InputOption::VALUE_REQUIRED,                
            )->addOption('export_to',null,InputOption::VALUE_OPTIONAL,'The storage for the xml data','csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ConsoleLogger = new ConsoleLogger($output, [
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
            LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
        ]);

        try {
            $storage   = $input->getOption('export_to');
            $source_file = $input->getOption('source_file'); 
            $source = 'Local'; 
            // for future use if in case file is remote check if source is remote code to download file
            // if ($this->isRemote($source_file)) {           
            // }
            if ($source_file == '') {
                throw new \Exception("Failed to load resource");
                return Command::FAILURE;
            }else{
                $import = new Import($source_file);      
                $import->load();
            }
                    
            if ($storage == '') {
                throw new \Exception("kindly provide storage to save file ");
                return Command::FAILURE;
            }else{
                $export = new Export($storage); 
                $export->write($import->getData());
            } 
        } catch (\Exception $exception) {
            $ConsoleLogger->error($exception->getMessage());
            $this->logError($exception->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;    
    }
    
    private function logError(string $message) {
        $this->errors[] = date('c') . " [Error] " . $message;
    }

    /**
     * Logging the errors at the end
     */
    public function __destruct() {
        global $argv;
        if (!empty($this->errors)) {
            error_log(date('c') . " [Command] " . implode(', ', $argv) . PHP_EOL);
        }

        foreach ($this->errors as $error) {
            error_log($error . PHP_EOL);
        }
    }
}

?>