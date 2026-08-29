<?php

declare(strict_types=1);

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../app/Core/autoload.php';

use App\Core\Router;

Router::despachar();
