<?php

namespace Great\Weatherforecast\Providers;

use Illuminate\Support\ServiceProvider;
use Great\Weatherforecast\Commands\GetLocationCommand;

class WeatherForecastServiceProvider extends ServiceProvider
{
  public function register() {}

  public function boot()
  {
      $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
      $this->loadViewsFrom(__DIR__.'/../views', 'weatherforecast');
      if ($this->app->runningInConsole()) {
          $this->publishResources();
          $this->commands([GetLocationCommand::class]);
      }
  }

  protected function publishResources()
  {
      // $  php artisan vendor:publish --tag=randomable-migrations
      $this->publishes([
          __DIR__ . '/../database/migrations/create_iplocation_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_iplocation_table.php'),
      ], 'iplocation-migrations');

      $this->publishes([
          __DIR__.'/../config/weatherForecast.php' => config_path('weatherForecast.php'),
      ], 'weatherforecast-config');

      $this->publishes([
          __DIR__.'/../assets/' => public_path('weatherforecast'),
      ], 'assets');
  }

}