<?php
namespace App\Tests\Analytics;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnalyticsTest extends WebTestCase
{
    /** @test */
    public function True(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function False(): void
    {
        $this->assertFalse(false);
    }

    /** @test */
    public function LoadHomePage(): void
    {
        $client = static::createClient();

        // Home Page
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Analytics Dashboard');
        $this->assertSelectorExists('div.bg-gray-100.h-screen');
    }

    /** @test */
    public function CheckHotelsApi()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/hotel/all');

        $this->assertResponseIsSuccessful();
    }

    /** @test */
    public function CheckAnalyticsApiNoQuery()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics');

        $this->assertResponseStatusCodeSame(409);
    }

    /** @test */
    public function CheckAnalyticsApiLackOfHotelId()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics?from=2021-01-01&to=2021-01-10');

        $this->assertResponseStatusCodeSame(409);
    }

    /** @test */
    public function CheckAnalyticsApiLackOfFromDate()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics?hotel_id=1&to=2021-01-10');

        $this->assertResponseStatusCodeSame(409);
    }

    /** @test */
    public function CheckAnalyticsApiLackOfToDate()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics?hotel_id=1&from=2021-01-01');

        $this->assertResponseStatusCodeSame(409);
    }

    /** @test */
    public function CheckAnalyticsApiFromDateLessThanToDate()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics?hotel_id=1&from=2021-01-10&to=2000-01-01');

        $this->assertResponseStatusCodeSame(409);
    }

    /** @test */
    public function CheckAnalyticsApiSuccessfully()
    {
        $client = static::createClient();

        // Get Hotel API
        $crawler = $client->request('GET', '/api/analytics?hotel_id=1&from=2021-01-01&to=2021-01-10');

        $this->assertResponseIsSuccessful();
    }
}
