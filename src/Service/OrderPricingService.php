<?php

namespace App\Service;

use App\Entity\Menu;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderPricingService
{
    public function __construct(private HttpClientInterface $httpClient)
    {

    }

    public function geocode(string $address, string $city): ?array
    {
        $query = urlencode($address . ', ' . $city . ', France');
        $url = "https://nominatim.openstreetmap.org/search?q=$query&format=json&limit=1";

        try {
            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'User-Agent' => 'Vite-et-Gourmand/1.0 (contact@vite-et-gourmand.fr)'
                ]
            ]);

            $data = $response->toArray();
            if (empty($data)) {
                return null;
            }
            return [
                'lat' => (float) $data[0]['lat'],
                'lon' => (float) $data[0]['lon']
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function calculatePrices(Menu $menu, int $peopleCount, string $address, string $city): ?array
    {
        $coords = $this->geocode($address, $city);
        if (!$coords) {
            return null;
        }

        $distance = $this->haversineDistance($coords['lat'], $coords['lon'], 44.837789, -0.57918);

        $menuPrice = (float) $menu->getBasePrice() * $peopleCount;
        $deliveryPrice = mb_strtolower(trim($city)) !== 'bordeaux' ? 5 + (0.59 * $distance) : 0;
        $discount = $peopleCount >= $menu->getMinPeople() + 5 ? $menuPrice * 0.10 : 0;
        $totalPrice = $menuPrice - $discount + $deliveryPrice;

        return [
            'distanceKm' => (string) $distance,
            'menuPrice' => (string) $menuPrice,
            'deliveryPrice' => (string) $deliveryPrice,
            'discount' => (string) $discount,
            'totalPrice' => (string) $totalPrice,
        ];
    }

    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // (km)

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}