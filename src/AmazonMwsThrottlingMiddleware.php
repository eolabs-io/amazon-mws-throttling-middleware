<?php

namespace EolabsIo\AmazonMwsThrottlingMiddleware;

use EolabsIo\AmazonMwsThrottlingMiddleware\Throttled;


class AmazonMwsThrottlingMiddleware
{


	public function forListInventorySupply()
	{
		// maximum request quota of 30 and a restore rate of two requests every second
		return (new Throttled())
					->key('list-inventory-supply-throttle')
					->maximumQuota(30)
					->restoreRate(2);
	}

	public function forListOrders()
	{
		// maximum request quota of six and a restore rate of one request every minute
		return (new Throttled())
					->key('list-orders-throttle')
					->maximumQuota(6)
					->restoreRateInMin(1);
	}

	public function forGetOrder()
	{
		// maximum request quota of six and a restore rate of one request every minute
		return (new Throttled())
					->key('get-order-throttle')
					->maximumQuota(6)
					->restoreRateInMin(1);
	}

	public function forListOrderItems()
	{
		// maximum request quota of 30 and a restore rate of one request every two seconds (or 1 every 1/2 second)
		return (new Throttled())
					->key('list-order-items-throttle')
					->maximumQuota(30)
					->restoreRate(0.5);
	}

	public function forListFinancialEventGroups()
	{
		// maximum request quota of 30 and a restore rate of one request every two seconds (or 1 every 1/2 second)
		return (new Throttled())
					->key('list-financial-event-groups-throttle')
					->maximumQuota(30)
					->restoreRate(0.5)
					->hourlyRequestQuota(1800);
	}

	public function forListFinancialEvents()
	{
		// maximum request quota of 30 and a restore rate of one request every two seconds (or 1 every 1/2 second)
		return (new Throttled())
					->key('list-financial-events-throttle')
					->maximumQuota(30)
					->restoreRate(0.5)
					->hourlyRequestQuota(1800);
	}

	public function forGetMatchingProduct()
	{
		// maximum request quota of 20 and a restore rate of two request every second
		return (new Throttled())
					->key('get-matching-product-throttle')
					->maximumQuota(20)
					->restoreRate(2)
					->hourlyRequestQuota(7200);
	}

}
