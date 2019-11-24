# Dusk Failures

A simple Laravel Package to enable the emailing of Dusk failure screenshots. This has been built to assist debugging Dusk tests which run on a Continuous Integration service.

During local testing, screenshots for Dusk failures can be easily viewed within a projects screenshot folder. Laravel Dusk tests can take a long time to run so it is much more convenient to pass the running of them to a continuous integration service such as Travis CI. 

This command can be used upon failure of any dusk tests. The resulting email will contain the screenshots allowing easier debugging. 

## Installation & Setup

You can install this package via composer:

````
composer require bibby/dusk-failures
````

Then in your .env file ensure you have added the following variable with and replace the value with a suitable email address. Multiple recipients can be comma separated. 

````
DUSK_FAILURES_RECIPIENT=youremail@example.com
````

## Publish

If you wish to override the email view or update config settings then publish using:

````
php artisan vendor:publish
````

## Usage

To use simply run:

````
php artisan dusk:failures 
````

## Options

The 'build' option can be specified. This is useful to indicate in the email which build the failed screenshots belong to:

```
php artisan dusk:failures --build=<insert-build-information>
```

The 'zip' option will zip and attach the screenshots instead of displaying them inline in the body of the email. This could be preferable if a large number of screenshots are expected.

```
php artisan dusk:failures --zip
```

The 'console' option can be specified which will attach the browser console logs.

```
php artisan dusk:failures --console.
```

Using Travis CI this command can be put in the on_failure block of the travis.yml file and used in combination with Travis environment variables:

````
after_failure:
  - php artisan dusk:failures --build=$TRAVIS_BUILD_WEB_URL --zip --console
```` 

## Credits

Andrew James Bibby 

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
