<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

trait HasThrottlingParameters
{
    /** @var string */
    protected $key;

    /** @var int */
    protected $maximumQuotaAllowed;

    /** @var float */
    protected $restoreRatePerSecond;

    /** @var int */
    protected $hourlyRequestQuota;


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

    public function hourlyRequestQuota($hourlyRequestQuota)
    {
        $this->hourlyRequestQuota = $hourlyRequestQuota;

        return $this;
    }

    public function getRequestQuota(): int
    {
        return Cache::get($this->key.'.request-quota', $this->maximumQuotaAllowed);
    }

    private function setRequestQuota(int $requestQuota): self
    {
        if($requestQuota < 0){
            $requestQuota = 0;
        }

        if($requestQuota > $this->maximumQuotaAllowed){
            $requestQuota = $this->maximumQuotaAllowed;
        }

        Cache::put($this->key.'.request-quota', $requestQuota);
        $this->setLastRequest();

        return $this;
    }

    private function addNumberOfRequests($restoredRequest): self
    {
        return $this->setRequestQuota(($this->getRequestQuota() + $restoredRequest));
    }

    public function getLastRequest(): Carbon
    {
        return Cache::get($this->key.'.last-requests', Carbon::now());
    }

    private function setLastRequest()
    {
        return Cache::put($this->key.'.last-requests', Carbon::now()); 
    }

    private function decreaseRequestQuota(): self
    {
        $requestQuota = $this->getRequestQuota();
        $requestQuota--;

        $this->setRequestQuota($requestQuota);

        return $this;
    }

}