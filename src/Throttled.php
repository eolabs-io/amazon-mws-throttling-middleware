<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware;

use EolabsIo\AmazonMwsThrottlingMiddleware\Throttle;

class Throttled
{
    /** @var string */
    protected $key = 'throttle-key';

    /** @var int */
    protected $maximumQuotaAllowed;

    /** @var int */
    protected $restoreRatePerSecond;

    /** @var int */
    protected $hourlyRequestQuota;


    public function __construct()
    {

    }

    public function key(string $key)
    {
        $this->key = $key;

        return $this;
    }

    public function maximumQuota(int $maximumQuotaAllowed)
    {
        $this->maximumQuotaAllowed = $maximumQuotaAllowed;

        return $this;
    }

    public function restoreRate($restoreRatePerSecond)
    {
        $this->restoreRatePerSecond = $restoreRatePerSecond;

        return $this;
    }

    public function restoreRateInMin($restoreRatePerMin)
    {
        return $this->restoreRate($restoreRatePerMin / 60);
    }

    public function hourlyRequestQuota(int $hourlyRequestQuota)
    {
        $this->hourlyRequestQuota = $hourlyRequestQuota;

        return $this;
    }

    public function handle($job, $next)
    {
        $this->getThrottle()
             ->then(function () use ($job, $next) {
                    $next($job);
                }, function ($releaseDuration) use ($job) {
                    $job->release($releaseDuration);
                });
    }

    protected function getThrottle(): Throttle
    {
        return (new Throttle())
                ->key($this->key)
                ->maximumQuota($this->maximumQuotaAllowed)
                ->restoreRate($this->restoreRatePerSecond);
    }

}