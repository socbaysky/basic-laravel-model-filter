```bash
$ composer require socbaysky/laravel-model-filter-basic
```

## Usage

Create new filter for your model example:

```bash
$ php artisan make:filter 'Models\User'
```

Or:

```bash
$ php artisan make:filter 'Models\AnyYourModel'
```

After run above command console, Laravel will automatically generate:
- app/Filters/QueryFilter.php (only first time run above command)
- app/Traits/Filterable.php (only first time run above command)
- app/Filters/**User**Filter.php (ensure this file is not exists)

Then you can custom app/Filters/**User**Filter.php