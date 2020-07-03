<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware;

use EolabsIo\AmazonMwsThrottlingMiddleware\Contracts\Deferrer;
use EolabsIo\AmazonMwsThrottlingMiddleware\SleepDeferrer;
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

    /** @var EolabsIo\AmazonMwsThrottlingMiddleware\Contracts\Deferrer */
    protected $deferrer;


    public function __construct()
    {
        $this->deferrer = new SleepDeferrer();
    }

    public function deferrer(Deferrer $deferrer)
    {
        $this->deferrer = $deferrer;

        return $this;
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
                });
    }

    protected function getThrottle(): Throttle
    {
        return (new Throttle($this->deferrer))
                ->key($this->key)
                ->maximumQuota($this->maximumQuotaAllowed)
                ->restoreRate($this->restoreRatePerSecond);
    }

}