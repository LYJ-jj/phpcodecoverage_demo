<?php

require_once "phpcodecoverage.php";

if (isset($_SERVER['PATH_INFO']))
{
    if ($_SERVER['PATH_INFO'] === '/' || $_SERVER['PATH_INFO'] === '')
    {
        echo 'This is index';
        exit;
    }
    else
    {
        $path_array = array_values(array_filter(explode('/', $_SERVER['PATH_INFO'])));
        if (empty($path_array))
        {
            throw new Exception('url error');
        }

        $ctrl = $path_array[0];
        $func = $path_array[1] ?? 'index';

        $file_path = 'controllers/' . $ctrl . '.php';
        if (file_exists($file_path))
        {
            require_once $file_path;
            $class = ucfirst($ctrl);
            $obj = new $class();
            $obj->$func();
        }
    }
}
else
{
    echo 'This is index';
    exit;
}