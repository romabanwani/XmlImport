<?php
namespace App\Library\Import;

interface ImportInterface
{
    public function getResource(): string;  
    public function parse();    
    public function getData(): array;       
    public function exist(): bool;
}