<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware\Contracts;

interface Deferrer
{
    public function getCurrentTime(): int;

    public function sleep(int $milliseconds);
}