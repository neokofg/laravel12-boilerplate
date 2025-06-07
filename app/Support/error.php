<?php

use Symfony\Component\HttpFoundation\Response;

function getCode(mixed $code): int
{
    if (gettype($code) !== 'integer') {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return ($code >= 200 && $code <= 599) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;
}
