<?php

declare(strict_types=1);

namespace App\Job\Parser;

use App\Job\Model\Job;
use DateTime;

class JsonJobParser implements JobParserInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function parse(): array
    {
        $jsonContent = file_get_contents($this->filePath);

        $data = json_decode($jsonContent, true);

        $jobs = [];
        foreach ($data['offers'] as $jobItem) {

            $publishedDate = $jobItem['publishedDate'] ?? '';
            $publicationDate = $this->convertDate($publishedDate);

            $jobs[] = new Job(
                title: $jobItem['title'] ?? '',
                reference: $jobItem['reference'] ?? '',
                description: $jobItem['description'] ?? '',
                url: $jobItem['urlPath'] ?? '',
                publication: $publicationDate,
                companyName: $jobItem['companyname'] ?? ''
            );
        }

        return $jobs;
    }

    private function convertDate(string $dateStr): string
    {
        $date = DateTime::createFromFormat('D M d H:i:s T Y', $dateStr);

        return $date->format('Y-m-d');
    }

}
