<?php

use App\Kernel;

// THE LAST VERSION OF THIS FILE CAN BE FOUND IN THE SYMFONY DEMO REPOSITORY:
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
