<?php

namespace App\Services;

use Google\Client;
use Google\Service\AnalyticsData;
use Google\Service\AnalyticsData\RunReportRequest;

class Ga4Service
{
    protected AnalyticsData $analytics;
    protected string $propertyId;

    public function __construct(string $propertyId)
    {
        $this->propertyId = $propertyId;

        $client = new Client();
        $client->setAuthConfig(storage_path('app/private/google_api_credentials.json'));
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');

        $this->analytics = new AnalyticsData($client);
    }

    protected function propertyPath(): string
    {
        return 'properties/' . $this->propertyId;
    }

    public function getEventCount(string $eventName)
    {
        $request = new RunReportRequest([
            'dimensions' => [
                ['name' => 'eventName'],
            ],
            'metrics' => [
                ['name' => 'eventCount'],
            ],
            'dimensionFilter' => [
                'filter' => [
                    'fieldName' => 'eventName',
                    'stringFilter' => [
                        'matchType' => 'EXACT',
                        'value' => $eventName,
                    ],
                ],
            ],
            'dateRanges' => [
                ['startDate' => '30daysAgo', 'endDate' => 'today'],
            ],
        ]);

        return $this->analytics->properties->runReport(
            $this->propertyPath(),
            $request
        );
    }

    public function getAllEventNames(int $days = 30)
    {
        $request = new RunReportRequest([
            'dimensions' => [
                ['name' => 'eventName'],
            ],
            'metrics' => [
                ['name' => 'eventCount'],
            ],
            'dateRanges' => [
                [
                    'startDate' => "{$days}daysAgo",
                    'endDate' => 'today',
                ],
            ],
            'orderBys' => [
                [
                    'metric' => ['metricName' => 'eventCount'],
                    'desc' => true,
                ],
            ],
        ]);

        return $this->analytics->properties->runReport(
            $this->propertyPath(),
            $request
        );
    }
}