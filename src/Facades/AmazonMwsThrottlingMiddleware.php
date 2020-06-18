<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EolabsIo\AmazonMwsResponseParser\Skeleton\SkeletonClass
 */
class AmazonMwsThrottlingMiddleware extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amazon-mws-throttling-middleware';
    }
}
