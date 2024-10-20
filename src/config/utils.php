<?php

function printMessage(string $message, array $messageParameters = []): void
{
	echo strtr($message."\n", $messageParameters);
}

function dd($data)
{
    var_dump($data);
    die();
}
