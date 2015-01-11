####BE AWARE THAT THIS IS THE DEV BRANCHE AND WE DO NOT RECOMMEND TO USE THIS FOR ANY PRODUCTION CONDITIONS!!
#####What is new in 0.2.0?
Version 0.2 will have a better manage and login system, and as you might know v0.1 used bootstrap as main style. In this version we will use Semantic UI as main style and we will also make some more custom css.

AlphaForumware is a free to use forum application written in PHP based on the Laravel PHP Framework. Our goal is to make an easy to use/manage application with a modern UI.

Dependenties
------------
* PHP 5.5+
* Composer
* Apache/Unix
* MySQL or another database supported by Laravel

Installation
------------
It is not recommended to use this application for production conditions, but you can still test it out. To do that you will have to do some things to configure the application, this is all you have to do:
* Install composer on your computer (documentation coming soon)
* Open a Terminal or CommandPrompt in the AlphaForumware root folder and enter `composer install` this will install laravel and some other dependencies. (can take a while)
* When that is done you have to go to the folder app and rename `config-sample` to `config` and enter that folder, now change your database settings in `database.php`
* Now open your Terminal or CommandPrompt and now run `php artisan migrate` in the root folder of your installation, this will configure your database.
* Now you should be able to register and login.
There isn't a way to make yourself an admin using the interface a.t.m. so you have to login into your database take for example phpMyAdmin and press on the `users` table and change the isAdmin value to `1`

Credits
-------
* Laravel PHP Framework: http://laravel.com
* Semantic UI: http://semantic-ui.com/
