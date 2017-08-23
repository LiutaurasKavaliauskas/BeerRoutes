<?php

namespace App\Console\Commands;

use App\Models\Breweries;
use App\Models\Geocodes;
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
        $lat = $this->option('lat');
        $long = $this->option('long');

        if (!$lat || !$long) {
            return $this->error('Not enough parameters...');
        }

        return $this->findBreweries($lat, $long);
    }

    /**
     * Return a nearest brewery for given coordinates
     *
     * @param $lat
     * @param $long
     * @param null $geocodes
     * @return Geocodes
     */
    public function findNearestBrewery($lat, $long, $geocodes = null)
    {
        $nearestGeocode = new Geocodes();
        $nearest = $this->fuel / 2;

        foreach ($geocodes as $geocode) {
            if ($geocode->latitude != $lat && $geocode->longitude != $long) {
                $distance = getDistanceByHaversine($lat, $long, $geocode->latitude, $geocode->longitude);

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
     * @param $lat
     * @param $long
     * @param int $fuel
     * @param int $distanceToHome
     * @param null $geocodes
     * @param array $distances
     */
    public function findBreweries($lat, $long, $fuel = 2000, $distanceToHome = 1000, $geocodes = null, $distances = [])
    {
        $homeLat = $this->option('lat');
        $homeLong = $this->option('long');

        if (!$geocodes) {
            $geocodes = Geocodes::all();
        }

        $geocodes = $geocodes->keyBy('id');

        $nearestBrewery = $this->findNearestBrewery($lat, $long, $geocodes);
        $nearestBreweryDistance = getDistanceByHaversine($lat, $long, $nearestBrewery->latitude, $nearestBrewery->longitude);

        $distanceToHome = getDistanceByHaversine($nearestBrewery->latitude, $nearestBrewery->longitude, $homeLat, $homeLong);

        $geocodes->forget($nearestBrewery->id);

        $fuel = $fuel - $nearestBreweryDistance;

        if ($fuel <= $distanceToHome) {
            return $this->printRoutesResults($distances);
        } else {
            $distances[] = [
                'geocode' => $nearestBrewery,
                'distance' => (int)$nearestBreweryDistance,
            ];
        }

        return $this->findBreweries($nearestBrewery->latitude, $nearestBrewery->longitude, $fuel, $distanceToHome, $geocodes, $distances);
    }

    /**
     * Print routes of the journey for finding beers
     *
     * @param $results
     */
    public function printRoutesResults($results)
    {
        $lat = $this->option('lat');
        $long = $this->option('long');

        $totalDistance = 0;
        $totalBeers = 0;
        $beers = [];

        $this->info('Found ' . count($results) . ' factories: ');
        $this->info('-> HOME: ' . $lat . ', ' . $long . ' distance ' . getDistanceByHaversine($lat, $long, $lat, $long) . 'km');

        foreach ($results as $result) {
            $brewery = $result['geocode']->getBrewery();

            $this->info(
                '-> [' . $brewery->id . '] '
                . $brewery->name . ': '
                . $result['geocode']->latitude . ', '
                . $result['geocode']->longitude
                . 'distance ' . $result['distance'] . 'km'
            );

            $breweryBeers = $brewery->getBeers();

            $totalDistance += $result['distance'];
            $totalBeers += count($breweryBeers);

            foreach ($breweryBeers as $beer) {
                $beers[] = $beer;
            }
        }

        $lastStop = array_pop($results);
        $distanceToHome = getDistanceByHaversine($lastStop['geocode']->latitude, $lastStop['geocode']->longitude, $lat, $long);

        $this->info('<- HOME: ' . $lat . ', ' . $long . ' distance ' . $distanceToHome . 'km');

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
