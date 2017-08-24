<?php

namespace App\Console\Commands;

use App\Models\Geocode;
use App\Services\HaversineFormulaService;
use Illuminate\Console\Command;

class FindBeersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beers:find {--lat=} {--long=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect as much beers as possible from given location';

    /**
     * Max distance that can be flown
     *
     * @var int
     */
    protected $fuel = 2000;

    /**
     * Locations geocodes
     *
     * @var array
     */
    protected $geocodes = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);

        $lat = $this->option('lat');
        $long = $this->option('long');

        if (!$lat || !$long) {
            return $this->error('Not enough parameters...');
        }

        $this->findBreweries($lat, $long, $lat, $long);

        $end = round(microtime(true) - $start, 3);
        $this->info('Execution time: ' . $end . 's');
    }

    /**
     * Return fuel amount
     *
     * @return int
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * Set fuel amount
     *
     * @param $fuel
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;
    }

    /**
     * Return geocodes
     *
     * @return array
     */
    public function getGeocodes()
    {
        return $this->geocodes;
    }

    /**
     * Set geocodes
     *
     * @param $geocodes
     */
    public function setGeocodes($geocodes)
    {
        $this->geocodes = $geocodes;
    }

    /**
     * Return a nearest brewery for given coordinates
     *
     * @param $lat
     * @param $long
     * @return Geocode
     */
    public function findNearestBrewery($lat, $long)
    {
        $geocodes = $this->getGeocodes();
        $nearestGeocode = new Geocode();
        $haversineService = new HaversineFormulaService();
        $radius = $this->getFuel() / 2;

        foreach ($geocodes as $geocode) {
            if ($geocode->latitude !== $lat && $geocode->longitude !== $long) {
                $haversineService->setLatitudeFrom($lat);
                $haversineService->setLongitudeFrom($long);
                $haversineService->setLatitudeTo($geocode->latitude);
                $haversineService->setLongitudeTo($geocode->longitude);

                $distance = $haversineService->calculateDistance();

                if ($distance < $radius) {
                    $radius = $distance;
                    $nearestGeocode = $geocode;
                }
            }
        }

        return $nearestGeocode;
    }

    /**
     * Find as much breweries as possible for given coordinates with fuel for 2000 km.
     *
     * @param $homeLat
     * @param $homeLong
     * @param $lat
     * @param $long
     * @param int $distanceToHome
     * @param array $distances
     */
    public function findBreweries($homeLat, $homeLong, $lat, $long, $distanceToHome = 1000, $distances = [])
    {
        $geocodes = $this->getGeocodes();

        if (!$geocodes) {
            $geocodes = new Geocode();
            $geocodes = $geocodes->getBreweriesInArea($homeLat, $homeLong, $this->getFuel() / 2);
        }

        $geocodes = $geocodes->keyBy('id');
        $this->setGeocodes($geocodes);

        $nearestBrewery = $this->findNearestBrewery($lat, $long);

        $haversineService = new HaversineFormulaService();

        $haversineService->setLatitudeFrom($lat);
        $haversineService->setLongitudeFrom($long);
        $haversineService->setLatitudeTo($nearestBrewery->latitude);
        $haversineService->setLongitudeTo($nearestBrewery->longitude);

        $nearestBreweryDistance = $haversineService->calculateDistance();

        $haversineService->setLatitudeFrom($nearestBrewery->latitude);
        $haversineService->setLongitudeFrom($nearestBrewery->longitude);
        $haversineService->setLatitudeTo($homeLat);
        $haversineService->setLongitudeTo($homeLong);

        $distanceToHome = $haversineService->calculateDistance();

        $geocodes->forget($nearestBrewery->id);

        $fuel = $this->getFuel() - $nearestBreweryDistance;

        if ($fuel <= $distanceToHome) {
            return $this->printRoutesResults($homeLat, $homeLong, $distances);
        }

        $distances[] = [
            'geocode' => $nearestBrewery,
            'distance' => (int)$nearestBreweryDistance,
        ];

        $this->setFuel($fuel);
        $this->setGeocodes($geocodes);

        return $this->findBreweries($homeLat, $homeLong, $nearestBrewery->latitude, $nearestBrewery->longitude, $distanceToHome, $distances);
    }

    /**
     * Print routes of the journey for finding beers
     *
     * @param $results
     */
    public function printRoutesResults($lat, $long, $results)
    {
        $totalDistance = 0;
        $totalBeers = 0;
        $beers = [];
        $haversineService = new HaversineFormulaService();

        $haversineService->setLatitudeFrom($lat);
        $haversineService->setLongitudeFrom($long);
        $haversineService->setLatitudeTo($lat);
        $haversineService->setLongitudeTo($long);

        $this->info('Found ' . count($results) . ' factories: ');
        $this->info('-> HOME: ' . $lat . ', ' . $long . ' distance ' . $haversineService->calculateDistance() . 'km');

        foreach ($results as $result) {
            $brewery = $result['geocode']->getBrewery();

            $this->info(
                '-> [' . $brewery->id . '] '
                . $brewery->name . ': '
                . $result['geocode']->latitude . ', '
                . $result['geocode']->longitude
                . ' distance ' . $result['distance'] . 'km'
            );

            $breweryBeers = $brewery->getBeers();

            $totalDistance += $result['distance'];
            $totalBeers += count($breweryBeers);

            foreach ($breweryBeers as $beer) {
                $beers[] = $beer;
            }
        }

        $lastStop = array_pop($results);

        $haversineService->setLatitudeFrom($lastStop['geocode']->latitude);
        $haversineService->setLongitudeFrom($lastStop['geocode']->longitude);
        $haversineService->setLatitudeTo($lat);
        $haversineService->setLongitudeTo($long);

        $distanceToHome = $haversineService->calculateDistance();

        $this->info('<- HOME: ' . $lat . ', ' . $long . ' distance ' . (int)$distanceToHome . 'km');

        $totalDistance += $distanceToHome;

        $this->info('');
        $this->info('Total distance travelled: ' . (int)$totalDistance . 'km');

        $this->printBeerResults($beers, $totalBeers);
    }

    /**
     * Print beers titles and total number
     *
     * @param $beers
     * @param $totalBeers
     */
    public function printBeerResults($beers, $totalBeers)
    {
        $this->info('');
        $this->info('');
        $this->info('Collected ' . $totalBeers . ' beer types: ');

        foreach ($beers as $beer) {
            $this->info('->' . $beer->name);
        }
    }
}
