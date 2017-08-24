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
     * Distance that can be flown
     *
     * @var int
     */
    protected $fuel = 2000;

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
     * Return a nearest brewery for given coordinates
     *
     * @param $lat
     * @param $long
     * @param null $geocodes
     * @return Geocode
     */
    public function findNearestBrewery($lat, $long, $geocodes = null)
    {
        $nearestGeocode = new Geocode();
        $haversineService = new HaversineFormulaService();
        $nearest = $this->fuel / 2;

        foreach ($geocodes as $geocode) {
            if ($geocode->latitude !== $lat && $geocode->longitude !== $long) {
                $haversineService->setLatitudeFrom($lat);
                $haversineService->setLongitudeFrom($long);
                $haversineService->setLatitudeTo($geocode->latitude);
                $haversineService->setLongitudeTo($geocode->longitude);

                $distance = $haversineService->calculateDistance();

                if ($distance < $nearest) {
                    $nearest = $distance;
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
     * @param int $fuel
     * @param int $distanceToHome
     * @param null $geocodes
     * @param array $distances
     */
    public function findBreweries($homeLat, $homeLong, $lat, $long, $fuel = 2000, $distanceToHome = 1000, $geocodes = null, $distances = [])
    {
        if (!$geocodes) {
            $geocodes = new Geocode();
            $geocodes = $geocodes->getBreweriesInArea($homeLat, $homeLong, $fuel / 2);
        }

        $geocodes = $geocodes->keyBy('id');

        $nearestBrewery = $this->findNearestBrewery($lat, $long, $geocodes);

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

        $fuel = $fuel - $nearestBreweryDistance;

        if ($fuel <= $distanceToHome) {
            return $this->printRoutesResults($homeLat, $homeLong, $distances);
        }

        $distances[] = [
            'geocode' => $nearestBrewery,
            'distance' => (int)$nearestBreweryDistance,
        ];

        return $this->findBreweries($homeLat, $homeLong, $nearestBrewery->latitude, $nearestBrewery->longitude, $fuel, $distanceToHome, $geocodes, $distances);
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
