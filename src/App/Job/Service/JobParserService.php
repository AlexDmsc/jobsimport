<?php

namespace App\Job\Service;

use App\Job\Parser\JobParserInterface;
use App\Job\Parser\JsonJobParser;
use App\Job\Parser\XmlJobParser;
use Exception;

class JobParserService
{
    /**
     * @throws Exception
     */
    public static function createParser(string $filePath): JobParserInterface
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'xml' => new XmlJobParser($filePath),
            'json' => new JsonJobParser($filePath),
        };
    }
}
