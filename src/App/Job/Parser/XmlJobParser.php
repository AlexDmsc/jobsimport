<?php

declare(strict_types=1);

namespace App\Job\Parser;

use App\Job\Model\Job;
use Exception;

class XmlJobParser implements JobParserInterface
{

    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function parse(): array
    {
        $xml = simplexml_load_file($this->filePath);

        if ($xml === false) {
            throw new Exception("Échec du chargement du fichier XML : $this->filePath");
        }

        $jobs = [];
        foreach ($xml->item as $item) {
            $jobs[] = new Job(
                title: (string)$item->title,
                reference: (string)$item->ref,
                description: (string)$item->description,
                url: (string)$item->url,
                publication: (string)$item->pubDate,
                companyName: (string)$item->company
            );
        }

        return $jobs;
    }
}
