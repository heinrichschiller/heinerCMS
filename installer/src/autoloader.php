<?php

function autoloader($class)
{
    $newName = str_replace('\\', '/', $class);
    $path = __DIR__ . "/lib/$newName.php";

    if(!class_exists($class)) {
        if(file_exists($path)) {
            include $path;
        }
    }
}

spl_autoload_register('autoloader');
