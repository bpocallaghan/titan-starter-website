# Laravel CMS Starter
A Laravel Website with Admin access Starter project with AdminLTE theme and basic features.

- Unit Tests `(156 tests, 690 assertions)`

[Preview project here](https://bpocallaghan.ie)
- User: github@bpocallaghan.ie
- Password: github

## Features
 - Admin LTE theme
 - Authentication
 - User Roles
 - Admin Navigation
 - Log and View Activities (website actions and admin resource changes)
 - Accounts
 - App Settings
 - Banners
 - Page Builder
 - Resources (Documents, Photos, Videos)
 - News
 - Shop
 - FAQ
 - Website: Contact Us

## TODO
 - More Tests (pages, news)
 - Events
 - Testimonials

 ## Setup (Basic)
 - Clone or Download the code
 - create your database
 - setup your virtual host (preview: http://titan.test)
 - open .env and update app information, database, mail
 - open `database\seeds\UsersTableSeeder.php` and set your admin user credentials
 - NPM (css and js): Install `npm install` and Run `npm run prod`

 ## Setup (Advanced)
 - `config\app.php` -> set timezone
 - create Facebook Website App https://developers.facebook.com/
 - create a Mailgun account and set custom domain
 - google Captcha https://www.google.com/recaptcha/admin#list
 - google Analytics Account https://analytics.google.com/analytics/web
 - google Console Developer account for google maps and google analytics API
    - https://console.developers.google.com
    - Enable the 'google analytics' API
 	- Create api browser key for google maps
 	- Get and Setup Laravel Analytics [Laravel Analytics (Spatie)](https://github.com/spatie/laravel-analytics/tree/3.1.0)
         - create new service account key (JSON)
         - download and rename the json to 'service-account-credentials.json'
         - store the file under /storage/app/analytics
         - go to (google analytics)[https://analytics.google.com/analytics/]
         - go to admin - property - user management and add the service account's email as a user
         - go to admin - view - settings and copy the 'site id' to your .env
 - get a Google Maps js API key https://developers.google.com/maps/documentation/javascript/get-api-key

## Thank you
- All [contributors](https://github.com/bpocallaghan/titan-starter/graphs/contributors)
- [ADMIN LTE](https://github.com/almasaeed2010/AdminLTE).
- Thank you [Taylor Ottwell](https://github.com/taylorotwell) for [Laravel](http://laravel.com/).
- Thank you [Jeffrey Way](https://github.com/JeffreyWay) for the awesome resources at [Laracasts](https://laracasts.com/)

## My Packages Included
- [File Generators](https://github.com/bpocallaghan/generators) Laravel 5 File Generators with config and publishable stubs
- [Notify](https://github.com/bpocallaghan/notify) Laravel 5 Flash Notifications with icons and animations and with a timeout
- [Alert](https://github.com/bpocallaghan/alert) A helper package to flash a bootstrap alert to the browser via a Facade or a helper function.
- [Impersonate User](https://github.com/bpocallaghan/impersonate) This allows you to authenticate as any of your customers.
- [Sluggable](https://github.com/bpocallaghan/sluggable) Provides a HasSlug trait that will generate a unique slug when saving your Laravel Eloquent model.
