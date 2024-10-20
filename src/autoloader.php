<?php

spl_autoload_register(function (string $classname) {
    include_once(__DIR__ . '/config/config.php');

    $path = str_replace('\\', '/', $classname);

    include_once($path . '.php');
});
