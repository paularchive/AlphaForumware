## AlphaForumware

#####What is new in v2.0?
Version 2.0 will no longer include bootstrap but Semantic UI
And some of the functions are rewritten.


AlphaForumware is a forum application written in PHP. We use the Laravel PHP Framework and Semantic UI. It's possible to:
* Register/Login
* Create/Edit/Delete Forum Categories
* Create/Edit/Delete Forum Sub Categories in Categories
* Create/Edit/Delete Topics in Categories
* Create/Edit/Delete Replies in Threads
* Backend coming soon!

Dependencies
------------
* PHP 5.5+
* Composer
* Apache/Unix
* MySQL or another database supported by Laravel

Installation
------------
AlphaForumware is build in the Laravel PHP Framework so you have to do some standard things to get it to work:
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
