<?php

namespace App\Tests;


use App\Command\XmlReaderCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use XMLReader;

class XmlImportCommandTest extends TestCase
{
    public function testExecute()
    {
        // $ROOT = $_SERVER['PWD'];        

        $application = new Application();
        $application->add(new XmlReaderCommand());

        $command = $application->find('app:xmlimport');
        $commandTester = new CommandTester($command);

        // Invalid case
        $commandTester->execute([]);
        $this->assertSame(Command::INVALID, $commandTester->getStatusCode());

        // Invalid URL case
        // $commandTester->execute([
        //     '--source_path' => 'https://google.com/test.xml',
        // ]);
        // $this->assertSame(Command::FAILURE, $commandTester->getStatusCode());

        // Success case
        $commandTester->execute([         
            '--source_file' => $ROOT . '/project_folder/coffee_feed.xml',
        ]);
        

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Process completed successfully', $output);
        $this->assertStringContainsString('rows imported successfully', $output);
        $this->assertStringContainsString('Data saved at', $output);

        // Failure case
        $commandTester->execute([            
            '--source_file' => $ROOT . '/project_folder/invalid.txt',
        ]);

        $this->assertSame(Command::FAILURE, $commandTester->getStatusCode());

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringNotContainsString('Process completed successfully', $output);
        $this->assertStringNotContainsString('rows imported successfully', $output);
        $this->assertStringNotContainsString('Data saved at', $output);
    }
}
