# Scaffolding For Laravel 5

## General Commands

```
// Move the `public` folder to `public_html` 
// Only enabled on `local` environment
php artisan setup:move-public
```

## Scaffolding Commands

#### Create a Resource
```
php artisan scaffold:resource car
```
This will create the following files
```
app\Entities\Cars\Car.php (Model)
app\Entities\Cars\CarsRepository.php (Repository, inherited from BaseRepository)
app\Http\Controllers\CarsController.php
database\migrations\<timestamp>_create_cars_table.php
database\seeds\CarsTableSeeder.php
routes\web.php (Resource Route added)
```

After the files are created, you have to edit the created migration file, and add the seeder file to main `DatabaseSeeder.php`


#### Creating Individual Files

If you don't want to create all files at once, you can call the individual commands.

```
php artisan scaffold:model car
php artisan scaffold:model:migration car
php artisan scaffold:repository car
php artisan scaffold:controller car
php artisan scaffold:seeder car
```

## CHECK YOUR SPELLING!!!

If you incorrectly spell the model name (The example of `car` above), it will get repeated on all files. So check your spelling properly before you press enter.

### Singular or Plural Words?

The package will convert between singular and plural as needed in most cases. For example, following commands create the same result.
```
// All these commands are identical and creates a `Car` model
php artisan scaffold:model car
php artisan scaffold:model cars
php artisan scaffold:model Car
php artisan scaffold:model Cars

// All these commands are identical and creates a `MiniVan` model
php artisan scaffold:model mini-van
php artisan scaffold:model miniVan
php artisan scaffold:model MiniVan
php artisan scaffold:model MiniVans

// But NOT
php artisan scaffold:model minivan
```