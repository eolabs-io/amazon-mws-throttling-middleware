<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware\Tests;

use EolabsIo\AmazonMwsThrottlingMiddleware\Tests\TestCase;
use EolabsIo\AmazonMwsThrottlingMiddleware\Throttled;
use Illuminate\Support\Carbon;
use Mockery;

class ThrottledTest extends TestCase
{
	/** @var \Closure */
    private $next;

    /** @var \Mockery\Mock */
    private $job;

    /** @var Illuminate\Support\Carbon */
    private $knownDate;


    protected function setUp(): void
    {
        parent::setUp();

        $this->mockJob();

        $this->knownDate = Carbon::create(2020, 3, 24, 12);
        Carbon::setTestNow(function() { return $this->knownDate->copy(); });  

        $this->middleware = (new Throttled())->key('test-throttle-key')->maximumQuota(30)->restoreRate(2);
    }

    /** @test */
    public function it_limits_job_execution()
    {
        $this->job->shouldReceive('fire')->times(30);
        $this->job->shouldReceive('release')->times(2);

        foreach (range(1, 32) as $i) {
            $this->middleware->handle($this->job, $this->next);
        }
    }

    /** @test */
    public function it_restores_job_execution_afer_throttle()
    {
        $this->job->shouldReceive('fire')->times(60);
        $this->job->shouldReceive('release')->times(2);

        foreach (range(1, 31) as $i) {
            $this->middleware->handle($this->job, $this->next);
        }

        //wait for restore
        $this->knownDate->addSeconds(20);

        foreach (range(1, 31) as $i) {
            $this->middleware->handle($this->job, $this->next);
        }
    }

    private function mockJob(): void
    {
        $this->job = Mockery::mock();

        $this->next = function ($job) {
            $job->fire();
        };
    }
}