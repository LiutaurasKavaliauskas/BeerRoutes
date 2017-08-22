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

        $a = $this->findBreweries($lat, $long);

    }


    /**
     * @param $lat
     * @param $long
     * @param null $geocodes
     * @return Geocodes
     */
    public function findNearestBrewery($lat, $long, $geocodes = null)
    {
        $nearestGeocode = new Geocodes();
        $nearest = 2000;

        foreach ($geocodes as $geocode) {
            if($geocode->latitude != $lat && $geocode->longitude != $long) {
                $distance = getDistanceByHaversine($lat, $long, $geocode->latitude, $geocode->longitude) / 1000;

                if ($distance < $nearest) {
                    $nearest = $distance;
                    $nearestGeocode = $geocode;
                }
            }
        }

        return $nearestGeocode;
    }

    /**
     * @param $lat
     * @param $long
     * @param int $fuel
     * @param int $distanceToHome
     * @param null $geocodes
     * @param array $distances
     * @return string
     */
    public function findBreweries($lat, $long, $fuel = 2000, $distanceToHome = 1000, $geocodes = null, $distances = [])
    {
        if (!$geocodes) {
            $geocodes = Geocodes::all();
        }

        $geocodes = $geocodes->keyBy('id');

        $nearestBrewery = $this->findNearestBrewery($lat, $long, $geocodes);
        $nearestBreweryDistance = getDistanceByHaversine($lat, $long, $nearestBrewery->latitude, $nearestBrewery->longitude) / 1000;

        $distanceToHome = getDistanceByHaversine($nearestBrewery->latitude, $nearestBrewery->longitude, $lat, $long) / 1000;
        $distances[] = $nearestBrewery->id . ' ' . $nearestBreweryDistance;

        $fuel = $fuel - $nearestBreweryDistance;

        $geocodes->forget($nearestBrewery->id);

        if ($fuel < $distanceToHome) {
            $this->getResult($distances);
        }

        $this->findBreweries($nearestBrewery->latitude, $nearestBrewery->longitude, $fuel, $distanceToHome, $geocodes, $distances);
    }

    public function getResult($a)
    {
        dd($a);
    }
}
