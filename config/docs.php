<?php

return [
    'password' => env('DOCS_PASSWORD', 'secret123'),
    'session_lifetime' => env('DOCS_SESSION_LIFETIME', 120),
    'title' => env('DOCS_TITLE', 'Easydocx API Documentation'),
    'description' => env('DOCS_DESCRIPTION', 'Документация API для Easydocx'),
    'version' => env('DOCS_VERSION', '0.0.1'),
];
