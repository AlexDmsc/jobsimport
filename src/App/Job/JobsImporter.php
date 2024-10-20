<?php

declare(strict_types=1);

namespace App\Job;

use PDO;

final class JobsImporter
{
    private PDO $db;

    private array $file;

    public function __construct(string $host, string $username, string $password, string $databaseName, array $file)
    {
        $this->file = $file;

        /* connect to DB */
        try {
            $this->db = new PDO('mysql:host=' . $host . ';dbname=' . $databaseName, $username, $password);
        } catch (\Exception $e) {
            die('DB error: ' . $e->getMessage() . "\n");
        }
    }

    public function importJobs(): int
    {
        $this->db->exec('DELETE FROM job');

        $stmt = $this->db->prepare('
            INSERT INTO job (reference, title, description, url, company_name, publication)
            VALUES (:reference, :title, :description, :url, :company_name, :publication)
        ');

        $count = 0;
       foreach ($this->file as $job) {
            $stmt->execute([
                ':reference' => $job->getReference(),
                ':title' => $job->getTitle(),
                ':description' => $job->getDescription(),
                ':url' => $job->getUrl(),
                ':company_name' => $job->getCompanyName(),
                ':publication' => $job->getPublication(),
            ]);
            $count++;
        }
        return $count;
    }
}
