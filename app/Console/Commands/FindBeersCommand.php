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

        $this->findBreweries($lat, $long);
    }


    public function findNearestBrewery($lat, $long, $radius = 2000, Geocodes $definedGeocode = null)
    {
        $geocodes = Geocodes::all();
        $nearestGeocode = new Geocodes();
        $nearest = 2000;

        if ($definedGeocode) {
            unset($geocodes[$definedGeocode->id]);
        }

        foreach ($geocodes as $geocode) {
            if($geocode->latitude != $lat && $geocode->longitude != $long) {
                $distance = getDistanceByHaversine($lat, $long, $geocode->latitude, $geocode->longitude) / 1000;

                if ($distance <= $radius && $distance < $nearest) {
                    $nearest = $distance;
                    $nearestGeocode = $geocode;
                }
            }
        }

        return $nearestGeocode;
    }

    public function findBreweries($lat, $long)
    {
        $fuel = $this->fuel;

        $nearestBrewery = $this->findNearestBrewery($lat, $long);
        $nearestBreweryDistance = getDistanceByHaversine($lat, $long, $nearestBrewery->latitude, $nearestBrewery->longitude) / 1000;
        $distanceToHome = getDistanceByHaversine($nearestBrewery->latitude, $nearestBrewery->longitude, $lat, $long) / 1000;
        $distances[] = $nearestBreweryDistance;
    }
}
