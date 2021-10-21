# SmartyCMS v1.2

**Updated to work with Laravel 8 and PHP 8.0+**

This is a Laravel content management system (CRUD) package that can help you get your administration panel in minutes.

**At this moment we support these modules:**

-   **Pages** (page elements, subpages, images, html editor)
-   **Galleries** (images, change order)
-   **Blog** (posts, comments)
-   **Shop** (products, categories, comments, orders, stock)
-   **Places** (locations, maps)
-   **Leads** (contacts, subscriptions)
-   **Multiple admins**

Once you have your administration panel up, you can easily put all of those elements wherever you want in you application files.

For usage documentation see **Usage section** bellow.

**Supports:** Laravel 6.0+, 7.0+, 8.0+ and PHP 7.2+, 8.0+

**Important:** Please, make sure you're at the latest version of Laravel 6, 7 or 8 to get PHP 8 support.

---

## Installation

Install using composer:

```
$ composer require smartystudio/smartycms
```

In Laravel 5.5+, with Package Auto Discovery it should all be set automatically.

**For Laravel < 5.5, follow these instructions after composer finishes package installation:**

Add the service provider to the **providers** array in `config/app.php` for Laravel 5.4 and lower:

```php
SmartyStudio\SmartyCms\AdminServiceProvider::class,
```

If you want to use this package as a facade, add this line to the `$aliases` array in `config/app.php`.

```php
'Cms' => SmartyStudio\SmartyCms\Facades\Cms::class,
```

**Start package installation by running install command below:**

```
$ php artisan smartycms:install
```

If you want to install package again from scratch, just delete the `config/smartycms.php` file and drop database, then run install command again.

**If our package update throws composer error, try updating dependencies manually with commend below:**

```
$ php artisan smartycms:update
```

Note that this installation uses migrations, so you must run it from machine that has access to your database.

For instance, if you use Vagrant/Homestead, you will have to do `vagrant ssh` first, go to your project directory, and run this install command. The same way you run your standard Laravel's migration command.

## Extends

-   To extend `order item` view in admin panel, in order to customize and show more details about your `order item` that are custom to your bisnis model, add blade template `resources\view\cms\order\item.blade.php` in you project. `order item` data is available within `$orderItem` variable.
-   To extend admin package navigations view add blade in you project `resources\view\cms\layout\navigation.blade.php`. Use unordered list `<ul>`.
-   To extend admin router with your own controllers create new file in `/routes/cms-routes.php` and point it to you controller. This will be under choosen `prefix` and secured with Admin's credentials.

## Database export

If you use this Laravel Admin package within a team, you will find this artisan command that backups and restores database very useful.

**Backup database with command:**

```
$ php artisan smartycms:dump-database
```

Your will be prompted to `Enter password:` for mysql user specified in `.env`. File will be saved in `/database/cms_dumps`.

**To restore database on another machine use:**

```
$ php artisan smartycms:restore-database
```

**NOTICE**

Always do migration first and be carefull that new import is compatable with tour migration status. You can check that with Artisan command `php artisan migrate:status` before dumoing the export file, and before importing the same on another machine.

**WARNING**

This will be **DROP** table and restore latest migration in `database/cms_dumps` folder. Your will be prompted to proceed twice with droping database. Mysql will ask several times to `Enter password:` for mysql user specified in `.env`. **We are not responsible for any data loss. Use this with caution.**

## Bash alias

You can create Laravel Admin alias, i.e. in your Homestead environment by adding this function to your bash profile (`vi ~/.bash_aliases`):

```
function cms() {
    php artisan smartycms:"$1"
}
```

Then if you want to do `php artisan smartycms:update`, just type:

```
$ cms update
```

## Documentation

Visit our [Wiki](https://github.com/smartystudio/smartycms/wiki/) for detailed usage documentation.

## Contributing

Contributions to the SmartyCMS library are welcome. Please note the following guidelines before submiting your pull request.

-   Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.
-   Write tests for new functions and added features
-   use [Laravel Mix](https://laravel.com/docs/master/mix) for assets

## Installing Laravel vendor packages

**composer install**

```
$ composer install
```

## Compiling Assets (Mix)

**npm install**

```
$ cd src
$ npm install
```

**bower install**

```
$ cd src
$ bower install
```

**build**

```
$ cd src
$ npm run production
```

**WARNING**

If npm trow an error, then do this:

1)

```
$ rm -rf node_modules
$ rm package-lock.json yarn.lock
$ npm cache clear --force
$ npm cache clean --force
```

2)

```
$ npm install cross-env
$ npm install 
```

3)

`$ npm run dev` or `$ npm run prod` ('prod' is build for production environment).


## License

The SmartyCMS is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT).
