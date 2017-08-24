## Task
You are beer fanatic millionaire. 
The weekend has came. Your crib is at LONG/LAT. 
You have an ideal helicopter and enough fuel to fly 2000 km. 
You have decided to try out as many beer species as possible from different breweries. 
Make a travel route which would allow to transport as many beer species as possible.   

Example coordinates: 51.355468, 11.100790
## Deployment

- Clone this repository
- Run `composer install`
- Update your .env file
- Run `docker-compose up -d` to run docker containers
- Run `php artisan:migrate` to migrate all tables
- Run `php artisan db:seed` to populate database with data (this may take a while)

## Usage

- To find out routes and collected beer run command `php artisan beer:find --lat={latitude} --long={longitude}`

## Testing

- To run PHP Unit tests run `vendor/bin/phpunit`