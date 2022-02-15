```bash
$ composer require socbaysky/laravel-model-filter-basic
```

## Usage

Create new filter for your model:

```bash
$ php artisan ui:coreui
```

## Configuration

To edit site title, menu and other things, publish the configuration file:

```bash
$ php artisan vendor:publish --provider="Vitti\LaravelModelFilter\ServiceProvider" --tag=config
```

You can now edit it at `config/coreui.php`.

## Customized views

If you need complete control of the provided views, run:

```bash
$ php artisan vendor:publish --provider="Vitti\LaravelModelFilter\ServiceProvider" --tag=views
```

You can now edit them under `resources/views/vendor/coreui`.

## Translations

At the moment, English and Dutch translations are available out of the box.
Just specifiy the language in `config/app.php`.
If you need to modify the texts or add other languages, you can publish the language files:

```
php artisan vendor:publish --provider="Vitti\LaravelModelFilter\ServiceProvider" --tag=translations
```

Now, you can edit translations or add languages in `resources/lang/vendor/coreui`.

## Updating the package

To update the package, run the following command. Note that this **will** overwrite any changes you've made in the published asset files. Published views, config and translations need to be updated manually.

```bash
$ composer update socbaysky/laravel-core-ui
$ php artisan vendor:publish --provider="Vitti\LaravelModelFilter\ServiceProvider" --tag=assets --force
```

## License

This packaged is licensed under the MIT License. 

## Acknowledgements

Heavily inspired by [Jeroen Noten](https://github.com/jeroennoten)'s [Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE) package.
