<?php

function getFullDate(DateTimeInterface $date): string
{
    return getDefaultDate($date)->format('Y-m-d H:i:s');
}

function getOnlyDate(DateTimeInterface $date): string
{
    return getDefaultDate($date)->format('Y-m-d');
}

function getOnlyTime(DateTimeInterface $date): string
{
    return getDefaultDate($date)->format('H:i:s');
}
function getDefaultDate(DateTimeInterface $date): DateTimeInterface
{
    return $date->setTimezone(config('app.timezone'));
}
