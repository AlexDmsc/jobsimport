<?php

declare(strict_types=1);

namespace App\Job\Model;

class Job
{
    private ?string $id;
    public function __construct(
        private string $title,
        private string $reference,
        private string $description,
        private string $url,
        private string $publication,
        private string $companyName,
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPublication(): string
    {
        return $this->publication;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}
