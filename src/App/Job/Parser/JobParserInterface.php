<?php

namespace App\Job\Parser;

interface JobParserInterface
{
    public function parse(): array;
}
