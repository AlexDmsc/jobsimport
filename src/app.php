<?php

/************************************
 * Entry point of the project.
 * To be run from the command line.
 ************************************/

use App\Job\JobsImporter;
use App\Job\JobsLister;
use App\Job\Service\JobParserService;

include_once(__DIR__ . '/config/utils.php');
include_once(__DIR__ . '/autoloader.php');
include_once(__DIR__ . '/config/config.php');

printMessage("Starting...");

$files = [
    'regionsjob.xml',
    'jobteaser.json'
];

/* import jobs files */
$allJobs = [];
foreach ($files as $filePath) {

    $parser = JobParserService::createParser(RESSOURCES_DIR . $filePath);
    $jobs = $parser->parse();
    $allJobs = array_merge($allJobs, $jobs);

    $jobsImporter = new JobsImporter(SQL_HOST, SQL_USER, SQL_PWD, SQL_DB, $allJobs);

    $count = $jobsImporter->importJobs();

    printMessage("> {count} jobs imported.", ['{count}' => $count]);

}

/* list jobs */
$jobsLister = new JobsLister(SQL_HOST, SQL_USER, SQL_PWD, SQL_DB);
$jobs = $jobsLister->listJobs();

printMessage("> all jobs ({count}):", ['{count}' => count($jobs)]);
foreach ($jobs as $job) {
    printMessage(" {id}: {reference} - {title} - {publication}", [
    	'{id}' => $job['id'],
    	'{reference}' => $job['reference'],
    	'{title}' => $job['title'],
    	'{publication}' => $job['publication']
    ]);
}


printMessage("Terminating...");
