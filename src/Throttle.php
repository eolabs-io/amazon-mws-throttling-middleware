<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware;

use EolabsIo\AmazonMwsThrottlingMiddleware\Concerns\HasThrottlingParameters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Throttle
{
    use HasThrottlingParameters;


    /** @var bool */
	private $throttled = false;


    public function __construct()
    {

    }

    public function then(callable $callback, callable $failure = null)
    {
        $this->evaluateThrottle();

    	if( ! $this->isThrottled()) {

            $this->decreaseRequestQuota();
    		
            return $callback();
    	}

        if ($failure) {
            $throttleDuration = $this->getThrottleDuration();
            return $failure($throttleDuration); 
        }
    }

    public function isThrottled(): bool
    {
        return $this->throttled;
    }

    public function evaluateThrottle(): self
    {
        $this->restoreRequestQuota();
        $this->throttled = ($this->getRequestQuota() == 0);

    	return $this;
    }

    public function restoreRequestQuota(): self
    {
        $secondsSinceLastRequest = $this->getLastRequestDuration();
  
        // restore rate of (one request) every (second)
        $restoredRequests = (int) ($secondsSinceLastRequest * $this->restoreRatePerSecond); 
        
        if($restoredRequests > 0) {
            $this->addNumberOfRequests($restoredRequests);
        }
        
        return $this;
    }

    public function getLastRequestDuration(): float
    {
        $lastRequest = $this->getLastRequest();
        return (Carbon::now()->diffInMilliseconds($lastRequest) / 1000);
        // return Carbon::now()->diffInSeconds($lastRequest);
    }

    public function getThrottleDuration(): float
    {
        $secondsSinceLastRequest = $this->getLastRequestDuration();
        $secondsPerRestoreRate = (1/$this->restoreRatePerSecond);

        return (($secondsPerRestoreRate)-$secondsSinceLastRequest);
    }

}