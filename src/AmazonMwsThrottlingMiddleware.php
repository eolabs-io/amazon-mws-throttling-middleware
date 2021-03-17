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

    public function forGetMatchingProducts()
    {
        // maximum request quota of 20 and a restore rate of two request every second
        return (new Throttled())
                    ->key('get-matching-products-throttle')
                    ->maximumQuota(20)
                    ->restoreRate(2)
                    ->hourlyRequestQuota(7200);
    }

    public function forListMarketplaceParticipations()
    {
        // maximum request quota of 20 and a restore rate of two request every second
        return (new Throttled())
                    ->key('list-marketplace-participations')
                    ->maximumQuota(15)
                    ->restoreRateInMin(1);
    }

    public function forRequestReport()
    {
        // maximum request quota of 15 and a restore rate of one request every min
        return (new Throttled())
                    ->key('request-report')
                    ->maximumQuota(15)
                    ->restoreRateInMin(1)
                    ->hourlyRequestQuota(60);
    }

    public function forGetReportRequestList()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report-request-list')
                    ->maximumQuota(10)
                    ->restoreRateInMin(0.3333)
                    ->hourlyRequestQuota(80);
    }

    public function forGetReportRequestCount()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report-request-count')
                    ->maximumQuota(10)
                    ->restoreRateInMin(0.3333)
                    ->hourlyRequestQuota(80);
    }

    public function forCancelReportRequests()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('cancel-report-requests')
                    ->maximumQuota(10)
                    ->restoreRateInMin(0.3333)
                    ->hourlyRequestQuota(80);
    }

    public function forGetReportList()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report-list')
                    ->maximumQuota(10)
                    ->restoreRateInMin(1)
                    ->hourlyRequestQuota(60);
    }

    public function forGetReportListByNextToken()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report-list-by-next-token')
                    ->maximumQuota(30)
                    ->restoreRate(0.5)
                    ->hourlyRequestQuota(1800);
    }

    public function forGetReportCount()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report-count')
                    ->maximumQuota(10)
                    ->restoreRateInMin(0.3333)
                    ->hourlyRequestQuota(80);
    }

    public function forGetReport()
    {
        // maximum request quota of 10 and a restore rate of one request every 45 sec
        return (new Throttled())
                    ->key('get-report')
                    ->maximumQuota(15)
                    ->restoreRateInMin(1)
                    ->hourlyRequestQuota(60);
    }

    public function forGetProductCategories()
    {
        // maximum request quota of 20 and a restore rate of one request every five seconds (or 1 every 1/5 second)
        return (new Throttled())
                    ->key('get-product-categories')
                    ->maximumQuota(20)
                    ->restoreRate(0.2)
                    ->hourlyRequestQuota(720);
    }
}
