## Zipzoft ID Provider for Laravel

#### Installation & Basic Usage

```
composer require zipzoft/laravel-id-socialite-provider
```

#### Add configuration to config/services.php
```php
'zipzoft' => [
  'client_id' => env('CLIENT_ID'),
  'client_secret' => env('CLIENT_SECRET'),
  'redirect' => env('CLIENT_REDIRECT_URI')
],
```


#### Add provider event listener
Configure the package's listener to listen for SocialiteWasCalled events.

Add the event to your listen[] array in app/Providers/EventServiceProvider

```php
protected $listen = [
  \SocialiteProviders\Manager\SocialiteWasCalled::class => [
    // ... other providers
    \Zipzoft\ID\Provider::class,
  ],
];
```


#### Usage
You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):
```php
return Socialite::driver('zipzoft')->redirect();
```