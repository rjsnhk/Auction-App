<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Auction-app

Auction app is a open source web app which is for making auction automated and wild speared. It help to open a new world for e-commerce sector. This web app help to sell add buy product which will be supervised by this system and administration.

For using this auction system follow this:
1. Get the source into your system
    git clone -link from github-

2. Get the dependencies
    composer install
    npm install
    npm run build

3. Migrate the database
    php artisan migrate
    (I use mysql for database. if you use other then you need to work on config file)
4. Add super admin
    php artisan db:seed
    
5. Run in your system
    php artisan serve


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
